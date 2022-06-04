@extends('admin.layouts.app')
<style>
.btn-group, .btn-group-vertical {
    position: relative;
    display: inline-block;
    vertical-align: middle;
}
.btn-group.open .dropdown-toggle {
    -webkit-box-shadow: inset 0 3px 5px rgb(0 0 0 / 13%);
    box-shadow: inset 0 3px 5px rgb(0 0 0 / 13%);
}

.btn-group .dropdown-toggle:active, .btn-group.open .dropdown-toggle {
    outline: 0;
}
.btn-group>.btn:first-child {
    margin-left: 0;
}
.btn-default.active, .btn-default:active, .open>.dropdown-toggle.btn-default {
    background-image: none;
}
.btn-default.active, .btn-default.focus, .btn-default:active, .btn-default:focus, .btn-default:hover, .open>.dropdown-toggle.btn-default {
    color: #333;
    background-color: #e6e6e6;
    border-color: #adadad;
}
.btn-group-vertical>.btn, .btn-group>.btn {
    position: relative;
    float: left;
}
.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
button, input, select, textarea {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
}
button, html input[type=button], input[type=reset], input[type=submit] {
    -webkit-appearance: button;
    cursor: pointer;
}
button, select {
    text-transform: none;
}
button {
    overflow: visible;
}
button, input, optgroup, select, textarea {
    margin: 0;
    font: inherit;
    color: inherit;
}
.open>.dropdown-menu {
    display: block;
}
.dropdown-menu>li>a {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
}
.show {
    display: block!important;
}
.btn-group>.btn:first-child {
    margin-left: 0;
}
.btn-group-vertical>.btn, .btn-group>.btn {
    position: relative;
    float: left;
}

