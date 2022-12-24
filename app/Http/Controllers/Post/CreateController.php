<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class CreateController extends BaseController
{
	public function __invoke()	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
		$categories = Category::all();
		$tags = Tag::all();
		return view('post.create', compact('categories', 'tags'));
	}
}
