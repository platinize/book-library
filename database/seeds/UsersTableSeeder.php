<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $surnames = ['Смирнов','Иванов',' Кузнецов',' Соколов','Попов','Лебедев','Козлов','Новиков',' Морозов','Петров','Волков','Соловьёв','Васильев'];
        $names = ['Пётр', 'Гарри','Геннадий','Генри','Генрих','Георгий','Герасим','Герман','ГерманнГлеб'];
        $middleNames = ['Вадимович','Викторович','Давидович','Лаврентьевич','Олегович','Святославович','Эдуардович','Яковлевич','Николаевич','Иосифович'];
        $data[] = [
            'name' => 'admin',
            'email' =>'admin@admin.ru',
            'phone' => '+'.'38050'.rand(1000000,9999999),
            'address' => 'dom 1, 1',
            'password'=>'$2y$10$QT0vDEoeWtScNVfmBLJUC.hhCABVDIpGsZ6pCmxrTCKVvBL7J3Lcm',
            'role'=>'admin',
            'created_at'=>date('Y-m-d', time()),
            'card_number' => strtoupper(str_random(2)).rand(100000,999999).'0'
        ];
        for($i=0; $i<25; $i++) {
            shuffle($surnames);
            shuffle($names);
            shuffle($middleNames);
            $data[] = [
                'name' => $surnames[0].' '.$names[0].' '.$middleNames[0],
                'email' =>$i.'email@email.it',
                'phone' => '+'.'38050'.rand(1000000,9999999),
                'address' => 'Дом '.$i.' Кв. '.$i,
                'password'=>'$2y$10$QT0vDEoeWtScNVfmBLJUC.hhCABVDIpGsZ6pCmxrTCKVvBL7J3Lcm',
                'role'=>'user',
                'created_at'=>date('Y-m-d', time()),
                'card_number' => strtoupper(str_random(2)).rand(100000,999999).$i
            ];
        }

        DB::table('users')->insert($data);
    }
}
