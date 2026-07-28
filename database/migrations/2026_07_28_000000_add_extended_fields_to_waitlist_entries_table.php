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
        Schema::table('waitlist_entries', function (Blueprint $table) {
            $table->string('child_name')->nullable()->after('email');
            $table->string('core_value')->nullable()->after('favorite_topic');
            $table->string('story_tone')->nullable()->after('core_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waitlist_entries', function (Blueprint $table) {
            $table->dropColumn(['child_name', 'core_value', 'story_tone']);
        });
    }
};