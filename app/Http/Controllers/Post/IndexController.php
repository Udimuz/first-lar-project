<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Filters\PostFilter;
use App\Http\Requests\Post\FilterRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
	//	http://first-proj/posts?category_id=4	http://first-proj/posts?category_id=4&title=am
	//public function __invoke(Request $request)
	public function __invoke(FilterRequest $request)	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
//		$posts = Post::all();
//		return view('post.index', compact('posts'));

		// Здесь проверял работу Policy, проверку на админа:
		//$this->authorize('view', auth()->user());

		// Фильтрация - делаем отсеивание данных:
		$data = $request->validated();

		$page = $data['page'] ?? 1;		// Так отлавливается, какая страница на данный момент открыта
		$perPage = $data['per_page'] ?? 10;
		// Не забыть эти параметры 'page', 'per_page' добавить в фильтр FilterRequest

		$filter = app()->make(PostFilter::class, ['queryParams' => array_filter($data)]);
		// Можно вызывать filter() обращаясь к классу Post потому что мы создали трейт Filterable и передали ему в класс сообщений Post.php
		// сюда в $filter передаём результат отработки в операторе выше:
		//$posts = Post::filter($filter)->get();
		//$posts = Post::filter($filter)->paginate(10);
		$posts = Post::filter($filter)->paginate($perPage, ['*'], 'page', $page);
		//dd($posts);
		//return PostResource::collection($posts);


//		$query = Post::query();
//		if (isset($data['category_id']))
//			$query->where('category_id', $data['category_id']);
//		if (isset($data['title']))	// Поиск по тексту, аналог "WHERE title LIKE '%da%'"
//			$query->where('title', 'like', "%{$data['title']}%");
//		$posts = $query->get();	dd($posts);


//		if ($request->has('category_id')) {
//		$data = Post::where('category_id', $request->category_id)->get();
//		dd($data); }
		//$posts = Post::where('is_published', 1)->where('category_id', 5)->get();	dd($posts);
		//$posts = Post::all();
//		$posts = Post::paginate(10);


		$tags = Tag::all();


		// 24.12.2022 попробовал собирать список через сервисы:	Но что-то много кода получается, из-за этих 2х строк, смысла мало
		//list($posts, $tags) = $this->service->list_of_posts();

		return view('post.index', compact('posts', 'tags'));
	}
}
