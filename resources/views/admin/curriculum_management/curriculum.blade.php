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
$programs = \App\academic_programs::distinct()->orderBy('program_code')->get(array('program_code', 'program_name'));

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
    <h1 style="margin-left:20px; "><i class="fa fa-folder"></i>  
        View Curriculum
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"> Curriculum Management</a></li>
        <li class="active"><a>Add Curriculum</a></li>
    </ol>
</section>
@endsection
@section('main-content')
<link rel="stylesheet" href="{{ asset ('plugins/toastr/toastr.css')}}">
<link rel="stylesheet" href="{{ asset('plugins\bootstrap\dist\css\bootstrap.min.css')}}">
<script type="text/javascript" href="{{ asset('plugins\bootstrap\dist\js\bootstrap.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

@if(Session::has('success'))
<div class='col-sm-12'>
    <div class='callout callout-success'>
        {{Session::get('success')}}
    </div>
</div>
@endif


<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Academic Programs</h3>
                    
                </div>
                <div class="box-body">
                    <div class='table-responsive'>
                    <div class="panel-group" id="accordion">
                      @foreach ($programs as $program)
                      @php
                        
                            $curricula = \App\curriculum::distinct()->where('program_code', $program->program_code)->get(['curriculum_year']);
                         @endphp

                       
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$program->program_code}}">
                              {{$program->program_code}}( {{$program->program_name}} )
                            </a>
                          </h4>
                        </div>
                        
                        <div id="collapse{{$program->program_code}}" class="panel-collapse collapse">
                            <div class="panel-body">
                              
                            <table class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>Curriculum Year</th>
                                <th class="text-center" width="30%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($curricula as $curriculum)
                            <tr>
                                <td>{{($curriculum->curriculum_year)-1}} - {{$curriculum->curriculum_year}}</td>
                                <td class="text-center"><a href="{{url('/admin', array('curriculum_management','list_curriculum',$program->program_code,$curriculum->curriculum_year))}}" class="btn btn-flat btn-success"><i class="fa fa-eye"></i></a>
                                    <!-- <a onclick="displayedityear('{{$curriculum->curriculum_year}}','{{$program->program_code}}')" class="btn btn-flat btn-primary"><i class="fa fa-pencil"></i></a> --></td>
                                </tr>
                              @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>



@endsection
@section('footer-script')

@if(Session::has('success'))
<script type="text/javascript">
    toastr.success(' <?php echo Session::get('success'); ?>', 'Message!');
</script>
@endif

<script>
</script>
