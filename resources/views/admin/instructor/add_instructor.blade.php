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
$dept=\App\department::distinct()->get(['dept_code']);
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
<section class="content-header" style="padding-left: 30px">
      <h1><i class="fa  fa-user-plus"></i>  
        Add New Instructor
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Add new instructor</li>
      </ol>
</section>
@if(Session::has('success'))
<div class='col-sm-12'>
    <div class='callout callout-success'>
        {{Session::get('success')}}
    </div>
</div>
@endif

<section class="content">
    <div class="row">
        <form class="form-horizontal" method='post' action='{{url('/admin', array('instructor', 'add_new_instructor'))}}'>
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
                            <input class="form form-control" name="username" placeholder="ID Number*" value="{{old('instructor_id')}}" type="text">
                        </div>
                        <div class="col-sm-6">
                            <label><b>Email</b></label>
                            <input class="form form-control" name='email' placeholder='Email Address' value="" type="email">
                        </div>
                        <div class="col-sm-3">
                            <label><b>Contact Number</b></label>
                            <input class="form form-control" name='tel_no' placeholder='Telephone Number' value="" type="text">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-5">
                            <label><b>Name</b></label>
                            <input class="form form-control" name='name' placeholder='Full Name*' value="{{old('name')}}" type="text">
                        </div>
                        
                    </div>
                </div>
               
            </div>    
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><b>Academic Information</b></h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-4">
                        <label><b>Department</b></label>
                        <select name="department" class="select2 form form-control">
                           <option value="">Select Department</option>
                            @foreach($dept as $depts)
                            <option value="{{$depts->dept_code}}">{{$depts->dept_code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label><b>Employee Status</b></label>
                        <select name="employee_type" class="select2 form form-control">
                            <option value="">Select Employee Type</option>
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                        </select>
                    </div>
                     <div class="col-sm-4">
                        <label><b>Designation</b></label>
                        <select name="designation_type" class="select2 form form-control">
                            <option value="">Select Designation</option>
                            <option value="Professor">Professor</option>
                            <option value="Assistant Professor">Assistant Professor</option>
                            <option value="Associate Professor">Associate Professor</option>
                            <option value="Lecturer">Lecturer</option>
                        </select>
                    </div>
                </div>
            </div>
                    
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><b>Account Information</b></h3>
                </div>
                <div class="box-body">
                    <div class="form form-group">
                        <div class="col-sm-6">
                            <label><b>Password</b></label>
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>
                        <div class="col-sm-6">
                            <label><b>Confirm Password</b></label>
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
                        </div>
                    </div>
                </div>
            </div>

            <div class='form form-group'>
                <div class='col-sm-12'>
                    <input type='submit' class='col-sm-12 btn btn-primary' value='SAVE'>
                </div>
            </div>
        </form>       
    </div>
</section>
@endsection
@section('footerscript')
@endsection

    