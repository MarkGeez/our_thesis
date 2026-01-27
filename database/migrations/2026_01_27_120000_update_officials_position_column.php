<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE officials MODIFY position VARCHAR(100) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE officials MODIFY position ENUM('Chairman','Kagawad','Secretary','Treasurer','Sk Chairman','Sk Kagawad') NOT NULL");
    }
};
