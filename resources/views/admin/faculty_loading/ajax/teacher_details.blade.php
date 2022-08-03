<div class="modal fade" id="editModal">
	<div class="modal-dialog">
      <div class="modal-content">
      	<div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          @foreach($tname as $data)
          <h4 class="modal-title">{{$data->name}}</h4>
          @endforeach
          <div class="row">
           <div class="col-sm-7">
           	<table id="table" class="table table-bordered table-condensed">
           		<tr>
           			<th>Course Code</th>
           			<th>Credit</th>
           		</tr>
           		@foreach($teacher_course as $tea)
           		<tr>
           			<td>{{$tea->course_code}}</td>
           			<td>{{$tea->course_credit}}</td>
           		</tr>
           		@endforeach
           	</table>
           </div>


<?php $sum=0; ?>
@foreach($teacher_course as $tc)
<?php $sum= $sum+$tc->course_credit; ?>
@endforeach
<?php  
$diffr= $data->credit-$sum;
?>

           <div class="col-sm-5">
           	<table id="table" class="table table-bordered table-condensed">
           		<tr>
           			<th>Total Credit :</th>
           			<td>{{$sum}}</td>
           		</tr>
           		<tr>
           			<th>Rest Credit :</th>
           			<td>{{$diffr}}</td>
           		</tr>
           	</table>
           </div>
           </div>
       	</div>
      </div>
  </div>
</div>