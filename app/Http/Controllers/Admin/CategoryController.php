<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->orderBy('sort_order')->orderBy('name_en')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug(
            ($data['slug'] ?? '') !== '' ? (string) $data['slug'] : $data['name_en']
        );

        Category::query()->create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category created.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug(
            ($data['slug'] ?? '') !== '' ? (string) $data['slug'] : $data['name_en'],
            $category->id
        );

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Category deleted.');
    }

    /**
     * @return array{name_en: string, name_ar: string|null, name_ku: string|null, image_url: string, sort_order: int, slug?: string|null}
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'name_en' => ['required', 'string', 'max:160'],
            'name_ar' => ['nullable', 'string', 'max:160'],
            'name_ku' => ['nullable', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:160', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'image_url' => ['required', 'url', 'max:2048'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:99999'],
        ]);
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source);
        if ($base === '') {
            $base = 'category';
        }

        $slug = $base;
        $n = 2;
        while (Category::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$n;
            $n++;
        }

        return $slug;
    }
}
