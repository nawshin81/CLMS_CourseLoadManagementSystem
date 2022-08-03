<?php

namespace App\Http\Controllers\Instructor\Ajax;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;
use App\Events\LoadingNotification;
use PDF;

class FacultyLoadingAjax extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    function get_offer_load(){
        if(Request::ajax()){
            $offering_id = Input::get('offering_id');
            $schedules = \App\room_schedules::where('offering_id',$offering_id)
                    ->where('instructor',Auth::user()->id)->get()->unique('offering_id');
            
            return view('instructor.faculty_loading.ajax.get_offer_load',compact('schedules','offering_id'));
        }
    }
    
    function accept_load(){
        if(Request::ajax()){
           $offering_id = Input::get('offering_id');
           
           $schedules = \App\room_schedules::where('instructor',Auth::user()->id)
                   ->where('offering_id',$offering_id)->get();
           if(!empty($schedules)){
               foreach($schedules as $schedule){
                   $schedule->is_loaded = 1;
                   $schedule->update();
               }
           }
           
           $user = \App\User::find(Auth::user()->id);
           
           $notification = new \App\LoadNotification;
           $notification->date_time = date('Y-m-d H:i:s');
           $notification->content = "Instructor ".strtoupper($user->lastname).', '.strtoupper($user->name).' accepted the faculty load suggested by the Admin.';
           $notification->save();
           
           $content = "Instructor ".strtoupper($user->lastname).', '.strtoupper($user->name).' accepted the faculty load suggested by the Admin.';
           
           event(new LoadingNotification($content));
        }
    }
    
    function reject_offer(){
        if(Request::ajax()){
          $offering_id = Input::get('offering_id');
          $reason = Input::get('reason');
          
          $schedules = \App\room_schedules::where('instructor',Auth::user()->id)
                   ->where('offering_id',$offering_id)->get();
           if(!empty($schedules)){
               foreach($schedules as $schedule){
                   $schedule->is_loaded = 0;
                   $schedule->instructor = NULL;
                   $schedule->update();
               }
           }
           
           $user = \App\User::find(Auth::user()->id);
           
           $notification = new \App\LoadNotification;
           $notification->date_time = date('Y-m-d H:i:s');
           $notification->content = "Instructor ".strtoupper($user->lastname).', '.strtoupper($user->name).' rejected the faculty load suggested by the Admin. Due to '.$reason;
           $notification->save();
           
           $content = "Instructor ".strtoupper($user->lastname).', '.strtoupper($user->name).' rejected the faculty load suggested by the Admin. Due to '.$reason;
           
           event(new LoadingNotification($content));
        }
    }
    
    function reloadtabular(){
        if(Request::ajax()){
            $tabular_schedules = \App\room_schedules::distinct()->
                    where('is_active',1)->where('instructor',Auth::user()->id)->get(['offering_id','is_loaded']);
            return view('instructor.faculty_loading.ajax.reloadtabular',compact('tabular_schedules'));
        }
    }


    function get_semester_occupied(){
        if(Request::ajax()){
            $offered_to = Input::get('offered_to');
            $program_code = Input::get('program_code');
            $period = Input::get('period');
            
            $schedules = \App\curriculum::where('offered_to',$offered_to)->where('program_code',$program_code)
                  ->where('period',$period)
                    ->get();
            

            //"/ajax/instructors/get_semester_occupied"
            return view('instructor.faculty_loading.ajax.get_semester_occupied',compact('schedules','offered_to','program_code','period'))->render();
        }
    }


    function print_semester_occupied($offered_to,$program_code,$period){

         $schedules = \App\curriculum::where('offered_to',$offered_to)->where('program_code',$program_code)
                  ->where('period',$period)
                    ->get();
// "/instructors/print_semester_occupied           
     $pdf = PDF::loadView('instructor.faculty_loading.print_semester_occupied',compact('schedules'));
        $pdf->setPaper('A4','portrait');
        return $pdf->stream("SemesterOccupied.pdf");
        }

      function print_self_course($instructor){
          $year=now()->year;
        $detail = \App\curriculum::join('teach','teach.course_code','curricula.course_code')->where('teach.instructor_id',$instructor)->where('teach.course_taken',$year)->where('curriculum_year',$year)->get();
     
        $pdf=PDF::loadView('instructor.faculty_loading.print_self_course',compact('instructor','detail'));
        $pdf->setPaper('A4','portrait');
        return $pdf->stream("FacultyLoading.pdf");
    }

    
    
}
