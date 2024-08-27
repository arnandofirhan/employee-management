<?php

namespace App\View\Components;

use Illuminate\View\Component;
use NumberFormatter;

class NumberFormat extends Component
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
        string $suffix = '',
        int $maxFractionDigits = 2,
        int $minFractionDigits = 0
    ) {
        $this->amount = $amount;
        $this->locale = $locale ?? app()->getLocale();
        $this->maxFractionDigits = $maxFractionDigits;
        $this->minFractionDigits = $minFractionDigits;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
    }

    public function render(): string
    {
        if (is_numeric($this->amount)) {
            $numberFormatter = new NumberFormatter($this->locale, NumberFormatter::DECIMAL);
            $numberFormatter->setAttribute($numberFormatter::ROUNDING_MODE, $this->minFractionDigits + 1);
            $numberFormatter->setAttribute($numberFormatter::MIN_FRACTION_DIGITS, $this->minFractionDigits);
            $numberFormatter->setAttribute($numberFormatter::MAX_FRACTION_DIGITS, $this->minFractionDigits > $this->maxFractionDigits ? $this->minFractionDigits : $this->maxFractionDigits);

            return ($this->amount < 0 ? '- ' : '') . $this->prefix . $numberFormatter->format($this->amount) . $this->suffix;
        } else {
            return '';
        }
    }
}
