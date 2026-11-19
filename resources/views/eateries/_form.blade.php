{{--
    Shared by create and edit. Expects $eatery (new or saved, with permit + features loaded),
    $districts, $features. Each field: old() first, then the saved value.
--}}
@php
    $selectedFeatures = old('features', $eatery->exists ? $eatery->features->pluck('id')->all() : []);
    $legend = 'font-display text-2xl font-extrabold tracking-tight';
    $label = 'text-sm font-semibold';
    $error = 'mt-1 text-sm font-medium text-sili';
@endphp

@if ($errors->any())
    <div class="mb-8 flex gap-3 rounded-md bg-sili/10 px-5 py-4 text-sili-deep" role="alert">
        <x-icon name="alert" class="mt-0.5 size-5" />
        <div>
            <p class="font-bold">{{ $errors->count() === 1 ? 'One thing needs fixing' : $errors->count() . ' things need fixing' }} before this can be saved:</p>
            <ul class="mt-2 list-inside list-disc space-y-0.5 text-sm">
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="space-y-10">
    <fieldset class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <legend class="{{ $legend }} mb-4">The eatery</legend>

        <div class="md:col-span-2">
            <label for="name" class="{{ $label }}">Name</label>
            <input type="text" id="name" name="name" maxlength="100" value="{{ old('name', $eatery->name) }}" placeholder="e.g. Carinderia ni Ancog"
                   class="field" @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
            @error('name') <p id="name-error" class="{{ $error }}">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="district_id" class="{{ $label }}">District</label>
            <select id="district_id" name="district_id" class="field" @error('district_id') aria-invalid="true" aria-describedby="district_id-error" @enderror>
                <option value="">Choose a district</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" @selected((string) old('district_id', $eatery->district_id) === (string) $district->id)>{{ $district->name }}</option>
                @endforeach
            </select>
            @error('district_id') <p id="district_id-error" class="{{ $error }}">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="price_range" class="{{ $label }}">Price range</label>
            <select id="price_range" name="price_range" class="field" @error('price_range') aria-invalid="true" aria-describedby="price_range-error" @enderror>
                <option value="">Choose a price range</option>
                @foreach (['budget' => '₱ · Budget', 'mid' => '₱₱ · Mid', 'splurge' => '₱₱₱ · Splurge'] as $value => $text)
                    <option value="{{ $value }}" @selected(old('price_range', $eatery->price_range) === $value)>{{ $text }}</option>
                @endforeach
            </select>
            @error('price_range') <p id="price_range-error" class="{{ $error }}">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label for="address" class="{{ $label }}">Address</label>
            <input type="text" id="address" name="address" maxlength="255" value="{{ old('address', $eatery->address) }}" placeholder="Street, barangay, Davao City"
                   class="field" @error('address') aria-invalid="true" aria-describedby="address-error" @enderror>
            @error('address') <p id="address-error" class="{{ $error }}">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="specialty" class="{{ $label }}">Specialty <span class="font-normal text-ink-soft">(optional)</span></label>
            <input type="text" id="specialty" name="specialty" maxlength="100" value="{{ old('specialty', $eatery->specialty) }}" placeholder="e.g. Tinolang Manok"
                   class="field" @error('specialty') aria-invalid="true" aria-describedby="specialty-error" @enderror>
            @error('specialty') <p id="specialty-error" class="{{ $error }}">{{ $message }}</p> @enderror
        </div>

        <div class="md:self-end">
            <label class="flex cursor-pointer items-start gap-3 rounded-md border-[1.5px] border-line bg-[#fffdf8] px-4 py-3 hover:border-[#bba982]">
                <input type="checkbox" name="is_open" value="1" @checked(old('is_open', $eatery->exists ? $eatery->is_open : true))
                       class="mt-0.5 size-4 accent-board">
                <span>
                    <span class="block text-sm font-semibold">Open</span>
                    <span class="block text-sm text-ink-soft">Unchecked means closed, and reviews are paused.</span>
                </span>
            </label>
            @error('is_open') <p class="{{ $error }}">{{ $message }}</p> @enderror
        </div>
    </fieldset>

    <fieldset>
        <legend class="{{ $legend }}">Features</legend>
        <p class="mt-1 text-sm text-ink-soft">Pick at least one.</p>
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach ($features as $feature)
                <label class="cursor-pointer">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}" @checked(in_array($feature->id, $selectedFeatures)) class="peer sr-only">
                    <span class="inline-flex items-center gap-2 rounded-full border-[1.5px] border-line bg-[#fffdf8] px-3.5 py-1.5 text-sm font-semibold transition
                                 hover:border-[#bba982] peer-checked:border-board peer-checked:bg-board peer-checked:text-chalk peer-focus-visible:outline-3 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-luyang">
                        {{ $feature->name }}
                    </span>
                </label>
            @endforeach
        </div>
        @error('features') <p class="{{ $error }} mt-2">{{ $message }}</p> @enderror
        @error('features.*') <p class="{{ $error }} mt-2">{{ $message }}</p> @enderror
    </fieldset>

    <fieldset class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <legend class="{{ $legend }} mb-4">Business permit</legend>

        <div>
            <label for="permit_no" class="{{ $label }}">Permit number</label>
            <input type="text" id="permit_no" name="permit_no" value="{{ old('permit_no', $eatery->permit?->permit_no) }}" placeholder="DVO-2026-0415"
                   class="field tabular-nums tracking-wide" @error('permit_no') aria-invalid="true" aria-describedby="permit_no-error" @enderror>
            @error('permit_no') <p id="permit_no-error" class="{{ $error }}">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="expires_on" class="{{ $label }}">Permit expiry date</label>
            <input type="date" id="expires_on" name="expires_on" value="{{ old('expires_on', $eatery->permit?->expires_on?->format('Y-m-d')) }}"
                   class="field" @error('expires_on') aria-invalid="true" aria-describedby="expires_on-error" @enderror>
            @error('expires_on') <p id="expires_on-error" class="{{ $error }}">{{ $message }}</p> @enderror
        </div>
    </fieldset>
</div>
