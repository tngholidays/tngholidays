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
                    <h1 class="title-bar">{{$row->id ? __('Booking Praposal: ').$row->title : __('Booking Proposal')}}</h1>
                </div>
                @if(!empty($row))
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
                        								            <select class="form-control DestinationChange" name="destination">
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
                                                                    <select class="form-control DurationChange" name="duration">
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
                        								            <select class="form-control TourChange" name="tour_id">
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
                                        <div class="panel-title"><strong>Day-Wise Itinerary</strong>
                                        <a href="#" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Itinerary</a>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group-item">
                                                <div class="g-items-header">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            Date<br />
                                                            (dd/mm/yyyy)
                                                        </div>
                                                        <div class="col-md-10">Plan</div>
                                                    </div>
                                                </div>
                                                <div class="g-items">
                                                    <?php
                                                        $i = 0; $tour_activities = $booking->activities();
                                                    ?> 
                                                    @if(!empty($tour_activities)) 
                                                    @foreach($tour_activities as $key=>$summary)
                                                    <?php $default_date = date('d/m/Y', strtotime($summary['date'])); ?>
                                                    <div class="item">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <p><strong>{{$summary['date'] ? $summary['date'] : ''}}, Day {{$key+1}}</strong></p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                @if(!empty($summary['breackfast']))
                                                                <div class="row">
                                                                    <div class="col-md-12">{{$summary['breackfast'] ?? ""}} <br /></div>
                                                                </div>
                                                                @endif 
                                                                @if(count($summary['transfer']) > 0)
                                                                @foreach($summary['transfer'] as $keyy =>$transfer)
                                                                <div class="row">
                                                                    <div class="col-md-12">{{$transfer['name'] ?? ""}} <br /></div>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                                @if(count($summary['hotel']) > 0)
                                                                <div class="row">
                                                                    <div class="col-md-12">{{$summary['hotel']['hotel_name'] ?? ""}} <br /></div>
                                                                </div>
                                                                @endif 
                                                                @if(count($summary['morning_activity']) > 0) @foreach($summary['morning_activity'] as $key=>$activity)
                                                                <div class="row">
                                                                    <div class="col-md-12">{{$activity['name'] ?? ""}} <br /></div>
                                                                </div>
                                                                @endforeach @endif @if(count($summary['activity']) > 0) @foreach($summary['activity'] as $key=>$activity)
                                                                <div class="row">
                                                                    <div class="col-md-12">{{$activity['name'] ?? ""}} <br /></div>
                                                                </div>
                                                                @endforeach @endif @if(count($summary['evening_activity']) > 0) @foreach($summary['evening_activity'] as $key=>$activity)
                                                                <div class="row">
                                                                    <div class="col-md-12">{{$activity['name'] ?? ""}} <br /></div>
                                                                </div>
                                                                @endforeach @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-title"><strong>Tour Price</strong></div>
                                        <div class="panel-body">
                                            <div class="email_new_booking">
                                                <?php
                                                    $translation = $tour->translateOrOrigin(app()->getLocale());
                                                    $lang_local = app()->getLocale();
                                                    $hotel_rooms = json_decode($booking->getMeta('hotel_rooms'), true);
                                                    ;
                                                    ?>
                                                    <div class="b-table-wrap">
                                                        <table class="b-table table table-bordered">
                                                            <tr>
                                                                <td class="label">{{__('Booking Number')}}</td>
                                                                <td class="val">#{{$booking->id}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label">{{__('Booking Status')}}</td>
                                                                <td class="val">{{$booking->statusName}}</td>
                                                            </tr>
                                                            @if($booking->gatewayObj)
                                                                <tr>
                                                                    <td class="label">{{__('Payment method')}}</td>
                                                                    <td class="val">{{$booking->gatewayObj->getOption('name')}}</td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td class="label">{{__('Tour name')}}</td>
                                                                <td class="val">
                                                                    <a href="{{$tour->getDetailUrl()}}">{!! clean($translation->title) !!}</a>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                @if($translation->address)
                                                                    <td class="label">{{__('Address')}}</td>
                                                                    <td class="val">
                                                                        {{$translation->address}}
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            @if($booking->start_date && $booking->end_date)
                                                                <tr>
                                                                    <td class="label">{{__('Start date')}}</td>
                                                                    <td class="val">{{display_date($booking->start_date)}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="label">{{__('Duration:')}}</td>
                                                                    <td class="val">
                                                                        {{human_time_diff($booking->end_date,$booking->start_date)}}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @php $person_types = $booking->getJsonMeta('person_types')
                                                            @endphp
                                                            

                                                            @if(!empty($person_types))
                                                                @foreach($person_types as $type)
                                                                    <tr>
                                                                        <td class="label">{{$type['name']}}:</td>
                                                                        <td class="val">
                                                                            <strong>{{$type['number']}}</strong>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td class="label">{{__("Guests")}}:</td>
                                                                    <td class="val">
                                                                        <strong>{{$booking->total_guests}}</strong>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            <?php $totalHotelPrice = 0; ?>
                                                            @if(!empty($booking->default_hotels) && $booking->default_hotels != "null")
                                                                <tr>
                                                                    <td class="label">{{__("Hotels")}}:</td>
                                                                        <td class="val no-r-padding">
                                                                            <table class="pricing-list" width="100%">
                                                                                <tr>
                                                                                    <th class="label">Location</th>
                                                                                    <th class="label">Hotel</th>
                                                                                    <th class="label">Room</th>
                                                                                </tr>
                                                                                @if(json_decode($booking->default_hotels, true) > 0)
                                                                                @foreach (json_decode($booking->default_hotels, true) as $indx => $hotel)
                                                                                <?php $hotelDDetail = getHotelById($hotel['hotel']); $totalHotelPrice += $hotel['total_price'] ?>
                                                                                    <tr>
                                                                                        <td class="label">{{@getLocationById($hotel['location_id'])->name}}</td>
                                                                                        <td class="label">{{@$hotelDDetail->title}} </td>
                                                                                        <td class="label">{{@getRoomsById($hotel['room'])->title}}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                                @endif
                                                                            </table>
                                                                            <br>
                                                                            <table class="table table-bordered" width="100%">
                                                                                <tr>
                                                                                    <th class="label">Room</th>
                                                                                    <th class="label">Persons</th>
                                                                                </tr>
                                                                                @if($hotel_rooms > 0)
                                                                                @foreach ($hotel_rooms as $indx => $room)
                                                                                    <tr>
                                                                                        <td class="label">Room {{$room['room']}}</td>
                                                                                        <td class="label">
                                                                                            <strong>Adult :</strong> {{$room['adults']}},
                                                                                            <strong>Child :</strong> {{$room['children']}}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                                @endif
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                <tr>
                                                            @endif
                                                            
                                                                <td class="label">{{__('Pricing')}}</td>
                                                                <td class="val no-r-padding">
                                                                    <table class="pricing-list" width="100%">
                                                                        @php $person_types = $booking->getJsonMeta('person_types')
                                                                        @endphp
                                                                        <?php $default_pkg_price = 0;  ?>
                                                                        @if(!empty($person_types))
                                                                            @foreach($person_types as $type)
                                                                             
                                                                                <tr>
                                                                                    <td class="label">{{$type['name']}}: {{$type['number']}} * {{format_money($type['price'])}}</td>
                                                                                    <td class="val no-r-padding">
                                                                                        <strong>{{format_money($type['price'] * $type['number'])}}</strong>
                                                                                        <?php $base_price = $type['price'] * $type['number']; 
                                                                                         $default_pkg_price += $base_price;
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                        
                                                                            <tr>
                                                                                <td class="label">{{__("Guests")}}: {{$booking->total_guests}} {{format_money($booking->getMeta('base_price'))}}</td>
                                                                                <td class="val no-r-padding">
                                                                                    <strong>{{format_money($booking->getMeta('base_price') * $booking->total_guests)}}</strong>
                                                                                    <?php 
                                                                                    $base_price = $booking->getMeta('base_price') * $booking->total_guests; 
                                                                                    $default_pkg_price += $base_price;
                                                                                    ?>

                                                                                </td>
                                                                            </tr>
                                                                        @endif

                                                                        @if(!empty($booking->applied_coupon) && $booking->applied_coupon != "null")
                                                                        <?php
                                                                            $applied_coupon = json_decode($booking->applied_coupon, true);
                                                                            if (!empty($applied_coupon)) {
                                                                                if ($applied_coupon['discount_type'] == 2) {
                                                                                    $coupon_dis_amount = ($base_price*$applied_coupon['discount'])/100;
                                                                                }else{
                                                                                    $coupon_dis_amount = $applied_coupon['discount'];
                                                                                }
                                                                            }
                                                                        ?>
                                                                            <tr>
                                                                                <td colspan="2" class="label-title"><strong>{{__("Coupon Discount:")}}</strong></td>
                                                                            </tr>
                                                                            <tr class="">
                                                                                <td colspan="2" class="no-r-padding no-b-border">
                                                                                    <table width="100%">
                                                                                        <tr>
                                                                                            <td class="label">
                                                                                                {{$applied_coupon['code']}}
                                                                                                :
                                                                                            </td>
                                                                                            <td class="val no-r-padding">
                                                                                                <strong>- {{format_money($coupon_dis_amount ?? 0)}}</strong>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                        @php $extra_price = $booking->getJsonMeta('extra_price');
                                                                            $totalExtraPrice = 0;
                                                                        @endphp

                                                                        @if(!empty($extra_price))
                                                                            <tr>
                                                                                <td colspan="2" class="label-title"><strong>{{__("Extra Charges:")}}</strong></td>
                                                                            </tr>
                                                                            <tr class="">
                                                                                <td colspan="2" class="no-r-padding no-b-border">
                                                                                    <table width="100%">
                                                                                    @foreach($extra_price as $type)
                                                                                        <tr>
                                                                                            <td class="label">{{$type['name']}}:</td>
                                                                                            <td class="val no-r-padding">
                                                                                                <strong>{{format_money($type['total'] ?? 0)}}</strong>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php $totalExtraPrice += $type['total'] ?? 0; ?>
                                                                                    @endforeach
                                                                                    </table>
                                                                                </td>
                                                                            </tr>

                                                                        @endif

                                                                         @php $discount_by_people = $booking->getJsonMeta('discount_by_people');
                                                                        $discount_by_peoplePrice = 0;
                                                                        @endphp
                                                                        @if(!empty($discount_by_people))
                                                                            <tr>
                                                                                <td colspan="2" class="label-title"><strong>{{__("Discounts:")}}</strong></td>
                                                                            </tr>
                                                                            <tr class="">
                                                                                <td colspan="2" class="no-r-padding no-b-border">
                                                                                    <table width="100%">
                                                                                    @foreach($discount_by_people as $type)
                                                                                        <tr>
                                                                                            <td class="label">
                                                                                                @if(!$type['to'])
                                                                                                    {{__('from :from guests',['from'=>$type['from']])}}
                                                                                                @else
                                                                                                    {{__(':from - :to guests',['from'=>$type['from'],'to'=>$type['to']])}}
                                                                                                @endif
                                                                                                :
                                                                                            </td>
                                                                                            <td class="val no-r-padding">
                                                                                                <strong>- {{format_money($type['total'] ?? 0)}}</strong>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php  $discount_by_peoplePrice += $type['total'] ?? 0; ?>
                                                                                    @endforeach
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                         <?php $modify_price_room = $booking->total - $default_pkg_price;?>
                                                                        @if($modify_price_room > 0)
                                                                            <tr>
                                                                                <td class="label">
                                                                                   Modify Price
                                                                                </td>
                                                                                <td class="val">
                                                                                     {{format_money($modify_price_room)}}
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                        @if(!empty($booking->proposal_discount) && $booking->proposal_discount != 'null')
                                                                            <tr>
                                                                                <td class="label">
                                                                                   {{($booking->proposal_discount > 0) ? 'Service Changes' : 'Extra Discount' }}
                                                                                </td>
                                                                                <td class="val">
                                                                                  @if($booking->proposal_discount > 0)
                                                                                  <?php  $booking->total_before_fees = $booking->total_before_fees + abs($booking->proposal_discount); ?>
                                                                                  + {{format_money(abs($booking->proposal_discount))}}
                                                                                  @else
                                                                                  <?php  $booking->total_before_fees = $booking->total_before_fees - abs($booking->proposal_discount); ?>
                                                                                  - {{format_money(abs($booking->proposal_discount))}}
                                                                                  @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <td class="label">
                                                                               Sub Total
                                                                            </td>
                                                                            <td class="val">
                                                                                {{format_money($booking->total)}}
                                                                            </td>
                                                                        </tr>
                                                                        @php
                                                                            $list_all_fee = [];
                                                                            if(!empty($booking->buyer_fees)){
                                                                                $buyer_fees = json_decode($booking->buyer_fees , true);
                                                                                $list_all_fee = $buyer_fees;
                                                                            }
                                                                            if(!empty($vendor_service_fee = $booking->vendor_service_fee)){
                                                                                $list_all_fee = array_merge($list_all_fee , $vendor_service_fee);
                                                                            }
                                                                        @endphp
                                                                        @if(!empty($list_all_fee))
                                                                            @foreach ($list_all_fee as $item)
                                                                                @php
                                                                                    $fee_price = $item['price'];
                                                                                    if(!empty($item['unit']) and $item['unit'] == "percent"){
                                                                                        $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];
                                                                                    }
                                                                                @endphp
                                                                                <tr>
                                                                                    <td class="label">
                                                                                        {{$item['name_'.$lang_local] ?? $item['name']}}
                                                                                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $item['desc_'.$lang_local] ?? $item['desc'] }}"></i>
                                                                                        @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                                                                            : {{$booking->total_guests}} * {{format_money( $fee_price )}}
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="val">
                                                                                        @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                                                                            {{ format_money( $fee_price * $booking->total_guests ) }}
                                                                                        @else
                                                                                            {{ format_money( $fee_price ) }}
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif

                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label fsz21">{{__('Total')}}  <button class="btn btn-primary text-right" type="button" data-toggle="modal" data-target="#costSummaryModal">Cost Summary</button></td>
                                                                <td class="val fsz21"><strong style="color: #FA5636">{{format_money($booking->total)}}</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label fsz21">{{__('Hotel Price')}}</td>
                                                                <td class="val fsz21"><strong style="color: #FA5636">{{format_money($totalHotelPrice)}}</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label fsz21">{{__('Paid')}}</td>
                                                                <td class="val fsz21"><strong style="color: #FA5636">{{format_money($booking->paid)}}</strong></td>
                                                            </tr>
                                                            @if($booking->total > $booking->paid)
                                                                <tr>
                                                                    <td class="label fsz21">{{__('Remain')}}</td>
                                                                    <td class="val fsz21"><strong style="color: #FA5636">{{format_money($booking->total - $booking->paid)}}</strong></td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>

                                            </div>
                                            <div class="row TotalPriceSection">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">{{__("Total Price")}}</label>
                                                        <input type="number" min="0" name="total_price" class="form-control TotalPrice" value="{{$booking->total}}" placeholder="{{__("Tour Price")}}" readonly>
                                                    </div>
                                                </div>
                                                <?php
                                                    $total_sale_price = $booking->total;
                                                    if (!empty($booking->proposal_discount)) {
                                                        if ($booking->proposal_discount < 0) {
                                                            $total_sale_price = $booking->total - abs($booking->proposal_discount);
                                                        }else{
                                                            $total_sale_price = $booking->total + abs($booking->proposal_discount);
                                                        }
                                                    }
                                                 ?>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">{{__("Discount")}}</label>
                                                        <input type="number" name="discount" class="form-control vendorProposalDis" value="{{ $booking->proposal_discount }}" placeholder="{{__("Extra Discount")}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">{{__("Total Proposal Price")}}</label>
                                                        <input type="text" name="total_tour_price" class="form-control proposalSalePrice" value="{{round($total_sale_price)}}" placeholder="{{__("Tour Sale Price")}}" readonly="">
                                                    </div>
                                                </div>
                                                <?php $admin_remark = $booking->getMeta('admin_remark') ?>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{__("Remark")}}</label>
                                                        <textarea name="admin_remark" class="form-control full-h" placeholder="...">{{$admin_remark}}</textarea>
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
    <div class="modal fade" id="costSummaryModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="display: initial!important;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cost Summary</h4>
                </div>
                <div class="modal-body table-responsive">
                    <div class="b-table-wrap">
                        <?php
                        $totalGuest = $booking->total_guests;
                        $car = null;
                        if($booking->total_guests <= 3) {
                            $car .= "Small";
                        }
                        if ($booking->total_guests >= 4 and $booking->total_guests <= 5) {
                            $car .= "Big";
                        }
                        if ($booking->total_guests >= 6 and $booking->total_guests <= 10) {
                            $car .= "Van";
                        }
                        if ($booking->total_guests >= 10 and $booking->total_guests <= 15) {
                            $car .= "Big Car & Van";
                        }
                        if ($booking->total_guests >= 16 and $booking->total_guests <= 20) {
                            $car .= "Two Van";
                        }
                        if ($booking->total_guests >= 20 and $booking->total_guests <= 25) {
                            $car .= "One Big Car & Two Van";
                        }
                        if ($booking->total_guests >= 25 and $booking->total_guests <= 30) {
                            $car .= "Three Van";
                        }
                        ?>
                        <h4>Required Car Type : {{$car}} - Adults : <strong>{{$booking->total_guests}}</strong></h4>
                        <table class="b-table table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Activity</th>
                                    <th>Price</th>
                                    <th>Price THB</th>
                                    <th>Per Pax</th>
                                    <th>Transfer Price</th>
                                    <th>THB</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $before_sale_price = !empty($booking->getMeta('before_sale_price')) ? $booking->getMeta('before_sale_price') : 0;
                                    $totalPrice = 0;
                                    $totalTransPrice = 0;

                                    $totalPriceTHB = 0;
                                    $totalTransDis = 0;
                                    $totalTransDisTHB = 0;
                                    $ii = 1;
                                    $before_sale_price = ($before_sale_price > $discount_by_peoplePrice) ? $before_sale_price-$discount_by_peoplePrice : $before_sale_price;
                                ?>
                                @if(!empty($tour_activities)) 
                                    @foreach($tour_activities as $key=>$summary)

                                    @if(count($summary['transfer']) > 0)
                                        @foreach($summary['transfer'] as $keyy => $transfer)
                                        <?php 
                                            $transfer_price = $transfer['transfer_price'] ?? 0;
                                        ?>
                                        <tr>
                                            <td>{{$ii}}</td>
                                            <td>{{$transfer['name'] ?? ""}}</td>
                                            <td>0</td>
                                            <td>0</td>
                                             <td>0</td>
                                            <td>{{$transfer_price}}</td>
                                            <td>{{($transfer_price > 0) ? $transfer_price/2.5 : 0}}</td>
                                        </tr>
                                        <?php 
                                        $totalTransPrice += $transfer_price;
                                        $ii++;
                                        ?>
                                        @endforeach
                                    @endif

                                    @if(count($summary['hotel']) > 0)
                                    <?php  $summary['hotel']['total_price'] = floatval($summary['hotel']['total_room_price']);
                                        ?>
                                        <tr>
                                            <td>{{$ii}}</td>
                                            <td>{{$summary['hotel']['hotel_name'] ?? ""}} <br> <strong>({{ $summary['hotel']['days']*2 ?? ""}} NIGHT)</strong>, <strong>Room Price {{$summary['hotel']['room_price']/2.5 ?? ""}}</strong>,<br> <strong>Room {{$summary['hotel']['room_name'] ?? ""}}</strong></td>
                                            <td>{{$summary['hotel']['total_room_price'] ?? ""}}</td>
                                            <td>{{$summary['hotel']['total_price']/2.5}}</td>
                                            <td>{{($summary['hotel']['total_price']/2.5)/$booking->total_guests }}</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <?php 
                                        $totalPrice += $summary['hotel']['total_room_price'] ?? 0;
                                        $totalPriceTHB += $summary['hotel']['total_price']/2.5 ?? 0;;
                                        $ii++;
                                        ?>
                                    @endif

                                    @if(count($summary['morning_activity']) > 0) 
                                        @foreach($summary['morning_activity'] as $key=>$activity)
                                        <?php 
                                            $activity['price'] = isset($activity['price']) ? floatval($activity['price'])*$booking->total_guests : 0;
                                            $transfer_price = $activity['transfer_price'] ?? 0;
                                            ?>
                                        <tr>
                                            <td>{{$ii}}</td>
                                            <td>{{$activity['name'] ?? ""}}</td>
                                            <td>{{$activity['price'] ?? ""}}</td>
                                            <td>{{$activity['price']/2.5}}</td>
                                            <td>{{($activity['price']/2.5)/$booking->total_guests }}</td>
                                            <td>{{$transfer_price}}</td>
                                            <td>{{($transfer_price > 0) ? $transfer_price/2.5 : 0}}</td>
                                        </tr>
                                        <?php 
                                        $totalPrice += $activity['price'] ?? 0;
                                        $totalTransPrice += $transfer_price;
                                        $totalPriceTHB += $activity['price']/2.5 ?? 0;
                                        $ii++;
                                        ?>
                                        @endforeach
                                    @endif

                                    @if(count($summary['activity']) > 0) 
                                        @foreach($summary['activity'] as $key=>$activity)
                                        <?php 
                                                $activity['price'] = isset($activity['price']) ? floatval($activity['price'])*$booking->total_guests : 0;
                                                $transfer_price = $activity['transfer_price'] ?? 0;
                                        ?>
                                        <tr>
                                            <td>{{$ii}}</td>
                                            <td>{{$activity['name'] ?? ""}}</td>
                                            <td>{{$activity['price'] ?? ""}}</td>
                                            <td>{{$activity['price']/2.5}}</td>
                                            <td>{{($activity['price']/2.5)/$booking->total_guests }}</td>
                                            <td>{{$transfer_price}}</td>
                                            <td>{{($transfer_price > 0) ? $transfer_price/2.5 : 0}}</td>
                                        </tr>
                                        <?php 
                                        $totalPrice += $activity['price'] ?? 0;
                                        $totalTransPrice += $transfer_price;
                                        $totalPriceTHB += $activity['price']/2.5 ?? 0;
                                        $ii++;
                                        ?>
                                        @endforeach
                                    @endif

                                    @if(count($summary['evening_activity']) > 0) 
                                        @foreach($summary['evening_activity'] as $key=>$activity)
                                         <?php 
                                            $activity['price'] = isset($activity['price']) ? floatval($activity['price'])*$booking->total_guests : 0;
                                             $transfer_price = $activity['transfer_price'] ?? 0;
                                             ?>
                                        <tr>
                                            <td>{{$ii}}</td>
                                            <td>{{$activity['name'] ?? ""}}</td>
                                            <td>{{$activity['price'] ?? ""}}</td>
                                            <td>{{$activity['price']/2.5}}</td>
                                            <td>{{($activity['price']/2.5)/$booking->total_guests }}</td>
                                            <td>{{$transfer_price}}</td>
                                            <td>{{($transfer_price > 0) ? $transfer_price/2.5 : 0}}</td>
                                        </tr>
                                        <?php 
                                        $totalPrice += $activity['price'] ?? 0;
                                        $totalTransPrice += $transfer_price;
                                        $totalPriceTHB += $activity['price']/2.5 ?? 0;
                                        $ii++;
                                        ?>
                                        @endforeach
                                    @endif
                                @endforeach @endif
                                <tr>
                                    <th colspan="2">
                                        Sub Total Amount
                                    </th>
                                    <th>
                                        Rs. {{$totalPrice}}
                                    </th>
                                    <th>
                                        TBH. {{$totalPriceTHB}}
                                    </th>
                                    <th>
                                        TBH. {{$totalPriceTHB/$booking->total_guests}}
                                    </th>

                                    <th>
                                        Rs. {{$totalTransPrice}}
                                    </th>
                                     <th colspan="2">
                                        TBH. {{$totalTransPrice/2.5}}
                                    </th>
                                </tr>
                                 <tr>
                                    <th colspan="2">
                                        Total Amount
                                    </th>
                                    <th>
                                        Total Price {{$totalPrice+$totalTransPrice}}
                                    </th>
                                    <th>
                                        Total Margin {{$before_sale_price}}
                                    </th>
                                    <th>
                                        Total Extra {{$totalExtraPrice}}
                                    </th>
                                    <th>
                                        Total Amount {{($totalPrice+$totalTransPrice)+$before_sale_price+$totalExtraPrice}}
                                    </th>
                                    <th colspan="2">
                                        Total Price TBH {{($totalTransPrice+$totalPriceTHB)/2.5}}
                                    </th>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
