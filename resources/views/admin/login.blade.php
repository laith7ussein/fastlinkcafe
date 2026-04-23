<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin login — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,600&display=swap" rel="stylesheet">
    <style>body { font-family: 'DM Sans', system-ui, sans-serif; }</style>
</head>
<body class="h-full bg-zinc-950 text-zinc-100 antialiased flex items-center justify-center p-6">
    <div class="w-full max-w-sm">
        <h1 class="text-2xl font-semibold text-center text-amber-400/95 mb-2">Admin</h1>
        <p class="text-center text-zinc-500 text-sm mb-8">{{ config('app.name') }}</p>
        <form method="post" action="{{ route('admin.login.store') }}" class="space-y-4 rounded-2xl border border-zinc-800 bg-zinc-900/60 p-6 shadow-xl">
            @csrf
            <div>
                <label for="email" class="block text-xs font-medium text-zinc-400 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', 'admin@example.com') }}" required autocomplete="username"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-zinc-100 focus:outline-none focus:ring-2 focus:ring-amber-500/50">
            </div>
            <div>
                <label for="password" class="block text-xs font-medium text-zinc-400 mb-1">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-zinc-100 focus:outline-none focus:ring-2 focus:ring-amber-500/50">
            </div>
            <label class="flex items-center gap-2 text-sm text-zinc-400">
                <input type="checkbox" name="remember" value="1" class="rounded border-zinc-600 bg-zinc-950 text-amber-500">
                Remember me
            </label>
            @error('email')
                <p class="text-sm text-rose-400">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full rounded-lg bg-amber-500 py-2.5 text-sm font-semibold text-zinc-950 hover:bg-amber-400 transition">
                Sign in
            </button>
        </form>
        <p class="text-center text-xs text-zinc-600 mt-6"><a href="{{ route('menu') }}" class="text-zinc-500 hover:text-zinc-400">← Back to menu</a></p>
    </div>
</body>
</html>
