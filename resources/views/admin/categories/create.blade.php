@extends('admin.layout')

@section('title', 'New category')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">New category</h1>
    <form method="post" action="{{ route('admin.categories.store') }}" class="max-w-xl space-y-4">
        @csrf
        @include('admin.categories._form', ['category' => null])
        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-amber-400">Save</button>
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-zinc-700 px-4 py-2 text-sm text-zinc-300 hover:bg-zinc-800">Cancel</a>
        </div>
    </form>
@endsection
