<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PostFilter extends AbstractFilter
{
	// Названия ключей и значения берутся из FilterRequest. Здесь записываются в константы.
	public const TITLE = 'title';
	public const CONTENT = 'content';
	public const CATEGORY_ID = 'category_id';

	// Здесь прописываем методы, которые должны запуститься, так же как они названы в коде ниже. И вернуть результат всего как массив:
	protected function getCallbacks(): array
	{
		return [
			self::TITLE => [$this, 'title'],
			self::CONTENT => [$this, 'content'],
			self::CATEGORY_ID => [$this, 'categoryId'],
		];
	}

	// Эти методы запускаются в классе AbstractFilter Php-функцией call_user_func():
	public function title(Builder $builder, $value)
	{
		$builder->where('title', 'like', "%{$value}%");
	}

	public function content(Builder $builder, $value)
	{
		$builder->where('content', 'like', "%{$value}%");
	}

	public function categoryId(Builder $builder, $value)
	{
		//dd($value);
		$builder->where('category_id', $value);
	}
}