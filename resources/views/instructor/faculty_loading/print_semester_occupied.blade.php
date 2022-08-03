<?php

?>

<html>
    <head>
        <style>
        .a{
            text-align: center;
            text-transform: uppercase;
            font-size: 20px;
        }
        .b{
            text-align: center;
            text-transform: uppercase;
            font-size: 18px;
        }
        .c{
            text-align: center;
            font-size: 15px;
        }
        </style>
    </head>
    <body>
        <div class="a">
            <b>Islamic University Of Technology</b>
             </div>
        <div class="b">
        
            
            </div>
        <div class="c">
        
        Report as of {{date('Y-m-d')}}
        </div>
        <table border="1" style="margin-top:20px;" width="100%" cellspacing="0" cellpadding="2px">
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
                        $curt = \App\teach::join('instructors_infos','instructors_infos.instructor_id','teach.instructor_id')->where('course_code',$schedule->course_code)->where('course_taken',now()->year)->get(array('name'));
                        ?>
                        <td>
                            @foreach($curt as $cur)
                            <ul>
                                <li>{{$cur->name}}</li>
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
    </body>
</html>