<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            $table->string('currency_code', 12)->default('IQD')->after('brand_accent_color');
            $table->boolean('price_show_cents')->default(true)->after('currency_code');
        });
    }

    public function down(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            $table->dropColumn(['currency_code', 'price_show_cents']);
        });
    }
};
