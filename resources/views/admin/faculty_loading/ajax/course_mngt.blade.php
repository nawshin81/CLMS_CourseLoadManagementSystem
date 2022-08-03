<?php 


$courses = \App\curriculum::distinct()->where('curriculum_year',now()->year)->where('course_code',$code)->where('program_code',$prog)->get();
$color_array = ['info','danger','warning','success'];
$ctr = 0;
?>

<style type="text/css">
    
</style>

<link rel="stylesheet" type="text/css" hre ="{{asset('plugins/bootstrap/dist/css/bootstrap.css')}}">

<div class='row'>
<div class='col-sm-7'>
<div class='box box-default box-solid'>
    <div class='box-header bg-navy-active'><h5 class='box-title'>Course Assignment</h5></div>

    <div class='box-body' id="search">
        <div class='col-sm-12' >
                <table class="table table-bordered table-condensed" >

                <tr>
                    <th class='col-sm-5' align="center">Course Name :</th>
                    <input style="display: none;" id="course_code" value="{{$code}}">
                    <th align="center" id="courseCode">{{$code}}</th>
                </tr>
                <tr>
                @foreach($courses as $data)
                    <td>Course Credit :</td>
                    <input id="lec" value="{{$data->lec}}" style="display: none;">
                    <td>{{$data->lec}}</td>
                </tr>
                <tr>
                    <td>Section :</td>
                    <td>{{$data->units}}</td>
                </tr>

                @endforeach
                <?php 
                $ass = \App\teach::join('instructors_infos','instructors_infos.instructor_id','teach.instructor_id')->where('course_taken',now()->year-1)->where('course_code',$code)->get(['name']);
                ?>
                <tr>
                    <td>Previous Teacher :</td>
                    <td>
                         <ul>
                         @foreach($ass as $val)
                    <li>
                        {{$val->name}}
                    </li>
                    @endforeach

                    </ul>
                    </td>
                   
                   
                </tr>
                </table>
  
        </div>

        <div id='displayassign' class='col-sm-12'></div>
        
    </div>
</div>

</div>

<div class='col-sm-5'>
<div class='box box-default box-solid'>
    <div class='box-header bg-navy-active'><h5 class='box-title'>All Teachers</h5></div>

        <div>
        
                <table id="table" class="table table-bordered table-condensed" >
                <tr>
                    <th width="3%"></th>
                    <th width="30%" align="center">Name</th>
                    <th width="2%"></th>
                </tr>

           <?php
                $teacher = \App\instructors_infos::distinct()->where('department',$dept)->get();  
                ?>
                @foreach($teacher as $data)
                <?php
                $sum_t_crd=0;
                $tot_crd = \App\teach::distinct()->where('instructor_id',$data->instructor_id)->where('course_taken',now()->year)->get(array('course_credit'));
                 ?>
                @foreach ($tot_crd as $t_crd) 
                   <?php 
                   $sum_t_crd=$t_crd->course_credit+$sum_t_crd;
                   ?>
                @endforeach
                <?php
                $gap=$data->credit-$sum_t_crd;
/*                echo $gap;*/
                 $teacherObject= json_encode(array("name"=>$data->name, "id"=>$data->instructor_id ,"gap"=>$gap));
                 
                 ?>
                <tr>
                    <td><input type="checkbox" name="checkteacher[]" value="{{$teacherObject}}"></td>
                    <td>
                        <div align="left">
                         {{$data->name}}
                         <div style="display: none;">
                             {{$data->instructor_id}}
                         </div>
                        </div>  
                    </td>
                    <td >
                        <div  align="right"><button class="btn btn-flat btn-success fa fa-eye" onclick="showteacher('{{$data->instructor_id}}')"></button></div>  
                    </td>
                </tr>
              @endforeach
                </table>
              <button class="btn btn-flat btn-primary btn-block" id="save">Load Credit</button>

        </div>
</div> 

</div>
</div>
<div id="displayeditmodal"></div>



