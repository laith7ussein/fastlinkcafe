@extends('admin.layout')

@section('title', 'Site & menu')

@section('content')
    <h1 class="text-2xl font-semibold mb-2">Site & public menu</h1>
    <p class="text-sm text-zinc-500 mb-8">Branding, hero cover, contact, and social links appear on the customer-facing menu at <a href="{{ route('menu') }}" target="_blank" class="text-amber-400 hover:underline">/</a>.</p>

    <form method="post" action="{{ route('admin.menu-appearance.update') }}" enctype="multipart/form-data" class="max-w-2xl space-y-10">
        @csrf
        @method('PUT')

        <section class="space-y-4">
            <h2 class="text-sm font-semibold text-zinc-300 uppercase tracking-wide">Public languages</h2>
            <p class="text-xs text-zinc-600 -mt-2">Customers only see enabled languages on the menu language picker and first-visit prompt. At least one must stay on.</p>
            @error('lang_en_enabled')
                <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-2 text-sm text-zinc-300">
                    <input type="checkbox" name="lang_en_enabled" value="1" class="rounded border-zinc-600 bg-zinc-950 text-amber-500"
                        @checked(old('lang_en_enabled', $settings->lang_en_enabled))>
                    English (EN)
                </label>
                <label class="flex items-center gap-2 text-sm text-zinc-300">
                    <input type="checkbox" name="lang_ar_enabled" value="1" class="rounded border-zinc-600 bg-zinc-950 text-amber-500"
                        @checked(old('lang_ar_enabled', $settings->lang_ar_enabled))>
                    العربية (AR)
                </label>
                <label class="flex items-center gap-2 text-sm text-zinc-300">
                    <input type="checkbox" name="lang_ku_enabled" value="1" class="rounded border-zinc-600 bg-zinc-950 text-amber-500"
                        @checked(old('lang_ku_enabled', $settings->lang_ku_enabled))>
                    کوردی (KU)
                </label>
            </div>
        </section>

        <section class="space-y-6">
            <h2 class="text-sm font-semibold text-zinc-300 uppercase tracking-wide">Google Fonts (public menu)</h2>
            <p class="text-xs text-zinc-600 -mt-2">Pick a font from the list for each language. We load weights 400–700 from Google Fonts and keep <strong class="text-zinc-400">Outfit</strong> and <strong class="text-zinc-400">Noto Sans Arabic</strong> as fallbacks. Add more names in <code class="text-zinc-500">config/google_fonts.php</code> if needed.</p>

            @foreach ([
                'en' => ['label' => 'English (EN)'],
                'ar' => ['label' => 'Arabic (AR)'],
                'ku' => ['label' => 'Kurdish (KU)'],
            ] as $code => $meta)
                @php $famKey = 'font_'.$code.'_family'; @endphp
                <div class="rounded-lg border border-zinc-800 bg-zinc-900/30 p-4 space-y-2">
                    <h3 class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">{{ $meta['label'] }}</h3>
                    @error('font_'.$code.'_family')
                        <p class="text-xs text-red-400">{{ $message }}</p>
                    @enderror
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Font</label>
                    <select name="font_{{ $code }}_family" class="w-full max-w-md rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
                        <option value="">Default (Outfit + Noto Sans Arabic)</option>
                        @foreach ($googleFontFamilies as $familyName)
                            <option value="{{ $familyName }}" @selected(old('font_'.$code.'_family', $settings->{$famKey}) === $familyName)>{{ $familyName }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </section>

        <section class="space-y-4">
            <h2 class="text-sm font-semibold text-zinc-300 uppercase tracking-wide">Branding</h2>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Brand accent color</label>
                <input type="color" name="brand_accent_color" value="{{ old('brand_accent_color', $settings->brandAccentColorSafe()) }}"
                    class="h-10 w-28 cursor-pointer rounded border border-zinc-700 bg-zinc-950 p-1">
                <p class="text-xs text-zinc-600 mt-1">Used for prices, highlights, and buttons on the public menu (hex #RRGGBB).</p>
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Currency code</label>
                <input name="currency_code" value="{{ old('currency_code', $settings->currencyCode()) }}" maxlength="12" placeholder="IQD" pattern="[A-Za-z]+" required dir="ltr"
                    class="w-full max-w-xs rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm uppercase focus:ring-2 focus:ring-amber-500/40">
                <p class="text-xs text-zinc-600 mt-1">ISO-style code shown after prices on the public menu (default IQD).</p>
            </div>
            <label class="flex items-start gap-2 text-sm text-zinc-300">
                <input type="checkbox" name="price_show_cents" value="1" class="mt-0.5 rounded border-zinc-600 bg-zinc-950 text-amber-500"
                    @checked(old('price_show_cents', $settings->price_show_cents))>
                <span>Show cents in prices (e.g. <span class="text-zinc-400">10.00</span>); turn off for whole units (e.g. <span class="text-zinc-400">10</span>).</span>
            </label>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Site name — English</label>
                <input name="site_name_en" value="{{ old('site_name_en', $settings->site_name_en) }}" maxlength="160" placeholder="{{ config('app.name') }}"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Site name — العربية</label>
                <input name="site_name_ar" value="{{ old('site_name_ar', $settings->site_name_ar) }}" maxlength="160"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40" dir="rtl">
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Site name — کوردی</label>
                <input name="site_name_ku" value="{{ old('site_name_ku', $settings->site_name_ku) }}" maxlength="160"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40" dir="rtl">
            </div>
            <p class="text-xs text-zinc-600 -mt-2">Shown in the menu header, hero, and browser title. Empty fields fall back to another language when possible, then to the app name in the tab title.</p>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Logo image URL</label>
                <input name="logo_url" type="url" value="{{ old('logo_url', $settings->logo_url) }}" maxlength="2048" placeholder="https://…"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Or upload logo</label>
                <input name="logo" type="file" accept="image/jpeg,image/png,image/gif,image/webp"
                    class="block w-full text-sm text-zinc-400 file:mr-3 file:rounded-lg file:border-0 file:bg-zinc-800 file:px-3 file:py-2 file:text-zinc-200 file:text-sm">
                <p class="text-xs text-zinc-600 mt-1">Square or wide PNG/SVG-style assets work well (max 4&nbsp;MB).</p>
            </div>
            @if ($settings->logo_url)
                <div class="flex items-center gap-3 rounded-lg border border-zinc-800 bg-zinc-900/40 p-3">
                    <img src="{{ $settings->logo_url }}" alt="Current logo" class="h-12 w-auto max-w-[140px] object-contain">
                    <label class="flex items-center gap-2 text-sm text-zinc-400">
                        <input type="checkbox" name="remove_logo" value="1" class="rounded border-zinc-600 bg-zinc-950 text-amber-500">
                        Remove logo
                    </label>
                </div>
            @endif
        </section>

        <section class="space-y-4">
            <h2 class="text-sm font-semibold text-zinc-300 uppercase tracking-wide">Hero cover</h2>
            @if ($settings->cover_image_url)
                <div class="rounded-lg border border-zinc-800 overflow-hidden bg-zinc-900/40">
                    <img src="{{ $settings->cover_image_url }}" alt="Current cover" class="w-full max-h-48 object-cover">
                </div>
            @endif
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Cover image URL</label>
                <input name="cover_image_url" type="url" value="{{ old('cover_image_url', $settings->cover_image_url) }}" maxlength="2048" placeholder="https://…"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Or upload cover</label>
                <input name="cover_image" type="file" accept="image/jpeg,image/png,image/gif,image/webp"
                    class="block w-full text-sm text-zinc-400 file:mr-3 file:rounded-lg file:border-0 file:bg-zinc-800 file:px-3 file:py-2 file:text-zinc-200 file:text-sm">
                <p class="text-xs text-zinc-600 mt-1">Wide images (for example 1200×600), max 6&nbsp;MB. Upload replaces the URL.</p>
            </div>
            @if ($settings->cover_image_url)
                <label class="flex items-center gap-2 text-sm text-zinc-400">
                    <input type="checkbox" name="remove_cover" value="1" class="rounded border-zinc-600 bg-zinc-950 text-amber-500">
                    Remove cover image
                </label>
            @endif
        </section>

        <section class="space-y-4">
            <h2 class="text-sm font-semibold text-zinc-300 uppercase tracking-wide">Contact</h2>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Phone</label>
                <input name="phone" value="{{ old('phone', $settings->phone) }}" maxlength="80" placeholder="+1 555 000 0000"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Address — English</label>
                <textarea name="address_en" rows="3" maxlength="500" placeholder="Street, city"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">{{ old('address_en', $settings->address_en) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Address — العربية</label>
                <textarea name="address_ar" rows="3" maxlength="500" dir="rtl"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">{{ old('address_ar', $settings->address_ar) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1">Address — کوردی</label>
                <textarea name="address_ku" rows="3" maxlength="500" dir="rtl"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">{{ old('address_ku', $settings->address_ku) }}</textarea>
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="text-sm font-semibold text-zinc-300 uppercase tracking-wide">Social links</h2>
            <p class="text-xs text-zinc-600 -mt-2">Full profile URLs. Shown as icons on the menu hero.</p>
            @foreach ([
                'social_facebook_url' => 'Facebook',
                'social_instagram_url' => 'Instagram',
                'social_twitter_url' => 'X (Twitter)',
                'social_tiktok_url' => 'TikTok',
                'social_snapchat_url' => 'Snapchat',
                'social_youtube_url' => 'YouTube',
            ] as $field => $label)
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">{{ $label }}</label>
                    <input name="{{ $field }}" type="url" value="{{ old($field, $settings->{$field}) }}" maxlength="2048" placeholder="https://…"
                        class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
                </div>
            @endforeach
        </section>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-amber-400">Save all</button>
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-zinc-700 px-4 py-2 text-sm text-zinc-300 hover:bg-zinc-800">Cancel</a>
        </div>
    </form>
@endsection
