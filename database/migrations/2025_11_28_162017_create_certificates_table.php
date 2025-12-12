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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('service_type')->constrained('certificates'); 
            $table->foreignId('user_id')->constrained('users'); 
            $table->string('purpose', 255); 
            $table->enum('status', ['pending', 'approved', 'declined'])
                  ->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
