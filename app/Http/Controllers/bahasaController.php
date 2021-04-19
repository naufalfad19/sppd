<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class bahasaController extends Controller
{
    public function swap($locale)
    {
        if (array_key_exists($locale, config('locale.languages'))) {
            session()->put('locale', $locale);
        }


        return redirect()->back();
    }
}
