<?php

use Illuminate\Database\Seeder;

class departmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\department::create([
            'dept_code'=>'CSE',
            'dept_name'=>'Computer Science and Engineering'
        ]);
        \App\department::create([
            'dept_code'=>'CEE',
            'dept_name'=>'Civil and Environmental Engineering'
        ]);
        \App\department::create([
            'dept_code'=>'EEE',
            'dept_name'=>'Electrical and Electronic Engineering'
        ]);
        \App\department::create([
            'dept_code'=>'MPE',
            'dept_name'=>'Mechanical and Production Engineering'
        ]);
        \App\department::create([
            'dept_code'=>'TVE',
            'dept_name'=>'Technical and Vocational Education'
        ]);
        \App\department::create([
            'dept_code'=>'BTM',
            'dept_name'=>'Bussiness and Technology Management'
        ]);
    }
}
