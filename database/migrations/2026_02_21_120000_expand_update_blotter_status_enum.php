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
        Schema::table('update_blotters', function (Blueprint $table) {
            $table->enum('status', [
                'first',
                'second',
                'third',
                'brgyHearing',
                'coldCase',
                'criminalCase',
                'referredToPnp',
                'resolved',
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('update_blotters', function (Blueprint $table) {
            $table->enum('status', [
                'first',
                'second',
                'third',
                'brgyHearing',
                'coldCase',
                'criminalCase',
            ])->change();
        });
    }
};
