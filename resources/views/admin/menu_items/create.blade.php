@extends('admin.layout')

@section('title', 'New item')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">New menu item</h1>
    <form method="post" action="{{ route('admin.menu-items.store') }}" enctype="multipart/form-data" class="max-w-xl space-y-4">
        @csrf
        @include('admin.menu_items._form', ['item' => null, 'categories' => $categories])
        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-amber-400">Save</button>
            <a href="{{ route('admin.menu-items.index') }}" class="rounded-lg border border-zinc-700 px-4 py-2 text-sm text-zinc-300 hover:bg-zinc-800">Cancel</a>
        </div>
    </form>
@endsection
