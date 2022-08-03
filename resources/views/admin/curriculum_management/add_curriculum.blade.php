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
$programs = \App\academic_programs::distinct()->get(array('program_code'));
$dept=\App\department::distinct()->get(['dept_code']);
?>
@extends($layout)

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('main-content') 
<link rel='stylesheet' href='{{asset('plugins/select2/select2.css')}}'>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $("button").click(function(){
            $('#dept').val($('#offered_to').val());
            $('#sem').val($('#per').val());
            $('#prog').val($('#program_code').val());
        });
    });
</script>


<section class="content-header">
    <h1><i class="fa fa-bullhorn"></i>  
        Add Curriculum
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"> Curriculum Management</a></li>
        <li class="active"><a>Add Curriculum</a></li>
    </ol>
</section>
<div class="">
    <div class="container-fluid" >
    <div class="box box-default">
        <div class="box-header">
            <h5 class="box-title"></h5>
        </div>
        <div class="box-body">
            <div class="row">
                <!-- program -->
                <div class="col-sm-4">
                    <div class="form-group" id="offering">
                        <label>Program</label>
                                <select class="form-control select2" id="program_code">
                                    <option>Please Select</option>
                                    @foreach($programs as $program)
                                    <option value="{{$program->program_code}}">{{$program->program_code}}</option>
                                    @endforeach
                                </select>
                    </div>
                </div>
                <!-- semester -->
                <div class="col-sm-4">
                    <div class="form-group" >
                        <label>Semester</label>
                                <select class="select2 form-control" id="per">
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
                <div class="col-sm-4">
                    <label></label>
                    <button type="button" class="btn btn-flat btn-primary btn-block"  data-toggle="modal" data-target="#myModal" >Add Course</button>
                </div>
        </div>
        

    </div>
</div>

 
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content modal-lg" >


<div class="content container-fluid">
    <div class="box box-default">
        <form action="{{url('admin/curriculum_management/upload/save_changes')}}" method="post">
        {{csrf_field()}}
        <div class="box-header"><i ></i>
            <h5 class='box-title'></h5>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dynamic_field">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th style="display: none;"> year</th>
                            <th style="display: none;">program</th>
                            <th style="display: none;">semester</th>
                            <th width="15%">Course Code</th>
                            <th width="30%">Course Name</th>
                            <th width="15%">Offered By</th>
                            <th width="10%">Credit</th>
                            <th width="10%">Sec</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="7%"><button class="add btn btn-flat btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                            <td style="display: none;" ><input name="program_code[]" id="prog"></td>
                            <td style="display: none;" ><input name="period[]" id="sem"></td>
                           
                            <td style="display: none;"><input type="text" class="form-control" name="curriculum_year[]" id="c_year1" value="{{ now()->year}}"> </td>
                            <td><input type="text" class="form-control" name="course_code[]" id="code1"></td>
                            <td><input type="text" class="form-control" name="course_name[]" id="name1"></td>
                            <td><select class="select2 form-control" id="department" name="offered_by[]">
                            <option value="">Select Department</option>
                            @foreach($dept as $depts)
                            <option value="{{$depts->dept_code}}">{{$depts->dept_code}}</option>
                            @endforeach
                            </select>
                             </td> 
                            <td><input type="text" class="form-control" name="lec[]" id="lec1"></td>
                           <!--  <td><input type="text" class="form-control" name="lab[]" id="lab1"></td> -->
                            <td><input type="text" class="form-control" name="units[]" id="units1"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button onclick="submit()" class="btn btn-flat btn-success"><i class="fa fa-check-circle"></i> Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>

<script>
   
</script>
@endsection

@section('footer-script')
<script src='{{asset('plugins/select2/select2.js')}}'></script>
<script>
</script>
<script>
   var no = 1;

    $('.add').on('click',function(e){
    if($("#c_year"+no).val()=="" || $("#code" + no).val()=="" || $("#name" + no).val()=="" || $("#lec" + no).val()=="" ||/* $("#lab" + no).val()=="" ||*/ $("#units" + no).val()==""){
        toastr.warning("Please Fill-up Required Fields ");
    }else{
        no++;
        $('#dynamic_field').append("<tr id='row"+no+"'>\n\
                <td><button class='btn btn-flat btn-danger remove' id='"+no+"'><i class='fa fa-close'></i></button></td>\n\
               <td style='display:none;'><input type='text' name='curriculum_year[]' class='form-control' id='c_year"+no+"' value='{{now()->year}}'></td>\n\
                <td style='display: none;'><input name='program_code[]' id='prog"+no+"'></td>\n\
                <td style='display: none;'><input name='period[]' id='sem"+no+"'></td>\n\
                <td><input type='text' class='form-control' name='course_code[]' id='code"+no+"'></td>\n\
                <td><input type='text' class='form-control' name='course_name[]' id='name"+no+"'></td>\n\
                <td> <select class='select2 form-control' id='department"+no+"' name='offered_by[]'><option value=''>Select Department</option>@foreach($dept as $depts)<option value='{{$depts->dept_code}}'>{{$depts->dept_code}}</option> @endforeach</select></td>\n\
                <td><input type='text' class='form-control' name='lec[]' id='lec"+no+"'></td>\n\
               \n\
                <td><input type='text' class='form-control' name='units[]' id='units"+no+"'></td>\n\
            </tr>");
        $('#sem'+no).val($('#per').val());
        $('#prog'+no).val($('#program_code').val());
    }
    e.preventDefault();
    return false;
})

$('#dynamic_field').on('click','.remove', function(e){
    var button_id = $(this).attr("id");
    $("#row"+button_id+"").remove();
    i--;
    e.preventDefault();
    return false;
}); 


</script>
@endsection

