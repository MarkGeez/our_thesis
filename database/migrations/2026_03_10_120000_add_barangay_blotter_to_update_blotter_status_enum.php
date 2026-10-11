<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('update_blotters', function (Blueprint $table) {
            $table->enum('status', [
                'barangayBlotter',
                'first',
                'second',
                'third',
                'brgyHearing',
                'coldCase',
                'criminalCase',
                'referredToPnp',
                'resolved',
            ])->change();
        });
    }

    public function down(): void
    {
        DB::table('update_blotters')
            ->where('status', 'barangayBlotter')
            ->update(['status' => 'first']);

        Schema::table('update_blotters', function (Blueprint $table) {
            $table->enum('status', [
                'first',
                'second',
                'third',
                'brgyHearing',
                'coldCase',
                'criminalCase',
                'referredToPnp',
                'resolved',
            ])->change();
        });
    }
};
