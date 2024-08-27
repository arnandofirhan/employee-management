<?php

namespace App\Http\Controllers\Languages;

use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function switch(string $lang)
    {
        if (!empty(config('languages')[$lang])) {
            session()->put('locale', $lang);
        }

        return redirect()->back();
    }
}
