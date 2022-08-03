<?php

use Illuminate\Database\Seeder;

class AcademicProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\academic_programs::create([
           'academic_type' => 'College',
           'department' => 'CSE',
           'program_code' => 'SWE',
           'program_name' => 'Software Engineering',
        ]);
        
        \App\academic_programs::create([
           'academic_type' => 'College',
           'department' => 'CSE',
           'program_code' => 'CSE',
           'program_name' => 'Computer Science and Engineering',
        ]);

        \App\academic_programs::create([
           'academic_type' => 'College',
           'department' => 'BTM',
           'program_code' => 'BTM',
           'program_name' => 'BBA in Technology Management',
        ]);

        \App\academic_programs::create([
           'academic_type' => 'College',
           'department' => 'CEE',
           'program_code' => 'CE',
           'program_name' => 'Civil Engineering',
        ]);

        \App\academic_programs::create([
           'academic_type' => 'College',
           'department' => 'EEE',
           'program_code' => 'EEE',
           'program_name' => 'Electrical and Electronic Engineering',
        ]);

        \App\academic_programs::create([
           'academic_type' => 'College',
           'department' => 'MPE',
           'program_code' => 'ME',
           'program_name' => 'Mechanical Engineering',
        ]);

        \App\academic_programs::create([
           'academic_type' => 'College',
           'department' => 'MPE',
           'program_code' => 'IPE',
           'program_name' => 'Industrial and Production Engineering',
        ]);

    }
}
