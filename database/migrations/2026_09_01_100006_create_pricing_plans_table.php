<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('price_from');
            $table->string('price_unit')->default('₽/м²');
            $table->boolean('is_featured')->default(false);
            $table->string('badge_text')->nullable();
            $table->string('bg_variant')->default('white'); // white|ink|sand
            $table->json('items'); // список пунктов
            $table->string('cta_label')->default('Рассчитать');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
