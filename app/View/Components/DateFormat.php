<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;

class DateFormat extends Component
{
    public $date;
    public $locale;
    public $format;

    public function __construct(
        $date,
        string $locale = null,
        string $format = 'l, j F Y H:i:s',
    ) {
        $this->date = $date;
        $this->locale = $locale ?? app()->getLocale();
        $this->format = $format;
    }

    public function render()
    {
        return Carbon::parse($this->date)->locale($this->locale)->settings(['formatFunction' => 'translatedFormat'])->format($this->format);
    }
}
