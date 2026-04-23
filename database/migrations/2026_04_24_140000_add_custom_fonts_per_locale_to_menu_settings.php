<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            $table->text('font_en_url')->nullable()->after('lang_ku_enabled');
            $table->string('font_en_family', 120)->nullable()->after('font_en_url');
            $table->text('font_ar_url')->nullable()->after('font_en_family');
            $table->string('font_ar_family', 120)->nullable()->after('font_ar_url');
            $table->text('font_ku_url')->nullable()->after('font_ar_family');
            $table->string('font_ku_family', 120)->nullable()->after('font_ku_url');
        });
    }

    public function down(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            $table->dropColumn([
                'font_en_url',
                'font_en_family',
                'font_ar_url',
                'font_ar_family',
                'font_ku_url',
                'font_ku_family',
            ]);
        });
    }
};
