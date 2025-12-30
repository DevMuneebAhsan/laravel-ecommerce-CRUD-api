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

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductFilter $filters)
    {
        return ProductResource::collection(Product::filter($filters)->Paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));
        } catch (ModelNotFoundException $exception) {
            return $this->ok('user not found', ['error' => 'The provided user do not exist']);
        }
        return new ProductResource(Product::create($request->mappedAttributes()));
    }

    /**
     * Display the specified resource.
     */
    public function show($product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            // if ($this->include('user')) {
            //     return new ProductResource($product->load('user'));
            // }
            $relations = [];

            if ($this->include('user')) {
                $relations[] = 'user';
            }

            if ($this->include('category')) {
                $relations[] = 'category';
            }

            if (!empty($relations)) {
                $product->load($relations);
            }
            return new ProductResource($product);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Product can not be found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            $product->update($request->mappedAttributes());
            return new ProductResource($product);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Product can not be found', 404);
        }
    }
    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceProductRequest $request, $product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            $product->update($request->mappedAttributes());
            return new ProductResource($product);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Product can not be found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            $product->delete();
            return $this->ok('Product successfully deleted');
        } catch (ModelNotFoundException $exception) {
            return $this->error('Product can not be found', 404);
        }
    }
}
