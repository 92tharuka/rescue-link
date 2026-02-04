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
        Schema::create('inventories', function (Blueprint $table) {
        $table->id();
        $table->string('item_name'); // e.g., "Water Bottles"
        $table->integer('quantity')->default(0); // e.g., 500
        $table->string('unit')->default('pcs'); // e.g., "Liters", "Packets", "Kg"
        $table->enum('category', ['Food', 'Medical', 'Equipment', 'Other']);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
