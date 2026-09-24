<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('portfolio_cases', function (Blueprint $table) {
            $table->id();
            $table->string('kind', 8)->default('kap'); // cos|kap|diz
            $table->string('code');
            $table->string('title');
            $table->string('tag_label');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('area');
            $table->string('days');
            $table->string('budget');
            $table->string('delta')->default('0 ₽');
            $table->text('text_body');
            $table->json('chips');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_cases');
    }
};
