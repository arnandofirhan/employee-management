<?php

namespace App\Repositories\Helpers;

class NumberFormatHelperRepository
{
    public function stringToNumber($value): float
    {
        $numberFormatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::DECIMAL);
        $value = str_replace($numberFormatter->getSymbol($numberFormatter::GROUPING_SEPARATOR_SYMBOL), "", $value);
        $value = str_replace($numberFormatter->getSymbol($numberFormatter::DECIMAL_SEPARATOR_SYMBOL), ".", $value);

        return (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
