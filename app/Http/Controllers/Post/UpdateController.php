<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;

class UpdateController extends BaseController
{
	public function __invoke(UpdateRequest $request, Post $post)	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
		$data = $request->validated();
		// Как я понял, туда ещё можно обращаться так:	указав необходимые для проверки параметры. only() вместо validated(). Увидел, что у некоторых программистов обращение к Request идёт так
		//$data = $request->only(['title','content','image','category_id','tags']);

		$this->service->update($post, $data);	// Теперь, всю работу с $data можно делать в сервисах

		// После добавления данных, логично перенаправить на страницу сообщения, указав его id-номер:
		return redirect()->route('post.show', $post->id);
	}

	public function old__invoke(UpdateRequest $request, Post $post)	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
		$data = $request->validated();
		$tags = $data['tags'] ?? [];
		unset($data['tags']);	// Нужно очистить этот элемент, иначе выйдет ошибка, при добавлении в базу, так как в этом элементе - массив

		$post->update($data);
		//$post = $post->fresh();
		// Нужно чтобы все старые Теги удалялись. И добавлялись Теги которые приходят:
		$post->tags()->sync($tags);

		// После добавления данных, логично перенаправить на страницу сообщения, указав его id-номер:
		return redirect()->route('post.show', $post->id);
	}
}
