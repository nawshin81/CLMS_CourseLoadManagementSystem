<?php

namespace App\Http\Controllers\Instructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class FacultyLoading extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
    }
    
    function faculty_loading(){
        if(Auth::user()->accesslevel == 1){
        $instructor = Auth::user()->id;
         $year=now()->year;
        $detail = \App\curriculum::join('teach','teach.course_code','curricula.course_code')->where('teach.instructor_id',$instructor)->where('teach.course_taken',$year)->where('curriculum_year',$year)->get();	
            return view('instructor.faculty_loading.faculty_loading',compact('instructor','detail'));
        }
    }

    function semester_occupied(){
        $courses = \App\curriculum::all();
        return view('instructor.faculty_loading.semester_occupied',compact('courses'));
    }
}
