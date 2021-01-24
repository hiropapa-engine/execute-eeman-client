<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\ClassModel;
use App\Student;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class1_members = [
            'きたわき　あさひ',
            'たかはし　いさき',
            'さいとう　そうま',
            'さいとう　けいた',
        ];

        $class2_members = [
            'かさい　はると',
            'ふるた　ひろのり',
            'まえだ　かいせい',
        ];

        $class3_members = [
            'のち　ひゆう',
            'しおこし　はる',
            'よねや　たけと',
        ];

        $class1 = ClassModel::where('time_from', '16:30:00')->get()->first();
        $class2 = ClassModel::where('time_from', '17:45:00')->get()->first();
        $class3 = ClassModel::where('time_from', '19:00:00')->get()->first();

        $students = Student::get();
        foreach($students as $student)
        {
            $class_id = -1;
            if (in_array($student->name, $class1_members))
            {
                $class_id = $class1->id;
            }
            else if (in_array($student->name, $class2_members))
            {
                $class_id = $class2->id;
            }
            else if (in_array($student->name, $class3_members))
            {
                $class_id = $class3->id;
            }
            if ($class_id != -1)
            {
                DB::table('tickets')->insert([
                    'class_id' => $class_id,
                    'student_id' => $student->id,
                ]);
            }
        }
    }
}
