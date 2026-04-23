<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'categoryCount' => Category::query()->count(),
            'itemCount' => MenuItem::query()->count(),
            'activeItemCount' => MenuItem::query()->where('is_active', true)->count(),
        ]);
    }
}
