



<?php
$details = \App\curriculum::distinct()->where('program_code', $prog)->where('period', $level)->where('curriculum_year', now()->year)->get();
?> 

        <div>
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"> {{$prog}}  ({{now()->year-1}}-{{now()->year}})</h3>
                </div>
                <div class="box-body">
                    <div class='table-responsive'>
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <th class='col-sm-2'>C.Code</th>
                                <th class='col-sm-3'>C.Name </th>
                                <th class='col-sm-1'>C.Credit</th>
                                <th class='col-sm-1'>Sec</th>
                                <th class='col-sm-4'>Teacher</th>
                                <th class='col-sm-1'>C.H</th>                                
                                
                            </tr>

                            @foreach ($details as $data)
                            <tr>
                                <td><a onclick="editload('{{$data->course_code}}')" href="#" title="Click to Edit">{{$data->course_code}}</a></td>
                                <td>{{$data->course_name}}</td>
                                <td>{{$data->lec}}</td>
                                <td>{{$data->units}}</td>

                            <?php
                            $teas =\App\teach::join('instructors_infos','instructors_infos.instructor_id','teach.instructor_id')->where('course_code',$data->course_code)->where('course_taken',now()->year)->get();
                            $crds = \App\teach::where('course_code',$data->course_code)->where('course_taken',now()->year)->get();
                            ?>
                                <td>
                                @foreach ($teas as $tea)
                                <ul>
                                    <li>{{$tea->name}}</li>
                                </ul>
                                @endforeach  
                                </td>
                                
                                <td>
                                @foreach ($crds as $crd)
                                <ul>
                                    <li>{{$crd->course_credit}}</li> 
                                </ul>
                                @endforeach 
                                </td>                             
                                
                            </tr>
                            @endforeach

                            
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>


<div id="displayeditload"></div>
<script>
    function editload(course_code){
        var array = {};
        array['course_code'] = course_code;
        $.ajax({
            type: "GET",
            url: "/ajax/admin/faculty_loading/edit_load",
            data: array,
            success: function(data){
                $('#displayeditload').html(data).fadeIn();
                $('#editload').modal('toggle');
            },error: function(){
                toastr.error('Something Went Wrong!','Message!');
            }
        })
    }
</script>
