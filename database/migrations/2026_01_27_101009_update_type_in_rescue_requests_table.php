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
        // Changing it to a standard string removes the strict ENUM or length limit
        $table->string('type')->change(); 
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
