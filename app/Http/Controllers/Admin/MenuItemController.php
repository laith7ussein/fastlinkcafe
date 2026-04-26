<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\MenuSetting;
use App\Services\MenuItemImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(): View
    {
        $items = MenuItem::query()
            ->with('category')
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->get();

        $settings = MenuSetting::instance();

        return view('admin.menu_items.index', compact('items', 'settings'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('sort_order')->orderBy('name_en')->get();

        return view('admin.menu_items.create', compact('categories'));
    }

    public function store(Request $request, MenuItemImageService $images): RedirectResponse
    {
        $data = $this->baseValidated($request);
        unset($data['image']);

        if ($request->hasFile('image')) {
            $data['image_url'] = $images->storeCroppedSquare($request->file('image'));
        }

        $data['is_active'] = $request->boolean('is_active');

        if (empty($data['image_url'])) {
            throw ValidationException::withMessages([
                'image_url' => 'Provide an image URL or upload an image file.',
            ]);
        }

        MenuItem::query()->create($data);

        return redirect()->route('admin.menu-items.index')->with('status', 'Item created.');
    }

    public function edit(MenuItem $menu_item): View
    {
        $categories = Category::query()->orderBy('sort_order')->orderBy('name_en')->get();

        return view('admin.menu_items.edit', [
            'item' => $menu_item,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, MenuItem $menu_item, MenuItemImageService $images): RedirectResponse
    {
        $data = $this->baseValidated($request);
        unset($data['image']);

        if ($request->hasFile('image')) {
            $this->deleteStoredMenuImage($menu_item->image_url);
            $data['image_url'] = $images->storeCroppedSquare($request->file('image'));
        } elseif (empty($data['image_url'])) {
            unset($data['image_url']);
        }

        $data['is_active'] = $request->boolean('is_active');

        // #region agent log
        if (isset($data['image_url']) && is_string($data['image_url'])) {
            $iu = $data['image_url'];
            $payload = json_encode([
                'sessionId' => 'ec7f84',
                'hypothesisId' => 'H3',
                'location' => 'MenuItemController::update:before_save',
                'message' => 'image_url about to persist',
                'data' => [
                    'urlLen' => strlen($iu),
                    'urlTail' => strlen($iu) > 80 ? substr($iu, -80) : $iu,
                    'hasUpload' => $request->hasFile('image'),
                ],
                'timestamp' => (int) (microtime(true) * 1000),
            ], JSON_UNESCAPED_SLASHES);
            if (is_string($payload)) {
                @file_put_contents(base_path('.cursor/debug-ec7f84.log'), $payload."\n", FILE_APPEND | LOCK_EX);
            }
        }
        // #endregion

        $menu_item->update($data);

        // #region agent log
        $menu_item->refresh();
        $dbUrl = $menu_item->image_url;
        if (is_string($dbUrl)) {
            $payload2 = json_encode([
                'sessionId' => 'ec7f84',
                'hypothesisId' => 'H3',
                'location' => 'MenuItemController::update:after_save',
                'message' => 'image_url from DB after refresh',
                'data' => [
                    'urlLen' => strlen($dbUrl),
                    'urlTail' => strlen($dbUrl) > 80 ? substr($dbUrl, -80) : $dbUrl,
                ],
                'timestamp' => (int) (microtime(true) * 1000),
            ], JSON_UNESCAPED_SLASHES);
            if (is_string($payload2)) {
                @file_put_contents(base_path('.cursor/debug-ec7f84.log'), $payload2."\n", FILE_APPEND | LOCK_EX);
            }
        }
        // #endregion

        return redirect()->route('admin.menu-items.index')->with('status', 'Item updated.');
    }

    public function destroy(MenuItem $menu_item): RedirectResponse
    {
        $this->deleteStoredMenuImage($menu_item->image_url);
        $menu_item->delete();

        return redirect()->route('admin.menu-items.index')->with('status', 'Item deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function baseValidated(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name_en' => ['required', 'string', 'max:200'],
            'name_ar' => ['nullable', 'string', 'max:200'],
            'name_ku' => ['nullable', 'string', 'max:200'],
            'description_en' => ['nullable', 'string', 'max:5000'],
            'description_ar' => ['nullable', 'string', 'max:5000'],
            'description_ku' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'image_url' => ['nullable', 'string', 'max:2048', $this->imageUrlValidator()],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:99999'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }

    /**
     * Allow absolute URLs (external/CDN) or same-origin stored paths from uploads.
     *
     * @return \Closure(string, mixed, \Closure(string): void): void
     */
    private function imageUrlValidator(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail): void {
            if (! is_string($value) || $value === '') {
                return;
            }
            if (str_contains($value, '..')) {
                $fail('Invalid image path.');

                return;
            }
            if (str_starts_with($value, '/storage/')) {
                return;
            }
            if (filter_var($value, FILTER_VALIDATE_URL) !== false) {
                return;
            }
            $fail('Provide a valid image URL or a path starting with /storage/.');
        };
    }

    private function deleteStoredMenuImage(?string $url): void
    {
        $relative = $this->publicStoragePathFromUrl($url);
        if ($relative !== null) {
            Storage::disk('public')->delete($relative);
        }
    }

    private function publicStoragePathFromUrl(?string $url): ?string
    {
        if (! is_string($url) || $url === '') {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);
        if (! is_string($path)) {
            return null;
        }

        $prefix = '/storage/';
        if (! str_starts_with($path, $prefix)) {
            return null;
        }

        return substr($path, strlen($prefix));
    }
}
