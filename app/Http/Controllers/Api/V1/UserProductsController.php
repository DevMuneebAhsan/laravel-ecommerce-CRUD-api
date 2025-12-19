<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\ProductFilter;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;


class UserProductsController extends ApiController
{
    public function index($user_id, ProductFilter $filters)
    {
        return ProductResource::collection(Product::where('user_id', $user_id)->filter($filters)->paginate());
    }
}
