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
        // 1. Core Auth Tables (Default)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 2. Waitlist Table (For the Landing Page)
        Schema::create('waitlist_entries', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->integer('child_age')->nullable();
            $table->string('favorite_topic')->nullable(); // e.g., "Dinosaurs", "Space"
            $table->timestamps();
        });

        // 3. BedTimeBot Core Architecture
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->integer('age')->nullable();
            $table->timestamps();
        });

        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // If a child profile is deleted, keep the story but nullify the child_id
            $table->foreignId('child_id')->nullable()->constrained('children')->nullOnDelete();
            $table->string('title')->nullable();
            $table->string('status')->default('pending'); // pending, generating_text, generating_images, completed, failed
            $table->json('prompt_settings')->nullable(); // Stores the "broccoli panel" toggles used for this generation
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained()->cascadeOnDelete();
            $table->integer('page_number');
            $table->text('text_content')->nullable();
            $table->string('image_url')->nullable();
            $table->string('audio_url')->nullable(); // For the TTS generation later
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop in reverse order to prevent foreign key constraint errors
        Schema::dropIfExists('pages');
        Schema::dropIfExists('stories');
        Schema::dropIfExists('children');
        Schema::dropIfExists('waitlist_entries');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};