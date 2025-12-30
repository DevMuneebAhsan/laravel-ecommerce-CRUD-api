<?php

namespace App\Http\Requests\Api\V1;


class UpdateProductRequest extends BaseProductRequest
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
            'data.attributes.title' => 'sometimes|string|max:255',
            'data.attributes.description' => 'sometimes|string',
            'data.attributes.price' => 'sometimes|numeric|decimal:0,2|min:0',
            'data.attributes.image' => 'nullable|string|max:255',
            'data.relationships.category.data.id' => ['sometimes', 'integer', 'exists:categories,id',],
            'data.relationships.author.data.id' => 'sometimes|integer',
        ];
        return $rules;
    }
}
