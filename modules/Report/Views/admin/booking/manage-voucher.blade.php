@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <div class="">
                <h1 class="title-bar">{{__('Manage Voucher')}}</h1>
            </div>
        </div>
        @include('admin.message')
        <div class="lang-content-box">
            <div class="row">
                <div class="col-md-12">
					<div class="panel">
					    <div class="panel-title">
					    	<strong class="VouchersHeading">Vouchers</strong>
					    	<button class="btn-info btn" type="button" data-toggle="modal" data-target="#GenerateVoucher">{{__('Generate Vouchers')}}</button>
					    </div>

					    <div class="panel-body">
								<div class="form-group-item">
							    <div class="g-items-header">
							        <div class="row">
							            <div class="col-md-3 text-left">Sightseen Name</div>
							            <div class="col-md-1">Date</div>
							            <div class="col-md-1">Pickup Time</div>
							            <div class="col-md-1">Pax.</div>
							            <div class="col-md-2">Conf. No.</div>
							            <div class="col-md-2">Status</div>
							            <div class="col-md-2">Action</div>
							        </div>
							    </div>
							    <div class="g-items">
								@if(count($rows) > 0)
	                        		@foreach ($rows as $indx => $row)
                              <?php $hotelDDetail = @getHotelById($row->term_id); ?>
							        <div class="item">
							            <div class="row">
							                <div class="col-md-3">{{($row->voucher_type==3) ? @$hotelDDetail->title : @$row->term->name}}</div>
							                <div class="col-md-1">{{$row->date}}</div>
							                <div class="col-md-1">{{$row->time}}</div>
							                <div class="col-md-1">
							                	<?php $no_of_pax = 0 ; ?>
							                	 @if(!empty($row->person_types))
	                                                 @foreach($row->person_types as $idx => $type)
								                		<?php $no_of_pax += $type['no_of_pax'] ?>
								                	 @endforeach
                                                 @endif
                                                 {{$no_of_pax}}
							                </div>
							                <div class="col-md-2">{{$row->conf_no}}</div>
							                <div class="col-md-2"> <span class="badge badge-{{$row->status}}">{{$row->status}}</span> </div>
							                <div class="col-md-2">
							                	<div class="dropdown">
		                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('Actions')}}
		                                            </button>
		                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
		                                                <a class="dropdown-item" href="{{url('admin/module/report/booking/edit_voucher/'.$row->id)}}">{{__('Edit')}}</a>
		                                                <a class="dropdown-item" href="{{url('admin/module/report/booking/delete_voucher/'.$row->id)}}">{{__('Delete')}}</a>
		                                                <a class="dropdown-item" href="{{url('admin/module/report/booking/mail_voucher/'.$row->id)}}">{{__('Mail')}}</a>
		                                            </div>
		                                        </div>
							                </div>
							            </div>
							        </div>
								    @endforeach
	                        	@endif
							    </div>
						    </div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="GenerateVoucher">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    	<form action="{{route('report.admin.storeVoucher',['id'=>'-1','lang'=>request()->query('lang')])}}" method="post">
    		<input type="hidden" name="booking_id" value="{{$booking->id}}" readonly />
    		<!-- <input type="hidden" name="term_id" value="" /> -->
		  @csrf
	        <div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Booking ID: #{{$booking->id}}</h4>
			    </div>
			    <!-- Modal body -->
			    <div class="modal-body">
			    		@php
                            $attributes = \Modules\Core\Models\Terms::getTermsById(json_decode($booking->tour_attributes));
                            $totalRooms = count(json_decode($booking->getMeta('hotel_rooms'), true));
                            $activities = $booking->allActivities();
                        @endphp
				    	<div class="panel">
						    <div class="panel-body">
						        <div class="row">
						        	<div class="col-lg-12">
								    	@if(is_default_lang())
									    	<label class="radio-inline">
										      <input type="radio" name="voucher_type" class="voucher_type" value="1" checked> {{__("Sightseeing")}}
										    </label>
										    <label class="radio-inline">
										      <input type="radio" name="voucher_type" class="voucher_type" value="2"> {{__("Restaurant")}}
										    </label>
										    <label class="radio-inline">
										      <input type="radio" name="voucher_type" class="voucher_type" value="3"> {{__("Hotel")}}
										    </label>
										    <label class="radio-inline">
										      <input type="radio" name="voucher_type" class="voucher_type" value="4"> {{__("Transportation")}}
										    </label>
										@endif
		                            </div>
								    <div class="col-lg-12" id="Sightseeing">
								        <div class="form-group">
								            <label class="control-label">Sightseeing</label>
								            <select class="form-control tourAttributes" name="sightseeing">
									            <option value="">Select Sightseeing</option>
									        @if(!empty($booking->tour_attributes) and !empty($attributes))
									            @foreach($attributes as $attribute )
			                                    	@php $translate_attribute = $attribute['parent']->translateOrOrigin(app()->getLocale()) @endphp
				                                    @if(empty($attribute['parent']['hide_in_single']) && strpos($attribute['parent']->slug, 'sightseeing') !== false)
				                                    @php $terms = $attribute['child']; $k = 0; @endphp
					                                    @foreach($terms as $term )
					                                    	@php
					                                    	$translate_term = $term->translateOrOrigin(app()->getLocale());

					                                    	$default_date = null;
                											if(!empty($activities)) {
											                	$key = array_search($term->id, array_column($activities, 'id'));
												                if (isset($activities[$key])) {
												                    $default_date = isset($activities[$key]['date']) ? $activities[$key]['date'] : '';
												                }
											            	}

                											if (!empty($default_date)) {
												            		$default_date = date('d/m/Y', strtotime($default_date));
												            	}
											                $time = null;
											                if(!empty($manageItinerary)) {
											                	$key = array_search($term->id, array_column($manageItinerary, 'id'));
												                if (isset($manageItinerary[$key])) {
												                    $time = $manageItinerary[$key]['time'];
												                }
											            	}
											                
					                                    	@endphp
											            	<option value="{{$term->id}}" @if(in_array($term->id, $term_ids)) disabled @endif date="{{$default_date}}" time="{{$time}}">{{$translate_term->name}} - ({{ $translate_attribute->name }})</option>
											            	<?php $k++; ?>
											            @endforeach
										            @endif
                                    			@endforeach
                                    		@endif
									        </select>
								        </div>
								    </div>
								    <div class="col-lg-12" id="Restaurant" style="display: none;">
								        <div class="form-group">
								            <label class="control-label">Restaurant</label>
								            <select class="form-control tourAttributes" name="restaurant">
									            <option value="">Select Restaurant</option>
									        @if(!empty($booking->tour_attributes) and !empty($attributes))
									            @foreach($attributes as $attribute )
			                                    	@php $translate_attribute = $attribute['parent']->translateOrOrigin(app()->getLocale()) @endphp
				                                    @if(empty($attribute['parent']['hide_in_single']) && strpos($attribute['parent']->slug, 'restaurant') !== false)
				                                    @php $terms = $attribute['child']; @endphp
					                                    @foreach($terms as $term )
					                                    	@php
					                                    	$translate_term = $term->translateOrOrigin(app()->getLocale());
					                                    	@endphp
											            	<option value="{{$term->id}}" @if(in_array($term->id, $term_ids)) disabled @endif>{{$translate_term->name}} - ({{ $translate_attribute->name }})</option>
											            @endforeach
										            @endif
                                    			@endforeach
                                    		@endif
									        </select>
								        </div>
								    </div>
								    
								    <div class="col-lg-12" id="Transportation" style="display: none;">
								        <div class="form-group">
								            <label class="control-label">Transportation</label>
								            <select class="form-control tourAttributes" name="transport">
									            <option value="">Select Transport</option>
    									        @if(!empty($booking->tour_attributes) and !empty($attributes))
    									            @if(!empty($attributes) and isset($attributes[22]) and count($attributes[22]) > 0 && count($attributes[22]['child']) > 0)
    									            <?php $k = 0; ?>
    				                                        @foreach($attributes[22]['child'] as $term )
    				                                        <?php 
						                                    	$dateDay = "+$k day";
						                                    	$default_date = null;

						                                    	if(!empty($activities)) {
												                	$key = array_search($term->id, array_column($activities, 'id'));
													                if (isset($activities[$key])) {
													                    $default_date = isset($activities[$key]['date']) ? $activities[$key]['date'] : '';
													                }
												            	}
												            	if (!empty($default_date)) {
												            		$default_date = date('d/m/Y', strtotime($default_date));
												            	}

												                $time = null;

												                if(!empty($manageItinerary)) {
												                	$key = array_search($term->id, array_column($manageItinerary, 'id'));
													                if (isset($manageItinerary[$key])) {
													                    $time = $manageItinerary[$key]['time'];
													                }
												            	}
												                ?>
    											            	<option value="{{$term->id}}" date="{{$default_date}}" time="{{$time}}" @if(in_array($term->id, $term_ids)) disabled @endif>{{$term->name}}</option>
    											            	<?php $k++; ?>
    											            @endforeach
    										            @endif
                                        		   @endif
									        </select>
								        </div>
								    </div>
								    <div class="col-lg-12" id="Hotels" style="display: none;">
								        <div class="form-group">
								            <label class="control-label">Hotels</label>
								            <select class="form-control tourAttributes" name="hotels">
									            <option value="">Select Hotel</option>
                              <?php $bookingDate = $booking->start_date; ?>
										    @if(!empty($booking->default_hotels))
	                            				@foreach (json_decode($booking->default_hotels, true) as $indx => $hotel)
                                      <?php $hotelDDetail = getHotelById($hotel['hotel']); ?>
	                            				<?php
                                      $room_type = getRoomsById($hotel['room'])->title;
                                      $noDays = $hotel['days'] * 2;
                                			$dayPlus = "+$noDays day";
                                      $checkInDate = date('d/m/Y', strtotime($bookingDate));
            							            $checkOutDate = date('d/m/Y', strtotime($bookingDate . $dayPlus));
            							            $date = str_replace('/', '-', $checkOutDate);
            									        $bookingDate = date('Y-m-d', strtotime($date));
                                      ?>
												   	<option value="{{$hotel['hotel']}}" room_type="{{$room_type}}" cDate="{{$checkInDate}}" coDate="{{$checkOutDate}}" rooms="{{$totalRooms}}" @if(in_array($hotel['hotel'], $term_ids)) disabled @endif>{{$hotelDDetail->title}}</option>
												@endforeach
	                            			@endif
									        </select>
								        </div>
								    </div>
								    <div class="col-lg-12">
								        <div class="form-group">
								            <label class="control-label">Package Details</label>
								            <input type="text" name="package_details" class="form-control package_details" value="" placeholder="Package Details" required />
								        </div>
								    </div>
                    				<div class="col-lg-12">
								        <div class="form-group">
								            <label class="control-label">Name</label>
								            <input type="text" name="name" class="form-control" value="" placeholder="Name" />
								        </div>
								    </div>
								    <div class="col-lg-12">
								        <div class="form-group">
								            <label class="control-label">Hotel Name</label>
								            <input type="text" name="hotel_name" class="form-control" value="" placeholder="Hotel Name" />
								        </div>
								    </div>

								</div>
								<div class="row" id="nonHotelDiv">
									<div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">Date</label>
								            <div class="calDiv">
										        <input type="text" name="date" class="form-control datePicker" value="" placeholder="Date"  required readonly />
							                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
						                </div>
								        </div>
								    </div>
								    <div class="col-lg-6">
								        <div class="form-group">
								    		<label class="control-label">Pickup Time</label>
								        	<input type="text" name="time" class="form-control timepicker" value="" placeholder="Pickup Time" readonly required />
								        </div>
								    </div>
								</div>
								<div class="row" id="HotelDiv" style="display: none;">
									<div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">Check In</label>
								            <div class="calDiv">
										        <input type="text" name="hotel[check_in]" class="form-control check_inDate datePicker" value="" placeholder="Date"  />
							                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
						                </div>
								        </div>
								    </div>
								    <div class="col-lg-6">
								        <div class="form-group">
								    		<label class="control-label">Check Out</label>
								        	<div class="calDiv">
											        <input type="text" name="hotel[check_out]" class="form-control check_outDate datePicker" value="" placeholder="Date"  />
								                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
							                </div>
								        </div>
								    </div>
								    <div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">Room Type</label>
								            <input type="text" name="hotel[room_type]" class="form-control roomType" value="" placeholder="Room Type" readonly />
								        </div>
								    </div>

								     <div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">No Of Room</label>
								            <input type="number" min="0" name="hotel[no_of_room]" class="form-control no_of_room" value="
								            " placeholder="No. of room" />
								        </div>
								    </div>
								</div>
							@php $person_types = $booking->getJsonMeta('person_types') @endphp
							 @if(!empty($person_types))
            					@foreach($person_types as $idx => $type)
								<div class="row">
									<div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">Person Type</label>
								            <input type="text" name="person_types[{{$idx}}][type]" class="form-control" value="{{$type['name']}}" readonly />
								        </div>
								    </div>
									<div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">No. of Pax</label>
								            <input type="number" name="person_types[{{$idx}}][no_of_pax]" class="form-control" value="{{$type['number']}}" placeholder="No. of Pax" required/>
								        </div>
								    </div>
								</div>
								@endforeach
        					@else
        					<div class="row">
									<div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">Person Type</label>
								            <input type="text" name="person_types[0][type]" class="form-control" value="Guests" readonly />
								        </div>
								    </div>
									<div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">No. of Pax</label>
								            <input type="number" name="person_types[0][no_of_pax]" class="form-control" value="{{$booking->total_guests}}" placeholder="No. of Pax" required/>
								        </div>
								    </div>
							</div>
        					@endif
								<div class="row">
								    <div class="col-lg-12">
								        <div class="form-group">
								            <label class="control-label">Confirmation No.</label>
								            <input type="text" name="conf_no" class="form-control" value="" placeholder="Confirmation No." />
								        </div>
								    </div>
								    <div class="col-lg-12">
								    	<div class="form-group">
									        <textarea name="remark" class="form-control full-h" rows="3" placeholder="write here..."></textarea>
									    </div>
								    </div>
								    <div class="col-lg-12">
								    	@if(is_default_lang())
									    	<label class="radio-inline">
										      <input type="radio" name="status" value="publish"> {{__("Publish")}}
										    </label>
										    <label class="radio-inline">
										      <input checked type="radio" name="status" value="draft"> {{__("Draft")}}
										    </label>
										@endif
		                            </div>
								</div>
						    </div>
						</div>

			    </div>
			    <!-- Modal footer -->
			    <div class="modal-footer">
			    	<div class="text-right">
	                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Generate')}}</button>
	                </div>
			        <span class="btn btn-secondary" data-dismiss="modal">Close</span>
			    </div>
			</div>
		</form>

    </div>
</div>

@endsection
