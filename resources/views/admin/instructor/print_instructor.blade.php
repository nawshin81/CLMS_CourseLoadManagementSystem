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
                    <th>Program</th>
                        <th>C.Code</th>
                        <th>C.Title</th>
                        <th>C.H</th>
                        <th>Sec</th>
               </tr>
            </thead>
            <tbody>
                     <?php
                            $totalCrd = 0;
                            ?>
                    
                        @foreach($detail as $details)
                        <tr> 
                        <td>{{$details->program_code}}</td>
                        <td>{{$details->course_code}}</td>
                        <td>{{$details->course_name}}</td>
                        <td>@if($details->course_credit==0) @else {{$details->course_credit}} @endif <?php $totalCrd= $details->course_credit + $totalCrd; ?>
                        </td>
                        <td>{{$details->units}}</td>
                    </tr>
                   @endforeach
                   <tr>
                                <th></th>
                                <th > </th>
                                <th >Total </th>
                                <th><?php echo $totalCrd; ?></th>
                                <th></th>


                            </tr>
                </tbody>
          
        </table>
    </body>
</html>