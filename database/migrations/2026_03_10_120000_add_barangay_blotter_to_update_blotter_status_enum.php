<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(
            "ALTER TABLE update_blotters MODIFY COLUMN status ENUM('barangayBlotter', 'first', 'second', 'third', 'brgyHearing', 'coldCase', 'criminalCase', 'referredToPnp', 'resolved') NOT NULL"
        );
    }

    public function down(): void
    {
        DB::table('update_blotters')
            ->where('status', 'barangayBlotter')
            ->update(['status' => 'first']);

        DB::statement(
            "ALTER TABLE update_blotters MODIFY COLUMN status ENUM('first', 'second', 'third', 'brgyHearing', 'coldCase', 'criminalCase', 'referredToPnp', 'resolved') NOT NULL"
        );
    }
};
