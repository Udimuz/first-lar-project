<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function PHPUnit\Framework\isNull;

class PostController extends Controller
{
	// --- --- События - actions --- ---

	public function index(): View {
		$posts = Post::all();
		//$categories = Category::all();	// dd($categories);	 // {{ !empty($post->category_id) ? ' - '.$categories[$post->category_id-1]->title : '' }}
		//dd(Category::find(1)->title);
		//for ($posts)

		//$category = Category::find(1);

		// Вот здесь уже более точная выборка из базы:	Собрать записи с "category_id=1"
		//$posts = Post::where('category_id', $category->id)->get();

		// Тоже самое, только через созданный нами метод "posts":
		//$posts = $category->posts;

		// Можем извлечь имя категории, в котором находится пост:
//		$post = Post::find(1);
//		dd($post->category->title);

//		$tag = Tag::find(3);
//		dd($tag->posts);

//		$post = Post::find(4);
//		dd($post->tags);

		$tags = Tag::all();

		return view('post.index', compact('posts', 'tags'));
	}

	public function create(): View {
		$categories = Category::all();
		$tags = Tag::all();
		return view('post.create', compact('categories', 'tags'));
	}

	public function store() {
		$data = request()->validate([
			// Здесь можно указать, какого типа данные принимаются в этом параметре. Могут быть например цифры. Подробнее в доках:	https://laravel.com/docs/9.x/validation#available-validation-rules
			'title' => 'required|string',
			'content' => 'required|string',
			'image' => 'string',
			'category_id' => '',
			'tags' => ''
		]);
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

	public function edit(Post $post): View {
		//dd($post);
		$categories = Category::all();
		$tags = Tag::all();
		return view('post.edit', compact('post', 'categories', 'tags'));
	}

	public function update(Post $post): RedirectResponse {
		$data = request()->validate([
			// Здесь можно указать, какого типа данные принимаются в этом параметре. Могут быть например цифры. Подробнее в доках:	https://laravel.com/docs/9.x/validation#available-validation-rules
			'title' => 'required|string',
			'content' => 'required|string',
			'image' => 'string',
			'category_id' => '',
			'tags' => ''
		]);
		$tags = $data['tags'] ?? [];
		unset($data['tags']);	// Нужно очистить этот элемент, иначе выйдет ошибка, при добавлении в базу, так как в этом элементе - массив

		$post->update($data);
		//$post = $post->fresh();
		// Нужно чтобы все старые Теги удалялись. И добавлялись Теги которые приходят:
		$post->tags()->sync($tags);

		// После добавления данных, логично перенаправить на страницу сообщения, указав его id-номер:
		return redirect()->route('post.show', $post->id);
	}

	public function destroy(Post $post): RedirectResponse {
		$post->delete();
		return redirect()->route('post.index');
	}

	// Такой способ сейчас стал стандартом. Который делает всё тоже самое, что функция ниже (старый способ)
	public function show(Post $post): View {
		$category = !empty($post->category->id) ? Category::find($post->category->id) : '';
		$tags = Tag::all();
		return view('post.show', compact('post', 'category', 'tags'));
		//dd($post->content);
	}

	// Раньше получали данные так:
	public function show_old($id) {
		$post = Post::FindOrFail($id);
		dd($post->title);
	}

	public function index2()
	{
		//return 'Сообщения';
		//$value = "Сообщения1234";
		//dd($value);

		//$post = Post::find(1);	// метод find класса Post берёт данные из базы по "id", find(1) - берёт данные по Id=1
		//$post = new Post();
		//$post = $post::find(2);
//		dump($post->id);
//		dump($post->content);
//		var_dump($post->title);
		//dump($post);	//var_dump($post);

		//dd(Post::where('id', 2)->get());
//		/** @var Post $post */
		$posts = Post::where('is_published', 1)->get();
		foreach ($posts as $post)
			dump($post->title);
		$posts = Post::all();
		foreach ($posts as $post)
			dump($post->title);
		//$posts = Post::where('is_published', 1)->first();	dump($posts->title);
		dd($posts);
	}

	public function create2()
	{
		$postsArr = [
			[
				'title' => 'Title from PhpStorm',
				'content' => 'Some interesting content',
				'image' => 'good.jpg',
				'likes' => 64,
				'is_published' => 1,
			],
			[
				'title' => 'Another title from PhpStorm',
				'content' => 'Another some interesting content',
				'image' => 'good.jpg',
				'likes' => 48,
				'is_published' => 1,
			]
		];
		// create в виде аргументов принимает массив значений:
//		Post::create([
//			'title' => 'Inserting title',
//			'content' => 'New content',
//			'image' => 'storm.jpg',
//			'likes' => 16,
//			'is_published' => 0,
//		]);

		foreach ($postsArr as $item) {
			dump($item);
			//	Post::create($item);
		}

		dd('created');
	}

	public function update_old()
	{
		/** @var Post $post */
		$post = Post::find(6);
		//dd($post->title);		//var_dump($post->title);
		$post->update([
			'title' => 'Another title from PhpStorm',
			'content' => 'Another some interesting content',
			'image' => 'nice.jpg',
			'likes' => 48,
			'is_published' => 1,
		]);
//		$post->update([
//			'title' => 'Updated title',
//			'content' => 'Updated content',
//			'image' => 'UpdatedPic.jpg',
//			'likes' => 8,
//			'is_published' => 0,
//		]);
		dd('updated');
	}

	public function delete()
	{
		//$post = Post::withTrashed()->find(6);
		$post = Post::find(6);
//		dump($post);
		if (!is_null($post)) {
//			$post->restore();
//			dump('Восстановлено');
			//$post->delete();
			//$post->forceDelete();
			//dump('delated');
		}
	}

	//	http://first-project/post/first_or_create
	public function firstOrCreate()
	{
		$anotherPost = [
			'title' => 'Some post',
			'content' => 'Some content',
			'image' => 'some.jpg',
			'likes' => 148,
			'is_published' => 1,
		];
		$post = Post::firstOrCreate([
			// Если нам Ларавел в базе найдёт 'title' со значением 'Some post', то он просто вернёт эту запись:
			'title' => 'Some post'
		],
			// Если же не находит, он создаёт новое сообщение и добавляет туда все эти атрибуты:
			$anotherPost
		);
		dump($post->content);
		dump('finished');
	}

	//	http://first-project/post/update_or_create
	public function updateOrCreate()
	{
		$anotherPost = [
			'title' => 'UpdateOrCreate some post',
			'content' => 'UpdateOrCreate some content',
			'image' => 'UpdateOrCreate.jpg',
			'likes' => 160,
			'is_published' => 0,
		];
		$another2Post = [
			'title' => 'Some post',
			'content' => 'some content',
			'image' => 'some.jpg',
			'likes' => 2,
			'is_published' => 0,
		];
		$post = Post::updateOrCreate([
			// Если нам Ларавел в базе найдёт 'title' со значением 'Some post', то он обновляет там атрибуты взятые из массива $anotherPost
			'title' => 'UpdateOrCreate some post'
		],
			// Если же не находит, он создаёт новое сообщение и добавляет туда атрибуты взятые из массива $anotherPost:
			$anotherPost
		);
		dump($post->content);
		dump('updated');
	}
}
