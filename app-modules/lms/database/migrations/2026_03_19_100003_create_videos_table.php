<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->string('extension');
            $table->text('path_name');
            $table->string('slug');
            $table->text('file_name');
            $table->string('file_type')->default('video');
            $table->text('file_name_without_extension');
            $table->integer('sort_order')->default(0);
            $table->integer('duration_seconds')->default(0);
            $table->timestamps();

            $table->unique(['chapter_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
