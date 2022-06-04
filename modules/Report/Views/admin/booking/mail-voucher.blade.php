@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        @include('admin.message')
        <div class="lang-content-box">
            <div class="row">
                <div class="col-md-7">
					<div class="panel">

					    <div class="panel-body">
					    	<?php $version = "?var=".rand(); ?>
					    	<iframe src="{{ asset('voucher/voucher.pdf') }}{{$version}}" width="100%" height="450px" title="voucher.pdf"></iframe>
						</div>
					</div>
                </div>
                <div class="col-md-5">
					<div class="panel">
					    <div class="panel-title">
					    	<strong>Mail</strong>
					    </div>

					    <div class="panel-body">
						    <form action="{{route('report.booking.send_mail',['id'=>$row->id])}}" method="post">
						    	@csrf
						    	<div class="row">
								    <div class="col-lg-12">
								    	<div class="form-group">
										    <label class="control-label">From Mail ID</label>
										    <select class="form-control" name="from">
									    	@foreach($mailInfo as $idx => $mail)
									        	<option value="{{$mail->id}}">{{$mail->username}}</option>
									        @endforeach
										    </select>
										</div>
								    </div>
								    <div class="col-lg-12">
								    	<div class="form-group">
										    <label class="control-label">Whatsapp No.</label>
										    <input type<input type="text" name="phone" class="form-control" value="" placeholder="Whatsapp No." />
										</div>
								    </div>
								</div>
						    	<table style="width: 100%;" cellpadding="0" cellspacing="0">
						    		<?php
						    			if ($row->voucher_type == 3) {
						    				$hotelDDetail = getHotelById($row->term_id);
						    				$emails = $hotelDDetail->emails;
						    			}else {
						    				$emails = $row->term->emails;
						    			}
						    		?>
								    <tbody>
								    	<tr>
								            <td colspan="2">
								                <p>To:
								                @if(!empty($emails))<strong>{{implode(", ",$emails)}}</strong>@endif
								                </p>
								            </td>
								        </tr>
								        <tr>
								            <td>
								                <p>Lead Person Name</p>
								                <p> <strong>@if(!empty($row->name)) {{$row->name}} @else {{$booking->first_name.' '.$booking->last_name}} @endif</strong></p>
								            </td>
								            <td>
								                <p>Booking No.</p>
								                <p> <strong>#{{$row->booking_id}}</strong></p>
								            </td>
								        </tr>
								        <tr>
								            <td>
								                <p>Quantity</p>
								                @php $person_types = $booking->getJsonMeta('person_types') @endphp
	                                             @if(!empty($person_types))
	                                                @foreach($person_types as $idx => $type)
	                                                  <p> <strong>{{$type['name']}} : {{$type['number']}}  x Participant</strong></p>
	                                                  @endforeach
	                                              @else
	                                                  <p> <strong>Guests : {{$booking->total_guests}}  x Participant</strong></p>
	                                              @endif
								            </td>
								            <td>
								                <p>Date</p>
								                <p> <strong>{{$row->date}}</strong></p>
								            </td>
								        </tr>
								    </tbody>
								</table>
								<button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> {{__('Send Mail')}}</button>
							</form>

						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection
