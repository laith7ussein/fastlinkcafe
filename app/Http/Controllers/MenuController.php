<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuSetting;
use App\Support\MenuLocale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $settings = MenuSetting::instance();
        $enabled = $settings->enabledLocales();

        if ($request->has('lang')) {
            $raw = MenuLocale::normalize($request->query('lang'));
            $lang = in_array($raw, $enabled, true) ? $raw : $enabled[0];
            $request->session()->put('menu_locale', $lang);
        } else {
            $raw = MenuLocale::normalize($request->session()->get('menu_locale'));
            $lang = in_array($raw, $enabled, true) ? $raw : $enabled[0];
            $request->session()->put('menu_locale', $lang);
        }

        $categories = Category::query()
            ->orderBy('sort_order')
            ->with(['activeMenuItems' => fn ($q) => $q->orderBy('sort_order')])
            ->get();

        return view('menu.index', compact('categories', 'settings', 'lang', 'enabled'));
    }
}
