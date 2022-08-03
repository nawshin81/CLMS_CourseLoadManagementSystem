<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Auth;

class FacultyLoadingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
    }
    
    function faculty_loading(){
       
           $instructors = \App\User::where('accesslevel',1)->get();
           return view('admin.faculty_loading.faculty_loading',compact('instructors'));
       
    }

    function editfaculty_loading()
    {
        $instructors = \App\User::where('accesslevel',1)->get();
        return view('admin.faculty_loading.editfaculty_loading',compact('instructors'));
    }

    function update_load(Request $request)
        {
            for ($i=0; $i <=count($request->rowid) ; $i++) { 
                if (array_key_exists($i, $request->rowid)) {
                    $id=$request->rowid[$i];
                    $curriculum = \App\teach::find($id);
                    $curriculum->course_credit= $request->credit[$i];
                    $curriculum->update();
                    
                }
                
            }
            Session::flash('success','Successfully Saved!');
            return redirect()->back();
        }
    
    function generate_schedule($instructor){
        
            $schedules = \App\room_schedules::distinct()->where('is_active',1)
                    ->where('instructor',$instructor)
                    ->get();
            
            return view('admin.faculty_loading.generate_schedule',compact('schedules','instructor'));
    }
    
    function instructorlist_reports($instructor){
        $year=now()->year;
        $detail = \App\curriculum::join('teach','teach.course_code','curricula.course_code')->where('teach.instructor_id',$instructor)->where('teach.course_taken',$year)->where('curriculum_year',$year)->get();
        return view('admin.instructor.edit_faculty_loading',compact('detail','instructor'));
    }
    
   


    function assignTeachers(Request $request) {
        //
        $courseCode = $request->input('course_code');
        $teachers = $request->input('teachers');
        $instructors = array();// array("code"=> $courseCode, "teachers"=> $teachers);

        // Query the remaining credit-hours of the teachers

        $i = 0;
        foreach( $teachers as $t ) {
            // TODO Check eligibility of this teacher
            

            $instructors[ $i++ ] = array(
                'instructor_id' => $t['id'],
                'course_code' => $courseCode,
                'course_credit' => $t['credit'],
                'course_taken' => date('Y')
            );
        }

        $num_insertions = \App\teach::insert($instructors);

        return response()->json([
            'status'=>200, 
            'data'=>$instructors, 
            'msg'=>"Assigned " . $num_insertions . " Teacher(s)"
        ]);
    }

}
