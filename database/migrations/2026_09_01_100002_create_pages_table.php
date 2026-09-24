<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nav_key')->nullable();
            $table->string('meta_title');
            $table->string('meta_description', 500)->nullable();
            $table->string('og_image')->nullable();
            $table->string('hero_eyebrow')->nullable();
            $table->text('hero_title_html')->nullable();
            $table->text('hero_lead')->nullable();
            $table->string('hero_cta1_label')->nullable();
            $table->string('hero_cta1_href')->nullable();
            $table->string('hero_cta2_label')->nullable();
            $table->string('hero_cta2_href')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_image_alt')->nullable();
            $table->string('hero_badge_label')->nullable();
            $table->string('hero_badge_sum')->nullable();
            $table->string('hero_badge_note')->nullable();
            $table->string('hero_caption_meta')->nullable();
            $table->string('hero_caption_title')->nullable();
            $table->string('hero_caption_term')->nullable();
            $table->string('hero_caption_note')->nullable();
            $table->string('stat1_num')->nullable();
            $table->string('stat1_label')->nullable();
            $table->string('stat2_num')->nullable();
            $table->string('stat2_label')->nullable();
            $table->string('stat3_num')->nullable();
            $table->string('stat3_label')->nullable();
            $table->json('marquee_items')->nullable();
            $table->json('sections')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
