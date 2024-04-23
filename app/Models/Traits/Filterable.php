<?php

namespace App\Models\Traits;

use App\Http\Filters\FilterInterface;
use App\Http\Resources\EmployeeResource;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param FilterInterface $filter
     *
     * @return Builder
     */
    public static function scopeFilter(Builder $builder, FilterInterface $filter)
    {
        $filter->apply($builder);

        return $builder;
    }
}
