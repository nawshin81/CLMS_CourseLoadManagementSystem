<?php

use Illuminate\Database\Seeder;

class CurriculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\curriculum::create([
           'curriculum_year' => '2018', 
           'offered_by' => 'CSE',
           'offered_to' => 'CSE',
           'program_code' => 'SWE',
           'program_name' => 'Bachelor of Science in Software Engineering',
           'control_code' => 'ITE 113',
           'course_code' => 'ITE 113',
           'course_name' => 'Intro to Information Technology 1',
           'lec' => '3',
           'lab' => '3',
           'units' => '3',
           
           'period' => '1st Semester',
           'is_complab' => '1'
        ]);
        
        \App\curriculum::create([
           'curriculum_year' => '2018', 
            'offered_by' => 'CSE',
           'offered_to' => 'CSE',
           'program_code' => 'SWE',
           'program_name' => 'Bachelor of Science in Software Engineering',
           'control_code' => 'PROG 113',
           'course_code' => 'PROG 113',
           'course_name' => 'Programming 1',
           'lec' => '3',
           'lab' => '3',
           'units' => '3',
           
           'period' => '1st Semester',
           'is_complab' => '1'
        ]);

         \App\curriculum::create([
           'curriculum_year' => '2019', 
            'offered_by' => 'CSE',
           'offered_to' => 'CSE',
           'program_code' => 'SWE',
           'program_name' => 'Bachelor of Science in Software Engineering',
           'control_code' => 'PROG 113',
           'course_code' => 'PROG 113',
           'course_name' => 'Programming 1',
           'lec' => '3',
           'lab' => '3',
           'units' => '3',
           'level' => '1st Year',
           'period' => '1st Semester',
           'is_complab' => '1'
        ]);
    }
}
