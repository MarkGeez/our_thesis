<?php
// database/migrations/xxxx_xx_xx_create_generated_reports_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_name');
            $table->string('report_type'); // population, blotter, certificate
            $table->json('filters_used')->nullable();
            $table->integer('total_records')->default(0);
            $table->timestamps();
            $table->foreignId('generated_by')->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};

