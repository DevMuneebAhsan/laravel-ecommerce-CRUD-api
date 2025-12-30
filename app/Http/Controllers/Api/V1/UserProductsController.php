<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\ProductFilter;
use App\Http\Requests\Api\V1\ReplaceProductRequest;
use App\Http\Requests\Api\V1\StoreProductRequest;
use App\Http\Requests\Api\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserProductsController extends ApiController
{
    public function index($user_id, ProductFilter $filters)
    {
        return ProductResource::collection(Product::where('user_id', $user_id)->filter($filters)->paginate());
    }
    public function store($user_id, StoreProductRequest $request)
    {
        $model = [
            'user_id' => $user_id,
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'category' => $request->input('data.attributes.category'),
            'price' => $request->input('data.attributes.price'),
            'image' => $request->input('data.attributes.image'),
        ];
        return new ProductResource(Product::create($model));
    }
    /**
     * Replace the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $user_id, $product_id)
    {
        $product = Product::findOrFail($product_id);
        if ($product->user_id == $user_id) {
            $product->update($request->mappedAttributes());
            return new ProductResource($product);
        }
    }

    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceProductRequest $request, $user_id, $product_id)
    {
        $product = Product::findOrFail($product_id);
        if ($product->user_id == $user_id) {
            $model = [
                'user_id' => $user_id,
                'title' => $request->input('data.attributes.title'),
                'description' => $request->input('data.attributes.description'),
                'category_id' => $request->input('data.attributes.category_id'),
                'price' => $request->input('data.attributes.price'),
                'image' => $request->input('data.attributes.image'),
            ];
            $product->update($model);
            return new ProductResource($product);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id, $product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            if ($product->user_id == $user_id) {
                $product->delete();
                return $this->ok('Product deleted successfully');
            }
            return $this->error('Product can not be found', 404);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Product can not be found', 404);
        }
    }
}
