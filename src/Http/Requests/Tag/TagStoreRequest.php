<?php

namespace Ihossain\LaravelTags\Http\Requests\Tag;

use Ihossain\LaravelTags\Helper\Helpers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class TagStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'      => 'string|required|min:2',
            'slug'      => 'string|required|unique:tags,slug',
            'type'      => 'string|required',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $moduleName = Helpers::getModuleName();
        if (!$this->filled('slug') && $this->filled('name')) {
            $this->merge([
                'slug' => Str::slug($moduleName .'-'. $this->input('name')),
                'type'  => $moduleName
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
