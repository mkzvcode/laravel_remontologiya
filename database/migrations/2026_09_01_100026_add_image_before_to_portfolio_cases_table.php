<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('portfolio_cases', function (Blueprint $table) {
            // Фото "до" — нужно только тем трём кейсам, что показываются
            // на главной в блоке со сравнивающим ползунком.
            $table->string('image_before')->nullable()->after('image_alt');
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_cases', function (Blueprint $table) {
            $table->dropColumn('image_before');
        });
    }
};
