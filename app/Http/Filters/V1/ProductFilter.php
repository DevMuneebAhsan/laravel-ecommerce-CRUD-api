<?php

namespace App\Http\Filters\V1;

class ProductFilter extends QueryFilter
{
    protected $sortable = [
        'name',
        'category',
        'price',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];
    public function include($value)
    {
        $this->builder->with($value);
    }
    public function category($value)
    {
        return $this->builder->where('category', $value);
    }
    public function name($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $likeStr);
    }
    public function price($value)
    {
        $price = explode(',', $value);
        if (count($price) == 2) {
            return $this->builder->whereBetween('price', $price);
        }
        return $this->builder->where('price', $value);
    }
    public function createdAt($value)
    {
        $dates = explode(',', $value);
        if (count($dates) == 2) {
            return $this->builder->whereBetween('created_at', $dates);
        }
        return $this->builder->whereDate('created_at', $value);
    }
    public function updatedAt($value)
    {
        $dates = explode(',', $value);
        if (count($dates) == 2) {
            return $this->builder->whereBetween('updated_at', $dates);
        }
        return $this->builder->whereDate('updated_at', $value);
    }
}
