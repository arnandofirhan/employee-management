<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MainGuestAuthLayout extends Component
{
    public function render(): View
    {
        return view('auth.layouts.main.guest');
    }
}
