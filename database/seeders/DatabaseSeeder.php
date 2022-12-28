<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
	public function test_run() {
		//dd(Post::factory(2)->make());
		dd(Category::factory(2)->make());
	}

    public function run()
    {
		#echo '-123456789-';
		//$post = Post::factory(2)->make();	dd($post);
		//dd(Category::factory(2)->make());
		//Post::factory(2)->create();

		Category::factory(10)->create();	// Создаст 10 категорий
		$tags = Tag::factory(20)->create();	// 20 тегов
		$posts = Post::factory(200)->create();	// 30 постов-сообщений

		// А это, как я понял, заполнит связующую теги и посты таблицу "post_tags"
		foreach ($posts as $post) {
			//Вставит по 1-5 тегов к каждому посту: по несколько записей в таблицу тегов. Т.е. у каждого сообщения теперь будет по несколько случайных тегов
			$tagsIds = $tags->random(random_int(1,5))->pluck('id');
			// Здесь обучали поставить просто цифру 5: но я выше попробовал сделать лучше
			//$tagsIds = $tags->random(5)->pluck('id');
			$post->tags()->attach($tagsIds);
		}
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
