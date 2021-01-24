<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'のち　ひゆう',
            'かさい　はると',
            'しおこし　はる',
            'きたわき　あさひ',
            'たかはし　いさき',
            'よねや　たけと',
            'ふるた　ひろのり',
            'まえだ　かいせい',
            'さいとう　そうま',
            'さいとう　けいた',
        ];

        foreach ($names as $name)
        {
            DB::table('students')->insert([
                'name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
