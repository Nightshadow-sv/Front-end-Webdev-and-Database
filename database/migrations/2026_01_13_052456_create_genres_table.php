<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Technology, Business, Politics, Science, Health, Sports
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('genres');
    }
};