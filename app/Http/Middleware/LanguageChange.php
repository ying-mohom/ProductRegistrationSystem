<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/**
 * Change Language 
 * @author YingMoHom
 * @create 07/06/2023
 */
class LanguageChange
{
    /**
     * Handle Language Change
     * @author YingMoHom
     * @create 07/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Session::get("locale") != null) {
            App::setLocale(Session::get("locale"));
        } else {
            Session::put("locale", "en");
            App::setLocale(Session::get("locale"));
        }

        return $next($request);
    }
}
