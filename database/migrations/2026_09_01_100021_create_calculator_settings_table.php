<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('calculator_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('area_min')->default(20);
            $table->unsignedInteger('area_max')->default(150);
            $table->unsignedInteger('area_default')->default(50);

            $table->string('type_cos_label')->default('Косметический');
            $table->unsignedInteger('base_cos')->default(4500);
            $table->decimal('factor_cos', 4, 2)->default(0.5);

            $table->string('type_kap_label')->default('Капитальный');
            $table->unsignedInteger('base_kap')->default(8900);
            $table->decimal('factor_kap', 4, 2)->default(1.12);

            $table->string('type_diz_label')->default('Дизайнерский');
            $table->unsignedInteger('base_diz')->default(15900);
            $table->decimal('factor_diz', 4, 2)->default(1.6);

            $table->string('default_type', 8)->default('kap');

            $table->string('opt_demo_label')->default('Демонтаж старой отделки');
            $table->unsignedInteger('opt_demo_price')->default(700);
            $table->boolean('opt_demo_default')->default(true);

            $table->string('opt_elec_label')->default('Полная замена электрики');
            $table->unsignedInteger('opt_elec_price')->default(900);
            $table->boolean('opt_elec_default')->default(true);

            $table->string('opt_plumb_label')->default('Замена труб и сантехники');
            $table->unsignedInteger('opt_plumb_price')->default(750);
            $table->boolean('opt_plumb_default')->default(false);

            $table->string('opt_plan_label')->default('Перепланировка с проектом');
            $table->unsignedInteger('opt_plan_price')->default(1100);
            $table->boolean('opt_plan_default')->default(false);

            $table->string('opt_design_label')->default('Дизайн-проект');
            $table->unsignedInteger('opt_design_price')->default(1200);
            $table->boolean('opt_design_default')->default(false);

            $table->string('opt_furn_label')->default('Сборка и монтаж мебели');
            $table->unsignedInteger('opt_furn_price')->default(500);
            $table->boolean('opt_furn_default')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculator_settings');
    }
};
