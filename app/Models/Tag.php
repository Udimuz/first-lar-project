<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

	public function posts() {
		// Для того чтоб создать взаимо-отношение "Многие ко многим" должны написать
		return $this->belongsToMany(Post::class, 'post_tags', 'tag_id', 'post_id'); //Связываем foreign - значит "кто", related - значит "с кем имеет отношение"
	}
}
