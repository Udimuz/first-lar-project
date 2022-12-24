<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
	protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
	public function definition()
	{
		return [
			'title' => fake()->sentence(5),	// fake()->name
			'content' => fake()->text(255),
			'image' => fake()->imageUrl,
			'likes' => random_int(1,1000),	// Создадим случайную цифру
			'is_published' => 1,
			'category_id' => Category::get()->random()->id,	// Тоже выведет случайное значение из существующих Категорий
		];
	}

    public function old_definition()
    {
        return [
//          'name' => 'Название',
//			'surname' => 'Второй параметр'
            'title' => $this->faker->name,	// Специальный метод "faker" даёт случайные значения
            'content' => $this->faker->text(255),
            'image' => $this->faker->imageUrl,
            'likes' => random_int(1,2000),	// Создадим случайную цифру
            'is_published' => 1,
            'category_id' => Category::get()->random()->id,	// Тоже выведет случайное значение из существующих Категорий
        ];
    }
}
