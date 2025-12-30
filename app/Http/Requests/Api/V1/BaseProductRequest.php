<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseProductRequest extends FormRequest
{
    public function mappedAttributes()
    {
        $attributeMap = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.price' => 'price',
            'data.attributes.image' => 'image',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
            'data.relationships.category.data.id' => 'category_id',
            'data.relationships.author.data.id' => 'user_id',
        ];
        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            $value = $this->input($key);
            if (!is_null($value)) {
                $attributesToUpdate[$attribute] = $value;
            }
        }
        return $attributesToUpdate;
    }
}
