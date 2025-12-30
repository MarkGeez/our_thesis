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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('barangay_name')->default('brgy249');
            $table->string('logo_path')->nullable();
            $table->string('theme')->default('default');
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            'barangay_name' => 'brgy249',
            'logo_path' => null,
            'theme' => 'default',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
