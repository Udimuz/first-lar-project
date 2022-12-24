<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
			$table->string('title');
			$table->text('content');
			$table->string('image')->nullable();

			// Создаём ключ зависимости:
			// Сначала создадим поле:
			$table->unsignedBigInteger('category_id')->nullable();
			// Теперь мы можем из этого сделать индекс:
			$table->index('category_id', 'post_category_idx');	// Даётся имя индексу 'post_category_idx'
			// Создание связанного ключа:
			$table->foreign('category_id', 'post_category_fk')->on('categories')->references('id');	// Даётся имя ключу 'post_category_fk', on() - на какую таблицу он ссылается, references() - на какую колонку будет ссылаться

			$table->unsignedBigInteger('likes')->nullable();
			//$table->integer('likes');
			$table->boolean('is_published')->default(1);
			//$table->boolean('is_published')->default(true);
			$table->timestamps();

			$table->softDeletes();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
