@extends('admin.layouts.app')

@section('content')
    <form action="{{route('report.admin.storeItinerary',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post">
        @csrf
        <input type="hidden" name="booking_id" value="{{$booking->id}}">
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{$row->id ? __('Manage Itinerary: ').$row->title : __('Manage Itinerary')}}</h1>
                </div>
            </div>
            @include('admin.message')
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                    	<div class="panel">
						    <div class="panel-title"><strong>Basic Info</strong></div>
						    <div class="panel-body">
 						        <!-- <div class="form-group">
						            <label>Title</label>
						            <input type="text" value="" placeholder="Tour title" name="title" class="form-control" />
						        </div>  -->
						        <div class="row">
								    <div class="col-lg-4">
								        <div class="form-group">
								        	<?php
									        	$date = date('M/y/d', strtotime($booking->start_date));
									        	$voucher_no = "TNG/$date/$booking->total_guests";
									        	$voucher_no = strtoupper($voucher_no);
								        	 ?>
								            <label class="control-label">Voucher</label>
								            <input type="text" name="voucher" class="form-control" value="{{$voucher_no}}" placeholder="Voucher" readonly />
								        </div>
								    </div>
								    <div class="col-lg-4">
								        <div class="form-group">
								            <label class="control-label">Agent Name</label>
								            <input type="text" name="agent_name" class="form-control" value="TNG Holidays" placeholder="Agent Name"/>
								        </div>
								    </div>
								    <div class="col-lg-4">
								        <div class="form-group">
								            <label class="control-label">Guest Name</label>
								            <input type="text" name="name" class="form-control" value="@if(!empty($row->name)) {{$row->name}} @else {{$booking->first_name.' '.$booking->last_name}} @endif" placeholder="Guest Name" />
								        </div>
								    </div>
								</div>
								<div class="row">
									<div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">No. of Pax</label>
								            <input type="text" name="no_of_pax" class="form-control" value="{{$booking->total_guests}}" placeholder="No. of Pax" readonly />
								        </div>
								    </div>
								    <div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">Meeting Point</label>
								            <input type="text" name="meeting_point" class="form-control" value="{{$row->meeting_point}}" placeholder="Meeting Point" required />
								        </div>
								    </div>
								</div>
						    </div>
						</div>
						<?php $totalRooms = count(json_decode($booking->getMeta('hotel_rooms'), true)); ?>
						<div class="panel">
						    <div class="panel-title"><strong>Hotels</strong></div>
						    <div class="panel-body">
 								<div class="form-group-item">
								    <div class="g-items-header">
								        <div class="row">
								            <div class="col-md-3 text-left">Hotel Name</div>
								            <div class="col-md-2">Check In<br>(dd/mm/yyyy)</div>
								            <div class="col-md-2">Check Out<br>(dd/mm/yyyy)</div>
								            <div class="col-md-2">Room Type</div>
								            <div class="col-md-3">Confirmation No.</div>
								        </div>
								    </div>
								    <div class="g-items">
								    	<?php $rowHotels = $row->hotels; $bookingDate = $booking->start_date;?>
									@if(json_decode($booking->default_hotels, true) > 0)
                            		@foreach (json_decode($booking->default_hotels, true) as $indx => $hotel)
                            		<?php
                            			$hotelDDetail = getHotelById($hotel['hotel']);
                            			$noDays = $hotel['days'] * 2;
                            			$dayPlus = "+$noDays day";
							            $checkInDate = date('d/m/Y', strtotime($bookingDate));
							            $checkOutDate = date('d/m/Y', strtotime($bookingDate . $dayPlus));
							            $date = str_replace('/', '-', $checkOutDate);
									    $bookingDate = date('Y-m-d', strtotime($date));
                            		?>
                            			<input type="hidden" name="hotels[{{$indx}}][location_id]" value="{{$hotel['location_id']}}">
                            			<input type="hidden" name="hotels[{{$indx}}][hotel]" value="{{$hotel['hotel']}}">
                            			<input type="hidden" name="hotels[{{$indx}}][room]" value="{{$hotel['room']}}">
								        <div class="item">
								            <div class="row">
								                <div class="col-md-3">{{$hotelDDetail->title}}<br>
								                <span class="addess">Address: {{$hotelDDetail->address}}</span>
								                </div>
								                <div class="col-md-2" days="{{$hotel['days']}}">
								                	<div class="calDiv">
											        <input type="text" name="hotels[{{$indx}}][check_in]" class="form-control datePicker" value="{{$row->hotels ? $rowHotels[$indx]['check_in'] : $checkInDate}}" placeholder="Check In" required />
											        <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
											        </div>
								                </div>
								                <div class="col-md-2">
								                	<div class="calDiv">
								                	<input type="text" name="hotels[{{$indx}}][check_out]" class="form-control datePicker" value="{{$row->hotels ? $rowHotels[$indx]['check_out'] : $checkOutDate}}" placeholder="Check Out" required />
								                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
								                </div>
								                </div>
								                <div class="col-md-2">
								                	{{@getRoomsById($hotel['room'])->title}}
								                	<input type="text" name="hotels[{{$indx}}][no_of_room]" class="form-control" value="{{$row->hotels ? $rowHotels[$indx]['no_of_room'] : $totalRooms}}" placeholder="No. of room" />
								                </div>
								                <div class="col-md-3">
								                	<input type="text" name="hotels[{{$indx}}][conf_no]" class="form-control" value="{{$row->hotels ? $rowHotels[$indx]['conf_no'] : ''}}" placeholder="Confirmation No." />
								                </div>
								            </div>
								        </div>
								    @endforeach
                            	@endif
								    </div>
							    </div>
							</div>
						</div>

						<div class="panel">
						    <div class="panel-title"><strong>Day-Wise Itinerary</strong></div>
						    <div class="panel-body">
 								<div class="form-group-item">
								    <div class="g-items-header">
								        <div class="row">
								            <div class="col-md-2">Date<br>(dd/mm/yyyy)</div>
								            <div class="col-md-3">Time</div>
								            <div class="col-md-7">Plan</div>
								        </div>
								    </div>
								    <div class="g-items">
								    	
								    	<?php
								    		$rowItinerary = $row->itinerary; $i = 0; 
								    		$tour_activities = $booking->activities();
								    	?>
								    @if(!empty($tour_activities))
								    	@foreach($tour_activities as $key=>$summary)
								    	<?php
								            	$hasItinerary = !empty($rowItinerary[$i]['date']) ? true : false;							            	$dayPlus = "+$i day";
								            	$default_date = date('d/m/Y', strtotime($booking->start_date . $dayPlus));
								            	// dd($default_date);
								            ?>
								            <div class="item">
									    		<div class="row">
									                <div class="col-md-1">
									                	<p> <strong>Day {{$key+1}}</strong></p>
									                </div>
									                <div class="col-md-11">
									                	@if(isset($summary['transfer']) && count($summary['transfer']) > 0)
									                	@foreach($summary['transfer'] as $key=>$transfer)

												            <input type="hidden" name="itinerary[{{$i}}][id]" value="{{$transfer['id']}}">
												            <input type="hidden" name="itinerary[{{$i}}][image_id]" value="{{$transfer['image_id']}}">
					                            			<input type="hidden" name="itinerary[{{$i}}][title]" value="{{$transfer['name']}}">
					                            			<input type="hidden" name="itinerary[{{$i}}][desc]" value="{{$transfer['desc']}}">
					                            			<input type="hidden" name="itinerary[{{$i}}][content]" value="{{$transfer['content']}}">
														            <div class="row">
														                <div class="col-md-3">
														                	<div class="calDiv">
																	        <input type="text" name="itinerary[{{$i}}][date]" class="form-control datePicker" value="{{$hasItinerary ? $rowItinerary[$i]['date'] : $default_date}}" placeholder="Date" />
														                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
													                </div>
														                </div>
														                <div class="col-md-2">
														                	<input type="text" name="itinerary[{{$i}}][time]" class="form-control" value="{{$hasItinerary ? $rowItinerary[$i]['time'] : ''}}" placeholder="Time" />
														                </div>
														                <div class="col-md-7">{{$transfer['name'] ?? ""}} <br></div>
														            </div>
														        <?php $i++; ?>
														    @endforeach
											    		@endif
									                	@if(isset($summary['activity']) && count($summary['activity']) > 0)
												    		@foreach($summary['activity'] as $key=>$activity)

												            <input type="hidden" name="itinerary[{{$i}}][id]" value="{{$activity['id']}}">
												            <input type="hidden" name="itinerary[{{$i}}][image_id]" value="{{$activity['image_id']}}">
					                            			<input type="hidden" name="itinerary[{{$i}}][title]" value="{{$activity['name']}}">
					                            			<input type="hidden" name="itinerary[{{$i}}][desc]" value="{{$activity['desc']}}">
					                            			<input type="hidden" name="itinerary[{{$i}}][content]" value="{{$activity['content']}}">
														            <div class="row">
														                <div class="col-md-3">
														                	<div class="calDiv">
																	        <input type="text" name="itinerary[{{$i}}][date]" class="form-control datePicker" value="{{$hasItinerary ? $rowItinerary[$i]['date'] : $default_date}}" placeholder="Date" />
														                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
													                </div>
														                </div>
														                <div class="col-md-2">
														                	<input type="text" name="itinerary[{{$i}}][time]" class="form-control" value="{{$hasItinerary ? $rowItinerary[$i]['time'] : ''}}" placeholder="Time" />
														                </div>
														                <div class="col-md-7">{{$activity['name'] ?? ""}} <br></div>
														            </div>
														        <?php $i++; ?>
												    		@endforeach
											    		@endif
									                </div>
									            </div>
									    	</div>
								    		
								    	@endforeach
								    @endif
								    <?php /*
								    @if(!empty($tour->itinerary))
						            <?php if(!is_array($tour->itinerary)) $tour->itinerary = json_decode($tour->itinerary); ?>
							            @foreach($tour->itinerary as $key=>$itinerary)
							            <?php
							            	$hasItinerary = isset($rowItinerary[$i]['date']) ? true : false;
							            	$dayPlus = "+$i day";
							            	$default_date = date('d/m/Y', strtotime($booking->start_date . $dayPlus));
							            	// dd($default_date);
							            ?>
							            <input type="hidden" name="itinerary[{{$i}}][image_id]" value="{{$itinerary['image_id']}}">
                            			<input type="hidden" name="itinerary[{{$i}}][title]" value="{{$itinerary['title']}}">
                            			<input type="hidden" name="itinerary[{{$i}}][desc]" value="{{$itinerary['desc']}}">
                            			<input type="hidden" name="itinerary[{{$i}}][content]" value="{{$itinerary['content']}}">
									        <div class="item">
									            <div class="row">
									                <div class="col-md-2">
									                	<div class="calDiv">
												        <input type="text" name="itinerary[{{$i}}][date]" class="form-control datePicker" value="{{$hasItinerary ? $rowItinerary[$i]['date'] : $default_date}}" placeholder="Date" />
									                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
								                </div>
									                </div>
									                <div class="col-md-3">
									                	<input type="text" name="itinerary[{{$i}}][time]" class="form-control" value="{{$hasItinerary ? $rowItinerary[$i]['time'] : ''}}" placeholder="Time" />
									                </div>
									                <div class="col-md-7">{{$itinerary['desc'] ?? ""}} <br></div>
									            </div>
									        </div>
									        <?php $i++; ?>
									    @endforeach
        							@endif
        							*/ ?>
								    </div>
							    </div>
							</div>
						</div>
						@include('Report::admin/booking/guest-form')
						<div class="panel">
						    <div class="panel-title"><strong>Remark</strong></div>
						    <div class="panel-body">
						        <div class="row">
								    <div class="col-lg-12">
								        <textarea name="remark" class="form-control full-h" rows="6" placeholder="write here...">{{$row->remark}}</textarea>
								    </div>
								</div>
						    </div>
						</div>

                    </div>
                    <div class="col-md-3">
                        <div class="panel">
                            <div class="panel-title"><strong>{{__('Publish')}}</strong></div>
                            <div class="panel-body">
                                @if(is_default_lang())
                                    <div>
                                        <label><input @if($row->status=='publish') checked @endif type="radio" name="status" value="publish"> {{__("Publish")}}
                                        </label></div>
                                    <div>
                                        <label><input @if($row->status=='draft') checked @endif type="radio" name="status" value="draft"> {{__("Draft")}}
                                        </label></div>
                                @endif
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save Changes')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
