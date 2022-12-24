<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		// Путь к шаблону указывается по папкам через точку:	Так подключается шаблон "resources/views/vendor/pagination/bootstrap-4.blade.php"
		Paginator::defaultView('vendor.pagination.bootstrap-4');	// tailwind ставится по умолчанию почему-то, страница выглядит поломанной
    }
}
