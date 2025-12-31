<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->unsignedInteger('quantity_requested')->default(1)->after('service_type_id');
            $table->string('remarks', 255)->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn(['quantity_requested', 'remarks']);
        });
    }
};
