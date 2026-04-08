<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialPageManualInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'phone_number' => 'nullable|string|max:30',
            'activity_location' => 'nullable|string|max:255',
            'most_viewed_wilayas' => 'nullable|array',
            'most_viewed_wilayas.*' => 'string',
            'most_followed_wilayas' => 'nullable|array',
            'most_followed_wilayas.*' => 'string',
            'followers_count' => 'nullable|integer|min:0',
            'page_topics' => 'nullable|array',
            'page_topics.*' => 'string|max:100',
            'audience_reach_rate' => 'nullable|numeric|min:0|max:100',
        ];
    }
}
