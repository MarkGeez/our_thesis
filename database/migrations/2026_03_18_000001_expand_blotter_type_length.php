<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(
            "ALTER TABLE blotters MODIFY COLUMN blotter_type VARCHAR(50) NOT NULL DEFAULT 'regular'"
        );
    }

    public function down(): void
    {
        DB::statement(
            "ALTER TABLE blotters MODIFY COLUMN blotter_type VARCHAR(20) NOT NULL DEFAULT 'regular'"
        );
    }
};
