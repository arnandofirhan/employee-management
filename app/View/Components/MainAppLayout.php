<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MainAppLayout extends Component
{
    public $title;
    public $breadcrumbs;
    public $isCenter;

    public function __construct(
        string $title = null,
        array $breadcrumbs = [],
        bool $isCenter = false
    ) {
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
        $this->isCenter = $isCenter;
    }

    public function render(): View
    {
        $data['title'] = $this->title;
        $data['breadcrumbs'] = $this->breadcrumbs;
        $data['isCenter'] = $this->isCenter;

        return view('layouts.main.app', $data);
    }
}
