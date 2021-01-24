<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_id' => '600d340c4215e',
            'company_name' => '株式会社EXECUTE',
            'name' => '山本　啓之',
            'email' => 'admin@hiropapa-engine.com',
            'phone_number' => '090-9439-5704',
            'password' => bcrypt('P+83=63U'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
