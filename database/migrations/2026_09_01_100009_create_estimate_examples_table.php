<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('estimate_examples', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle');
            $table->string('code_label')->nullable();
            $table->string('area_label')->nullable();
            $table->json('rows');           // [{name, price}]
            $table->json('checklist');      // ["текст пункта", ...]
            $table->string('total_label')->default('Работы, итого');
            $table->string('total_value');
            $table->string('materials_label')->default('Черновые материалы (по чекам)');
            $table->string('materials_value')->nullable();
            $table->string('days_label')->default('Срок по договору');
            $table->string('days_value')->nullable();
            $table->string('cta_label')->default('Хочу такую смету по своей квартире');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estimate_examples');
    }
};
