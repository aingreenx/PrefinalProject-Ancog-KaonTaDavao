{{--
    Shared by create and edit. Expects $eatery (new or saved, with permit + features loaded),
    $districts, $features. Each field: old() first, then the saved value.
--}}
@php
    $input = 'mt-1 w-full rounded-lg border border-stone-300 bg-white px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200';
    $selectedFeatures = old('features', $eatery->exists ? $eatery->features->pluck('id')->all() : []);
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-semibold">Please fix the following:</p>
        <ul class="mt-1 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="name" class="block text-sm font-medium">Name</label>
        <input type="text" id="name" name="name" maxlength="100" value="{{ old('name', $eatery->name) }}" class="{{ $input }}">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="district_id" class="block text-sm font-medium">District</label>
        <select id="district_id" name="district_id" class="{{ $input }}">
            <option value="">Choose a district</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected((string) old('district_id', $eatery->district_id) === (string) $district->id)>{{ $district->name }}</option>
            @endforeach
        </select>
        @error('district_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="price_range" class="block text-sm font-medium">Price range</label>
        <select id="price_range" name="price_range" class="{{ $input }}">
            <option value="">Choose a price range</option>
            @foreach (['budget' => '₱ Budget', 'mid' => '₱₱ Mid', 'splurge' => '₱₱₱ Splurge'] as $value => $label)
                <option value="{{ $value }}" @selected(old('price_range', $eatery->price_range) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('price_range') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label for="address" class="block text-sm font-medium">Address</label>
        <input type="text" id="address" name="address" maxlength="255" value="{{ old('address', $eatery->address) }}" class="{{ $input }}">
        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="specialty" class="block text-sm font-medium">Specialty <span class="font-normal text-stone-500">(optional)</span></label>
        <input type="text" id="specialty" name="specialty" maxlength="100" value="{{ old('specialty', $eatery->specialty) }}" class="{{ $input }}">
        @error('specialty') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-end">
        <label class="inline-flex items-center gap-2 pb-2">
            <input type="checkbox" name="is_open" value="1" @checked(old('is_open', $eatery->exists ? $eatery->is_open : true))
                   class="h-4 w-4 rounded border-stone-300 text-orange-600 focus:ring-orange-500">
            <span class="text-sm font-medium">Open (accepting reviews)</span>
        </label>
        @error('is_open') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <fieldset class="md:col-span-2">
        <legend class="text-sm font-medium">Features</legend>
        <div class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($features as $feature)
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}" @checked(in_array($feature->id, $selectedFeatures))
                           class="h-4 w-4 rounded border-stone-300 text-orange-600 focus:ring-orange-500">
                    <span class="text-sm">{{ $feature->name }}</span>
                </label>
            @endforeach
        </div>
        @error('features') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        @error('features.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </fieldset>

    <div>
        <label for="permit_no" class="block text-sm font-medium">Permit number</label>
        <input type="text" id="permit_no" name="permit_no" placeholder="DVO-2026-0415" value="{{ old('permit_no', $eatery->permit?->permit_no) }}" class="{{ $input }} font-mono">
        @error('permit_no') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="expires_on" class="block text-sm font-medium">Permit expiry date</label>
        <input type="date" id="expires_on" name="expires_on" value="{{ old('expires_on', $eatery->permit?->expires_on?->format('Y-m-d')) }}" class="{{ $input }}">
        @error('expires_on') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
