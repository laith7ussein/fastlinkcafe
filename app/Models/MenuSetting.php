<?php

namespace App\Models;

use App\Support\MenuLocale;
use Illuminate\Database\Eloquent\Model;

class MenuSetting extends Model
{
    protected $fillable = [
        'cover_image_url',
        'brand_accent_color',
        'site_name_en',
        'site_name_ar',
        'site_name_ku',
        'logo_url',
        'phone',
        'address_en',
        'address_ar',
        'address_ku',
        'lang_en_enabled',
        'lang_ar_enabled',
        'lang_ku_enabled',
        'social_facebook_url',
        'social_instagram_url',
        'social_twitter_url',
        'social_tiktok_url',
        'social_youtube_url',
    ];

    protected function casts(): array
    {
        return [
            'lang_en_enabled' => 'boolean',
            'lang_ar_enabled' => 'boolean',
            'lang_ku_enabled' => 'boolean',
        ];
    }

    public static function instance(): self
    {
        $row = static::query()->first();

        if ($row) {
            return $row;
        }

        return static::query()->create([
            'cover_image_url' => null,
            'brand_accent_color' => '#d4a853',
            'site_name_en' => null,
            'site_name_ar' => null,
            'site_name_ku' => null,
            'logo_url' => null,
            'phone' => null,
            'address_en' => null,
            'address_ar' => null,
            'address_ku' => null,
            'lang_en_enabled' => true,
            'lang_ar_enabled' => true,
            'lang_ku_enabled' => true,
            'social_facebook_url' => null,
            'social_instagram_url' => null,
            'social_twitter_url' => null,
            'social_tiktok_url' => null,
            'social_youtube_url' => null,
        ]);
    }

    /**
     * @return list<string>
     */
    public function enabledLocales(): array
    {
        $out = [];
        foreach (MenuLocale::SUPPORTED as $code) {
            $key = 'lang_'.$code.'_enabled';
            if ($this->getAttribute($key)) {
                $out[] = $code;
            }
        }

        return $out !== [] ? $out : ['en'];
    }

    public function isLocaleEnabled(string $locale): bool
    {
        $locale = MenuLocale::normalize($locale);
        $key = 'lang_'.$locale.'_enabled';

        return (bool) $this->getAttribute($key);
    }

    public function siteNameFor(?string $locale = null): string
    {
        $locale = MenuLocale::normalize($locale);
        foreach ([$locale, 'en', 'ar', 'ku'] as $code) {
            $v = $this->getAttribute('site_name_'.$code);
            if (is_string($v) && trim($v) !== '') {
                return $v;
            }
        }

        return '';
    }

    public function addressFor(?string $locale = null): string
    {
        $locale = MenuLocale::normalize($locale);
        foreach ([$locale, 'en', 'ar', 'ku'] as $code) {
            $v = $this->getAttribute('address_'.$code);
            if (is_string($v) && trim($v) !== '') {
                return $v;
            }
        }

        return '';
    }

    public function hasAnySiteName(): bool
    {
        foreach (MenuLocale::SUPPORTED as $code) {
            $v = $this->getAttribute('site_name_'.$code);
            if (is_string($v) && trim($v) !== '') {
                return true;
            }
        }

        return false;
    }

    public function hasAnyAddress(): bool
    {
        foreach (MenuLocale::SUPPORTED as $code) {
            $v = $this->getAttribute('address_'.$code);
            if (is_string($v) && trim($v) !== '') {
                return true;
            }
        }

        return false;
    }

    public function displayName(?string $locale = null): string
    {
        $name = $this->siteNameFor($locale);

        return $name !== '' ? $name : (string) config('app.name', 'Menu');
    }

    public function brandAccentColorSafe(): string
    {
        $c = $this->brand_accent_color ?? '#d4a853';

        return is_string($c) && preg_match('/^#[0-9A-Fa-f]{6}$/', $c) ? $c : '#d4a853';
    }
}
