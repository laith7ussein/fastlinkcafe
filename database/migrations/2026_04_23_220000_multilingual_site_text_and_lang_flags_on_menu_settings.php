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
            $table->string('site_name_en', 160)->nullable()->after('brand_accent_color');
            $table->string('site_name_ar', 160)->nullable()->after('site_name_en');
            $table->string('site_name_ku', 160)->nullable()->after('site_name_ar');
            $table->text('address_en')->nullable()->after('site_name_ku');
            $table->text('address_ar')->nullable()->after('address_en');
            $table->text('address_ku')->nullable()->after('address_ar');
            $table->boolean('lang_en_enabled')->default(true)->after('address_ku');
            $table->boolean('lang_ar_enabled')->default(true)->after('lang_en_enabled');
            $table->boolean('lang_ku_enabled')->default(true)->after('lang_ar_enabled');
        });

        foreach (DB::table('menu_settings')->get() as $row) {
            DB::table('menu_settings')->where('id', $row->id)->update([
                'site_name_en' => $row->site_name ?? null,
                'address_en' => $row->address ?? null,
            ]);
        }

        Schema::table('menu_settings', function (Blueprint $table) {
            $table->dropColumn(['site_name', 'address']);
        });
    }

    public function down(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            $table->string('site_name', 160)->nullable()->after('brand_accent_color');
            $table->text('address')->nullable()->after('phone');
        });

        foreach (DB::table('menu_settings')->get() as $row) {
            DB::table('menu_settings')->where('id', $row->id)->update([
                'site_name' => $row->site_name_en,
                'address' => $row->address_en,
            ]);
        }

        Schema::table('menu_settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_name_en',
                'site_name_ar',
                'site_name_ku',
                'address_en',
                'address_ar',
                'address_ku',
                'lang_en_enabled',
                'lang_ar_enabled',
                'lang_ku_enabled',
            ]);
        });
    }
};
