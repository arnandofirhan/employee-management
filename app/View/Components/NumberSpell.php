<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Config;
use Illuminate\View\Component;
use Riskihajar\Terbilang\Facades\Terbilang;

class NumberSpell extends Component
{
    public $amount;
    public $locale;
    public $maxFractionDigits;
    public $minFractionDigits;
    public $prefix;
    public $suffix;

    public function __construct(
        $amount,
        string $locale = null,
        string $prefix = '',
        string $suffix = ''
    ) {
        $this->amount = $amount;
        $this->locale = $locale ?? app()->getLocale();
        $this->prefix = $prefix;
        $this->suffix = $suffix;
    }

    public function render()
    {
        if (is_numeric($this->amount)) {
            Config::set('terbilang.locale', $this->locale);
            $res = Terbilang::make($this->amount, $this->suffix ? ' rupiah' : '', $this->prefix ? 'senilai ' : '');

            return $res->value;
        } else {
            return '';
        }
    }
}
