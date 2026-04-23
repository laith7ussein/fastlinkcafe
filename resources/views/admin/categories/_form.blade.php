@php
    $c = $category;
@endphp
<div class="space-y-6">
    <div>
        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wide mb-2">English</p>
        <label class="block text-xs font-medium text-zinc-400 mb-1">Name <span class="text-rose-400">*</span></label>
        <input name="name_en" value="{{ old('name_en', $c?->name_en) }}" required maxlength="160" dir="ltr"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
    </div>
    <div>
        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wide mb-2">Arabic</p>
        <label class="block text-xs font-medium text-zinc-400 mb-1">Name</label>
        <input name="name_ar" value="{{ old('name_ar', $c?->name_ar) }}" maxlength="160" dir="rtl"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
    </div>
    <div>
        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wide mb-2">Kurdish (Sorani)</p>
        <label class="block text-xs font-medium text-zinc-400 mb-1">Name</label>
        <input name="name_ku" value="{{ old('name_ku', $c?->name_ku) }}" maxlength="160" dir="rtl"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
    </div>
</div>
<div class="mt-4">
    <label class="block text-xs font-medium text-zinc-400 mb-1">Slug <span class="text-zinc-600">(optional, Latin)</span></label>
    <input name="slug" value="{{ old('slug', $c?->slug) }}" maxlength="160" pattern="[a-z0-9]+(?:-[a-z0-9]+)*"
        placeholder="auto from English name"
        class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-amber-500/40" dir="ltr">
</div>
<div>
    <label class="block text-xs font-medium text-zinc-400 mb-1">Image URL</label>
    <input name="image_url" type="url" value="{{ old('image_url', $c?->image_url) }}" required maxlength="2048" dir="ltr"
        class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
    <p class="text-xs text-zinc-600 mt-1">Direct image URL (CDN, Unsplash, etc.).</p>
</div>
<div>
    <label class="block text-xs font-medium text-zinc-400 mb-1">Sort order</label>
    <input name="sort_order" type="number" min="0" max="99999" value="{{ old('sort_order', $c?->sort_order ?? 0) }}" required
        class="w-40 rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
</div>
