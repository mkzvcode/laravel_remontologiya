<?php

namespace Database\Seeders;

use App\Models\Promise;
use Illuminate\Database\Seeder;

class PromiseSeeder extends Seeder
{
    public function run(): void
    {
        Promise::query()->delete();

        $rows = [
            ['number' => '01', 'title' => 'Договор с фиксированной ценой', 'text' => 'Стоимость прописана постатейно и не меняется в процессе работ. Изменения — только по вашей инициативе и с новым допсоглашением.', 'is_dark' => false],
            ['number' => '02', 'title' => 'Выезд в день обращения', 'text' => 'Замерщик приедет в день звонка, замер бесплатный. Смета с разбивкой по позициям — в течение суток.', 'is_dark' => false],
            ['number' => '03', 'title' => 'Гарантия 24 месяца', 'text' => 'Официальная гарантия на все виды работ. Дефект по нашей вине — приезжаем и переделываем бесплатно.', 'is_dark' => false],
            ['number' => '04', 'title' => 'Фотоотчёт каждый день', 'text' => 'Фото прогресса в мессенджер ежедневно, плюс отметки по чек-листу этапа. Видно, за что вы платите.', 'is_dark' => true],
        ];

        foreach ($rows as $i => $row) {
            Promise::create($row + ['sort_order' => $i]);
        }
    }
}
