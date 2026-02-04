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
        Schema::create('rescue_requests', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone');
        $table->enum('type', ['Food', 'Water', 'Medical', 'Evacuation', 'Other']);
        $table->text('description')->nullable();
        $table->decimal('latitude', 10, 8);
        $table->decimal('longitude', 11, 8);
        $table->enum('status', ['Pending', 'In Progress', 'Resolved'])->default('Pending');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rescue_requests');
    }
};
