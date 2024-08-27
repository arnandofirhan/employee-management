<?php

namespace App\Constants;

use Illuminate\Support\Str;

abstract class BaseConstant
{
    abstract public static function texts(): array;

    public static function text($key): ?string
    {
        if (isset(static::texts()[$key])) {
            return static::texts()[$key];
        }

        return null;
    }

    public static function labels(): array
    {
        $data = [];
        foreach (static::texts() as $value => $text) {
            $data[$value] = Str::snake($text);
        }

        return $data;
    }

    public static function label($key): ?string
    {
        if (isset(static::texts()[$key])) {
            return Str::snake(static::texts()[$key]);
        }

        return null;
    }

    public static function slugs(): array
    {
        $data = [];
        foreach (static::texts() as $value => $text) {
            $data[$value] = Str::kebab($text);
        }

        return $data;
    }

    public static function slug($key): ?string
    {
        if (isset(static::texts()[$key])) {
            return Str::kebab(static::texts()[$key]);
        }

        return null;
    }

    public static function textLabel(string $label): ?string
    {
        return ucwords(str_replace('_', ' ', $label));
    }
}
