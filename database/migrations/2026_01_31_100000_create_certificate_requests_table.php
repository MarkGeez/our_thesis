<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('resident_id')->nullable()->constrained('residents')->nullOnDelete();
            $table->string('certificate_type', 50); // bonafide, indigency, soloparent, senior
            $table->string('purpose', 500);
            $table->json('request_data')->nullable(); // type-specific checkboxes, etc.
            $table->enum('status', ['pending', 'approved', 'declined', 'picked_up'])->default('pending');
            $table->text('decline_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_requests');
    }
};
