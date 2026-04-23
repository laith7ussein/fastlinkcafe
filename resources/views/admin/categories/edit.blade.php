@extends('admin.layout')

@section('title', 'Edit category')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Edit category</h1>
    <form method="post" action="{{ route('admin.categories.update', $category) }}" class="max-w-xl space-y-4">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['category' => $category])
        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-amber-400">Update</button>
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-zinc-700 px-4 py-2 text-sm text-zinc-300 hover:bg-zinc-800">Cancel</a>
        </div>
    </form>
@endsection
