<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Http\Filters\PostFilter;
use App\Http\Requests\Post\FilterRequest;
use App\Models\Post;

class IndexController extends Controller
{
	//	http://first-proj/admin/post/
	public function __invoke(FilterRequest $request)	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
		// Фильтрация - делаем отсеивание данных:
		$data = $request->validated();

		$filter = app()->make(PostFilter::class, ['queryParams' => array_filter($data)]);
		$posts = Post::filter($filter)->paginate(5);

		return view('admin.post.index', compact('posts'));
	}
}
