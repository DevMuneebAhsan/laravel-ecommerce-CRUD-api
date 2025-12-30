<?php

namespace App\Http\Filters\V1;

class CategoryFilter extends QueryFilter
{
    protected $sortable = [
        'name',
        'parentId'  => 'parent_id',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    /**
     * Include relationships
     * ?include=children,parent
     */
    public function include($value)
    {
        $this->builder->with(explode(',', $value));
    }

    /**
     * Filter by category name
     * ?filter[name]=Elect*
     */
    public function name($value)
    {
        $likeStr = str_replace('*', '%', $value);

        return $this->builder->where('name', 'like', $likeStr);
    }

    /**
     * Filter by parent category
     * ?filter[parentId]=1
     * ?filter[parentId]=null (main categories)
     */
    public function parentId($value)
    {
        if ($value === 'null') {
            return $this->builder->whereNull('parent_id');
        }

        return $this->builder->where('parent_id', $value);
    }

    /**
     * Filter by creation date
     * ?filter[createdAt]=2024-01-01
     * ?filter[createdAt]=2024-01-01,2024-12-31
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
     * Filter by update date
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
