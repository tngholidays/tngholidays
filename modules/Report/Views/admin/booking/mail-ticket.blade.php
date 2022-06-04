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
					    	<iframe src="{{ asset('voucher/ticketPDF.pdf') }}{{$version}}" width="100%" height="450px" title="voucher.pdf"></iframe>
						</div>
					</div>
                </div>
                <div class="col-md-5">
					<div class="panel">
					    <div class="panel-title">
					    	<strong>Mail</strong>
					    </div>

					    <div class="panel-body">
						    <form action="{{route('report.booking.send_ticket_mail',['id'=>$booking->id])}}" method="post">
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
						    			$emails = $service->emails;
						    		?>
								    <tbody>
								    	<tr>
								            <td colspan="2">
								                <p>To:
								                @if(!empty($emails))<strong>{{implode(", ",$emails)}}</strong>@endif
								                </p>
								            </td>							        <tr>
								            <td>
								                <p>Lead Person Name</p>
								                <p> <strong>{{$booking->first_name.' '.$booking->last_name}}</strong></p>
								            </td>
								            <td>
								                <p>Booking No.</p>
								                <p> <strong>#{{$booking->id}}</strong></p>
								            </td>
								        </tr>
								        <tr>
								            <td>
								                <p>Quantity</p>
								               	@php $ticket_types = $booking->getJsonMeta('selected_tickets') @endphp
	                                             @if(!empty($ticket_types))
	                                                @foreach($ticket_types as $idx => $ticket_type)
	                                                <?php $timeslot =  getArrayByColumn($ticket_type['timeslots'], 'id', $ticket_type['timeslot_id']); ?>
	                                                  <p> <strong>Ticket : <i>{{$ticket_type['title']}}</i></strong></p>
	                                                  <p> <strong>Time Slot : <i>{{$timeslot['time']}}</i> </strong></p>
	                                                  <p> <strong>Adult : {{$ticket_type['adult_ticket']}}  x Participant</strong></p>
	                                                  <p> <strong>Child : {{$ticket_type['child_ticket']}}  x Participant</strong></p>
	                                                  @endforeach
	                                              @endif
								            </td>
								            <td>
								                <p>Date</p>
								                <p> <strong>{{display_date($booking->start_date)}}</strong></p>
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
