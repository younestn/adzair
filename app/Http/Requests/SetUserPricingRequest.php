<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetUserPricingRequest extends FormRequest
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
            'cpc' => 'required|numeric|min:0.0001|max:999.9999',
            'type' => 'required|in:advertiser,publisher',
            'platform' => 'nullable|in:facebook,instagram,tiktok,youtube,twitter,snapchat',
        ];
    }
}
