<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class ReportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
    }
    
    function room_occupied(){
        $courses = \App\curriculum::all();
        return view('admin.reports.room_occupied',compact('courses'));
    }
    
// ->where('program_code',$program_code)
//                     ->where('period',$period)
    function print_room_occupied($offered_to,$program_code,$period){

         $schedules = \App\curriculum::where('offered_to',$offered_to)->where('program_code',$program_code)
                  ->where('period',$period)->where('curriculum_year',now()->year)
                    ->get();
//"/admin/reports/print_rooms_occupied            
     $pdf = PDF::loadView('admin.reports.print_room_occupied',compact('schedules','program_code','period'));
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($program_code.'Course View.pdf');
        }



    


    
        
        
    }

