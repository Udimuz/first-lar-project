<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
	use Filterable;
	use SoftDeletes;

	public $someProperty = "Кошка";
	protected $table = 'posts';
	protected $guarded = [];

	// В данном случае пишем имя в единственном числе п.ч. у нас у каждого поста только одна категория:
	public function category() {
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}

	public function categrs() {
		// - имеет один -
		return $this->hasOne(Category::class, 'id', 'category_id');
		//	Без параметров искало по колонке "post_id" в таблице categories, а такой колонки там нет:	Выходила ошибка
		//	select * from `categories` where `categories`.`post_id` in (31, 32, 33, 34)
		//return $this->hasOne(Category::class);
	}

	public function tags() {
		// Для того чтоб создать взаимо-отношение "Многие ко многим" должны написать
		return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id'); //Связываем foreign - значит "кто", related - значит "с кем имеет отношение"
	}

	// ----- СКОПЫ для автоматизации: -----

	// Запускается в контроллере так:	Post::allPaginate(10);
	public function scopeAllPaginate($query, $numbers) {
		//return $query->with('tags', 'state')->orderBy('created_at', 'desc')->limit($numbers)->get();
		// Собрал сам:
		//return $query->with('tags', 'state')->orderBy('id', 'asc')->limit($numbers)->get();
		//return $query->with('tags')->orderBy('id', 'asc')->paginate($numbers);
		return $query->with('tags', 'categrs')->paginate($numbers);
	}

	// Запускается в контроллере так:	Post::filterPaginate($filter, $perPage, $page);
	public function scopeFilterPaginate($query, $filter, $perPage, $page) {
		//return $query->with('tags', 'state')->orderBy('created_at', 'desc')->limit($numbers)->get();
		// Собрал сам:
		//return $query->with('tags', 'state')->orderBy('id', 'asc')->limit($numbers)->get();
		//return $query->with('tags')->orderBy('id', 'asc')->paginate($numbers);
		return $query->filter($filter)->with('tags', 'categrs')->paginate($perPage, ['*'], 'page', $page);
		// Можно вызывать filter() обращаясь к классу Post потому что мы создали трейт Filterable и передали ему в класс сообщений Post.php
	}

}
