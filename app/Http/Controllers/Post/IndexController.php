<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;

class IndexController extends BaseController
{
	public function __invoke()	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
//		$posts = Post::all();
//		return view('post.index', compact('posts'));

		//$posts = Post::all();
		$posts = Post::paginate(10);
		$tags = Tag::all();

		// 24.12.2022 попробовал собирать список через сервисы:	Но что-то много кода получается, из-за этих 2х строк, смысла мало
		//list($posts, $tags) = $this->service->list_of_posts();

		return view('post.index', compact('posts', 'tags'));
	}
}
