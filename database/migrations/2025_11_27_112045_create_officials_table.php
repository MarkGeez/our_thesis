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
            
            $table->foreignId('resident_id')->nullabe();
            $table->foreignId('position_id')->unique()->constrained();
            
            $table->text('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('officials');
    }
};