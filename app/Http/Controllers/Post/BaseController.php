<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Services\Post\Service;

class BaseController extends Controller
{
	public Service $service;

	// Создаём конструктор, в который приходит наш сервис
	public function __construct(Service $service)
	{
		$this->service = $service; // Сохраняем пришедшие данные в свойство Сервиса
	}

}