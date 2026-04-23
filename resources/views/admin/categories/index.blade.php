@extends('admin.layout')

@section('title', 'Categories')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-semibold">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-amber-400">New category</a>
    </div>
    <div class="overflow-x-auto rounded-xl border border-zinc-800">
        <table class="min-w-full text-sm">
            <thead class="bg-zinc-900 text-left text-zinc-500">
                <tr>
                    <th class="px-4 py-3 font-medium">Order</th>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Slug</th>
                    <th class="px-4 py-3 font-medium"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse ($categories as $cat)
                    <tr class="hover:bg-zinc-900/40">
                        <td class="px-4 py-3 text-zinc-400">{{ $cat->sort_order }}</td>
                        <td class="px-4 py-3 font-medium text-zinc-200">{{ $cat->nameForAdmin() }}</td>
                        <td class="px-4 py-3 text-zinc-500 font-mono text-xs">{{ $cat->slug }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="text-amber-400 hover:underline">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="post" class="inline" onsubmit="return confirm('Delete this category and all its items?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-zinc-500">No categories yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
