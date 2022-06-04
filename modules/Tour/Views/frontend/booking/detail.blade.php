@php $lang_local = app()->getLocale() @endphp
<div class="booking-review">
    <h4 class="booking-review-title">{{__("Your Booking")}}</h4>
    <div class="booking-review-content">
        <div class="review-section">
            <div class="service-info">
                <div>
                    @php
                        $service_translation = $service->translateOrOrigin($lang_local);
                    @endphp
                    <h3 class="service-name"><a href="{{$service->getDetailUrl()}}">{!! clean($service_translation->title) !!}</a></h3>
                    @if($service_translation->address)
                        <p class="address"><i class="fa fa-map-marker"></i>
                            {{$service_translation->address}}
                        </p>
                    @endif
                </div>
                @php $vendor = $service->author; @endphp
                @if($vendor->hasPermissionTo('dashboard_vendor_access') and !$vendor->hasPermissionTo('dashboard_access'))
                    <div class="mt-1">
                        <i class="icofont-info-circle"></i>
                        {{ __("Vendor") }}: <a href="{{route('user.profile',['id'=>$vendor->id])}}" target="_blank" >{{$vendor->getDisplayName()}}</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="review-section">
            <ul class="review-list">
                @if($booking->start_date)
                    <li>
                        <div class="label">{{__('Start date:')}}</div>
                        <div class="val">
                            {{display_date($booking->start_date)}}
                        </div>
                    </li>
                    <li>
                        <div class="label">{{__('Duration:')}}</div>
                        <div class="val">
                            {{human_time_diff($booking->end_date,$booking->start_date)}}
                        </div>
                    </li>
                @endif
                @php $person_types = $booking->getJsonMeta('person_types')@endphp
                @if(!empty($person_types))
                    @foreach($person_types as $type)
                        <li>
                            <div class="label">{{$type['name_'.$lang_local] ?? __($type['name'])}}:</div>
                            <div class="val">
                                {{$type['number']}}
                            </div>
                        </li>
                    @endforeach
                @else
                    <li>
                        <div class="label">{{__("Guests")}}:</div>
                        <div class="val">
                            {{$booking->total_guests}}
                        </div>
                    </li>
                @endif

            </ul>
        </div>
        {{--@include('Booking::frontend/booking/checkout-coupon')--}}
    @if(!empty($booking->default_hotels) && $booking->default_hotels != "null")
        <div class="review-section total-review bookedHotels">
            @if(json_decode($booking->default_hotels, true) > 0)
                <div class="form-section-group form-group">
                @foreach (json_decode($booking->default_hotels, true) as $indx => $hotel)
                @if(!empty($hotel['hotel']))
                <?php $hotelDDetail = getHotelById($hotel['hotel']); ?>
                    <div class="form-group">
                        <div class="img">
                            <img src="{{url('/uploads').'/'.getImageUrlById($hotelDDetail->image_id)}}" alt="img" width="100px">
                        </div>
                        <div class="otherDetails">
                            <h5 class="name hotelName">{{$hotelDDetail->title}}</h5>
                            <span class="locationn">{{getLocationById($hotel['location_id'])->name}}</span>
                            <div class="type">
                                <!-- <p class="type">Room Type</p> -->
                                <p class="roomName"><strong>{{@getRoomsById($hotel['room'])->title}}</strong></p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                </div>
            @endif
        </div>
    @endif
        @do_action('booking.checkout.before_total_review')
        <div class="review-section total-review">
            <ul class="review-list">
                @php $person_types = $booking->getJsonMeta('person_types') @endphp
                <?php $default_pkg_price = 0;  ?>
                @if(!empty($person_types))
                    @foreach($person_types as $type)
                        <li>
                            <div class="label">{{ $type['name_'.$lang_local] ?? __($type['name'])}}: {{$type['number']}} * {{format_money($type['price'])}}</div>
                            <div class="val">
                                {{format_money($type['price'] * $type['number'])}}
                                <?php 
                                    $base_price = $type['price'] * $type['number']; 
                                    $default_pkg_price += $base_price;
                                ?>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li>
                        <div class="label">{{__("Guests")}}: {{$booking->total_guests}} * {{format_money($booking->getMeta('base_price'))}}</div>
                        <div class="val">
                            {{format_money($booking->getMeta('base_price') * $booking->total_guests)}}
                            <?php $base_price = $booking->getMeta('base_price') * $booking->total_guests; ?>
                        </div>
                    </li>
                @endif

                <?php  $coupon_dis_amount = 0; ?>
                @if(!empty($booking->applied_coupon) && $booking->applied_coupon != 'null')
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
                    <li>
                        <div class="label-title"><strong>{{__("Coupon:")}}</strong></div>
                    </li>
                    <li class="no-flex checkOutCoupon">
                        <div class="coupon-list">
                            <div class="code-block">
                                <div class="img-block">
                                    <i class="fa fa-gift" aria-hidden="true"></i>
                                    <span class="coupon-code">{{$applied_coupon['code']}}</span>
                                </div>
                                <button class="btn btn-sm btn-primary"><i class="fa fa-inr" aria-hidden="true"></i> {{$coupon_dis_amount}}</button>
                            </div>
                            <div class="note-block">
                                <span class="coupon-note">
                                  Discount of INR {{$coupon_dis_amount}} Applied
                                </span>
                            </div>
                        </div>
                    </li>
                @endif

                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price))
                    <li>
                        <div class="label-title"><strong>{{__("Extra Charges:")}}</strong></div>
                    </li>
                    <li class="no-flex">
                        <ul>
                            @foreach($extra_price as $type)
                                <li>
                                    <div class="label">{{$type['name_'.$lang_local] ?? __($type['name'])}}:</div>
                                    <div class="val">
                                        {{format_money($type['total'] ?? 0)}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                @php $discount_by_people = $booking->getJsonMeta('discount_by_people')@endphp
                @if(!empty($discount_by_people))
                    <li>
                        <div class="label-title"><strong>{{__("Discounts:")}}</strong></div>
                    </li>
                    <li class="no-flex">
                        <ul>
                            @foreach($discount_by_people as $type)
                                <li>
                                    <div class="label">
                                        @if(!$type['to'])
                                            {{__('from :from guests',['from'=>$type['from']])}}
                                        @else
                                            {{__(':from - :to guests',['from'=>$type['from'],'to'=>$type['to']])}}
                                        @endif
                                        :
                                    </div>
                                    <div class="val">
                                        - {{format_money($type['total'] ?? 0)}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif

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
                <?php 
                    $modify_price_room = $booking->total - $default_pkg_price;

                ?>

            @if($modify_price_room > 0)
                <li>
                    <div class="label">
                        Modify Price
                    </div>
                    <div class="val">
                        {{format_money($modify_price_room)}}
                    </div>
                </li>
            @endif
            <?php /*
            @if(!empty($booking->modify_price))
            <?php $modify_price = abs($booking->modify_price) * $booking->total_guests; ?>
                <li>
                    <div class="label">
                        Modify Price
                    </div>
                    <div class="val">
                        @if($booking->modify_price > 0)
                        <?php  $booking->total_before_fees = $booking->total_before_fees + $modify_price; ?>
                        + {{format_money($modify_price)}}
                        @else
                        <?php  $booking->total_before_fees = $booking->total_before_fees - $modify_price; ?>
                        - {{format_money($modify_price)}}
                        @endif
                    </div>
                </li>
            @endif
            */ ?>

            @if(!empty($booking->proposal_discount) && $booking->proposal_discount != 'null')
                <li>
                    <div class="label">
                        {{($booking->proposal_discount > 0) ? 'Service Changes' : 'Extra Discount' }}
                    </div>
                    <div class="val">
                        @if($booking->proposal_discount > 0)
                        <?php  $booking->total_before_fees = $booking->total_before_fees + abs($booking->proposal_discount); ?>
                        + {{format_money(abs($booking->proposal_discount))}}
                        @else
                        <?php  $booking->total_before_fees = $booking->total_before_fees - abs($booking->proposal_discount); ?>
                        - {{format_money(abs($booking->proposal_discount))}}
                        @endif
                    </div>
                </li>
            @endif
            <li>
                    <div class="label">
                        Sub Total
                    </div>
                    <div class="val">
                       {{format_money($booking->total)}}
                    </div>
                </li>
                @if(!empty($list_all_fee))
                    @foreach ($list_all_fee as $item)
                        @php
                            $fee_price = $item['price'];
                            if(!empty($item['unit']) and $item['unit'] == "percent"){
                                $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];
                            }
                        @endphp
                        <li>
                            <div class="label">
                                {{$item['name_'.$lang_local] ?? $item['name']}}
                                <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $item['desc_'.$lang_local] ?? $item['desc'] }}"></i>
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    : {{$booking->total_guests}} * {{format_money( $fee_price )}}
                                @endif
                            </div>
                            <div class="val">
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    {{ format_money( $fee_price * $booking->total_guests ) }}
                                @else
                                    {{ format_money( $fee_price ) }}
                                @endif
                            </div>
                        </li>
                    @endforeach
                @endif

                <li class="final-total d-block">
                    <div class="d-flex justify-content-between">
                        <div class="label">{{__("Total:")}}</div>
                        <div class="val">{{format_money($booking->total)}}</div>
                    </div>
                    @if($booking->status !='draft')
                        <div class="d-flex justify-content-between">
                            <div class="label">{{__("Paid:")}}</div>
                            <div class="val">{{format_money($booking->paid)}}</div>
                        </div>
                        @if($booking->paid < $booking->total )
                            <div class="d-flex justify-content-between">
                                <div class="label">{{__("Remain:")}}</div>
                                <div class="val">{{format_money($booking->total - $booking->paid)}}</div>
                            </div>
                        @endif
                    @endif
                </li>
                @include ('Booking::frontend/booking/checkout-deposit-amount')
            </ul>
        </div>
    </div>
</div>
