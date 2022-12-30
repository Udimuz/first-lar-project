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
        Schema::table('users', function (Blueprint $table) {
			// Создание новой колонки 'role' типа "string" со значением по-умолчанию 'user':
            $table->string('role')->default('user')->after('email');	// и добавим колонку после колонки 'email'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
			// При откате, мы должны сделать обратные действия, удалить колонку:
			$table->dropColumn('role');
        });
    }
};
