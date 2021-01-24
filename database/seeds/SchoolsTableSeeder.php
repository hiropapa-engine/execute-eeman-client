<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\School;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::get()->first();
        $school = new School();
        $school->category_id = $category->id;
        $school->name = '琴似校';
        $school->save();
    }
}
