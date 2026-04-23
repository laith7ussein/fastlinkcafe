<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            $table->string('brand_accent_color', 7)->default('#d4a853')->after('cover_image_url');
        });

        DB::table('menu_settings')->whereNull('brand_accent_color')->update(['brand_accent_color' => '#d4a853']);
    }

    public function down(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            $table->dropColumn('brand_accent_color');
        });
    }
};
