@if(count($schedules)>0)
<div class="box box-default">
    <div class="box-header">
        <h5 class="box-title">Search Results</h5>
        <div class="box-tools pull-right">
         <a href="/admin/reports/print_rooms_occupied/{{$offered_to}}/{{$program_code}}/{{$period}}" class="btn btn-flat btn-primary"><i class="fa fa-print"></i> Generate PDF</a>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>C.Id</th>
                        <th>C.Title</th>
                        <th>C.H</th>
                        <th>Sec</th>
                        <th>Off.By</th>
                        <th>Pre.Teacher</th>
                        <th>Cur.Teacher</th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                            $totalLec = 0;
                            $totalUnits = 0;
                  



                    ?>
                    @foreach($schedules as $schedule)
                    <tr>
                        <td>{{$schedule->course_code}}</td>
                        <td>{{$schedule->course_name}}</td>
                        <td>@if ($schedule->lec==0) @else {{$schedule->lec}} @endif <?php $totalLec = $schedule->lec + $totalLec; ?></td>
                        <td>@if ($schedule->units==0) @else {{$schedule->units}} @endif <?php $totalUnits = $schedule->units + $totalUnits; ?></td>
                        <td>{{$schedule->offered_by}}</td>
                        
                        <?php
                        $prvt = \App\teach::join('instructors_infos','instructors_infos.instructor_id','teach.instructor_id')->where('course_code',$schedule->course_code)->where('course_taken',(now()->year-1))->get(array('name'));
                        ?>
                        <td>
                            @foreach($prvt as $prv)
                            <ul>
                                <li>{{$prv->name}}</li>
                            </ul>
                             @endforeach
                        </td>

                        <?php
                        $curt = \App\teach::join('instructors_infos','instructors_infos.instructor_id','teach.instructor_id')->where('course_code',$schedule->course_code)->where('course_taken',now()->year)->get(array('name','course_credit'));
                        ?>
                        <td>
                            @foreach($curt as $cur)
                            <ul>
                                <li>{{$cur->name}}({{$cur->course_credit}})</li>
                            </ul>
                             @endforeach
                        </td> 
                        </tr>
                   @endforeach
                    <tr align="center">

                                <th > </th>
                                <th >Total </th>
                                <th><?php echo $totalLec; ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>


                            </tr>

                </tbody>

            </table>
        </div>
    </div>
</div>
@else
<div class="box box-danger">
    <div class="box-header"><h5 class="box-title">Search Results</h5></div>
    <div class="box-body">
        <div align="callout callout-warning">
            <div align="center">
                <h5>No Results Found!</h5>
            </div>
        </div>
    </div>
</div>
@endif

