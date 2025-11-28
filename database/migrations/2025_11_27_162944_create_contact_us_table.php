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
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string(column: 'email');
            $table->string('ContactNo');
            $table->foreignId('editedBy')->constrained('users');
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_us');
    }
};
