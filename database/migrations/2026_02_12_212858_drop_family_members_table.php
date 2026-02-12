<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop the existing table and recreate it with the new structure
        Schema::dropIfExists('family_members');
        
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('household_id')
                  ->constrained('households')
                  ->cascadeOnDelete();

            $table->foreignId('resident_id')
                  ->constrained('residents')
                  ->cascadeOnDelete();

            $table->foreignId('encoded_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
        
        // Rollback to original structure
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('household_id')
                  ->constrained('households')
                  ->cascadeOnDelete();

            $table->foreignId('encoded_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('lastName');

            $table->date('birthdate')->nullable();
            $table->enum('sex', ['Male', 'Female'])->nullable();

            $table->string('relationship'); 
            $table->string('contactNumber'); 

            $table->timestamps();
        });
    }
};