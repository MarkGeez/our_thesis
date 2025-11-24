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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('firstName', 70);
            $table->string('middleName', 50);
            $table->string('lastName', 50);
            $table->string('contactNumber', 11);
            $table->date('birthday');
            $table->string('proofOfIdentity');
            $table->enum('role', ['admin', 'subadmin', 'resident', 'non-resident']);
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->timestamp('registrationDate');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
