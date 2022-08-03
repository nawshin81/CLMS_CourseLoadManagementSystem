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
$program = \App\curriculum::distinct()->where('program_code', $program_code)->get(['program_name'])->first();
$levels = \App\curriculum::distinct()->where('program_code', $program_code)->where('curriculum_year', $curriculum_year)->orderBy('period', 'asc')->get(['level', 'period']);


?>
@extends($layout)
@section('messagemenu')
<li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"></span>
            </a>
</li>
<li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"></span>
            </a>
</li>
          
<li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger"></span>
            </a>
</li>
@endsection
@section('header')
<section class="content-header">
    <h1 style="margin-left:20px; "><i class="fa  fa-folder-open"></i>
        List of Curriculum
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"> Curriculum Management</a></li>
        <li class="active"><a>View Curriculum </a></li>
        <li class="active"><a>List of Curriculum</a></li>
    </ol>
</section>
@endsection
@section('main-content')
<section class="content">
    @if(Session::has('success'))
    <div class='col-sm-12'>
        <div class='callout callout-success'>
            {{Session::get('success')}}
        </div>
    </div>
    @endif
    
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"> {{$program_code}}  ({{$curriculum_year-1}}-{{$curriculum_year}})</h3>
                </div>
                <div class="box-body">
                    <?php $totalUnits = 0; ?>
                    <div class='table-responsive'>
                    @foreach ($levels as $level)
                    <table class="table table-condensed">
                        <thead>
                        <th>{{$level->period}}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th class='col-sm-2'>Course Code</th>
                                <th class='col-sm-6'>Course Description</th>
                                <th class='col-sm-1'>LEC</th>
                                <th class='col-sm-1'>SEC</th>
                                
                            </tr>
                            <?php
                            $curriculums = \App\curriculum::where('program_code', $program_code)->where('curriculum_year', $curriculum_year)->where('level', $level->level)->where('period', $level->period)->get();
                            ?>
                            <?php
                            $totalLec = 0;
                            $totalUnits = 0;
                            ?>
                            @foreach ($curriculums as $curriculum)
                            <tr>
                                <td>
                                    @if(Auth::user()->accesslevel == 0)
                                    <a onclick="editmodal('{{$curriculum->id}}')" href="#" title="Click to Edit">{{$curriculum->course_code}}</a>
                                    @else
                                    {{$curriculum->course_code}}
                                    @endif
                                </td>
                                <td>{{$curriculum->course_name}}</td>
                                <td>@if ($curriculum->lec==0) @else {{$curriculum->lec}} @endif <?php $totalLec = $curriculum->lec + $totalLec; ?></td>
                                <td>@if ($curriculum->units==0) @else {{$curriculum->units}} @endif <?php $totalUnits = $curriculum->units + $totalUnits; ?></td>
                                
                            </tr>
                            @endforeach
                            <tr align="center">
                                <th > </th>
                                <th >Total </th>
                                <th><?php echo $totalLec; ?></th>
                                <th></th>

                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="displayeditmodal"></div>
@endsection
@section('footer-script')
<script>
    function editmodal(curriculum_id){
        var array = {};
        array['curriculum_id'] = curriculum_id;
        $.ajax({
            type: "GET",
            url: "/ajax/curriculum_management/edit_modal",
            data: array,
            success: function(data){
                $('#displayeditmodal').html(data).fadeIn();
                $('#editModal').modal('toggle');
            },error: function(){
                toastr.error('Something Went Wrong!','Message!');
            }
        })
    }
</script>
@endsection