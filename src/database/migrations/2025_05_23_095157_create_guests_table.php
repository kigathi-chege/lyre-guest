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
        if (!Schema::hasTable('guests')) {
            Schema::create('guests', function (Blueprint $table) {
                $table->id();
                $table->timestamps();

                $table->string('ip')->nullable();
                $table->string('user_agent')->nullable();
                $table->string('referrer')->nullable();
                $table->string('current_url')->nullable();
                $table->string('previous_url')->nullable();
                $table->string('country')->nullable();
                $table->string('city')->nullable();
                $table->string('language')->nullable();
                $table->string('session_id')->nullable();

                $table->uuid('guest_uuid')->unique()->nullable();
                $table->foreignId('user_id')->nullable()->constrained();
            });
        }

        if (!Schema::hasColumn('guests', 'currency_code')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->string('currency_code')->nullable();
                $table->string('country_code')->nullable();
                $table->string('region_code')->nullable();
                $table->string('region_name')->nullable();
                $table->string('zip_code')->nullable();
                $table->string('iso_code')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
                $table->string('metro_code')->nullable();
                $table->string('area_code')->nullable();
                $table->string('timezone')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
