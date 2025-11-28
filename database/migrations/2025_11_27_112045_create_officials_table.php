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
        Schema::create('officials', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            // This references the 'users' table (assumed to be correct)
            $table->foreignId('user_id')->constrained();
            
            // This attempts to reference the 'positions' table
            $table->foreignId('position_id')->unique()->constrained();
            
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officials');
    }
};