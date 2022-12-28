<?php

namespace App\Models\Traits;

use App\Http\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
	/**
	 * @param Builder $builder
	 * @param FilterInterface $filter
	 *
	 * @return Builder
	 */

	// Этот метод будет вызываться так: filter(). Если бы имя этого метода назывался scopeFilterMoon, то и вызывался бы он как filterMoon()
	public function scopeFilter(Builder $builder, FilterInterface $filter)
	{
		$filter->apply($builder);

		return $builder;
	}
}