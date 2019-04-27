<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->hasHeader('X-localization')){

            \App::setLocale($request->header('X-localization'));
 
            Carbon::setLocale($request->header('X-localization'));

        }else if ( \Session::has('locale')) {
            \App::setLocale(\Session::get('locale'));
 
            Carbon::setLocale(\Session::get('locale'));
        }
 
        return $next($request);
    }
}