.dropdown-toggle::after {
    display: inline-block;
    margin-left: 0.255em;
    vertical-align: 0.255em;
    content: "";
    border-top: 0.3em solid;
    border-right: 0.3em solid transparent;
    border-bottom: 0;
    border-left: 0.3em solid transparent;
}
.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
    color: #fff;
    text-decoration: none;
    background-color: #337ab7;
    outline: 0;
}
.dropdown-menu>li>a {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
}
.checkbox, .radio {
    position: relative;
    display: block;
    margin-top: 10px;
    margin-bottom: 10px;
}
.dropdown-menu {
    top: 100% !important;
    left: 0 !important;
    z-index: 1000!important;
    float: left!important;
    min-width: 160px!important;
    font-size: 14px!important;
    text-align: left!important;
    list-style: none!important;
    background-color: #fff!important;
    -webkit-background-clip: padding-box!important;
    background-clip: padding-box!important;
    border: 1px solid #ccc!important;
    border: 1px solid rgba(0,0,0,.15)!important;
    border-radius: 4px!important;
    -webkit-box-shadow: 0 6px 12px rgb(0 0 0 / 18%)!important;
    box-shadow: 0 6px 12px rgb(0 0 0 / 18%)!important;
        transform: none !important;
}
.multiselect-container li a label {
    padding: 4px 20px 3px 15px !important;
}
</style>
@section('content')
    <form action="{{route('report.admin.storeProposal',['id'=>($old_row->id) ? $old_row->id : '-1','lang'=>request()->query('lang')])}}" method="post">
        @csrf
        <input type="hidden" name="enquiry_id" value="{{$enquiry->id}}">
        <input type="hidden" name="step" value="0">
        <input type="hidden" name="proposalRoute" value="{{url('admin/module/report/booking/booking_proposal/'.$enquiry->id.'/'.$step)}}">
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{$row->id ? __('Booking Praposal: ').$row->title : __('Booking Praposal')}}</h1>
                </div>
                @if(!empty($row->tour_details))
                    <a class="btn btn-primary btn-sm" href="{{url('admin/module/report/booking/view_proposal/'.$enquiry->id)}}" target="_blank">{{__("View Praposal")}}</a>
                @endif
            </div>

            @include('admin.message')
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                  <!-- Step First Start -->
                    <div id="first-section">
                        <div class="panel" style="pointer-events: none;">
                        						    <div class="panel-title"><strong>Basic Info</strong></div>
                        						    <div class="panel-body">
                         						        <!-- <div class="form-group">
                        						            <label>Title</label>
                        						            <input type="text" value="" placeholder="Tour title" name="title" class="form-control" />
                        						        </div>  -->
                        						        <div class="row">
                        								    <div class="col-lg-4">
                        								        <div class="form-group">
                        								            <label class="control-label">Name</label>
                                                    <?php $name = !empty($old_row->name) ? $old_row->name : $enquiry->name; ?>
                        								            <input type="text" name="name" class="form-control" value="{{$name}}" placeholder="Name" />
                        								        </div>
                        								    </div>
                        								    <div class="col-lg-4">
                        								        <div class="form-group">
                        								            <label class="control-label">Destinations</label>
                        								            <?php
                        								            	$locations = getLocations();
                        								            	$destination_id = !empty($old_row->destination) ? $old_row->destination : $enquiry->destination;
                        								            ?>
                        								            <select class="form-control DestinationChange" name="destination" required>
                        									            <option value="">Select Hotel</option>
                        												@if(count($locations) > 0)
                        			                                        @foreach($locations as $location )
                        			                                            <option value="{{$location->id}}" {{$destination_id==$location->id ? 'selected' : ''}}>{{$location->name}}</option>
                        			                                        @endforeach
                        			                                    @endif
                        									        </select>
                        								        </div>
                        								    </div>
                                                            <?php
                                                                $attributes = getTermsById($attributesIds);
                                                            ?>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Durations</label>
                                                                    <?php
                                                                        $duration_id = !empty($old_row->duration) ? $old_row->duration : $enquiry->duration;
                                                                    ?>
                                                                    <select class="form-control DurationChange" name="duration" required>
                                                                        <option value="">Select Duration</option>
                                                                        @if(isset($attributes[12]) and count($attributes[12]) > 0 && count($attributes[12]['child']) > 0)
                                                                            @foreach($attributes[12]['child'] as $term )
                                                                                <option value="{{$term->id}}" {{$duration_id==$term->id ? 'selected' : ''}}>{{$term->name}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="">
                                                                    <label>Select Sightseeings:</label>
                                                                    <select name="sightseeing" id="multiple-checkboxes" multiple="multiple">
                                                                        @if(!empty($attributes))
                                                                        @foreach($attributes as $attribute)
                                                                            @if(strpos($attribute['parent']->slug, 'sightseeing') !== false)
                                                                                @foreach($attribute['child'] as $term )
                                                                                    <option value="{{$term->id}}">{{$term->name}} ({{$attribute['parent']->name}})</option>
                                                                                }
                                                                                }
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                        								    <div class="col-lg-4">
                        								        <div class="form-group">
                        								            <label class="control-label">Packages</label>
                        								            <?php
                        								            	$tours = getToursByLocation($destination_id);
                                                      $tour_id = (!empty($tour->id) ? $tour->id : $enquiry->object_id);
                        								            ?>
                        								            <select class="form-control TourChange" name="tour_id" required>
                        									            <option value="">Select Package</option>
                        												@if(count($tours) > 0)
                        			                                        @foreach($tours as $pack )
                        			                                            <option value="{{$pack->id}}" {{$tour_id==$pack->id ? 'selected' : ''}}>{{$pack->title}}</option>
                        			                                        @endforeach
                        			                                    @endif
                        									        </select>
                                                  <input type="hidden" name="old_tour_id" value="{{$tour_id}}">
                        								        </div>
                        								    </div>
                        								    <div class="col-lg-4">
                        								        <div class="form-group">
                        								            <label class="control-label">Start Date</label>
                                                    <?php
                                                    if (!empty($old_row->start_date)) {
                                                      $start_date = str_replace("-", "/", $old_row->start_date);
                                                    }else {
                                                      $start_date = $enquiry->approx_date;
                                                    }


                                                    ?>
                        								            <div class="calDiv">
                        								                <input type="text" name="start_date" class="form-control datePicker" value="{{$start_date}}" placeholder="Start Date" required />
                        								                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        								        	</div>
                        								    </div>
                        								</div>
                        						    </div>
                        						</div>
                        					</div>
            				@if(!empty($tour->id))
            					   <div class="panel">
            						    <div class="panel-title"><strong>Day-Wise Itinerary</strong></div>
            						    <div class="panel-body">
             								<div class="form-group-item">
            								    <div class="g-items-header">
            								        <div class="row">
            								            <div class="col-md-3">Date<br>(dd/mm/yyyy)</div>
            								            <div class="col-md-7">Plan</div>
            								        </div>
            								    </div>
            								    <div class="g-items">
                                  <?php
                                  if (!empty($row->start_date)) {
                                    $start_date = $row->start_date;
                                    $start_date = date('Y-m-d', strtotime($start_date));
                                  }else {
                                    $start_date = str_replace("/", "-", $enquiry->approx_date);
                                    $start_date = date('Y-m-d', strtotime($start_date));
                                  }
                                  if (!empty($row->default_hotels)) {
                                    $default_hotels = $row->default_hotels;
                                  }else {
                                    $default_hotels = $tour->meta->default_hotels;
                                  }
                                  ?>
            								    	<?php $rowItinerary = $row->itinerary; $i = 0; $today = $start_date?>
            								    @if(!empty($tour->itinerary))
            						            <?php if(!is_array($tour->itinerary)) $tour->itinerary = json_decode($tour->itinerary); ?>
            							            @foreach($tour->itinerary as $key=>$itinerary)
            							            <?php
            							            	$hasItinerary = isset($rowItinerary[$i]['date']) ? true : false;
            							            	$dayPlus = "+$i day";
            							            	$default_date = date('d/m/Y', strtotime($today . $dayPlus));
            							            	// dd($default_date);
            							            ?>
            							            <input type="hidden" name="itinerary[{{$i}}][image_id]" value="{{$itinerary['image_id']}}">
                                      <input type="hidden" name="itinerary[{{$i}}][title]" value="{{$itinerary['title']}}">
                                      <input type="hidden" name="itinerary[{{$i}}][desc]" value="{{$itinerary['desc']}}">
                                      <input type="hidden" name="itinerary[{{$i}}][content]" value="{{$itinerary['content']}}">
            									        <div class="item">
            									            <div class="row">
            									                <div class="col-md-3">
            									                	<div class="calDiv">
            												        <input type="text" name="itinerary[{{$i}}][date]" class="form-control datePicker" value="{{$hasItinerary ? $rowItinerary[$i]['date'] : $default_date}}" placeholder="Date" />
            												        <input type="hidden" name="itinerary[{{$i}}][time]" class="form-control" value="" placeholder="Time" />
            									                 <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
            								                </div>
            									                </div>
            									                <div class="col-md-7">{{$itinerary['desc'] ?? ""}} <br></div>
            									            </div>
            									        </div>
            									        <?php $i++; ?>
            									    @endforeach
                    							@endif
            								    </div>
            							    </div>
            							</div>
            						</div>

            						<div class="panel">
            						    <div class="panel-title"><strong>Welcome Note</strong></div>
            						    <div class="panel-body">
            						        <div class="form-group">
            						            <div class="">
            						                <textarea name="welcome_note" class="d-none has-ckeditor" cols="30" rows="10">
                                        @if(!empty($row->welcome_note)) {!! $row->welcome_note !!} @else {!! getProposalNote('welcome_note') !!} @endif
                                        </textarea>
            						            </div>
            						        </div>
            						    </div>
            						</div>
            						<div class="panel">
            						    <div class="panel-title"><strong>Term & Condations</strong></div>
            						    <div class="panel-body">
            						        <div class="form-group">
            						            <div class="">
            						                <textarea name="term_condations" class="d-none has-ckeditor" cols="30" rows="10">
                                          @if(!empty($row->term_condations)) {!! $row->term_condations !!} @else {!! getProposalNote('term_condations') !!} @endif
                                        </textarea>
            						            </div>
            						        </div>
            						    </div>
            						</div>
                        <div class="panel">
            						    <div class="panel-title"><strong>Cancellation Note</strong></div>
            						    <div class="panel-body">
            						        <div class="form-group">
            						            <div class="">
            						                <textarea name="cancellation_note" class="d-none has-ckeditor" cols="30" rows="10">
                                          @if(!empty($row->cancellation_note)) {!! $row->cancellation_note !!} @else {!! getProposalNote('cancellation_note') !!} @endif
                                        </textarea>
            						            </div>
            						        </div>
            						    </div>
            						</div>
            						<div class="panel">
            						    <div class="panel-title"><strong>Payment Policy</strong></div>
            						    <div class="panel-body">
            						        <div class="form-group">
            						            <div class="">
            						                <textarea name="tips" class="d-none has-ckeditor" cols="30" rows="10">
                                          @if(!empty($row->tips)) {!! $row->tips !!} @else {!! getProposalNote('tips') !!} @endif
                                        </textarea>
            						            </div>
            						        </div>
            						    </div>
            						</div>
                        <div class="panel">
            						    <div class="panel-title"><strong>Other/Visa Information</strong></div>
            						    <div class="panel-body">
            						        <div class="form-group">
            						            <div class="">
            						                <textarea name="other_note" class="d-none has-ckeditor" cols="30" rows="10">
                                          @if(!empty($row->other_note)) {!! $row->other_note !!} @else {!! getProposalNote('other_note') !!} @endif
                                        </textarea>
            						            </div>
            						        </div>
            						    </div>
            						</div>
            						<div class="panel">
            						    <div class="panel-title"><strong>Thanku You Note</strong></div>
            						    <div class="panel-body">
            						        <div class="form-group">
            						            <div class="">
            						                <textarea name="thankyou_note" class="d-none has-ckeditor" cols="30" rows="10">
                                          @if(!empty($row->thankyou_note)) {!! $row->thankyou_note !!} @else {!! getProposalNote('thankyou_note') !!} @endif
                                        </textarea>
            						            </div>
            						        </div>
            						    </div>
            						</div>
            					@endif
                    </div>
                    <div id="second-section">
                        <div class="panel">
                          <?php $totalSalePrice = 0; ?>
                          <div class="panel-title"><strong>Guests</strong></div>
                          <div class="panel-body">

                            <div class="form-group-item">
                                <label class="control-label">{{__('Person Types')}}</label>
                                <div class="g-items-header">
                                    <div class="row">
                                        <div class="col-md-5">{{__("Person Type")}}</div>
                                        <div class="col-md-4">{{__('Number of Person')}}</div>
                                        <div class="col-md-3">{{__('Price')}}</div>
                                    </div>
                                </div>
                                <?php
                                $total_guests = 0;
                                $default_guests = array(
                                  array("name" => "Adult","number" => null),
                                  array("name" => "Child","number" => null),
                                  array("name" => "Kid","number" => null)
                                );
                                  if (!empty($row->person_types)) {
                                    $enquiry->person_types = $row->person_types;
                                  }elseif (empty($enquiry->person_types)) {
                                    $enquiry->person_types = $default_guests;
                                  }
                                  $tour_person_types = isset($tour->meta->person_types) ? $tour->meta->person_types : array();
                                ?>
                                <div class="g-items PersonTypes">
                                    @if(!empty($enquiry->person_types))
                                        @foreach($enquiry->person_types as $key=>$person_type)
                                        <?php
                                        if(empty($person_type['name']) || $person_type['name'] == null){
                                            $person_type['name'] = $default_guests[$key]['name'];
                                        }
                                        if (empty($row->person_types)) {
                                            $array1 = getArrayByValue($tour_person_types, 'name', $person_type['name']);
                                            $person_type = array_merge($array1,$person_type);
                                          }
                                      $priceOnePerson = ($person_type['price']);

                                          $person = isset($person_type['number']) ? $person_type['number'] : 0;
                                          $totalPersonPrice = ($person_type['price'] * $person);
                                          $totalSalePrice += $totalPersonPrice;
                                          if ($person_type['price'] <= 0) {
                                            $totalPersonPrice = 0;
                                         }
                                         $total_guests += $person;
                                        ?>
                                            <div class="item">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <input type="text" name="person_types[{{$key}}][name]" class="form-control" value="{{$person_type['name'] ?? ''}}" placeholder="{{__('Eg: Adults')}}" readonly>
                                                        <input type="hidden" name="person_types[{{$key}}][desc]" class="form-control" value="{{$person_type['desc'] ?? ''}}" placeholder="{{__('Description')}}" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <input type="hidden" min="0" name="person_types[{{$key}}][min]" class="form-control" value="{{$person_type['min'] ?? 0}}" placeholder="{{__("Minimum per booking")}}">
                                                      <input type="hidden" min="0" name="person_types[{{$key}}][max]" class="form-control" value="{{$person_type['max'] ?? 0}}" placeholder="{{__("Maximum per booking")}}">


                                                      <input type="number" min="0" name="person_types[{{$key}}][number]" class="form-control bookingProposalGuest" value="{{isset($person_type['number']) ? $person_type['number'] : 0}}" placeholder="{{__("Number of Person")}}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="hidden" min="0" name="person_types[{{$key}}][price]" class="form-control priceOnePerson" value="{{$priceOnePerson ?? 0}}" placeholder="{{__("per 1 item")}}" readonly>
                                    
                                                        <input type="text" min="0" name="person_types[{{$key}}][total_price]" class="form-control totalPrice" value="{{$totalPersonPrice ?? 0}}" placeholder="{{__("per 1 item")}}" readonly>
                        
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
                          <div class="panel-title"><strong>Extra Price</strong></div>
                          <div class="panel-body">
                            <div class="form-group-item">
                                <label class="control-label">{{__('Extra Price')}}</label>
                                <div class="g-items-header">
                                    <div class="row">
                                        <div class="col-md-1">#</div>
                                        <div class="col-md-6">{{__("Name")}}</div>
                                        <div class="col-md-5">{{__('Price')}}</div>
                                    </div>
                                </div>
                                <?php
                                $extra_price1 = 0;
                                  if (!empty($row->extra_price)) {
                                    $extra_prices = $row->extra_price;
                                  }else {
                                    $extra_prices = isset($tour->meta->extra_price) ? $tour->meta->extra_price : array();
                                  }
                                ?>
                                <div class="g-items">
                                    @if(!empty($extra_prices))
                                        @foreach($extra_prices as $key=>$extra_price)
                                          <?php
                                            $extra_price1 += isset($extra_price['enable']) ? $extra_price['price'] : 0;
                                            $totalSalePrice += $extra_price1;
                                          ?>
                                            <div class="item extra_price_item" data-number="{{$key}}">
                                                <div class="row">
                                                  <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label><input type="checkbox" class="bookingProposalExtra" name="extra_price[{{$key}}][enable]" value="1" {{isset($extra_price['enable']) ? 'checked' : ''}}></label>
                                                    </div>
                                                  </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="extra_price[{{$key}}][name]" class="form-control" value="{{$extra_price['name'] ?? ''}}" placeholder="{{__('Extra price name')}}" readonly>
                                                        <input type="hidden" name="extra_price[{{$key}}][type]" class="form-control" value="{{$extra_price['type'] ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="hidden" min="0" name="extra_price[{{$key}}][price]" class="form-control" value="{{$extra_price['price']}}" readonly>
                                                        <input type="text" min="0" name="extra_price[{{$key}}][total]" class="form-control totalPrice" value="{{$extra_price['price']}}" readonly>
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
                          <div class="panel-title"><strong>Discount by number of people</strong></div>
                          <div class="panel-body">
                            <div class="form-group-item">
                                <div class="g-items-header">
                                    <div class="row">
                                        <div class="col-md-4">No of people</div>
                                        <div class="col-md-3">Discount</div>
                                        <div class="col-md-3">Type</div>
                                        <div class="col-md-1"></div>
                                    </div>
                                </div>
                                <?php
                                  if (!empty($row->discount_by_people)) {
                                    $discount_by_people = $row->discount_by_people;
                                  }else {
                                    $discount_by_people = isset($tour->meta->discount_by_people) ? $tour->meta->discount_by_people : array();
                                  }
                                  $total_discount_by_people = 0;
                                  $transfers_price = $custom_tour['transfers_price'] * $total_guests;
                                  if ($discount_by_people and !empty($discount_by_people)) {
                                        foreach ($discount_by_people as $type) {
                                            if ($type['from'] <= $total_guests and (!$type['to'] or $type['to'] >= $total_guests)) {

                                                $type_total = 0;
                                                switch ($type['type']) {
                                                    case "fixed":
                                                        $type_total = $type['amount'];
                                                        break;
                                                    case "percent":
                                                        $type_total = $transfers_price / 100 * $type['amount'];
                                                        break;
                                                }
                                                $totalSalePrice -= $type_total;
                                                $total_discount_by_people += $type_total;
                                            }
                                        }
                                    }
                                ?>
                                <div class="g-items">
                                @if(!empty($discount_by_people))
                                    @foreach($discount_by_people as $key=>$discount)
                                    <div class="item" data-number="0">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="number" min="0" name="discount_by_people[{{$key}}][from]" class="form-control" value="{{$discount['from'] ?? ''}}" placeholder="From" readonly />
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" min="0" name="discount_by_people[{{$key}}][to]" class="form-control" value="{{$discount['to'] ?? ''}}" placeholder="To" readonly />
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" min="0" name="discount_by_people[{{$key}}][amount]" class="form-control" value="{{$discount['amount'] ?? ''}}" readonly />
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="discount_by_people[{{$key}}][type]" class="form-control" value="{{$discount['type'] ?? ''}}" readonly />
                                            </div>
                                            <div class="col-md-1">
                                                
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
          						    <div class="panel-title"><strong>Tour Price</strong></div>
          						    <div class="panel-body">
                            <div class="row TotalPriceSection">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">{{__("Total Price")}}</label>
                                        <input type="number" min="0" name="total_price" class="form-control TotalPrice" value="{{$totalSalePrice}}" placeholder="{{__("Tour Price")}}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">{{__("Total Extra Price")}}</label>
                                        <input type="text" name="total_extra_price" class="form-control TotalExtraPrice" value="{{$extra_price1}}" placeholder="{{__("Extra Price Price")}}" readonly="">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">{{__("Discount by people")}}</label>
                                        <input type="text" name="total_discount_by_people" class="form-control DiscountByPeople" value="{{$total_discount_by_people}}" placeholder="{{__("discount_by_people")}}" readonly="">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">{{__("Discount")}}</label>
                                        <input type="number" name="discount" class="form-control PraposalDiscount" value="{{$row->discount}}" placeholder="{{__("Extra Discount")}}">
                                    </div>
                                </div>
                                <?php
                                if ($row->discount > 0) {
                                  $totalSalePrice += abs($row->discount);
                                }else {
                                  $totalSalePrice -= abs($row->discount);
                                }
                                ?>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">{{__("Total Sale Price")}}</label>
                                        <input type="text" name="total_tour_price" class="form-control proposalSalePrice" value="{{$totalSalePrice}}" placeholder="{{__("Tour Sale Price")}}" readonly="">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <span>
                                        {{__("If the regular price is less than the discount , it will show the regular price")}}
                                    </span>
                                </div>
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
                                    <button class="btn btn-primary submitBookingProposal" type="submit"><i class="fa fa-save"></i>{{__('Save Changes')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
