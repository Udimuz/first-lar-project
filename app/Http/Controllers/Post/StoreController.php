<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;

class StoreController extends BaseController
{
	public function __invoke(StoreRequest $request)	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
		$data = $request->validated();
		// Как я понял, туда ещё можно обращаться так:	указав необходимые для проверки параметры. only() вместо validated(). Увидел, что у некоторых программистов обращение к Request идёт так. Какая-то более строгая проверка чтоли
		//$data = $request->only(['title','content','image','category_id','tags']);

		$this->service->store($data);	// Теперь, всю работу с $data можно делать в сервисах

		// После добавления данных, лучше перенаправить на другую страницу:
		return redirect()->route('post.index');
	}

	public function old__invoke(StoreRequest $request)	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
		$data = $request->validated();
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

		// После добавления данных, лучше перенаправить на другую страницу:
		return redirect()->route('post.index');
	}
}
