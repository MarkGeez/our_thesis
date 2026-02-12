<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('official_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('official_id')->nullable()->constrained('officials')->nullOnDelete();
            $table->foreignId('resident_id')->nullable()->constrained('residents')->nullOnDelete();
            $table->string('position', 100);
            $table->string('details', 255)->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('action', 30)->default('updated');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('position');
            $table->index('start');
            $table->index('end');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('official_histories');
    }
};
