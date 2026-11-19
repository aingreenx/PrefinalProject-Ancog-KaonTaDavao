<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EateryController extends Controller
{
    /** Validated keys that belong to the eateries table. */
    private const EATERY_FIELDS = ['district_id', 'name', 'address', 'price_range', 'specialty', 'is_open'];

    /** Validated keys that belong to the permits table. */
    private const PERMIT_FIELDS = ['permit_no', 'expires_on'];

    public function index(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();
        $districtId = $request->integer('district');
        $feature = $request->string('feature')->toString();

        $eateries = Eatery::withCardData()
            // ?q= matches name OR specialty (grouped so it combines with the other filters)
            ->when($q !== '', fn ($query) => $query->where(
                fn ($w) => $w->where('name', 'like', "%{$q}%")->orWhere('specialty', 'like', "%{$q}%")
            ))
            ->when($districtId > 0, fn ($query) => $query->where('district_id', $districtId))
            ->when($feature !== '', fn ($query) => $query->whereHas(
                'features',
                fn ($f) => $f->where('name', $feature)
            ))
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString(); // pagination links keep the current filters

        return view('eateries.index', [
            'eateries' => $eateries,
            'districts' => District::orderBy('name')->get(),
            'features' => Feature::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('eateries.create', [
            'eatery' => new Eatery(),
            'districts' => District::orderBy('name')->get(),
            'features' => Feature::orderBy('name')->get(),
        ]);
    }

    public function store(StoreEateryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $eatery = DB::transaction(function () use ($data): Eatery {
            $eatery = Eatery::create([
                ...Arr::only($data, self::EATERY_FIELDS),
                'slug' => $this->uniqueSlug(Str::slug($data['name'])),
            ]);
            $eatery->permit()->create(Arr::only($data, self::PERMIT_FIELDS));
            $eatery->features()->sync($data['features']);

            return $eatery;
        });

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery added.');
    }

    public function show(Eatery $eatery): View
    {
        $eatery->load([
            'district',
            'permit',
            'features',
            'dishes' => fn ($q) => $q->orderBy('name'),
            'reviews' => fn ($q) => $q->with('user')->orderByDesc('created_at')->orderByDesc('id'),
        ])->loadCount('reviews')->loadAvg('reviews', 'rating');

        return view('eateries.show', [
            'eatery' => $eatery,
            'users' => User::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function edit(Eatery $eatery): View
    {
        $eatery->load(['permit', 'features']);

        return view('eateries.edit', [
            'eatery' => $eatery,
            'districts' => District::orderBy('name')->get(),
            'features' => Feature::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateEateryRequest $request, Eatery $eatery): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $eatery): void {
            $eatery->update([
                ...Arr::only($data, self::EATERY_FIELDS),
                'slug' => $this->uniqueSlug(Str::slug($data['name']), $eatery->id),
            ]);
            // Update the existing permit, or create one if it is missing.
            $eatery->permit()->updateOrCreate([], Arr::only($data, self::PERMIT_FIELDS));
            $eatery->features()->sync($data['features']);
        });

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery updated.');
    }

    public function destroy(Eatery $eatery): RedirectResponse
    {
        // Remove children through the relationships so no child rows are left behind.
        DB::transaction(function () use ($eatery): void {
            $eatery->permit()->delete();
            $eatery->dishes()->delete();
            $eatery->reviews()->delete();
            $eatery->features()->detach();
            $eatery->delete();
        });

        return redirect()->route('eateries.index')->with('status', 'Eatery deleted.');
    }

    /**
     * Two names can make the same slug ("Kainan!" and "Kainan" both give "kainan").
     * If the slug is taken by another eatery, add -2, -3, ... so saving never fails.
     */
    private function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $candidate = $slug;
        $number = 2;

        while (Eatery::where('slug', $candidate)->where('id', '!=', $ignoreId ?? 0)->exists()) {
            $candidate = $slug . '-' . $number;
            $number++;
        }

        return $candidate;
    }
}
