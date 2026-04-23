<?php

namespace App\Models;

use App\Support\MenuLocale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'name_ku',
        'slug',
        'image_url',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    public function activeMenuItems(): HasMany
    {
        return $this->menuItems()->where('is_active', true);
    }

    public function nameFor(?string $locale = null): string
    {
        $locale = MenuLocale::normalize($locale);
        foreach ([$locale, 'en', 'ar', 'ku'] as $code) {
            $key = 'name_'.$code;
            $v = $this->getAttribute($key);
            if (is_string($v) && trim($v) !== '') {
                return $v;
            }
        }

        return '';
    }

    public function nameForAdmin(): string
    {
        return $this->nameFor('en');
    }
}
