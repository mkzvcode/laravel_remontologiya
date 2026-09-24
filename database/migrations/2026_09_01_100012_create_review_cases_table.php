<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('review_cases', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title');
            $table->text('text_body');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('budget');
            $table->string('note');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_cases');
    }
};
