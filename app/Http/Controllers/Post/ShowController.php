<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class ShowController extends BaseController
{
	public function __invoke(Post $post)	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
		$category = !empty($post->category->id) ? Category::find($post->category->id) : '';
		$tags = Tag::all();
		return view('post.show', compact('post', 'category', 'tags'));

	}
}
