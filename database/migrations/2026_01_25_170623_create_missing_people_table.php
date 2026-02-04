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
        Schema::create('missing_people', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->string('photo_path')->nullable(); // Saves the image filename
        $table->string('contact_phone');
        $table->string('status')->default('Missing'); // Missing vs Found
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missing_people');
    }
};
