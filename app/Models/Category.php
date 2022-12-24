<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

	// По конвенции - даём имя методу "posts" п.ч. у одной модели (Category) много постов.
	// Если бы у категории был только один пост, мы бы писали "post"
	public function posts() {
		// hasMany() - это такой метод Ларавел понять что у данного объекта (созданного на основе класса Category) есть чего-то много
		// Это метод, который определяет отношения данного объекта с каким-то другим объектом. В нашем случае - это посты.
		return $this->hasMany(Post::class, 'category_id', 'id');
	}
}
