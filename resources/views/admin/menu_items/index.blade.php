@extends('admin.layout')

@section('title', 'Menu items')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-semibold">Menu items</h1>
        <a href="{{ route('admin.menu-items.create') }}" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-amber-400">New item</a>
    </div>
    <div class="overflow-x-auto rounded-xl border border-zinc-800">
        <table class="min-w-full text-sm">
            <thead class="bg-zinc-900 text-left text-zinc-500">
                <tr>
                    <th class="px-4 py-3 font-medium">Item</th>
                    <th class="px-4 py-3 font-medium">Category</th>
                    <th class="px-4 py-3 font-medium">Price</th>
                    <th class="px-4 py-3 font-medium">Active</th>
                    <th class="px-4 py-3 font-medium"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse ($items as $item)
                    <tr class="hover:bg-zinc-900/40">
                        <td class="px-4 py-3">
                            <span class="font-medium text-zinc-200">{{ $item->nameForAdmin() }}</span>
                            <span class="block text-xs text-zinc-600">#{{ $item->sort_order }}</span>
                        </td>
                        <td class="px-4 py-3 text-zinc-400">{{ $item->category->nameForAdmin() }}</td>
                        <td class="px-4 py-3 text-amber-400/90">{{ number_format((float) $item->price, 2) }}</td>
                        <td class="px-4 py-3">
                            @if ($item->is_active)
                                <span class="text-emerald-400/90">Yes</span>
                            @else
                                <span class="text-zinc-600">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.menu-items.edit', $item) }}" class="text-amber-400 hover:underline">Edit</a>
                            <form action="{{ route('admin.menu-items.destroy', $item) }}" method="post" class="inline" onsubmit="return confirm('Delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-zinc-500">No items yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
