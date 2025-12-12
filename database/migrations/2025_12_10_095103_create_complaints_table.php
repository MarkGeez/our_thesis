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
    Schema::create('complaints', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('complainant_id');
        $table->string('complainantName');
        $table->string('address');
        $table->text('details');
        $table->unsignedBigInteger('respondent_id')->nullable();
        $table->enum('status', ['on-going', 'resolved', 'rejected'])->default('on-going');
        $table->timestamps();
        
        $table->foreign('complainant_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('respondent_id')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
