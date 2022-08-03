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
<?php use Carbon\Carbon; 

?>

<?php
$progs = \App\curriculum::distinct()->orderBy('program_code')->get(array('program_code'));
$depts = \App\curriculum::distinct()->orderBy('offered_to')->get(array('offered_to'));
$sems = \App\curriculum::distinct()->orderBy('period')->get(array('period'));
?>

@extends($layout)

@section('main-content')
<link rel="stylesheet" href="{{ asset ('plugins/datatables/dataTables.bootstrap.css')}}">
<section class="content-header">
      <h1><i class="fa fa-archive"></i>  
        Reports
        <small>Course Occupied</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Course Occupied</li>
      </ol>
</section>

<div class="container-fluid" style="margin-top: 15px;">
    <div class="box box-default">
        <div class="box-header"><h5 class="box-title">Search Filters</h5></div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Department</label>
                        <select class="form-control select2" id="offered_to">
                            <option>Please Select</option>
                            @foreach($depts as $dept)
                            <option value="{{$dept->offered_to}}">{{$dept->offered_to}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Program</label>
                        <select class="form-control select2" id="program_code">
                            <option>Please Select</option>
                            @foreach($progs as $prog)
                            <option value="{{$prog->program_code}}">{{$prog->program_code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Semester</label>
                        <select class="form-control select2" id="period">
                            <option>Please Select</option>
                            @foreach($sems as $sem)
                            <option value="{{$sem->period}}">{{$sem->period}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>&nbsp</label>
                        <button onclick="searchdata(offered_to.value, program_code.value, period.value)" class="btn-block btn btn-flat btn-primary"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="displaydata"></div>
</div>

@endsection

@section('footer-script')
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.js')}}"></script>
<script>
function searchdata(offered_to,program_code,period){
    var array = {};
    array['offered_to'] = offered_to;
    array['program_code'] = program_code;
    array['period'] = period;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/reports/get_rooms_occupied",
        data: array,
        success: function(data){
            $('#displaydata').html(data).fadeIn();
        }, error: function(){
            toastr.error('No Result Found!','Notification!');
        }
    })
}
</script>
@endsection
