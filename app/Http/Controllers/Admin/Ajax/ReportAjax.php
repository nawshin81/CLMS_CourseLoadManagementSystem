<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class ReportAjax extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    function get_room_occupied(){
        if(Request::ajax()){
            $offered_to = Input::get('offered_to');
            $program_code = Input::get('program_code');
            $period = Input::get('period');
            
            $schedules = \App\curriculum::where('offered_to',$offered_to)->where('program_code',$program_code)
                  ->where('period',$period)->where('curriculum_year',now()->year)
                    ->get();
            
            //"/ajax/admin/reports/get_rooms_occupied"
            return view('admin.reports.ajax.get_room_occupied',compact('schedules','offered_to','program_code','period'))->render();
        }
    }

    
}
