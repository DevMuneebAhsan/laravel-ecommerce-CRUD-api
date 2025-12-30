<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Filters\V1\CategoryFilter;
use App\Http\Requests\Api\V1\StoreCategoryRequest;
use App\Http\Requests\Api\V1\UpdateCategoryRequest;
use App\Http\Requests\Api\V1\ReplaceCategoryRequest;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryFilter $filters)
    {
        $categories = Category::filter($filters);

        $relations = [];

        if ($this->include('parent')) {
            $relations[] = 'parent';
        }

        if ($this->include('children')) {
            $relations[] = 'children';
        }

        if ($this->include('products')) {
            $relations[] = 'products';
        }

        if (!empty($relations)) {
            $categories->with($relations);
        }

        return CategoryResource::collection(
            $categories->paginate()
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create(
            $request->mappedAttributes()
        );

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show($category_id)
    {
        try {
            $category = Category::findOrFail($category_id);

            $relations = [];

            if ($this->include('parent')) {
                $relations[] = 'parent';
            }

            if ($this->include('children')) {
                $relations[] = 'children';
            }

            if ($this->include('products')) {
                $relations[] = 'products';
            }

            if (!empty($relations)) {
                $category->load($relations);
            }

            return new CategoryResource($category);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Category cannot be found', 404);
        }
    }

    /**
     * Update the specified resource in storage (PATCH).
     */
    public function update(UpdateCategoryRequest $request, $category_id)
    {
        try {
            $category = Category::findOrFail($category_id);

            $category->update(
                $request->mappedAttributes()
            );

            return new CategoryResource($category);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Category cannot be found', 404);
        }
    }

    /**
     * Replace the specified resource in storage (PUT).
     */
    public function replace(ReplaceCategoryRequest $request, $category_id)
    {
        try {
            $category = Category::findOrFail($category_id);

            $category->update(
                $request->mappedAttributes()
            );

            return new CategoryResource($category);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Category cannot be found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category_id)
    {
        try {
            $category = Category::findOrFail($category_id);

            $category->delete();

            return $this->ok('Category successfully deleted');
        } catch (ModelNotFoundException $exception) {
            return $this->error('Category cannot be found', 404);
        }
    }
}
