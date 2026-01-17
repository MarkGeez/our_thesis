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
            $table->enum('position', ['Chairman', 'Kagawad', 'Secretary', 'Treasurer', 'Sk Chairman', 'Sk Kagawad']);
            $table->foreignId('resident_id')->constrained('residents');
            $table->string('details', 255);
            $table->date('start');
            $table->date('end');
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
