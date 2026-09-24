<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
            PromiseSeeder::class,
            ServiceSeeder::class,
            PricingPlanSeeder::class,
            PriceCategorySeeder::class,
            EstimateExampleSeeder::class,
            PortfolioCaseSeeder::class,
            ProcessStepSeeder::class,
            ReviewSeeder::class,
            GuaranteeSeeder::class,
            TeamMemberSeeder::class,
            AboutSeeder::class,
            FaqSeeder::class,
            BlogPostSeeder::class,
            VacancySeeder::class,
            CalculatorSettingSeeder::class,
        ]);
    }
}
