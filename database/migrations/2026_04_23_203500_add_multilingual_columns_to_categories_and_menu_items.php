<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_en', 160)->nullable()->after('id');
            $table->string('name_ar', 160)->nullable()->after('name_en');
            $table->string('name_ku', 160)->nullable()->after('name_ar');
        });

        if (Schema::hasColumn('categories', 'name')) {
            DB::statement('UPDATE categories SET name_en = name');
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('name_en', 200)->nullable()->after('category_id');
            $table->string('name_ar', 200)->nullable()->after('name_en');
            $table->string('name_ku', 200)->nullable()->after('name_ar');
            $table->text('description_en')->nullable()->after('name_ku');
            $table->text('description_ar')->nullable()->after('description_en');
            $table->text('description_ku')->nullable()->after('description_ar');
        });

        if (Schema::hasColumn('menu_items', 'name')) {
            DB::statement('UPDATE menu_items SET name_en = name');
            if (Schema::hasColumn('menu_items', 'description')) {
                DB::statement('UPDATE menu_items SET description_en = description');
            }
            Schema::table('menu_items', function (Blueprint $table) {
                $table->dropColumn(['name', 'description']);
            });
        }
    }

    public function down(): void
    {
        // Roll back via restore from backup if needed; reversing merged columns is lossy.
    }
};
