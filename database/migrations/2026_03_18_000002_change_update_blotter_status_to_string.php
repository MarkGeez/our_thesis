<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement(
            "ALTER TABLE update_blotters MODIFY COLUMN status VARCHAR(50) NOT NULL"
        );
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement(
            "ALTER TABLE update_blotters MODIFY COLUMN status ENUM('barangayBlotter', 'first', 'second', 'third', 'brgyHearing', 'coldCase', 'criminalCase', 'referredToPnp', 'resolved') NOT NULL"
        );
    }
};
