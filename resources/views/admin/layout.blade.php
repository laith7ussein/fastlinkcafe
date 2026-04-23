<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['DM Sans', 'system-ui', 'sans-serif'] } } } }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
</head>
<body class="h-full bg-zinc-950 text-zinc-100 antialiased font-sans">
    <div class="min-h-full flex flex-col">
        <header class="border-b border-zinc-800 bg-zinc-900/80 backdrop-blur sticky top-0 z-40">
            <div class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold tracking-tight text-amber-400/95">Fastlink Admin</a>
                <nav class="flex flex-wrap items-center gap-4 text-sm text-zinc-400">
                    <a href="{{ route('menu') }}" target="_blank" class="hover:text-zinc-200 transition">View menu</a>
                    <a href="{{ route('admin.categories.index') }}" class="hover:text-zinc-200 transition {{ request()->routeIs('admin.categories.*') ? 'text-amber-400' : '' }}">Categories</a>
                    <a href="{{ route('admin.menu-items.index') }}" class="hover:text-zinc-200 transition {{ request()->routeIs('admin.menu-items.*') ? 'text-amber-400' : '' }}">Items</a>
                    <a href="{{ route('admin.menu-appearance.edit') }}" class="hover:text-zinc-200 transition {{ request()->routeIs('admin.menu-appearance.*') ? 'text-amber-400' : '' }}">Site & menu</a>
                    <form method="post" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-zinc-500 hover:text-rose-400 transition">Log out</button>
                    </form>
                </nav>
            </div>
        </header>
        <main class="flex-1 max-w-6xl w-full mx-auto px-4 py-8">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-900/60 bg-emerald-950/40 px-4 py-3 text-sm text-emerald-200">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-rose-900/60 bg-rose-950/40 px-4 py-3 text-sm text-rose-200">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
