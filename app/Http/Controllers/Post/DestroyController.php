<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;

class DestroyController extends BaseController
{
	public function __invoke(Post $post)	// Этот метод "__invoke" в ООП у PHP вызывается каждый раз когда идёт обращение к классу
	{
		$post->delete();
		return redirect()->route('post.index');
	}
}
