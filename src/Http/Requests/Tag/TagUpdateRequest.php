<?php

namespace Ihossain\LaravelTags\Http\Requests\Tag;

use Ihossain\LaravelTags\Helper\Helpers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class TagUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'      => 'string|nullable|min:2',
            'slug'      => 'string|nullable|unique:tags,slug,'.$this->route(str_replace('-', '_', Helpers::getRouteName())),
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (!$this->filled('slug') && $this->filled('name')) {
            $this->merge([
                'slug' => Str::slug('course-'.$this->input('name')),
            ]);
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
