<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('number', 8)->default('01');
            $table->string('title');
            $table->string('price_label')->nullable();
            $table->string('duration')->nullable();
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->boolean('is_featured_home')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
