@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-semibold text-zinc-100 mb-6">Dashboard</h1>
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-zinc-800 bg-zinc-900/50 p-5">
            <p class="text-xs uppercase tracking-wide text-zinc-500">Categories</p>
            <p class="text-3xl font-semibold text-amber-400 mt-1">{{ $categoryCount }}</p>
        </div>
        <div class="rounded-xl border border-zinc-800 bg-zinc-900/50 p-5">
            <p class="text-xs uppercase tracking-wide text-zinc-500">Menu items</p>
            <p class="text-3xl font-semibold text-amber-400 mt-1">{{ $itemCount }}</p>
        </div>
        <div class="rounded-xl border border-zinc-800 bg-zinc-900/50 p-5">
            <p class="text-xs uppercase tracking-wide text-zinc-500">Active items</p>
            <p class="text-3xl font-semibold text-emerald-400/90 mt-1">{{ $activeItemCount }}</p>
        </div>
    </div>
    <p class="mt-8 text-sm text-zinc-500">Manage <a href="{{ route('admin.categories.index') }}" class="text-amber-400 hover:underline">categories</a>, <a href="{{ route('admin.menu-items.index') }}" class="text-amber-400 hover:underline">items</a>, and <a href="{{ route('admin.menu-appearance.edit') }}" class="text-amber-400 hover:underline">site &amp; menu</a> (name, logo, cover, contact), or open the <a href="{{ route('menu') }}" class="text-zinc-400 hover:underline">public menu</a>.</p>
@endsection
