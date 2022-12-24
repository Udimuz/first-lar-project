<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Models\Tag;

class Service
{
	// Теперь вся реализация с Базой данных у меня прописана в этом методе:
	public function store($data): void
	{
		$tags = $data['tags'];
		unset($data['tags']);	// Нужно очистить этот элемент, иначе выйдет ошибка, при добавлении в базу, так как в этом элементе - массив
		// а Post::create() который добавляет данные в базу, как раз ждёт аргументом массив с ключами и значениями, которые он будет вносить в базу.
		// Поэтому, лучше давать имена формы такие же как поля в базе
		$post = Post::create($data);

//		foreach ($tags as $tag)
//			PostTag::firstOrCreate([
//				'tag_id' => $tag,
//				'post_id' => $post->id
//			]);
		// Или так: Но это не вставит данные во временные поля: время создания, изменения. Да и эти поля обычно не нужны, их удаляют
		$post->tags()->attach($tags);
	}

	public function update($post, $data): void
	{
		$tags = $data['tags'] ?? [];
		unset($data['tags']);	// Нужно очистить этот элемент, иначе выйдет ошибка, при добавлении в базу, так как в этом элементе - массив

		$post->update($data);
		//$post = $post->fresh();
		// Нужно чтобы все старые Теги удалялись. И добавлялись Теги которые приходят:
		$post->tags()->sync($tags);
	}

	public function list_of_posts(): array
	{
//		$posts = Post::all();
//		$tags = Tag::all();
		return [Post::all(), Tag::all()];
	}
}