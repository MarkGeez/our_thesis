<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->string('position', 100)->change();
        });
    }

    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->enum('position', [
                'Chairman',
                'Kagawad',
                'Secretary',
                'Treasurer',
                'Sk Chairman',
                'Sk Kagawad',
            ])->change();
        });
    }
};
