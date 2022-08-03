<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;
use Illuminate\Support\Facades\Session;

use PDF;

class FacultyLoadingAjax extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    function courses_to_load(){
        if(Request::ajax()){
            $program = Input::get('program');
            $semester = Input::get('level');
            $con=\App\teach::distinct()->where('course_taken',now()->year)->get(array('course_code'));
            $courses = \App\curriculum::distinct()->where('curriculum_year',now()->year)->where('program_code',$program)->where('period',$semester)->whereNotIn('course_code',$con)->
                    get();
            return view('admin.faculty_loading.ajax.courses_to_load',compact('semester','courses','program'))->render();
        }
    }

    function print_instructor($instructor){
        $year=now()->year;
       $detail = \App\curriculum::join('teach','teach.course_code','curricula.course_code')->where('teach.instructor_id',$instructor)->where('teach.course_taken',$year)->where('curriculum_year',$year)->get();
       $ins= \App\instructors_infos::where('instructor_id',$instructor)->get();
     
        $pdf=PDF::loadView('admin.instructor.print_instructor',compact('instructor','detail'));
        $pdf->setPaper('A4','portrait');
        foreach ($ins as $teacher ) {
            return $pdf->stream($teacher->name.' Load.pdf');
        }
       
    }


    function course_mngt(){
        if(Request::ajax()){
        $dept = Input::get('dept');
        $code = Input::get('course_code');
        $prog=Input::get('program');
        
        
      
            
        return view('admin.faculty_loading.ajax.course_mngt',compact('code','dept','prog'))->render();
        }
    }


    function courses_lists(){
        if(Request::ajax()){      
        $level = Input::get('level');
        $prog=Input::get('program');

        return view('admin.faculty_loading.ajax.courses_lists',compact('level','prog'))->render();
        }
    }


    function edit_load(){
        if(Request::ajax()){     
        $course = Input::get('course_code');

    
    $details = \App\curriculum::distinct()->where('course_code', $course)->where('curriculum_year', now()->year)->get();

        return view('admin.faculty_loading.ajax.edit_load',compact('course','details'))->render();
        }
    }

        



    function course_assign(){
        if(Request::ajax()){
            $course_code=Input::get('course_code');
            $teacher=Input::get('name');
            $teacher_id=\App\instructors_infos::distinct()->where('name',$teacher)->get(['instructor_id']);
            $teacher_credit=Input::get('credit');
            for ($i=0; $i <5 ; $i++) { 
                $row = new \App\teach;
                $row->instructor_id=$teacher_id[$i];
                $row->course_credit=$teacher_credit[$i];
                $row->course_code=$course_code;
                $row->course_taken=now()->year;
                $row->save();
            }
          return view('admin.faculty_loading.ajax.course_assign',compact('teacher'))->render();
        }
    }

    
    function current_load(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $level = Input::get('level');
            
            $loads = DB::table('curricula')
                    ->join('offerings_infos','curricula.id','offerings_infos.curriculum_id')
                    ->join('room_schedules','room_schedules.offering_id','offerings_infos.id')
                    ->where('room_schedules.instructor',$instructor)
                    ->get();
            $tabular_schedules = \App\room_schedules::distinct()->
                    where('is_active',1)->where('instructor',$instructor)->get(['offering_id']);
            $schedules = \App\room_schedules::
                    where('is_active',1)->where('instructor',$instructor)->get();
            
            return view('admin.faculty_loading.ajax.current_load',compact('schedules','instructor','level','tabular_schedules','loads'))->render();
        }
    }
    
    function add_faculty_load(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $offering_id = Input::get('offering_id');
            $info = \App\instructors_infos::where('instructor_id',$instructor)->first();
            
            
            $loads = DB::table('curricula')
                    ->join('offerings_infos','curricula.id','offerings_infos.curriculum_id')
                    ->join('room_schedules','room_schedules.offering_id','offerings_infos.id')
                    ->where('room_schedules.instructor',$instructor)
                    ->get();
            $load_units = \App\UnitsLoad::where('instructor_id',$instructor)->get();
            
            if($loads->sum('units') >= $load_units->sum('units')){
                abort(404);
            }
            
            $schedules = \App\room_schedules::where('offering_id',$offering_id)->get();
            if(!$schedules->isEmpty()){
                foreach($schedules as $schedule){
                    $conflict = \App\room_schedules::distinct()
                            ->where('instructor',$instructor)
                            ->where('day',$schedule->day)
                            ->where(function($query) use ($schedule) {
                                $query->whereBetween('time_starts', array(date("H:i:s", strtotime($schedule->time_starts)), date("H:i:s", strtotime($schedule->time_end))))
                                ->orwhereBetween('time_end', array(date("H:i:s", strtotime($schedule->time_starts)), date("H:i:s", strtotime($schedule->time_end))));
                            })
                            ->get(['offering_id']);
                    if($conflict->isEmpty()){
                        $schedule->instructor = $instructor;
                        $schedule->update();
                    }else{
                        $rollback_schedules = \App\room_schedules::where('offering_id',$schedule->offering_id)->get();
                        if(!$rollback_schedules->isEmpty()){
                            foreach($rollback_schedules as $rollback){
                                $rollback->instructor = NULL;
                                $rollback->update();
                            }
                            abort(500);

                        }
                    }
                }
            }
        }
    }
    
    function remove_faculty_load(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $offering_id = Input::get('offering_id');
            $schedules = \App\room_schedules::where('instructor',$instructor)->where('offering_id',$offering_id)->get();
            
            if(!$schedules->isEmpty()){
                foreach($schedules as $schedule){
                    $schedule->instructor = NULL;
                    $schedule->is_loaded = 0;
                    $schedule->save();
                }
            }
        }
    }
    
    function search_courses(){
        if(Request::ajax()){
            $value = Input::get('value');
            $level = Input::get('level');
            
            $curriculum = \App\curriculum::where('course_code','like',"%$value%")->get();
            
            return view('admin.faculty_loading.ajax.search_courses',compact('curriculum','level'));
        }
    }
    
    function reloadnotif(){
        if(Request::ajax()){
            $notif_id = Input::get('notif_id');
            
            $notification = \App\LoadNotification::find($notif_id);
            $notification->is_trash = 1;
            $notification->update();
            
            $notifications = \App\LoadNotification::get();
            return view('admin.notification.ajax.reload_notification',compact('notifications'));
        }
    }

    function edit_modal(){
        if(Request::ajax()){
            $teacher_id = Input::get('id');
            $teacher_course = \App\teach::where('instructor_id',$teacher_id)->where('course_taken',now()->year)->get();
             $tname=\App\instructors_infos::where('instructor_id',$teacher_id)->get();
            
            return view('admin.faculty_loading.ajax.teacher_details',compact('teacher_course','tname'));
        }
    }
    
    function get_units_loaded(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $offering_id = Input::get('offering_id');
            $level = Input::get('level');
            $type = \App\instructors_infos::where('instructor_id',$instructor)->first()->employee_type;
            $units = \App\UnitsLoad::where('instructor_id',$instructor)->first()->units;
            $tabular_schedules = \App\room_schedules::distinct()->
                    where('is_active',1)->where('instructor',$instructor)->get(['offering_id']);
            return view('admin.faculty_loading.ajax.get_units_loaded',compact('instructor','tabular_schedules','type','units','offering_id','level'));
        }
    }
    
    function override_add(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $offering_id = Input::get('offering_id');
            $override = Input::get('override');
            
            $info = \App\instructors_infos::where('instructor_id',$instructor)->first();
            
            $load_units = \App\UnitsLoad::where('instructor_id',$instructor)->first();
            $load_units->units = $override;
            $load_units->update();
            
            $schedules = \App\room_schedules::where('offering_id',$offering_id)->get();
            if(!$schedules->isEmpty()){
                foreach($schedules as $schedule){
                    $conflict = \App\room_schedules::distinct()
                            ->where('instructor',$instructor)
                            ->where('day',$schedule->day)
                            ->where(function($query) use ($schedule) {
                                $query->whereBetween('time_starts', array(date("H:i:s", strtotime($schedule->time_starts)), date("H:i:s", strtotime($schedule->time_end))))
                                ->orwhereBetween('time_end', array(date("H:i:s", strtotime($schedule->time_starts)), date("H:i:s", strtotime($schedule->time_end))));
                            })
                            ->get(['offering_id']);
                    if($conflict->isEmpty()){
                        $schedule->instructor = $instructor;
                        $schedule->update();
                    }else{
                        $rollback_schedules = \App\room_schedules::where('offering_id',$schedule->offering_id)->get();
                        if(!$rollback_schedules->isEmpty()){
                            foreach($rollback_schedules as $rollback){
                                $rollback->instructor = NULL;
                                $rollback->update();
                            }
                            abort(500);
                            
                        }
                    }
                }
            }
        
        }
    }
}
