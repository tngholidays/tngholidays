<div class="panel">
    <div class="panel-title"><strong>Guest Details</strong></div>
    <div class="panel-body">
			<div class="form-group-item">
		    <div class="g-items-header">
		        <div class="row">
		            <div class="col-md-1">S.N.</div>
		            <div class="col-md-4">First Name</div>
		            <div class="col-md-2">Surname</div>
		            <div class="col-md-2">DOB<br>(dd/mm/yyyy)</div>
		            <div class="col-md-3">Passport No.</div>
		        </div>
		    </div>
		    <div class="g-items">
		    	<?php $rowGuests = $row->guests; ?>
		    @for ($i = 0; $i < $booking->total_guests; $i++)
		        <div class="item">
		            <div class="row">
		            	<div class="col-md-1">{{$i+1}}</div>
		                <div class="col-md-4">
		                	<div class="NameDiv">
		                	<select class="form-control" name="guests[{{$i}}][name_prefix]" id="sel1">
							    <option value="Mr." {{($row->guests && $rowGuests[$i]['name_prefix'] == "Mr.") ? "selected" : ''}}>Mr.</option>
							    <option value="Mrs."{{($row->guests && $rowGuests[$i]['name_prefix'] == "Mrs.") ? "selected" : ''}}>Mrs.</option>
							    <option value="Ms."{{($row->guests && $rowGuests[$i]['name_prefix'] == "Ms.") ? "selected" : ''}}>Ms.</option>
							    <option value="Miss."{{($row->guests && $rowGuests[$i]['name_prefix'] == "Miss.") ? "selected" : ''}}>Miss.</option>
							 </select>
					        <input type="text" name="guests[{{$i}}][first_name]" class="form-control" value="{{$row->guests ? $rowGuests[$i]['first_name'] : ''}}" placeholder="First Name" required />
		                </div>
		                </div>
		                <div class="col-md-2">
		                	<input type="text" name="guests[{{$i}}][surname]" class="form-control" value="{{$row->guests ? $rowGuests[$i]['surname'] : ''}}" placeholder="Surname" />
		                </div>
		                <div class="col-md-2">
		                	<div class="calDiv calDiv12">
		                	<input type="text" name="guests[{{$i}}][dob]" class="form-control datePicker" value="{{$row->guests ? $rowGuests[$i]['dob'] : ''}}" placeholder="DOB" onkeydown="return false;" required />
		                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
					        </div>
		                </div>
		                <div class="col-md-3">
		                	<input type="text" name="guests[{{$i}}][passport_no]" class="form-control" value="{{$row->guests ? $rowGuests[$i]['passport_no'] : ''}}" placeholder="Passport No." required />
		                </div>
		            </div>
		        </div>
		    @endfor
		    </div>
	    </div>
	</div>
</div>