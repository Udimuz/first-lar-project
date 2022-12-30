<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		// Хелпер auth() который всегда возвращает пользователя:	Делает тоже что	 $user = User::where('is_auth', 1)
		// Из базы вытягивает пользователя который в данный момент заходит на сайт
		//dd(auth()->user()->role);	//dd(auth()->id());
		if (auth()->user()->role !== 'admin')
			return redirect()->route('wrong');
		//return redirect()->route('home');
        return $next($request);
    }
}
