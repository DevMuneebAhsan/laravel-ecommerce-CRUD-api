<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\ProductFilter;
use App\Http\Requests\Api\V1\ReplaceProductRequest;
use App\Http\Requests\Api\V1\StoreProductRequest;
use App\Http\Requests\Api\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
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
            //policy
            $this->isAble('store', Product::class);
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
            //policy
            $this->isAble('update', $product);
            $product->update($request->mappedAttributes());
            return new ProductResource($product);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Product can not be found', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized for this action', 403);
        }
    }
    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceProductRequest $request, $product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            //policy
            $this->isAble('replace', $product);
            $product->update($request->mappedAttributes());
            return new ProductResource($product);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Product can not be found', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized for this action', 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            $this->isAble('delete', $product);
            $product->delete();
            return $this->ok('Product successfully deleted');
        } catch (ModelNotFoundException $exception) {
            return $this->error('Product can not be found', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized for this action', 403);
        }
    }
}
