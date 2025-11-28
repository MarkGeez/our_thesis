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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')->constrained('services');
            $table->foreignId('user_id')->constrained('users');
            $table->string('purpose', 255);
            $table->enum('status', ['PENDING', 'APPROVED', 'DECLINED', 'RETURNED'])
                  ->default('PENDING');
            $table->date('request_schedule')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};