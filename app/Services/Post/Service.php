<?php

namespace App\Services\Post;

use App\Http\Filters\PostFilter;
use App\Http\Requests\Post\FilterRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;

class Service
{
	// Теперь вся реализация с Базой данных у меня прописана в этом методе:
	public function store($data)
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

		return $post;
	}

	public function update($post, $data): void
	{
		$tags = $data['tags'] ?? [];
		unset($data['tags']);	// Нужно очистить этот элемент, иначе выйдет ошибка, при добавлении в базу, так как в этом элементе - массив

		$post->update($data);
		// Нужно чтобы все старые Теги удалялись. И добавлялись Теги которые приходят:
		$post->tags()->sync($tags);
		//$post = $post->fresh();
	}

	public function posts_list(FilterRequest $request): LengthAwarePaginator
	{
		// Фильтрация - делаем отсеивание данных:
		$data = $request->validated();

		$page = $data['page'] ?? 1;		// Так отлавливается, какая страница на данный момент открыта
		$perPage = $data['per_page'] ?? 10;
		// Не забыть эти параметры 'page', 'per_page' добавить в фильтр FilterRequest

		$filter = app()->make(PostFilter::class, ['queryParams' => array_filter($data)]);

		return Post::filterPaginate($filter, $perPage, $page);
	}

	public function list_of_posts(): array
	{
//		$posts = Post::all();
//		$tags = Tag::all();
		return [Post::all(), Tag::all()];
	}
}