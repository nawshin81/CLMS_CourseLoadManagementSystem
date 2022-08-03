
<table class="table" >
                <tr>
                    <th class='col-sm-5' align="center">Assigned Teacher</th>
                    <th align="center">Credit</th>
                </tr>
                @foreach($teacher as $teach)
                <?php
                $teachers= \App\instructors_infos::distinct()->where('instructor_id',$teach)->get();
                ?>
                <tr>
                	<td>
                		<div >{{$teachers->name}}</div>
                	</td>
                </tr>
                @endforeach
</table>