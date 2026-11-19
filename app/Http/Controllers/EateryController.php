<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EateryController extends Controller
{
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
        abort(501); // Phase 4
    }

    public function store(Request $request): RedirectResponse
    {
        abort(501); // Phase 4
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
        abort(501); // Phase 4
    }

    public function update(Request $request, Eatery $eatery): RedirectResponse
    {
        abort(501); // Phase 4
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
}
