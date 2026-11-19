<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Eatery;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Reviews are paused for closed eateries: returning false makes
     * Laravel answer 403 Forbidden.
     */
    public function authorize(): bool
    {
        /** @var Eatery $eatery */
        $eatery = $this->route('eatery');

        return $eatery->is_open;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'body' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Choose who is writing this review.',
            'rating.between' => 'Ratings go from 1 to 5 stars only.',
            'body.min' => 'Kaon Ta Ancog: reviews need at least 10 characters.',
        ];
    }
}
