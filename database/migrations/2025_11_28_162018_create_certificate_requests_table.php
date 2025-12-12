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
        Schema::create('certificateRequests', function (Blueprint $table) {
             $table->id(); 
            $table->foreignId('ServiceType')->constrained('certificates'); 
            $table->foreignId('UserId')->constrained('users'); 
            $table->string('purpose', 255); 
            $table->enum('status', ['pending', 'approved', 'declined', 'returned'])
                  ->default('pending'); 
            $table->date('requestSchedule')->nullable();
            $table->timestamp('approvedAt')->nullable();
            $table->timestamp('returnedAt')->nullable();
            $table->timestamps();
             
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificateRequests');
    }
};
