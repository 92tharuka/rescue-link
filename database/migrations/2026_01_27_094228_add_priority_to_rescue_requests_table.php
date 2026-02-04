<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rescue_requests', function (Blueprint $table) {
            // We use an integer: 1 (Critical), 2 (High), 3 (Normal)
            $table->integer('priority')->default(3)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rescue_requests', function (Blueprint $table) {
            //
        });
    }
};
