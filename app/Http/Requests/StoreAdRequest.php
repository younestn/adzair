<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdRequest extends FormRequest
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
            'type' => 'required|in:image,text',
            'content' => 'required_if:type,text|string|max:500',
            'image_url' => 'required_if:type,image|url',
            'destination_url' => 'required|url',
            'target_url' => 'nullable|url',
            'media_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov|max:51200',
            'target_wilayas' => 'nullable|array',
            'target_wilayas.*' => 'string|in:' . implode(',', config('algeria.wilayas', [])),
            'target_audience' => 'nullable|array',
            'niche' => 'required|string|max:100',
            'is_product_ad' => 'nullable|boolean',
            'headline' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'media_url' => 'nullable|url',
        ];
    }
}
