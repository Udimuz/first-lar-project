<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
	use SoftDeletes;

	public $someProperty = "Кошка";
	protected $table = 'posts';
	protected $guarded = [];

	// В данном случае пишем имя в единственном числе п.ч. у нас у каждого поста только одна категория:
	public function category() {
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}

	public function tags() {
		// Для того чтоб создать взаимо-отношение "Многие ко многим" должны написать
		return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id'); //Связываем foreign - значит "кто", related - значит "с кем имеет отношение"
	}
}
