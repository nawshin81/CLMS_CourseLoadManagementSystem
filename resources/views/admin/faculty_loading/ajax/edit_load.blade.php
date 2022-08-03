@if(Session::has('success'))
<div class='col-sm-12'>
    <div class='callout callout-success'>
        {{Session::get('success')}}
    </div>
</div>
@endif



<div class="modal fade" id="editload">
  
    <div class="modal-dialog">
      <div class="modal-content">
          <form action="{{url('/ajax/admin/faculty_loading/update_load')}}" method="post">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            @foreach($details as $detail)
          <h4 class="modal-title">{{$course}} - {{$detail->course_name}}</h4>
        </div>
        <div class="modal-body">
            {{csrf_field()}}
                <div class="row">
                <div class="col-sm-4">
                    <label>Course Code : </label>
                    {{$detail->course_code}}
                </div>
                <div class="col-sm-8">
                    <label>Course Name : </label>
                    {{$detail->course_name}}
                </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Lec : </label>
                            {{$detail->lec}}
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Sec : </label>
                            {{$detail->units}}
                        </div>
                    </div>
                </div>

                <?php
                $teas =\App\teach::join('instructors_infos','instructors_infos.instructor_id','teach.instructor_id')->where('course_code',$course)->where('course_taken',now()->year)->get();
                
                ?>

                @foreach($teas as $tea)

                <?php
                $teach_ids=\App\teach::where('course_code',$course)->where('course_taken',now()->year)->where('instructor_id',$tea->instructor_id)->get();
                ?>
                @foreach($teach_ids as $teach_id)
                <input name="rowid[]" style="display: none;" value="{{$teach_id->id}}">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Teacher : </label>
                             <input type="text"  class="form-control" value="{{$tea->name}}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>C.H : </label>
                             <input type="text" name="credit[]" class="form-control" value="{{$tea->course_credit}}">
                        </div>
                    </div>
                </div>
                @endforeach
                @endforeach
               
        </div>
        @endforeach
        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-flat btn-primary">Save changes</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>