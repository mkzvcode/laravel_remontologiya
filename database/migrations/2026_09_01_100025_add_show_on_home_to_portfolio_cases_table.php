<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('portfolio_cases', function (Blueprint $table) {
            // Отмечает 3 кейса, которые показываются в блоке "Было и стало"
            // на главной (со сравнивающим ползунком). На странице портфолио
            // при этом видны все.
            $table->boolean('show_on_home')->default(false)->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_cases', function (Blueprint $table) {
            $table->dropColumn('show_on_home');
        });
    }
};
