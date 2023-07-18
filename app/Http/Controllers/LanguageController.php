<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/**
 * Create Controller For Language  Changing
 * @author YingMoHom
 * @create 06/07/2023
 */
class LanguageController extends Controller
{
    public function setLang($locale)
    {

        App::setLocale($locale);

        Session::put("locale", $locale);

        return redirect()->back();
    }
}
