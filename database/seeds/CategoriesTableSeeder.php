<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::get()->first();
        $category = new Category();
        $category->user_id = $user->id;
        $category->name = 'Dスクール';
        $category->save();
    }
}
