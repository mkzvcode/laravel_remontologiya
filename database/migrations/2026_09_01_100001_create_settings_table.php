<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone_e164')->default('+79222371555');
            $table->string('phone_display')->default('+7 (922) 237-15-55');
            $table->string('whatsapp_url')->nullable();
            $table->string('telegram_url')->nullable();
            $table->string('email')->nullable();
            $table->string('address_line')->nullable();
            $table->string('work_hours')->nullable();
            $table->string('inn')->nullable();
            $table->string('brand_name')->default('Ремонтология');
            $table->string('brand_meta')->default('Челябинск · с 2016');
            $table->text('footer_about')->nullable();
            $table->string('footer_legal')->nullable();
            $table->string('og_image')->nullable();
            $table->string('seo_suffix')->default(' | Ремонтология');
            $table->string('ga_id')->nullable();
            $table->string('metrika_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
