<?php 
$collection = collect([]);

if(!$courses->isEmpty()){
    foreach($courses as $course){
            $collection->push((object)[
               'course_code' => $course->course_code,
               'course_name' => $course->course_name,
               'dept'=>$course->offered_by,
               'program'=>$course->program_code
            ]);
       
    }
}

$color_array = ['info','danger','warning','success'];
$ctr = 0;
?>

<div class='box box-default box-solid'>
    <div class='box-header bg-navy-active'><h5 class='box-title'>Courses to Load</h5></div>
    <div class='box-body' id="searchcourse">
        <div  >
            <div class="draggable" data-duration="03:00">
                <table class="table table-bordered table-condensed">
                <tr>
                   
                    <th width="30%">Course</th>
                </tr>
                @foreach($collection as $data)
                <tr>
                    <td>
                        <button class="btn btn-flat btn-primary btn-block" onclick="displaysch('{{$data->course_code}}','{{$data->dept}}','{{$data->program}}')">
                            <div align="center">{{$data->course_code}}<br>({{$data->course_name}})
                        </div>
                        </button>
                            
                    </td>
                </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('plugins/jQueryUI/jquery-ui.js')}}"></script>


<script type="text/javascript">





    function displaysch(course_code,dept,program){
    var array = {};
    array['course_code'] = course_code;
    array['dept'] = dept;
    array['program']=program;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/faculty_loading/course_mngt",
        data: array,
        success: function(data){
            $('#displaysch').html(data).fadeIn();
            
            
        }
    })
}
</script>
