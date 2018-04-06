<?php

use Illuminate\Database\Seeder;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [
            'Автобиографическая повесть','Антиутопия','Биография','Боевики','Вестерн','Героическая фантастика',
            'Городское фэнтези','Детектив','Детская литература','Документальная литература','Драма','Искусство',
            'Историческая драма','Исторический детектив','Исторический роман','Классика','Легенды и мифы','Постмодернизм',
            'Любовный роман','Магический реализм','Мемуары','Мистика','Научная фантастика','Научно-популярная литература',
            'Новелла','Остросюжетный роман','Повесть','Поэзия','Драматургия','Поэма','Приключенческий роман',
            'Проза','Публицистика','Пьеса','Рассказ','Религия','Роман','Сказка','Техническая литература','Утопия',
            'Фантастика','Философская литература','Фэнтези','Другое'];
        $data = [];
        foreach ($genres as $value){
            $data[] = ['name'=>$value];
        }
        DB::table('genres')->insert($data);
    }
}
