<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class AboutController extends Controller
{
	// --- --- События - actions --- ---

	public function index() {
		return view('about');
	}
}
