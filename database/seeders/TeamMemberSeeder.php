<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        TeamMember::query()->delete();

        $rows = [
            ['name' => 'Денис', 'role' => 'Основатель', 'avatar_letter' => 'Д', 'note' => '10 лет в ремонте, лично согласует каждую смету и приезжает на все финальные приёмки.'],
            ['name' => 'Артур', 'role' => 'Прораб', 'avatar_letter' => 'А', 'note' => 'Ведёт объекты под ключ — не больше трёх одновременно. Ваш единственный контакт по стройке.'],
            ['name' => 'Игорь', 'role' => 'Электрик', 'avatar_letter' => 'И', 'note' => 'Полный электромонтаж со схемой щита и протоколом проверки линий на сдаче.'],
            ['name' => 'Настя', 'role' => 'Менеджер', 'avatar_letter' => 'Н', 'note' => 'На связи весь ремонт: фотоотчёты, графики закупок, документы и акты приёмки.'],
        ];

        foreach ($rows as $i => $row) {
            TeamMember::create($row + ['show_on_home' => true, 'sort_order' => $i]);
        }
    }
}
