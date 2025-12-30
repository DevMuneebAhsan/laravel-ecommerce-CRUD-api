<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'type' => 'category',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'parent_id' => $this->parent_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'children' => [
                    'data' => static::collection($this->whenLoaded('children')),
                ],
                'parent' => [
                    'data' => $this->when($this->parent, [
                        'type' => 'category',
                        'id' => $this->parent_id,
                        'attributes' => [
                            'name' => $this->parent->name ?? null,
                        ]
                    ]),
                ],
                'products' => [
                    'data' => ProductResource::collection($this->whenLoaded('products')),
                ],
                'includes' => [
                    'parent' => new CategoryResource($this->whenLoaded('parent')),
                    'children' => CategoryResource::collection($this->whenLoaded('children')),
                    'products' => ProductResource::collection($this->whenLoaded('products')),
                ],
                'links' => [
                    'self' => route('categories.show', ['category' => $this->id]),
                ],
            ]
        ];
    }
}
