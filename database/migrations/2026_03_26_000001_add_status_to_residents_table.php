<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('residents', 'status')) {
            Schema::table('residents', function (Blueprint $table) {
                $table->string('status', 20)->default('active')->after('headOfFamily');
            });
        }

        DB::table('residents')
            ->whereNull('status')
            ->orWhere('status', '')
            ->update(['status' => 'active']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('residents', 'status')) {
            Schema::table('residents', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
