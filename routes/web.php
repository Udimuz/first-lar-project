<?php

//use App\Http\Controllers\Post\IndexController;
//use App\Http\Controllers\Post\CreateController;
//use App\Http\Controllers\Post\DestroyController;
//use App\Http\Controllers\Post\EditController;
//use App\Http\Controllers\Post\IndexController;
//use App\Http\Controllers\Post\ShowController;
//use App\Http\Controllers\Post\StoreController;
//use App\Http\Controllers\Post\UpdateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers;

//Route::get('/', 'MyPlaceController@index');
//Route::get('/', [App\Http\Controllers\MyPlaceController::class, 'index']);
Route::resource('/', App\Http\Controllers\PostController::class);	//MyPlaceController
//Route::get('/', [App\Http\Controllers\PostController::class, 'index']);

//Route::get('/posts', [\App\Http\Controllers\Post\IndexController::class])->name('post.index');
//Route::get('/posts', \App\Http\Controllers\Post\IndexController::class)->name('post.index');
//Route::get('/posts/create', \App\Http\Controllers\Post\CreateController::class)->name('post.create');
//Route::post('/posts', \App\Http\Controllers\Post\StoreController::class)->name('post.store');
//Route::get('/posts/{post}', \App\Http\Controllers\Post\ShowController::class)->name('post.show');
//Route::get('/posts/{post}/edit', \App\Http\Controllers\Post\EditController::class)->name('post.edit');
//Route::patch('/posts/{post}', \App\Http\Controllers\Post\UpdateController::class)->name('post.update');
//Route::delete('/posts/{post}', \App\Http\Controllers\Post\DestroyController::class)->name('post.delete');

//Route::get('/posts', [\App\Http\Controllers\Post\IndexController::class, '__invoke'])->name('post.index');
//Route::get('/posts/create', [\App\Http\Controllers\Post\CreateController::class, '__invoke'])->name('post.create');
//Route::post('/posts', [\App\Http\Controllers\Post\StoreController::class, '__invoke'])->name('post.store');
//Route::get('/posts/{post}', [\App\Http\Controllers\Post\ShowController::class, '__invoke'])->name('post.show');
//Route::get('/posts/{post}/edit', [\App\Http\Controllers\Post\EditController::class, '__invoke'])->name('post.edit');
//Route::patch('/posts/{post}', [\App\Http\Controllers\Post\UpdateController::class, '__invoke'])->name('post.update');
//Route::delete('/posts/{post}', [\App\Http\Controllers\Post\DestroyController::class, '__invoke'])->name('post.delete');

// Сгруппировать роуты, показывает, что все эти контроллеры находятся в папке "Post":
//Route::group(['namespace' => 'Post'], function(){
//	Route::get('/posts', [IndexController::class, '__invoke'])->name('post.index');
//	//Route::get('/posts', 'IndexController')->name('post.index');
//	Route::get('/posts/create', [CreateController::class, '__invoke'])->name('post.create');
//	Route::post('/posts', [StoreController::class, '__invoke'])->name('post.store');
//	Route::get('/posts/{post}', [ShowController::class, '__invoke'])->name('post.show');
//	Route::get('/posts/{post}/edit', [EditController::class, '__invoke'])->name('post.edit');
//	Route::patch('/posts/{post}', [UpdateController::class, '__invoke'])->name('post.update');
//	Route::delete('/posts/{post}', [DestroyController::class, '__invoke'])->name('post.delete');
//});

// По уроку в Laravel 8 было:	Route::group(['namespace'=>'Post']
// Для 9-й версии посоветовали прописать группу так:
Route::group(['namespace'=>'App\Http\Controllers\Post'], function(){
	Route::get('/posts', 'IndexController')->name('post.index');
	Route::get('/posts/create', 'CreateController')->name('post.create');
	Route::post('/posts', 'StoreController')->name('post.store');
	Route::get('/posts/{post}', 'ShowController')->name('post.show');
	Route::get('/posts/{post}/edit', 'EditController')->name('post.edit');
	Route::patch('/posts/{post}', 'UpdateController')->name('post.update');
	Route::delete('/posts/{post}', 'DestroyController')->name('post.delete');
});

// prefix добавит везде к ссылке впереди адрес "/admin/". Это чтобы не создавать такие роуты '/admin/post', '/admin/add', а сократить
Route::group(['namespace'=>'App\Http\Controllers\Admin', 'prefix'=>'admin', 'middleware'=>'admin'], function() {
	//Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('main.index');
	//Route::get('/admin', 'IndexController')->name('main.index');
	Route::group(['namespace'=>'Post'], function(){
		// Чтобы страница запускалась по адресу "/admin/post"
		Route::get('/post', 'IndexController')->name('admin.post.index');
	});
});

// Route обладает функцией колбак, проще говоря - Ответ на наш запрос:	например "PostController - index"
//Route::get('/post', [App\Http\Controllers\PostController::class, 'index']);

//Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('post.index');
//Route::get('/posts/create', [App\Http\Controllers\PostController::class, 'create'])->name('post.create');
//Route::post('/posts', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
//Route::get('/posts/{post}', [App\Http\Controllers\PostController::class, 'show'])->name('post.show');
//Route::get('/posts/{post}/edit', [App\Http\Controllers\PostController::class, 'edit'])->name('post.edit');
//Route::patch('/posts/{post}', [App\Http\Controllers\PostController::class, 'update'])->name('post.update');
//Route::delete('/posts/{post}', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.delete');


Route::get('/main', [App\Http\Controllers\MainController::class, 'index'])->name('main.index');
Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about.index');
Route::get('/contacts', [App\Http\Controllers\ContactsController::class, 'index'])->name('contacts.index');


//Route::get('/post/create', [App\Http\Controllers\PostController::class, 'create']);
Route::get('/post/update', [App\Http\Controllers\PostController::class, 'update']);
Route::get('/post/delete', [App\Http\Controllers\PostController::class, 'delete']);
Route::get('/post/first_or_create', [App\Http\Controllers\PostController::class, 'firstOrCreate']);
Route::get('/post/update_or_create', [App\Http\Controllers\PostController::class, 'updateOrCreate']);

//Route::get('/', function () {
//	return 'Test 1';
//    //return view('welcome');
//});

Route::get('/kto', function () {
	return 'Попытка входа без прав админа';
	//return view('welcome');
})->name('wrong');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
