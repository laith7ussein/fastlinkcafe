@php
    $i = $item;
@endphp
<div>
    <label class="block text-xs font-medium text-zinc-400 mb-1">Category</label>
    <select name="category_id" required class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('category_id', $i?->category_id) == $cat->id)>{{ $cat->nameForAdmin() }}</option>
        @endforeach
    </select>
</div>

<div class="space-y-6 mt-4">
    <div>
        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wide mb-2">English</p>
        <label class="block text-xs font-medium text-zinc-400 mb-1">Name <span class="text-rose-400">*</span></label>
        <input name="name_en" value="{{ old('name_en', $i?->name_en) }}" required maxlength="200" dir="ltr"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
        <label class="block text-xs font-medium text-zinc-400 mb-1 mt-2">Description</label>
        <textarea name="description_en" rows="3" maxlength="5000" dir="ltr"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">{{ old('description_en', $i?->description_en) }}</textarea>
    </div>
    <div>
        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wide mb-2">Arabic</p>
        <label class="block text-xs font-medium text-zinc-400 mb-1">Name</label>
        <input name="name_ar" value="{{ old('name_ar', $i?->name_ar) }}" maxlength="200" dir="rtl"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
        <label class="block text-xs font-medium text-zinc-400 mb-1 mt-2">Description</label>
        <textarea name="description_ar" rows="3" maxlength="5000" dir="rtl"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">{{ old('description_ar', $i?->description_ar) }}</textarea>
    </div>
    <div>
        <p class="text-xs font-semibold text-zinc-500 uppercase tracking-wide mb-2">Kurdish (Sorani)</p>
        <label class="block text-xs font-medium text-zinc-400 mb-1">Name</label>
        <input name="name_ku" value="{{ old('name_ku', $i?->name_ku) }}" maxlength="200" dir="rtl"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
        <label class="block text-xs font-medium text-zinc-400 mb-1 mt-2">Description</label>
        <textarea name="description_ku" rows="3" maxlength="5000" dir="rtl"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">{{ old('description_ku', $i?->description_ku) }}</textarea>
    </div>
</div>

<div class="mt-4">
    <label class="block text-xs font-medium text-zinc-400 mb-1">Price</label>
    <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $i?->price) }}" required dir="ltr"
        class="w-full max-w-xs rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
</div>
<div class="rounded-lg border border-zinc-800 bg-zinc-900/40 p-4 space-y-3">
    <p class="text-xs font-medium text-zinc-400">Image <span class="text-zinc-600 font-normal">(URL or upload)</span></p>
    @if ($i?->image_url)
        <div class="flex items-start gap-3">
            <img src="{{ $i->image_url }}" alt="" class="h-20 w-20 rounded-lg object-cover border border-zinc-700 shrink-0">
            <p class="text-xs text-zinc-500 leading-relaxed">Current image. Uploads are cropped to <strong>900×900</strong> automatically.</p>
        </div>
    @else
        <p class="text-xs text-zinc-600">Uploaded files are center-cropped to <strong>900×900</strong> and saved as JPEG. External image URLs are not resized.</p>
    @endif
    <div>
        <label class="block text-xs text-zinc-500 mb-1">Image URL</label>
        <input name="image_url" type="url" value="{{ old('image_url', $i?->image_url) }}" maxlength="2048" placeholder="https://…" dir="ltr"
            class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
    </div>
    <div>
        <label class="block text-xs text-zinc-500 mb-1">Upload image</label>
        <input name="image" type="file" accept="image/jpeg,image/png,image/gif,image/webp"
            class="block w-full text-sm text-zinc-400 file:mr-3 file:rounded-lg file:border-0 file:bg-zinc-800 file:px-3 file:py-2 file:text-zinc-200 file:text-sm">
    </div>
</div>
<div>
    <label class="block text-xs font-medium text-zinc-400 mb-1">Sort order</label>
    <input name="sort_order" type="number" min="0" max="99999" value="{{ old('sort_order', $i?->sort_order ?? 0) }}" required
        class="w-40 rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/40">
</div>
<div class="flex items-center gap-2">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" id="is_active" class="rounded border-zinc-600 bg-zinc-950 text-amber-500" @checked(old('is_active', $i?->is_active ?? true))>
    <label for="is_active" class="text-sm text-zinc-300">Visible on public menu</label>
</div>
