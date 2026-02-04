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
        Schema::create('safe_zones', function (Blueprint $table) {
        $table->id();
        $table->string('name');             // e.g., "City Temple"
        $table->string('type');             // e.g., "Temple", "School", "High Ground"
        $table->integer('capacity');        // e.g., 500 people
        $table->decimal('latitude', 10, 7);
        $table->decimal('longitude', 10, 7);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safe_zones');
    }
};
