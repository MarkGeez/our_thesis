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
            $table->timestamps();
            $table->foreignId('complainant_id')->constrained('users');
            $table->string("complainantName", 255);
            $table->string("address", 255);
            $table->longText("details");
            $table->foreignId( "respondent_id")->nullable()->constrained("users");
            $table->enum("status",["resolved", "on-going", "rejected"])->default("pending");

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
