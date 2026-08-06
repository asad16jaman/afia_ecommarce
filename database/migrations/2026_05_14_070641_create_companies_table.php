<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('hotline', 20)->nullable();
            $table->string('email', 100)->unique()->nullable();

            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('website_url')->nullable();

            $table->string('favicon_image')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('footer_title')->nullable();
            $table->text('footer_short_description')->nullable();

             $table->string('heritage', 100)->nullable();
             $table->string('production_capacity', 100)->nullable();
             $table->string('total_projects', 100)->nullable();
             $table->string('total_workforce', 100)->nullable();

            $table->text('google_map')->nullable();
            $table->text('copyright')->nullable();
            $table->text('video',400)->nullable();
            $table->text('file',400)->nullable();
            $table->text('file_thum',400)->nullable();
            $table->text('file_title',400)->nullable();
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->ipAddress('ip_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
