<?php

namespace App\Constants;

class GenderCategoryConstant extends BaseConstant
{
    const MALE = 1;
    const FEMALE = 2;

    public static function texts(): array
    {
        return [
            self::MALE => 1,
            self::FEMALE => 2,
        ];
    }
}
