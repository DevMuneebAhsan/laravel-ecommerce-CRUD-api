<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends BaseProductRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'data.attributes.title' => 'required|string|max:255',
            'data.attributes.description' => 'required|string',
            'data.attributes.price' => 'required|numeric|decimal:0,2|min:0',
            'data.attributes.image' => 'nullable|string|max:255',
            'data.relationships.category.data.id' => ['required', 'integer', 'exists:categories,id'],
        ];
        if ($this->routeIs('products.store')) {
            $rules['data.relationships.author.data.id'] = 'required|integer';
        }
        return $rules;
    }
}
