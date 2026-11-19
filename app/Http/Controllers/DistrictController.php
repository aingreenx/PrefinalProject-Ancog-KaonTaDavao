<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\View\View;

class DistrictController extends Controller
{
    public function index(): View
    {
        // The page lists every district, so no pagination here.
        $districts = District::withCount('eateries')->orderBy('name')->get();

        return view('districts.index', ['districts' => $districts]);
    }

    public function show(District $district): View
    {
        // reviews_count is counted through hasManyThrough (District -> Eatery -> Review).
        $district->loadCount('reviews');

        $eateries = $district->eateries()->withCardData()->orderBy('name')->get();

        return view('districts.show', [
            'district' => $district,
            'eateries' => $eateries,
        ]);
    }
}