<script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    $('#save').click(function() {
        var id = [];
        $(':checkbox:checked').each(function(i){
            id[i] = $(this).val();
        });
        if(id.length === 1) 
        {
            alert("Please Select atleast one checkbox");
        }
        else{
            var teacher=[];
            for (var i =0; i< (id.length)-1; i++) {
                teacher[i]=id[i];
                console.log(teacher[i]);
            }
            displayassign(teacher);
        }
    });

    function exportClicked(numTeachers) {
        // console.log(teacherJsonStr);
        // var teacherArray = JSON.parse(teacherJsonStr);
        console.log("export clicked");
        var courseCode = "{{$code}}"; //$code; --> TODO retrieve real value of the selected course-code
        console.log("Course code: " + courseCode);

        var teachers = [];
        var sum=0;
        var br=0;
        var name;
        for(var i=0; i<numTeachers; i++) {
            var tj = $('#teacher'+i).val();
            //console.log(tj);
            teachers[i] = JSON.parse(tj);
            teachers[i]['credit'] = $('#cred'+i).val();

            //console.log(teachers[i]['credit']);
            cre=parseInt(teachers[i]['credit'], 10);
            
            gap=parseInt($('#gap'+i).val(), 10);
            console.log(gap);
            if(cre>gap)
            {
                name=teachers[i]['name'];
                br=1;
            }
            sum+=cre;
        }
        console.log(teachers);
        console.log(CSRF_TOKEN);
        console.log(sum);
        console.log($('#lec').val());

        // Optional TODO : Check eligibility of the teacher
        if (sum>$('#lec').val())
        {
            toastr.warning('Credit Limit Exceeded');
        }
        else if(sum<$('#lec').val())
        {
            toastr.warning('Credit Limit Not Fulfilled');
        }
        else if(br==1)
        {
            toastr.warning(name+' Course Overloaded');
        }
        else{
            $.ajax({
            url: '/admin/faculty_loading/assignTeachers', // /admin/faculty_loading/assignTeachers
            type: 'POST',
            data: {_token: CSRF_TOKEN, course_code: courseCode, teachers: teachers},
            success: function(response) {
                toastr.success('assignTeachers : successful response got');
                //console.log("");
                console.log(response);
                // TODO Reflect success in the UI
            },
            error: function(response) {
                toastr.error("assignTeachers : error response got");
                console.log(response);
                // TODO Alert the user about the error
            }
        });
        }
        
    }

    function displayassign(teacher_name){
        var teach_cre = [];
        var text = "<div id='table' class='table-editable '>\n\
            <table class='table  table-bordered table-condensed'>\n\
                <tr>\n\
                    <th class='col-sm-5' align='center'>Assigned Teacher</th>\n\
                    <th align='center'>Credit</th>\n\
                </tr>";
        var text2="";
        /*teacher_name.forEach(function(entry) {
            console.log("teacher_name : " + entry);
        });*/
        var numTeachers = teacher_name.length;
        var i;
        for (i = 0 ; i < numTeachers; i++) {
            var teacherObj = JSON.parse(teacher_name[i]);
            var name = teacherObj['name'];
            var gap=teacherObj['gap'];
            console.log(name);
            text2+="<tr>\n\
                <td align='left'>"+name+"</td>\n\
                <td><input id='cred"+i+"'></td>\n\
                <td style=\"display:none;\"><input id='teacher"+i+"' value='"+(teacher_name[i])+"'></td>\n\
                <td style=\"display:none;\"><input id='gap"+i+"' value='"+gap+"'></td>\n\
            </tr>";
            var credit = $('#cred'+i).val();
            if(credit==null || typeof credit==='undefined')
                credit = 0;
            var jsonStr = '{"credit":'+credit+', "name":"'+name+'", "id":'+teacherObj['id']+'}';
            console.log("teach_credit["+i+"] : " + jsonStr);
            teach_cre[i]=JSON.parse(jsonStr);
        };
        /*teach_cre.forEach(function(entry) {
            console.log("teach_cre : " + entry);
        });*/
        /*var teacherJsonStr = JSON.stringify(teach_cre);
        console.log(teacherJsonStr);*/
        var text3="</table>\n\
            <button id='export' class='btn btn-primary' onclick='exportClicked("+numTeachers+")'>Export Data</button></div></div>";//onclick='exporting("+teacher_name+","+teach_cre+",{{$code}})'

        document.getElementById('displayassign').innerHTML = text+text2+text3;
    }

    function exporting(teacher_name,teach_cre,course_code){
        var array={};
        array['course_code']=course_code;
        array['name']=teacher_name;
        array['credit']=teach_cre;
        $.ajax({
            type: "GET",
            url: "/ajax/admin/faculty_loading/course_assign",
            data: array,
            success: function(data){
                $('#displayassign').html(data);
            }
        })

    }


    function showteacher(instructor_id){
        var array={};
        array['id']=instructor_id;
        $.ajax({
            type:"GET",
            url:"/ajax/admin/faculty_loading/edit_modal",
            data:array,
           success: function(data){
                $('#displayeditmodal').html(data).fadeIn();
                $('#editModal').modal('toggle');
            },error: function(){
                toastr.error('Something Went Wrong!','Message!');
            }
        })
    }

</script>