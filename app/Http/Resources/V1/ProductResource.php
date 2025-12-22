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
                'category' => $this->category,
                'image' => $this->image,
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
                ]
            ],
            'includes' => new UserResource($this->whenLoaded('user')),
            'links' => [
                'self' => route('products.show', ['product' => $this->id]),
            ],
        ];
    }
}
