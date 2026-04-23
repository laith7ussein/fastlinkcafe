<?php

namespace App\Support;

use App\Models\MenuSetting;

final class GoogleFontsCatalog
{
    /**
     * @return list<string>
     */
    public static function families(): array
    {
        $raw = config('google_fonts.families', []);
        if (! is_array($raw)) {
            return [];
        }
        $out = array_values(array_unique(array_filter(array_map('strval', $raw))));

        sort($out, SORT_STRING);

        if ($out === []) {
            return ['Outfit', 'Noto Sans Arabic'];
        }

        return $out;
    }

    public static function isValid(?string $name): bool
    {
        if ($name === null || trim($name) === '') {
            return false;
        }

        return in_array($name, self::families(), true);
    }

    /**
     * Google Fonts CSS2 URL for Outfit + Noto Sans Arabic + any per-locale picks on the setting row.
     */
    public static function stylesheetHrefForSettings(MenuSetting $settings): string
    {
        $families = ['Outfit', 'Noto Sans Arabic'];
        foreach (['font_en_family', 'font_ar_family', 'font_ku_family'] as $key) {
            $v = $settings->getAttribute($key);
            if (is_string($v) && self::isValid($v)) {
                $families[] = $v;
            }
        }
        $families = array_values(array_unique($families));

        return self::buildCss2Href($families);
    }

    /**
     * @param  list<string>  $families
     */
    public static function buildCss2Href(array $families): string
    {
        $parts = [];
        foreach ($families as $fam) {
            $fam = trim($fam);
            if ($fam === '') {
                continue;
            }
            $q = str_replace(' ', '+', $fam);
            $parts[] = 'family='.$q.':wght@400;500;600;700';
        }
        if ($parts === []) {
            return 'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap';
        }

        return 'https://fonts.googleapis.com/css2?'.implode('&', $parts).'&display=swap';
    }
}
