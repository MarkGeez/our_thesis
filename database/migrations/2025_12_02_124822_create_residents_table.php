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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('firstName', 70);
            $table->string('middleName', 70);
            $table->string('lastName', 70);
            $table->string('houseNo',8);
            $table->string('street',70);
            $table->string('contactNo', 11);
            $table->date('birthday');
            $table->string('emergencyContactNo', 11);
            $table->string('emergencyContactName', 255);
            $table->unsignedTinyInteger('age', );
            $table->enum('sex',['male', 'female']);
            $table->enum('parent',['yes', 'no', 'single']);
            $table->enum('enrolled', ['yes', 'no']);
            $table->string('educationalAttainment')->nullable();
            $table->foreignId('religionId')->constrained('religions');
            $table->enum('headOfFamily', ['yes','no']);
            $table->foreignId('EncodedBy')->constrained('users');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
