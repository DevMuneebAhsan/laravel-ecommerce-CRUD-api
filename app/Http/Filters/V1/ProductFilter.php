<?php

namespace App\Http\Filters\V1;

class ProductFilter extends QueryFilter
{
    protected $sortable = [
        'title',
        'price',
        'categoryId' => 'category_id',
        'createdAt'  => 'created_at',
        'updatedAt'  => 'updated_at',
    ];

    /**
     * Include relationships
     * ?include=category,user
     */
    public function include($value)
    {
        $this->builder->with(explode(',', $value));
    }

    /**
     * Filter by category ID
     * ?filter[categoryId]=3
     */
    public function categoryId($value)
    {
        return $this->builder->where('category_id', $value);
    }

    /**
     * Filter by category name (via relationship)
     * ?filter[category]=Elect*
     */
    public function category($value)
    {
        $likeStr = str_replace('*', '%', $value);

        return $this->builder->whereHas('category', function ($query) use ($likeStr) {
            $query->where('name', 'like', $likeStr);
        });
    }

    /**
     * Filter by product title
     * ?filter[title]=iph*
     */
    public function title($value)
    {
        $likeStr = str_replace('*', '%', $value);

        return $this->builder->where('title', 'like', $likeStr);
    }

    /**
     * Filter by price
     * ?filter[price]=100
     * ?filter[price]=100,500
     */
    public function price($value)
    {
        $price = explode(',', $value);

        if (count($price) === 2) {
            return $this->builder->whereBetween('price', $price);
        }

        return $this->builder->where('price', $value);
    }

    /**
     * Filter by created date
     */
    public function createdAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) === 2) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

    /**
     * Filter by updated date
     */
    public function updatedAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) === 2) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }
}
