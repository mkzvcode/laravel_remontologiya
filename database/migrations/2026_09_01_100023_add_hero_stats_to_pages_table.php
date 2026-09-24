<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Гибкий список статистик в шапке страницы: {num, label}[].
            // Заменяет собой stat1..stat3 — на разных страницах разное число плашек
            // (на главной их 3, на "Отзывах" и "Вакансиях" — 4).
            $table->json('hero_stats')->nullable()->after('stat3_label');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('hero_stats');
        });
    }
};
