<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('folder_path');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['series_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
