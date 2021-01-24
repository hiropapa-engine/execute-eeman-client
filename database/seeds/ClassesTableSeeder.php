<?php

use Illuminate\Database\Seeder;
use App\School;
use App\ClassModel;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $times = [
            ['16:30', '17:30'],
            ['17:45', '18:45'],
            ['19:00', '20:00']
        ];

        $school = School::get()->first();
        for ($i = 0; $i < count($times); $i++)
        {
            $class = new ClassModel();
            $class->school_id = $school->id;
            $class->time_from = $times[$i][0];
            $class->time_to = $times[$i][1];
            $class->save();
        }
    }
}
