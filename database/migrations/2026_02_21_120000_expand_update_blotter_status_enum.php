<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement(
            "ALTER TABLE update_blotters MODIFY COLUMN status ENUM('first', 'second', 'third', 'brgyHearing', 'coldCase', 'criminalCase', 'referredToPnp', 'resolved') NOT NULL"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement(
            "ALTER TABLE update_blotters MODIFY COLUMN status ENUM('first', 'second', 'third', 'brgyHearing', 'coldCase', 'criminalCase') NOT NULL"
        );
    }
};
