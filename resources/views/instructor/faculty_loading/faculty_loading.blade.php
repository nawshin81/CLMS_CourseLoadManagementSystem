@extends('layouts.instructor')


@section('main-content')
<link rel="stylesheet" href="{{ asset ('plugins/toastr/toastr.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/fullcalendar/fullcalendar.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/datatables/jquery.dataTables.css')}}">
<section class="content-header" style="padding-bottom: 20px">
    <h1><i class="fa fa-bullhorn"></i>
        Faculty Loading Assignment
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Faculty Loading Assignment</li>
    </ol>
</section>

<?php
$ins_name = \App\user::where('id',$instructor)->first();
?>

<div class="box box-default">
    <div class="box-header">
        <h5 class="box-title">{{strtoupper($ins_name->name)}}</h5>
        <div class="box-tools pull-right"><a href="/instructor/faculty_loading/print_self_course/{{$instructor}}" class="btn btn-flat btn-primary"><i class="fa fa-print"></i> Generate PDF</a></div> 
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        
                        <th width="15%">Program</th>
                        <th width="15%">C.Code</th>
                        <th width="30%">C.Title</th>
                        <th width="10%">C.H</th>
                        <th width="10%">Sec</th>
                    </tr>
                </thead>
                 <tbody>
                     <?php
                            $totalCrd = 0;
                            ?>
                    <tr>
                        @foreach($detail as $details) 
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
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script type="text/javascript" src="{{ asset('/plugins/moment/moment.js') }}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.js')}}"></script>
<script src="{{asset('plugins/jQueryUI/jquery-ui.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.js')}}"></script>
@endsection