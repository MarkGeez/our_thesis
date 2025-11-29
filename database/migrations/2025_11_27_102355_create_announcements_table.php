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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title', 100);
            $table->string('image', 255)->nullable();
            $table->longText('details');
            $table->date('eventTime')->nullable();
            $table->date('eventEnd')->nullable();
            $table->timestamp('postedAt')->useCurrent();
            $table->date('archiveTime');
            $table->foreignId('user_id')->constrained();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
