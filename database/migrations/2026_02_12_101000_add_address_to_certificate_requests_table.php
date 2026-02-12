<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('certificate_requests', 'address')) {
            Schema::table('certificate_requests', function (Blueprint $table) {
                $table->string('address', 255)->nullable()->after('purpose');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('certificate_requests', 'address')) {
            Schema::table('certificate_requests', function (Blueprint $table) {
                $table->dropColumn('address');
            });
        }
    }
};
