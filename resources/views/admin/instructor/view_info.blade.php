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
<?php $programs= \App\academic_programs::distinct()->get(['program_name','program_code'])?>

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
@section('main-content')
<link rel="stylesheet" href="{{asset('plugins/select2/select2.css')}}">
<section class="content-header">
      <h1><i class="fa fa-bullhorn"></i>  
        Update Instructor
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Update Instructor</li>
      </ol>
</section>
<section class="content">
    <div class="row">
        <form class="form-horizontal" method='post' action='{{route('admin.updateinstructor',['id'=>$user->id])}}'>
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title"><b>Personal Information</b></h3>
                    </div>
                    @if (count($errors) > 0)
                    @foreach($errors->all() as $error)
                    <script type="text/javascript">
                        toastr.error(' <?php echo $error ?>', 'Message!');
                    </script>
                    @endforeach
                    @endif
                    
    

                    
                    
                    <div class="box-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label><b>ID Number</b></label>
                                <input class="form form-control" value="{{$user->username}}" name="username" placeholder="ID Number*" value="{{old('instructor_id')}}" type="text">
                            </div>
                            <div class="col-sm-5">
                                <label><b>Email</b></label>
                                <input class="form form-control" name='email' value="{{$user->email}}" placeholder='Email Address' value="" type="email">
                            </div>
                             <div class="col-sm-4">
                                <label><b>Contact Number</b></label>
                                <input class="form form-control" value="{{$info->tel_no}}" name='tel_no' placeholder='Telephone Number' value="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label><b>Name</b></label>
                                <input class="form form-control" value="{{$user->name}}" name='name' placeholder='First Name*' value="{{old('name')}}" type="text">
                            </div>
                            
                        </div>

                    </div>
                </div>
   
            <div class="col-md-14">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>Academic Information</b></h3>
                    </div>
                    <div class="box-body">
                      
                        <div class="col-sm-4">
                            <label><b>Department</b></label>
                            <select name="department" class="select2 form form-control">
                               <option value="">Select Department</option>
                                @foreach($programs as $program)
                                <option @if($info->department == $program->program_code) selected="selected" 
                                @endif 
                                value="{{$program->program_code}}">
                                {{$program->program_code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label><b>Employee Status</b></label>
                            <select name="employee_type" class="select2 form form-control">
                                <option value="">Select Employee Type</option>
                                <option 
                                @if($info->employee_type == 'Full Time') selected='selected' @endif value="Full Time">Full Time</option>
                                <option @if($info->employee_type == 'Part Time') selected='selected' @endif value="Part Time">Part Time</option>
                            </select>
                        </div>
                                             <div class="col-sm-4">
                        <label><b>Designation</b></label>
                        <select name="designation_type" class="select2 form form-control">
                            <option value="">Select Designation</option>
                            <option 
                             @if($info->designation_type == 'Professor') selected='selected' @endif 
                            value="Professor">Professor</option>
                            <option 
                            @if($info->designation_type == 'Assistant Professor') selected='selected' @endif
                            value="Assistant Professor">Assistant Professor</option>
                            <option
                            @if($info->designation_type == 'Associate Professor') selected='selected' @endif
                             value="Associate Professor">Associate Professor</option>
                            <option 
                            @if($info->designation_type == 'Lecturer') selected='selected' @endif
                             value="Lecturer">Lecturer</option>
                        </select>
                    </div>
                    </div>
                            
                </div>
            </div>
            
            <div class='form form-group'>
                <div class='col-sm-12'>
                    <input type='submit' class='col-sm-12 btn btn-primary' value='Update'>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
@section('footerscript')
<script src='{{asset('plugins/select2/select2.js')}}'></script>
@endsection

    