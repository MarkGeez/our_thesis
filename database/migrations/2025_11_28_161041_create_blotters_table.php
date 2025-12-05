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
        Schema::create("blotter", function(Blueprint $table){
            
            $table->id(); 
            $table->foreignId('plaintiffId')->nullable()->constrained('users'); 
            $table->string('plaintiffAddress', 255)->nullable();
            $table->integer('plaintiffContactNumber')->nullable();
            $table->string('plaintiffName', 255);
            $table->string('plaintiffMiddleName', 255)->nullable();
            $table->string('plaintiffLastName', 255);
            $table->integer('plaintiffAge')->nullable(); 

            $table->string('defendantAddress', 255)->nullable();
            $table->integer('defendantContactNumber')->nullable(); 
            $table->string('defendantName', 255);
            $table->string('defendantMiddleName', 255)->nullable();
            $table->string('defendantLastName', 255);
            $table->integer('defendantAge')->nullable(); 

            $table->string('witnessName', 255)->nullable();
            $table->integer('witnessContactNumber')->nullable();
            $table->mediumText('proof')->nullable(); 
            $table->longText('blotterDescription');
            $table->string('schedule', 255)->nullable(); 
            $table->foreignId('encodedBy')->nullable()->constrained('users');
            $table->string('action');
            $table->enum('status', ['PENDING', 'SCHEDULED', 'RESOLVED', 'CLOSED'])
                    ->default('PENDING');

            $table->longText('statusDescription')->nullable();
            $table->timestamps(); 
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blotters');
    }
};
