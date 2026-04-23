<?php

namespace App\Support;

final class MenuLocale
{
    public const SUPPORTED = ['en', 'ar', 'ku'];

    public static function normalize(?string $value): string
    {
        $v = $value ?? 'en';

        return in_array($v, self::SUPPORTED, true) ? $v : 'en';
    }

    public static function htmlLang(string $locale): string
    {
        return match ($locale) {
            'ku' => 'ckb',
            'ar' => 'ar',
            default => 'en',
        };
    }

    public static function isRtl(string $locale): bool
    {
        return in_array($locale, ['ar', 'ku'], true);
    }
}
