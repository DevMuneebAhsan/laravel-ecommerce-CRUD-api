<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'product',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when(!$request->routeIs(['products.index', 'users.products.index']), $this->description),
                'price' => $this->price,
                'image' => $this->image,
                'category_id' => $this->category_id,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ],
                    'links' => [
                        'self' => route('users.show', ['user' => $this->user_id]),
                    ],
                ],
                'category' => [
                    'data' => [
                        'type' => 'category',
                        'id' => (string) $this->category_id,
                    ],
                    'links' => [
                        'self' => route('categories.show', ['category' => $this->category_id]),
                    ],
                ],
            ],
            'includes' => [
                'author' => new UserResource($this->whenLoaded('user')),
                'category' => new CategoryResource($this->whenLoaded('category')),
            ],
            'links' => [
                'self' => route('products.show', ['product' => $this->id]),
            ],
        ];
    }
}
