<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MenuAppearanceController extends Controller
{
    public function edit(): View
    {
        $settings = MenuSetting::instance();

        return view('admin.menu_appearance.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'brand_accent_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'site_name_en' => ['nullable', 'string', 'max:160'],
            'site_name_ar' => ['nullable', 'string', 'max:160'],
            'site_name_ku' => ['nullable', 'string', 'max:160'],
            'phone' => ['nullable', 'string', 'max:80'],
            'address_en' => ['nullable', 'string', 'max:500'],
            'address_ar' => ['nullable', 'string', 'max:500'],
            'address_ku' => ['nullable', 'string', 'max:500'],
            'cover_image_url' => ['nullable', 'url', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:6144'],
            'remove_cover' => ['sometimes', 'boolean'],
            'logo_url' => ['nullable', 'url', 'max:2048'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:4096'],
            'remove_logo' => ['sometimes', 'boolean'],
            'social_facebook_url' => ['nullable', 'url', 'max:2048'],
            'social_instagram_url' => ['nullable', 'url', 'max:2048'],
            'social_twitter_url' => ['nullable', 'url', 'max:2048'],
            'social_tiktok_url' => ['nullable', 'url', 'max:2048'],
            'social_youtube_url' => ['nullable', 'url', 'max:2048'],
        ]);

        $langEn = $request->boolean('lang_en_enabled');
        $langAr = $request->boolean('lang_ar_enabled');
        $langKu = $request->boolean('lang_ku_enabled');
        if (! $langEn && ! $langAr && ! $langKu) {
            return redirect()->back()
                ->withErrors(['lang_en_enabled' => 'Enable at least one language for the public menu.'])
                ->withInput();
        }

        $settings = MenuSetting::instance();

        $coverUrl = $this->resolveCoverUrl($request, $settings->cover_image_url);
        $logoUrl = $this->resolveLogoUrl($request, $settings->logo_url);

        $settings->update([
            'cover_image_url' => $coverUrl,
            'logo_url' => $logoUrl,
            'brand_accent_color' => $request->input('brand_accent_color'),
            'site_name_en' => $this->blankToNull($request->input('site_name_en')),
            'site_name_ar' => $this->blankToNull($request->input('site_name_ar')),
            'site_name_ku' => $this->blankToNull($request->input('site_name_ku')),
            'phone' => $this->blankToNull($request->input('phone')),
            'address_en' => $this->blankToNull($request->input('address_en')),
            'address_ar' => $this->blankToNull($request->input('address_ar')),
            'address_ku' => $this->blankToNull($request->input('address_ku')),
            'lang_en_enabled' => $langEn,
            'lang_ar_enabled' => $langAr,
            'lang_ku_enabled' => $langKu,
            'social_facebook_url' => $this->blankToNull($request->input('social_facebook_url')),
            'social_instagram_url' => $this->blankToNull($request->input('social_instagram_url')),
            'social_twitter_url' => $this->blankToNull($request->input('social_twitter_url')),
            'social_tiktok_url' => $this->blankToNull($request->input('social_tiktok_url')),
            'social_youtube_url' => $this->blankToNull($request->input('social_youtube_url')),
        ]);

        return redirect()->route('admin.menu-appearance.edit')->with('status', 'Site & menu settings saved.');
    }

    private function resolveCoverUrl(Request $request, ?string $current): ?string
    {
        if ($request->boolean('remove_cover')) {
            $this->deleteStoredUnderPrefix($current, 'menu-covers/');

            return null;
        }

        if ($request->hasFile('cover_image')) {
            $this->deleteStoredUnderPrefix($current, 'menu-covers/');

            return $this->storePublicImage($request->file('cover_image'), 'menu-covers');
        }

        if ($request->filled('cover_image_url')) {
            $new = $request->input('cover_image_url');
            if ($new !== $current) {
                $this->deleteStoredUnderPrefix($current, 'menu-covers/');
            }

            return $new;
        }

        return $current;
    }

    private function resolveLogoUrl(Request $request, ?string $current): ?string
    {
        if ($request->boolean('remove_logo')) {
            $this->deleteStoredUnderPrefix($current, 'site-logos/');

            return null;
        }

        if ($request->hasFile('logo')) {
            $this->deleteStoredUnderPrefix($current, 'site-logos/');

            return $this->storePublicImage($request->file('logo'), 'site-logos');
        }

        if ($request->filled('logo_url')) {
            $new = $request->input('logo_url');
            if ($new !== $current) {
                $this->deleteStoredUnderPrefix($current, 'site-logos/');
            }

            return $new;
        }

        return $current;
    }

    private function blankToNull(?string $v): ?string
    {
        $t = $v !== null ? trim($v) : '';

        return $t === '' ? null : $t;
    }

    private function storePublicImage(UploadedFile $file, string $directory): string
    {
        $path = $file->store($directory, 'public');

        return Storage::disk('public')->url($path);
    }

    private function deleteStoredUnderPrefix(?string $url, string $prefix): void
    {
        $relative = $this->publicStoragePathFromUrl($url);
        if ($relative !== null && str_starts_with($relative, $prefix)) {
            Storage::disk('public')->delete($relative);
        }
    }

    private function publicStoragePathFromUrl(?string $url): ?string
    {
        if (! is_string($url) || $url === '') {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);
        if (! is_string($path)) {
            return null;
        }

        $storagePrefix = '/storage/';
        if (! str_starts_with($path, $storagePrefix)) {
            return null;
        }

        return substr($path, strlen($storagePrefix));
    }
}
