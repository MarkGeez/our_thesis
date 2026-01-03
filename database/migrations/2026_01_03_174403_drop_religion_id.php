<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            // Drop foreign key only if it exists
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        });
        
        Schema::table('residents', function (Blueprint $table) {
            // Drop the religionId column if it exists
            if (Schema::hasColumn('residents', 'religionId')) {
                $table->dropColumn('religionId');
            }
            
            // Add new religion string column if it doesn't exist
            if (!Schema::hasColumn('residents', 'religion')) {
                $table->string('religion', 100)->nullable();
            }
        });
        
        Schema::table('residents', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            if (Schema::hasColumn('residents', 'religion')) {
                $table->dropColumn('religion');
            }
            
            if (!Schema::hasColumn('residents', 'religionId')) {
                $table->foreignId('religionId')->constrained('religions');
            }
        });
    }
};
