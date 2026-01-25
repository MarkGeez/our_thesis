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
        Schema::create('update_blotters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blotter_id')->constrained();
            $table->text('remarks');
            $table->enum('status', ['first', 'second', 'third', 'brgyHearing', 'coldCase', 'criminalCase']);
            $table->foreignId('updated_by')->constrained('users');
            $table->string('photo_path');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_blotters');
    }
};
