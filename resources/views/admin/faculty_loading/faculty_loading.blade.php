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
$dept=\App\academic_programs::distinct()->get(['program_code']);
?>


@extends($layout)

@section('main-content')
<link rel='stylesheet' href='{{asset('plugins/select2/select2.css')}}'>

<section class="content-header">
      <h1><i class="fa fa-calendar "></i>
        Add Faculty Loading
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Add Faculty Loading</li>
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
                    <button class='btn btn-flat btn-primary btn-block' onclick='displaycourses(program.value,level.value)'>Start Loading</button>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-4' id='displaycourses'></div>
        <div class='col-sm-8'  id='displaysch'></div>
        <!-- <div class='col-sm-4'  id='displayteacher'></div> -->
    </div>
</div>

<div id="displaygetunitsloaded"></div>
@endsection

@section('footer-script')
<script src="{{asset('plugins/select2/select2.js')}}"></script>

<script>

$(document).ready(function(){
    $('#displaysemester').hide();
    $('#displaysearch').hide();
    
    $('#displaydept').on('change',function(){
        $('#displaysemester').fadeIn();
    })
    
        $('#displaysemester').on('change',function(){
        $('#displaysearch').fadeIn();
    })
})

function displaycourses(program,level){
    var array = {};
    array['level'] = level;
    array['program'] = program;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/faculty_loading/courses_to_load",
        data: array,
        success: function(data){
            $('#displaycourses').html(data).fadeIn();
            // displayteacher(program);
        }
    })
}

/*function displayteacher(program){
    var array = {};
    array['program'] = program;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/faculty_loading/teacher_to_course",
        data: array,
        success: function(data){
            $('#displayteacher').html(data).fadeIn();

            
        }
    })
}
*/

</script>
@endsection