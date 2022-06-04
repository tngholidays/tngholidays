@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
<div class="d-flex justify-content-between mb20">
            <div class="">
                <h1 class="title-bar">{{__('Edit Voucher')}}</h1>
            </div>
        </div>
    <form action="{{route('report.admin.storeVoucher',['id'=>$row->id,'lang'=>request()->query('lang')])}}" method="post">
    		<input type="hidden" name="booking_id" value="{{$booking->id}}" readonly />
        @csrf
        <input type="hidden" name="id" value="{{$row->id}}">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                	@include('admin.message')
                    <div class="lang-content-box">
                        <div class="panel">
                            <div class="panel-body">
                            	@php
		                            $attributes = \Modules\Core\Models\Terms::getTermsById(json_decode($booking->tour_attributes));
		                            $default_hotels = json_decode($booking->default_hotels, true);
		                            $activities = $booking->allActivities();
		                            function hotelDetail($hotel_id, $booking)
							    	{
							    		$arr = '';
							    		$default_hotels = json_decode($booking->default_hotels, true);
							    		foreach ($default_hotels as $key => $ho) {
							    			if ($ho['hotel'] == $hotel_id) {
							    				$arr =  $ho;
							    			}
							    		}
							    		return $arr;
							    	}
							    	$totalRooms = count(json_decode($booking->getMeta('hotel_rooms'), true));
		                        @endphp
						        <div class="row">
						        	<div class="col-lg-12">
								    	@if(is_default_lang())
									    	<label class="radio-inline">
										      <input type="radio" name="voucher_type" class="voucher_type" value="1" {{$row->voucher_type == 1 ? 'checked' : ''}}> {{__("Sightseeing")}}
										    </label>
										    <label class="radio-inline">
										      <input type="radio" name="voucher_type" class="voucher_type" value="2" {{$row->voucher_type == 2 ? 'checked' : ''}}> {{__("Restaurant")}}
										    </label>
										    <label class="radio-inline">
										      <input type="radio" name="voucher_type" class="voucher_type" value="3" {{$row->voucher_type == 3 ? 'checked' : ''}}> {{__("Hotel")}}
										    </label>
										    <label class="radio-inline">
										      <input type="radio" name="voucher_type" class="voucher_type" value="4" {{$row->voucher_type == 4 ? 'checked' : ''}}> {{__("Transportation")}}
										    </label>
										@endif
		                            </div>
						        	<div class="col-lg-12" id="Sightseeing" style="display:{{$row->voucher_type == 1 ? 'block' : 'none'}};">
								        <div class="form-group">
								            <label class="control-label">Sightseeing</label>
								            <select class="form-control tourAttributes" name="sightseeing">
									            <option value="">Select Sightseeing</option>
										    @if($row->voucher_type == 1)
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
													                    $default_date = $activities[$key]['date'];
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
												            	<option value="{{$term->id}}" @if(in_array($term->id, $term_ids) && $term->id != $row->term_id) disabled @endif @if($term->id == $row->term_id) selected @endif date="{{$default_date}}" time="{{$time}}">{{$translate_term->name}} - ({{ $translate_attribute->name }})</option>
												            	<?php $k++; ?>
												            @endforeach
											            @endif
	                                    			@endforeach
	                                    		@endif
	                                    	@endif
									        </select>
								        </div>
								    </div>
								    <div class="col-lg-12" id="Restaurant" style="display:{{$row->voucher_type == 2 ? 'block' : 'none'}};">
								        <div class="form-group">
								            <label class="control-label">Restaurant</label>
								            <select class="form-control tourAttributes" name="restaurant">
									            <option value="">Select Restaurant</option>
										    @if($row->voucher_type == 2)
										        @if(!empty($booking->tour_attributes) and !empty($attributes))
										            @foreach($attributes as $attribute )
				                                    	@php $translate_attribute = $attribute['parent']->translateOrOrigin(app()->getLocale()) @endphp
					                                    @if(empty($attribute['parent']['hide_in_single']) && strpos($attribute['parent']->slug, 'restaurant') !== false)
					                                    @php $terms = $attribute['child'] @endphp
						                                    @foreach($terms as $term )
						                                    	@php
						                                    	$translate_term = $term->translateOrOrigin(app()->getLocale());
						                                    	@endphp
												            	<option value="{{$term->id}}" @if(in_array($term->id, $term_ids) && $term->id != $row->term_id) disabled @endif @if($term->id == $row->term_id) selected @endif>{{$translate_term->name}} - ({{ $translate_attribute->name }})</option>
												            	
												            @endforeach
											            @endif
	                                    			@endforeach
	                                    		@endif
	                                    	@endif
									        </select>
								        </div>
								    </div>
								    <div class="col-lg-12" id="Transportation" style="display:{{$row->voucher_type == 4 ? 'block' : 'none'}};">
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
    											            	<option value="{{$term->id}}" @if(in_array($term->id, $term_ids) && $term->id != $row->term_id) disabled @endif @if($term->id == $row->term_id) selected @endif   date="{{$default_date}}" time="{{$time}}" @if(in_array($term->id, $term_ids)) disabled @endif>{{$term->name}}</option>
    											            	<?php $k++; ?>
    											            @endforeach
    										            @endif
                                        		   @endif
									        </select>
								        </div>
								    </div>
								    <div class="col-lg-12" id="Hotels" style="display:{{$row->voucher_type == 3 ? 'block' : 'none'}};">
								        <div class="form-group">
								            <label class="control-label">Hotels</label>
								            <select class="form-control tourAttributes" name="hotels">
									            <option value="">Select Hotel</option>
										    @if($row->voucher_type == 3)
										    <?php $bookingDate = $booking->start_date; ?>
											    @if($default_hotels > 0)
		                            				@foreach ($default_hotels as $indx => $hotel)
		                            				<?php
				                                        $hotelDDetail = getHotelById($hotel['hotel']);
				                                        $room_type = getRoomsById($hotel['room'])->title;
				                                        $noDays = $hotel['days'] * 2;
				                                        $dayPlus = "+$noDays day";
				                                        $checkInDate = date('d/m/Y', strtotime($bookingDate));
				                                        $checkOutDate = date('d/m/Y', strtotime($bookingDate . $dayPlus));
				                                        $date = str_replace('/', '-', $checkOutDate);
				                                        $bookingDate = date('Y-m-d', strtotime($date));
				                                    ?>
													   	<option value="{{$hotel['hotel']}}" room_type="{{$room_type}}" cDate="{{$checkInDate}}" coDate="{{$checkOutDate}}" rooms="{{$totalRooms}}" @if(in_array($hotel['hotel'], $term_ids) && $hotel['hotel'] != $row->term_id) disabled @endif @if($hotel['hotel'] == $row->term_id) selected @endif>{{$hotelDDetail->title}}</option>
													@endforeach
		                            			@endif
		                            		@endif
									        </select>
								        </div>
								    </div>
								    
								    <div class="col-lg-12">
								        <div class="form-group">
								            <label class="control-label">Package Details</label>
								            <input type="text" name="package_details" class="form-control package_details" value="{{$row->package_details}}" placeholder="Package Details" required />
								        </div>
								    </div>
                    <div class="col-lg-12">
								        <div class="form-group">
								            <label class="control-label">Name</label>
								            <input type="text" name="name" class="form-control" value="{{$row->name}}" placeholder="Name" />
								        </div>
								        
								    </div>
								    <div class="col-lg-12">
									        <div class="form-group">
									            <label class="control-label">Hotel Name</label>
									            <input type="text" name="hotel_name" class="form-control" value="{{$row->hotel_name}}" placeholder="Hotel Name" />
									        </div>
									    </div>
								</div>
								<div class="row" id="nonHotelDiv" style="display:{{$row->voucher_type != 3 ? '' : 'none'}};">
									<div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">Date</label>
								            <div class="calDiv">
										        <input type="text" name="date" class="form-control datePicker" value="{{$row->date}}" placeholder="Date"  required readonly />
							                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
						                </div>
								        </div>
								    </div>
								    <div class="col-lg-6">
								        <div class="form-group">
								    		<label class="control-label">Pickup Time</label>
								        	<input type="text" name="time" class="form-control timepicker" value="{{$row->time}}" placeholder="Pickup Time" readonly required />
								        </div>
								    </div>
								</div>
								<div class="row" id="HotelDiv" style="display:{{$row->voucher_type == 3 ? '' : 'none'}};">
									<div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">Check In</label>
								            <div class="calDiv">
										        <input type="text" name="hotel[check_in]" class="form-control check_inDate datePicker" value="{{$row->hotel ? $row->hotel['check_in'] : ''}}" placeholder="Date"  />
							                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
						                </div>
								        </div>
								    </div>
								    <div class="col-lg-6">
								        <div class="form-group">
								    		<label class="control-label">Check Out</label>
								        	<div class="calDiv">
											        <input type="text" name="hotel[check_out]" class="form-control check_outDate datePicker" value="{{$row->hotel ? $row->hotel['check_out'] : ''}}" placeholder="Date"  />
								                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
							                </div>
								        </div>
								    </div>
								    <div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">Room Type</label>
								            <input type="text" name="hotel[room_type]" class="form-control roomType" value="{{isset($row->hotel['room_type']) ? $row->hotel['room_type'] : ''}}" placeholder="Room Type" readonly />
								        </div>
								    </div>
								     <div class="col-lg-6">
								        <div class="form-group">
								            <label class="control-label">No. Of Room</label>
								            <input type="number" min="0" name="hotel[no_of_room]" class="form-control no_of_room" value="{{$row->hotel ? $row->hotel['no_of_room'] : ''}}" placeholder="No. of room" />
								        </div>
								    </div>
								</div>
								 @if(!empty($row->person_types))
	            					@foreach($row->person_types as $idx => $type)
									<div class="row">
										<div class="col-lg-6">
									        <div class="form-group">
									            <label class="control-label">Person Type</label>
									            <input type="text" name="person_types[{{$idx}}][type]" class="form-control" value="{{$type['type']}}" readonly />
									        </div>
									    </div>
										<div class="col-lg-6">
									        <div class="form-group">
									            <label class="control-label">No. of Pax</label>
									            <input type="number" name="person_types[{{$idx}}][no_of_pax]" class="form-control" value="{{$type['no_of_pax']}}" placeholder="No. of Pax" required/>
									        </div>
									    </div>
									</div>
									@endforeach
	        					@endif
								<div class="row">
								    <div class="col-lg-12">
								        <div class="form-group">
								            <label class="control-label">Confirmation No.</label>
								            <input type="text" name="conf_no" class="form-control" value="{{$row->conf_no}}" placeholder="Confirmation No." />
								        </div>
								    </div>
								    <div class="col-lg-12">
								    	<div class="form-group">
									        <textarea name="remark" class="form-control full-h" rows="3" placeholder="write here...">{{$row->remark}}</textarea>
									    </div>
								    </div>
								    <div class="col-lg-12">
								    	@if(is_default_lang())
									    	<label class="radio-inline">
										      <input @if($row->status=='publish') checked @endif type="radio" name="status" value="publish"> {{__("Publish")}}
										    </label>
										    <label class="radio-inline">
										      <input @if($row->status=='draft') checked @endif type="radio" name="status" value="draft"> {{__("Draft")}}
										    </label>
										@endif
		                            </div>
								</div>
						    </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">{{__("Save Change")}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section ('script.body')
@endsection
