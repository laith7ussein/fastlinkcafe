<?php

namespace App\Models;

use App\Support\MenuLocale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    protected $fillable = [
        'category_id',
        'name_en',
        'name_ar',
        'name_ku',
        'description_en',
        'description_ar',
        'description_ku',
        'price',
        'image_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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

    public function descriptionFor(?string $locale = null): ?string
    {
        $locale = MenuLocale::normalize($locale);
        foreach ([$locale, 'en', 'ar', 'ku'] as $code) {
            $key = 'description_'.$code;
            $v = $this->getAttribute($key);
            if (is_string($v) && trim($v) !== '') {
                return $v;
            }
        }

        return null;
    }

    public function nameForAdmin(): string
    {
        return $this->nameFor('en');
    }
}
