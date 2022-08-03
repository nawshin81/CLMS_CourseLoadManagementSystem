<?php 
$layout = "";

if(Auth::user()->is_first_login == 1){
    $layout = 'layouts.first_login';
}else{
    if(Auth::user()->accesslevel == 100){
        $layout = 'layouts.superadmin';
    }elseif(Auth::user()->accesslevel == 1){
        $layout = 'layouts.instructor';
    }elseif(Auth::user()->accesslevel == 0){
        $layout = 'layouts.admin';
    }
}
?>

<?php
use App\Http\Controllers\Helper; 
$dept=\App\academic_programs::distinct()->get(['program_code']);
?>


@extends($layout)

@section('main-content')
<link rel='stylesheet' href='{{asset('plugins/select2/select2.css')}}'>

    @if(Session::has('success'))
    <div class='col-sm-12'>
        <div class='callout callout-success'>
            {{Session::get('success')}}
        </div>
    </div>
    @endif

<section class="content-header">
      <h1><i class="fa fa-edit "></i>
        View Faculty Loading
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Edit Faculty Loading</li>
      </ol>
</section>




<div class="container-fluid" style="margin-top: 15px;">
    <div class="box box-default">
        <div class="box-header">
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group" id="displaydept">
                        <label>Program</label>
                        <select class="select2 form-control" id="program">
                            <option value="">Select Program</option>
                            @foreach($dept as $depts)
                            <option value="{{$depts->program_code}}">{{$depts->program_code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <div class="form-group" id="displaysemester">
                        <label>Semester</label>
                        <select class="select2 form-control" id="level">
                            <option>Please Select</option>
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                            <option value="3rd Semester">3rd Semester</option>
                            <option value="4th Semester">4th Semester</option>
                            <option value="5th Semester">5th Semester</option>
                            <option value="6th Semester">6th Semester</option>
                            <option value="7th Semester">7th Semester</option>
                            <option value="8th Semester">8th Semester</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-4" id="displaysearch">
                    <label></label>
                    <button class='btn btn-flat btn-primary btn-block' onclick='showcourses(program.value,level.value)'>Show Courses</button>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12' id='showthecourses'></div>       
    </div>
</div>

<div id="displaygetunitsloaded"></div>
@endsection


@section('footer-script')
<script src="{{asset('plugins/select2/select2.js')}}"></script>

<script>

function showcourses(program,level){
    var array = {};
    array['level'] = level;
    array['program'] = program;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/faculty_loading/courses_lists",
        data: array,
        success: function(data){
            $('#showthecourses').html(data).fadeIn();
            // displayteacher(program);
        }
    })
}



</script>
@endsection