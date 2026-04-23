<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            $table->string('site_name', 160)->nullable()->after('cover_image_url');
            $table->text('logo_url')->nullable()->after('site_name');
            $table->string('phone', 80)->nullable()->after('logo_url');
            $table->text('address')->nullable()->after('phone');
            $table->text('social_facebook_url')->nullable()->after('address');
            $table->text('social_instagram_url')->nullable()->after('social_facebook_url');
            $table->text('social_twitter_url')->nullable()->after('social_instagram_url');
            $table->text('social_tiktok_url')->nullable()->after('social_twitter_url');
            $table->text('social_youtube_url')->nullable()->after('social_tiktok_url');
        });
    }

    public function down(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_name',
                'logo_url',
                'phone',
                'address',
                'social_facebook_url',
                'social_instagram_url',
                'social_twitter_url',
                'social_tiktok_url',
                'social_youtube_url',
            ]);
        });
    }
};
