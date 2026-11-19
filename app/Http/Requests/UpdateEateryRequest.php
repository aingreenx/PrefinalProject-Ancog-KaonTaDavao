<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Eatery;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEateryRequest extends FormRequest
{
    /**
     * No login in this project (handout Section 1), so anyone may edit an eatery.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * An unchecked checkbox sends nothing, so turn "missing" into false.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_open' => $this->boolean('is_open'),
        ]);
    }

    /**
     * Same as StoreEateryRequest, but the unique rules ignore this eatery
     * and its own permit, so saving without changes still passes.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Eatery $eatery */
        $eatery = $this->route('eatery');

        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('eateries', 'name')->ignore($eatery->id)],
            'district_id' => ['required', 'exists:districts,id'],
            'address' => ['required', 'string', 'max:255'],
            'price_range' => ['required', 'in:budget,mid,splurge'],
            'specialty' => ['nullable', 'string', 'max:100'],
            'is_open' => ['boolean'],
            'features' => ['required', 'array', 'min:1'],
            'features.*' => ['exists:features,id'],
            'permit_no' => ['required', 'regex:/^DVO-\d{4}-\d{4,5}$/', Rule::unique('permits', 'permit_no')->ignore($eatery->permit?->id)],
            'expires_on' => ['required', 'date', 'after:today'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Kaon Ta Ancog already lists an eatery with this name.',
            'features.required' => 'Pick at least one feature.',
            'features.min' => 'Pick at least one feature.',
            'permit_no.regex' => 'Permit number must look like DVO-2026-0415.',
            'expires_on.after' => 'The permit must not be expired.',
        ];
    }
}
