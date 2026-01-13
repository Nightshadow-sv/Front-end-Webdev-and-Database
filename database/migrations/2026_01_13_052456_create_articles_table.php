<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genre_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('summary', 600);
            $table->longText('content'); // HTML or Markdown (rendered to HTML before save by admin)
            $table->enum('status', ['Draft', 'Published'])->default('Draft');
            $table->timestamp('published_at')->nullable();
            $table->string('featured_image')->nullable(); // public path like /assets/images/filename.jpg
            $table->string('author_name'); // keep simple for user-side; admin side can link author_id later
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('articles');
    }
};