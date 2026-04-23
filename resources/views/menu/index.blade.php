@php
    $__accent = $settings->brandAccentColorSafe();
@endphp
<!DOCTYPE html>
<html lang="{{ \App\Support\MenuLocale::htmlLang($lang) }}" dir="{{ \App\Support\MenuLocale::isRtl($lang) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->displayName($lang) }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        (function () {
            try {
                var ENABLED = @json($enabled);
                var p = new URLSearchParams(window.location.search);
                var q = p.get('lang');
                if (ENABLED.length === 1
                    || localStorage.getItem('fastlinkmenu_lang_gate_v1')
                    || (q && ENABLED.indexOf(q) >= 0)) {
                    document.documentElement.classList.add('lang-gate-done');
                }
            } catch (e) {}
        })();
    </script>
    <style>
        :root {
            --bg: #0c0c0f;
            --surface: #14141a;
            --surface2: #1c1c24;
            --border: #2a2a34;
            --text: #f4f4f5;
            --muted: #a1a1aa;
            --accent: {{ $__accent }};
            --accent-dim: color-mix(in srgb, var(--accent) 18%, transparent);
            --safe-b: env(safe-area-inset-bottom, 0px);
            --safe-t: env(safe-area-inset-top, 0px);
            --font-sans: 'Outfit', 'Noto Sans Arabic', ui-sans-serif, system-ui, sans-serif;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: var(--font-sans);
            background: var(--bg);
            color: var(--text);
            min-height: 100dvh;
            padding-bottom: calc(1rem + var(--safe-b));
        }
        html:not(.lang-gate-done) body {
            overflow: hidden;
        }
        .lang-gate {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            padding-top: max(1.25rem, var(--safe-t));
            padding-bottom: max(1.25rem, var(--safe-b));
            background: rgba(8, 8, 10, 0.92);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        html:not(.lang-gate-done) .lang-gate {
            display: flex;
        }
        .lang-gate-card {
            width: 100%;
            max-width: 22rem;
            border-radius: 18px;
            border: 1px solid var(--border);
            background: var(--surface);
            padding: 1.25rem 1.1rem 1.1rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.55);
        }
        .lang-gate-card h2 {
            margin: 0 0 0.35rem;
            font-size: 1.15rem;
            font-weight: 700;
            text-align: center;
            letter-spacing: -0.02em;
        }
        .lang-gate-card p {
            margin: 0 0 1rem;
            font-size: 0.8rem;
            color: var(--muted);
            text-align: center;
            line-height: 1.45;
        }
        .lang-gate-btns {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }
        .lang-gate-btns button {
            width: 100%;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: var(--surface2);
            color: var(--text);
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0.75rem 1rem;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        .lang-gate-btns button:active {
            background: color-mix(in srgb, var(--accent) 22%, var(--surface2));
            border-color: var(--accent-dim);
        }
        .lang-gate-btns button.primary {
            background: var(--accent);
            color: #111;
            border-color: transparent;
        }
        .lang-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
            gap: 0.35rem;
            padding: 0 0 0.65rem;
        }
        .lang-bar a {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.35rem 0.55rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--muted);
            border: 1px solid transparent;
        }
        .lang-bar a.is-active {
            color: var(--accent);
            border-color: var(--accent-dim);
            background: color-mix(in srgb, var(--accent) 12%, transparent);
        }
        .top {
            position: sticky;
            top: 0;
            z-index: 30;
            background: linear-gradient(
                180deg,
                rgba(12, 12, 15, 0.98) 0%,
                rgba(12, 12, 15, 0.96) 52%,
                rgba(12, 12, 15, 0.92) 78%,
                rgba(12, 12, 15, 0.55) 100%
            );
            padding: calc(0.75rem + var(--safe-t)) 1rem 0.5rem;
        }
        .top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }
        .brand-block {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            min-width: 0;
            flex: 1;
        }
        .brand-logo {
            height: 34px;
            width: auto;
            max-width: 100px;
            object-fit: contain;
            flex-shrink: 0;
        }
        .brand {
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: -0.02em;
            color: var(--text);
            line-height: 1.2;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .basket-btn {
            position: relative;
            width: 44px; height: 44px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        .basket-btn:active { transform: scale(0.96); }
        .basket-count {
            position: absolute;
            top: 4px; right: 4px;
            min-width: 18px; height: 18px;
            padding: 0 5px;
            border-radius: 999px;
            background: var(--accent);
            color: #111;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
        .basket-count:empty, .basket-count[data-q="0"] { display: none; }
        .menu-cover {
            position: relative;
            width: 100%;
            overflow: hidden;
            background: var(--surface2);
        }
        .menu-cover-bg {
            width: 100%;
            height: clamp(10.5rem, 36dvh, 20rem);
            object-fit: cover;
            display: block;
        }
        .menu-cover-fallback {
            width: 100%;
            height: clamp(10.5rem, 36dvh, 20rem);
            background: linear-gradient(160deg, #1a1a22 0%, var(--bg) 100%);
        }
        .menu-cover::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(12, 12, 15, 0.82) 0%,
                rgba(12, 12, 15, 0.35) 38%,
                rgba(12, 12, 15, 0.45) 62%,
                rgba(12, 12, 15, 0.88) 100%
            );
            pointer-events: none;
            z-index: 1;
        }
        .menu-cover-inner {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            padding: 0.45rem 0.85rem 0.55rem;
            display: flex;
            flex-direction: column;
            gap: 0.18rem;
        }
        .cover-title {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
            text-shadow: 0 1px 12px rgba(0,0,0,0.65);
        }
        .cover-addr {
            margin: 0;
            font-size: 0.72rem;
            line-height: 1.28;
            color: rgba(244,244,245,0.92);
            text-shadow: 0 1px 8px rgba(0,0,0,0.55);
            white-space: pre-line;
        }
        .cover-phone {
            margin: 0;
        }
        .cover-phone a {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--accent);
            text-decoration: none;
            text-shadow: 0 1px 8px rgba(0,0,0,0.5);
        }
        .cover-phone a:active { opacity: 0.85; }
        .cover-socials {
            display: flex;
            flex-wrap: wrap;
            gap: 0.28rem;
            margin-top: 0.05rem;
        }
        .cover-socials a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: rgba(12,12,15,0.55);
            border: 1px solid rgba(255,255,255,0.12);
            color: var(--text);
            -webkit-tap-highlight-color: transparent;
        }
        .cover-socials a:active { transform: scale(0.96); }
        .cover-socials svg { width: 18px; height: 18px; opacity: 0.95; }
        .cover-hero-logo {
            align-self: flex-start;
            max-height: 2.35rem;
            width: auto;
            max-width: 140px;
            object-fit: contain;
            filter: drop-shadow(0 2px 10px rgba(0,0,0,0.55));
        }
        .cats-wrap {
            position: relative;
            margin: 0 -1rem;
            padding: 0.35rem 1rem 0.45rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            background: linear-gradient(
                180deg,
                rgba(12, 12, 15, 0) 0%,
                rgba(12, 12, 15, 0.45) 42%,
                rgba(12, 12, 15, 0.88) 72%,
                rgba(12, 12, 15, 0.98) 100%
            );
        }
        .cats-wrap::-webkit-scrollbar { display: none; }
        .cats {
            display: flex;
            gap: 0.65rem;
            padding-bottom: 0.15rem;
            scroll-snap-type: x mandatory;
        }
        .cat-pill {
            flex: 0 0 auto;
            scroll-snap-align: start;
            width: 5.5rem;
            text-align: center;
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0;
            color: inherit;
            -webkit-tap-highlight-color: transparent;
        }
        .cat-pill .img {
            width: 5.5rem; height: 5.5rem;
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid transparent;
            transition: border-color 0.2s, box-shadow 0.2s;
            margin: 0 auto 0.35rem;
            background: var(--surface2);
        }
        .cat-pill.is-active .img {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }
        .cat-pill img {
            width: 100%; height: 100%;
            object-fit: cover;
            display: block;
        }
        .cat-pill .lbl {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1.2;
            max-width: 5.5rem;
            margin: 0 auto;
            padding: 0.28rem 0.35rem 0.32rem;
            border-radius: 8px;
            background: linear-gradient(
                180deg,
                rgba(28, 28, 36, 0.92) 0%,
                rgba(18, 18, 24, 0.96) 100%
            );
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
        }
        .cat-pill.is-active .lbl {
            color: var(--accent);
            border-color: var(--accent-dim);
            background: linear-gradient(
                180deg,
                color-mix(in srgb, var(--accent) 22%, rgba(18, 18, 24, 0.98)) 0%,
                rgba(18, 18, 24, 0.98) 100%
            );
        }
        main { padding: 0 1rem; }
        .section {
            scroll-margin-top: calc(var(--safe-t) + 15rem);
            margin-bottom: 2rem;
        }
        .section h2 {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            margin: 0 0 0.75rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.65rem;
        }
        @media (min-width: 480px) {
            .grid { grid-template-columns: repeat(3, 1fr); }
        }
        .card {
            border-radius: 14px;
            overflow: hidden;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text);
            text-align: left;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
            transition: border-color 0.15s;
        }
        .card:active { border-color: #3f3f4a; }
        .card .ph {
            aspect-ratio: 1;
            background: var(--surface2);
            position: relative;
        }
        .card .ph img {
            width: 100%; height: 100%;
            object-fit: cover;
            display: block;
        }
        .card .meta { padding: 0.5rem 0.6rem 0.65rem; }
        .card .name {
            font-size: 0.82rem;
            font-weight: 600;
            line-height: 1.25;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card .price {
            margin-top: 0.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--accent);
        }
        .empty {
            text-align: center;
            padding: 4rem 1rem;
            color: var(--muted);
            font-size: 0.95rem;
        }
        /* Modal */
        .backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.72);
            z-index: 50;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        .backdrop.open { opacity: 1; pointer-events: auto; }
        .sheet {
            position: fixed;
            left: 0; right: 0; bottom: 0;
            z-index: 51;
            max-height: min(88dvh, 640px);
            background: var(--surface);
            border-radius: 20px 20px 0 0;
            border: 1px solid var(--border);
            border-bottom: none;
            transform: translateY(105%);
            transition: transform 0.28s cubic-bezier(0.32, 0.72, 0, 1);
            display: flex;
            flex-direction: column;
            padding-bottom: var(--safe-b);
        }
        .sheet.open { transform: translateY(0); }
        .sheet-handle {
            width: 36px; height: 4px;
            border-radius: 2px;
            background: #3f3f46;
            margin: 0.6rem auto 0;
        }
        .sheet-img {
            width: 100%;
            max-height: 42dvh;
            object-fit: cover;
            margin-top: 0.5rem;
        }
        .sheet-body { padding: 1rem 1.1rem 1.25rem; overflow-y: auto; flex: 1; }
        .sheet-body h3 { margin: 0 0 0.35rem; font-size: 1.25rem; font-weight: 700; }
        .sheet-body .desc { margin: 0; color: var(--muted); font-size: 0.92rem; line-height: 1.5; }
        .sheet-body .price-big { margin-top: 0.75rem; font-size: 1.35rem; font-weight: 700; color: var(--accent); }
        .sheet-actions {
            padding: 0.75rem 1rem 1rem;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 0.5rem;
        }
        .btn-add {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.85rem 1rem;
            border-radius: 14px;
            border: none;
            background: var(--accent);
            color: #111;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-add:active { transform: scale(0.98); }
        .btn-close-sheet {
            width: 48px;
            border-radius: 14px;
            border: 1px solid var(--border);
            background: var(--surface2);
            color: var(--text);
            font-size: 1.25rem;
            cursor: pointer;
        }
        /* Basket panel */
        .basket-panel {
            position: fixed;
            inset: 0;
            z-index: 60;
            pointer-events: none;
        }
        .basket-panel.open { pointer-events: auto; }
        .basket-panel .bd {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.6);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .basket-panel.open .bd { opacity: 1; }
        .basket-drawer {
            position: absolute;
            top: 0; right: 0;
            width: min(100%, 380px);
            height: 100%;
            background: var(--surface);
            border-left: 1px solid var(--border);
            transform: translateX(100%);
            transition: transform 0.25s ease;
            display: flex;
            flex-direction: column;
        }
        .basket-panel.open .basket-drawer { transform: translateX(0); }
        .basket-head {
            padding: calc(1rem + var(--safe-t)) 1rem 0.75rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .basket-head h2 { margin: 0; font-size: 1.1rem; }
        .basket-list { flex: 1; overflow-y: auto; padding: 0.75rem; }
        .basket-line {
            display: flex;
            gap: 0.65rem;
            padding: 0.65rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.88rem;
        }
        .basket-line img { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; }
        .basket-line .grow { flex: 1; min-width: 0; }
        .basket-line .nm { font-weight: 600; }
        .basket-line .pq { color: var(--muted); font-size: 0.8rem; margin-top: 0.15rem; }
        .basket-remove {
            flex: 0 0 auto;
            align-self: center;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: rgba(20,20,26,0.9);
            color: var(--muted);
            font-size: 1.25rem;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-tap-highlight-color: transparent;
        }
        .basket-remove:active { background: var(--surface2); color: #f87171; }
        .basket-foot { padding: 1rem; border-top: 1px solid var(--border); }
        .basket-foot p { margin: 0 0 0.5rem; font-size: 0.85rem; color: var(--muted); }
    </style>
</head>
<body>
    <div class="lang-gate" id="langGate" role="dialog" aria-modal="true" aria-labelledby="langGateTitle">
        <div class="lang-gate-card">
            <h2 id="langGateTitle">Welcome</h2>
            <p>اختر اللغة · هەڵبژاردنی زمان · Choose your language</p>
            <div class="lang-gate-btns">
                @foreach ($enabled as $i => $code)
                    <button type="button" class="{{ $i === 0 ? 'primary' : '' }}" data-lang="{{ $code }}">@if ($code === 'en')English @elseif ($code === 'ar')العربية @else کوردی @endif</button>
                @endforeach
            </div>
        </div>
    </div>
    @php
        $s = $settings;
        $siteTitle = $s->displayName($lang);
        $hasHeroInner = $s->hasAnySiteName() || $s->logo_url || $s->phone || $s->hasAnyAddress()
            || $s->social_facebook_url || $s->social_instagram_url || $s->social_twitter_url
            || $s->social_tiktok_url || $s->social_youtube_url;
        $heroShows = $s->cover_image_url || $hasHeroInner;
        $telHref = $s->phone ? preg_replace('/[^0-9+]/', '', $s->phone) : '';
    @endphp
    @if ($heroShows)
        <header class="menu-cover">
            @if ($s->cover_image_url)
                <img class="menu-cover-bg" src="{{ $s->cover_image_url }}" alt="" fetchpriority="high" decoding="async" width="1200" height="560">
            @else
                <div class="menu-cover-bg menu-cover-fallback" role="presentation"></div>
            @endif
            @if ($hasHeroInner)
                <div class="menu-cover-inner">
                    @if ($s->logo_url)
                        <img class="cover-hero-logo" src="{{ $s->logo_url }}" alt="" width="160" height="64" loading="lazy" decoding="async">
                    @endif
                    @if ($s->siteNameFor($lang) !== '')
                        <h1 class="cover-title">{{ $s->siteNameFor($lang) }}</h1>
                    @endif
                    @if ($s->addressFor($lang) !== '')
                        <p class="cover-addr">{!! e($s->addressFor($lang)) !!}</p>
                    @endif
                    @if ($s->phone)
                        <p class="cover-phone">
                            <a href="tel:{{ $telHref !== '' ? $telHref : $s->phone }}">{{ $s->phone }}</a>
                        </p>
                    @endif
                    @if ($s->social_facebook_url || $s->social_instagram_url || $s->social_twitter_url || $s->social_tiktok_url || $s->social_youtube_url)
                        <div class="cover-socials">
                            @if ($s->social_facebook_url)
                                <a href="{{ $s->social_facebook_url }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2v-2.3c0-1.99 1.16-3.08 3-3.08.86 0 1.76.15 1.76.15v2h-1.5c-1.49 0-1.95.93-1.95 1.88V12h3.32l-.53 3H13v6.8c4.56-.93 8-4.96 8-9.8z"/></svg>
                                </a>
                            @endif
                            @if ($s->social_instagram_url)
                                <a href="{{ $s->social_instagram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 01-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 017.8 2m-.2 2A3.6 3.6 0 004 7.6v8.8A3.6 3.6 0 007.6 20h8.8a3.6 3.6 0 003.6-3.6V7.6A3.6 3.6 0 0016.4 4H7.6m9.65 1.5a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5M12 7a5 5 0 015 5 5 5 0 01-5 5 5 5 0 01-5-5 5 5 0 015-5m0 2a3 3 0 100 6 3 3 0 000-6z"/></svg>
                                </a>
                            @endif
                            @if ($s->social_twitter_url)
                                <a href="{{ $s->social_twitter_url }}" target="_blank" rel="noopener noreferrer" aria-label="X">
                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                            @if ($s->social_tiktok_url)
                                <a href="{{ $s->social_tiktok_url }}" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>
                                </a>
                            @endif
                            @if ($s->social_youtube_url)
                                <a href="{{ $s->social_youtube_url }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.5 6.2a3 3 0 00-2.1-2.1C19.3 3.5 12 3.5 12 3.5s-7.3 0-9.4.6A3 3 0 00.5 6.2 31.5 31.5 0 000 12a31.5 31.5 0 00.5 5.8 3 3 0 002.1 2.1c2.1.6 9.4.6 9.4.6s7.3 0 9.4-.6a3 3 0 002.1-2.1 31.5 31.5 0 00.5-5.8 31.5 31.5 0 00-.5-5.8zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </header>
    @endif
    <div class="top">
        <div class="top-row">
            <div class="brand-block">
                @if ($s->logo_url && ! ($heroShows && $hasHeroInner))
                    <img class="brand-logo" src="{{ $s->logo_url }}" alt="" width="100" height="40" loading="lazy" decoding="async">
                @endif
                <div class="brand">{{ $siteTitle }}</div>
            </div>
            <button type="button" class="basket-btn" id="openBasket" aria-label="Basket">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 6h15l-1.5 9h-12z"/>
                    <circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/>
                    <path d="M6 6L5 3H2"/>
                </svg>
                <span class="basket-count" id="basketBadge" data-q="0"></span>
            </button>
        </div>
        @if (count($enabled) > 1)
            <div class="lang-bar" role="navigation" aria-label="{{ $lang === 'ar' ? 'اللغة' : ($lang === 'ku' ? 'زمان' : 'Language') }}">
                @foreach ($enabled as $code)
                    <a href="{{ route('menu', ['lang' => $code]) }}" class="{{ $lang === $code ? 'is-active' : '' }}">@if ($code === 'en')English @elseif ($code === 'ar')العربية @else کوردی @endif</a>
                @endforeach
            </div>
        @endif
        @if ($categories->isEmpty())
            <p class="empty" style="padding:1rem 0">No menu categories yet.</p>
        @else
            <div class="cats-wrap" id="catsScroll">
                <div class="cats" id="cats">
                    @foreach ($categories as $cat)
                        <button type="button" class="cat-pill" data-cat="{{ $cat->id }}" data-target="cat-{{ $cat->id }}" aria-label="{{ $cat->nameFor($lang) }}">
                            <div class="img"><img src="{{ $cat->image_url }}" alt="" loading="lazy" decoding="async"></div>
                            <div class="lbl">{{ $cat->nameFor($lang) }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <main id="menuMain">
        @forelse ($categories as $cat)
            <section class="section" id="cat-{{ $cat->id }}">
                <h2>{{ $cat->nameFor($lang) }}</h2>
                @if ($cat->activeMenuItems->isEmpty())
                    <p class="empty" style="padding:2rem 0">No items in this category.</p>
                @else
                    <div class="grid">
                        @foreach ($cat->activeMenuItems as $item)
                            <button type="button" class="card js-item"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->nameFor($lang) }}"
                                data-price="{{ number_format((float) $item->price, 2, '.', '') }}"
                                data-image="{{ $item->image_url }}"
                                data-description="{{ $item->descriptionFor($lang) ?? '' }}">
                                <div class="ph"><img src="{{ $item->image_url }}" alt="" loading="lazy" decoding="async"></div>
                                <div class="meta">
                                    <div class="name">{{ $item->nameFor($lang) }}</div>
                                    <div class="price">{{ $settings->formatPriceWithCurrency($item->price) }}</div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                @endif
            </section>
        @empty
            <p class="empty">Menu coming soon.</p>
        @endforelse
    </main>

    <div class="backdrop" id="itemBackdrop" aria-hidden="true"></div>
    <div class="sheet" id="itemSheet" role="dialog" aria-modal="true" aria-labelledby="sheetTitle">
        <div class="sheet-handle"></div>
        <img class="sheet-img" id="sheetImg" src="" alt="">
        <div class="sheet-body">
            <h3 id="sheetTitle"></h3>
            <p class="desc" id="sheetDesc"></p>
            <div class="price-big" id="sheetPrice"></div>
        </div>
        <div class="sheet-actions">
            <button type="button" class="btn-close-sheet" id="sheetClose" aria-label="Close">×</button>
            <button type="button" class="btn-add" id="sheetAdd">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Add to basket
            </button>
        </div>
    </div>

    <div class="basket-panel" id="basketPanel">
        <div class="bd" id="basketBackdrop"></div>
        <div class="basket-drawer">
            <div class="basket-head">
                <h2>Basket</h2>
                <button type="button" class="btn-close-sheet" id="closeBasket" aria-label="Close">×</button>
            </div>
            <div class="basket-list" id="basketList"></div>
            <div class="basket-foot">
                <p>Items are saved on this device only. There is no checkout from this preview menu.</p>
                <button type="button" class="btn-add" id="clearBasket" style="background:var(--surface2);color:var(--text);border:1px solid var(--border)">Clear basket</button>
            </div>
        </div>
    </div>

    <script>
    (function () {
        var MENU_LANGS = @json($enabled);
        var PRICE_FMT = @json($settings->priceFormatForJs());
        function formatMoney(amount) {
            var n = Number(amount);
            if (!Number.isFinite(n)) n = 0;
            var dec = PRICE_FMT.showCents ? 2 : 0;
            var fixed = n.toFixed(dec);
            var parts = fixed.split('.');
            var intPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            var num = PRICE_FMT.showCents && parts[1] !== undefined ? intPart + '.' + parts[1] : intPart;
            return num + ' ' + PRICE_FMT.currency;
        }
        try {
            var _p = new URLSearchParams(window.location.search);
            var _q = _p.get('lang');
            if (_q && MENU_LANGS.indexOf(_q) >= 0) {
                localStorage.setItem('fastlinkmenu_lang_gate_v1', '1');
            }
        } catch (e) {}

        var gate = document.getElementById('langGate');
        if (gate) {
            gate.addEventListener('click', function (e) {
                var btn = e.target.closest('[data-lang]');
                if (!btn) return;
                try {
                    localStorage.setItem('fastlinkmenu_lang_gate_v1', '1');
                } catch (err) {}
                window.location.href = @json(route('menu')) + '?lang=' + encodeURIComponent(btn.getAttribute('data-lang'));
            });
        }

        const STORAGE_KEY = 'fastlinkmenu_basket_v1';
        let basket = [];
        try { basket = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]'); if (!Array.isArray(basket)) basket = []; } catch (e) { basket = []; }

        const badge = document.getElementById('basketBadge');
        const basketPanel = document.getElementById('basketPanel');
        const basketList = document.getElementById('basketList');
        let currentItem = null;

        function totalQty() {
            return basket.reduce((s, l) => s + (l.qty || 0), 0);
        }
        function save() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(basket));
            syncBadge();
            renderBasket();
        }
        function syncBadge() {
            const q = totalQty();
            badge.textContent = q > 0 ? String(q) : '';
            badge.dataset.q = String(q);
        }
        function renderBasket() {
            if (!basket.length) {
                basketList.innerHTML = '<p style="color:var(--muted);text-align:center;padding:2rem 0.5rem;font-size:0.9rem">Basket is empty.</p>';
                return;
            }
            basketList.innerHTML = basket.map((l, i) => `
                <div class="basket-line">
                    <img src="${escapeAttr(l.image_url)}" alt="">
                    <div class="grow">
                        <div class="nm">${escapeHtml(l.name)}</div>
                        <div class="pq">${l.qty} × ${formatMoney(l.price)}</div>
                    </div>
                    <div style="font-weight:700;color:var(--accent)">${formatMoney(l.qty * Number(l.price))}</div>
                    <button type="button" class="basket-remove" data-basket-remove="${i}" title="Remove" aria-label="Remove from basket">×</button>
                </div>
            `).join('');
        }
        function escapeHtml(s) {
            const d = document.createElement('div');
            d.textContent = s;
            return d.innerHTML;
        }
        function escapeAttr(s) {
            return String(s).replace(/"/g, '&quot;').replace(/</g, '');
        }

        const backdrop = document.getElementById('itemBackdrop');
        const sheet = document.getElementById('itemSheet');
        const sheetImg = document.getElementById('sheetImg');
        const sheetTitle = document.getElementById('sheetTitle');
        const sheetDesc = document.getElementById('sheetDesc');
        const sheetPrice = document.getElementById('sheetPrice');

        function openSheet(item) {
            currentItem = item;
            sheetImg.src = item.image;
            sheetImg.alt = item.name;
            sheetTitle.textContent = item.name;
            sheetDesc.textContent = item.description || 'No description.';
            sheetPrice.textContent = formatMoney(item.price);
            backdrop.classList.add('open');
            sheet.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeSheet() {
            backdrop.classList.remove('open');
            sheet.classList.remove('open');
            document.body.style.overflow = '';
            currentItem = null;
        }

        document.querySelectorAll('.js-item').forEach((el) => {
            el.addEventListener('click', () => {
                openSheet({
                    id: el.dataset.id,
                    name: el.dataset.name,
                    price: el.dataset.price,
                    image: el.dataset.image,
                    description: el.dataset.description,
                });
            });
        });
        backdrop.addEventListener('click', closeSheet);
        document.getElementById('sheetClose').addEventListener('click', closeSheet);
        document.getElementById('sheetAdd').addEventListener('click', () => {
            if (!currentItem) return;
            const id = String(currentItem.id);
            const line = basket.find((l) => String(l.id) === id);
            if (line) line.qty += 1;
            else basket.push({
                id: currentItem.id,
                name: currentItem.name,
                price: currentItem.price,
                image_url: currentItem.image,
                qty: 1,
            });
            save();
            closeSheet();
        });

        document.getElementById('openBasket').addEventListener('click', () => {
            basketPanel.classList.add('open');
            renderBasket();
        });
        document.getElementById('closeBasket').addEventListener('click', () => basketPanel.classList.remove('open'));
        document.getElementById('basketBackdrop').addEventListener('click', () => basketPanel.classList.remove('open'));
        document.getElementById('clearBasket').addEventListener('click', () => {
            basket = [];
            save();
        });

        basketList.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-basket-remove]');
            if (!btn) return;
            const i = parseInt(btn.getAttribute('data-basket-remove'), 10);
            if (!Number.isNaN(i) && i >= 0 && i < basket.length) {
                basket.splice(i, 1);
                save();
            }
        });

        const pills = document.querySelectorAll('.cat-pill');
        const sections = document.querySelectorAll('.section');
        const catsScroll = document.getElementById('catsScroll');
        const topBar = document.querySelector('.top');

        function stickyStackOffset() {
            return (topBar ? topBar.getBoundingClientRect().height : 0) + 12;
        }

        function scrollToSection(sectionEl) {
            if (!sectionEl) return;
            const y = sectionEl.getBoundingClientRect().top + window.scrollY - stickyStackOffset();
            window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' });
        }

        function scrollActivePillIntoView(activePill) {
            if (!activePill || !catsScroll) return;
            const pad = 14;
            const pr = activePill.getBoundingClientRect();
            const wr = catsScroll.getBoundingClientRect();
            if (pr.left >= wr.left + pad && pr.right <= wr.right - pad) return;
            const pillCenter = pr.left + pr.width / 2;
            const wrapCenter = wr.left + wr.width / 2;
            catsScroll.scrollBy({ left: pillCenter - wrapCenter, behavior: 'smooth' });
        }

        function setActive(id) {
            let active = null;
            pills.forEach((p) => {
                const on = p.dataset.cat === id;
                p.classList.toggle('is-active', on);
                if (on) active = p;
            });
            if (active) {
                requestAnimationFrame(() => scrollActivePillIntoView(active));
            }
        }
        pills.forEach((p) => {
            p.addEventListener('click', () => {
                const t = document.getElementById(p.dataset.target);
                if (t) scrollToSection(t);
                setActive(p.dataset.cat);
            });
        });

        const io = new IntersectionObserver(
            (entries) => {
                entries.forEach((en) => {
                    if (en.isIntersecting) {
                        const id = en.target.id.replace('cat-', '');
                        setActive(id);
                    }
                });
            },
            { rootMargin: '-35% 0px -50% 0px', threshold: 0 }
        );
        sections.forEach((s) => io.observe(s));

        if (pills.length) setActive(pills[0].dataset.cat);
        syncBadge();
        renderBasket();
    })();
    </script>
</body>
</html>
