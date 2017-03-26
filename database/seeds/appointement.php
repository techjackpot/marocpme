<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class appointement extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    //     DB::table('appointments')->insert([
    //         'name' => str_random(10),
    //         'email' => str_random(10).'@gmail.com',
    //         'password' => bcrypt('secret'),
    //     ]);
       //
    //    DB::table('appointments')->insert([
    //         'calendar_id' => 2,
    //         'mailProspect' => str_random(10) . '@gmail.com',
    //         'date' => Carbon::now(),
    //         'note' => bcrypt('secret'),
    //         'hour' => Carbon::createFromFormat('Y-m-d H', '2017-03-4 22')->toDateTimeString(),
    //         'emplacement' => 'Marrakech',
       //
    //     ]);

        DB::table('users')->insert([
            'password' => bcrypt("123456"),
            'nom'=>'nadir',
            'prenom'=>'anass',
            'email' => 'anass@gmail.com',
            'tel' => '+233999394934',
            'poste' => 'kfkdkfd',
            'localisation' => 'marrakech',
            //'isAdmin' => 'heIS',
            'active' => 'forNow'
        ]);
            }
}
