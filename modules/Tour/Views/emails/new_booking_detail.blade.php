<?php
$translation = $service->translateOrOrigin(app()->getLocale());
$lang_local = app()->getLocale();
?>
<div class="b-panel-title">{{__('Tour information')}}</div>
<div class="b-table-wrap">
    <table class="b-table" cellspacing="0" cellpadding="0">
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
                <a href="{{$service->getDetailUrl()}}">{!! clean($translation->title) !!}</a>
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
                            <?php $hotelDDetail = getHotelById($hotel['hotel']); ?>
                                <tr>
                                    <td class="label">{{@getLocationById($hotel['location_id'])->name}}</td>
                                    <td class="label">{{$hotelDDetail->title}} </td>
                                    <td class="label">{{@getRoomsById($hotel['room'])->title}}</td>
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

                    @if(!empty($person_types))
                        @foreach($person_types as $type)
                            <tr>
                                <td class="label">{{$type['name']}}: {{$type['number']}} * {{format_money($type['price'])}}</td>
                                <td class="val no-r-padding">
                                    <strong>{{format_money($type['price'] * $type['number'])}}</strong>
                                    <?php $base_price = $type['price'] * $type['number']; ?>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="label">{{__("Guests")}}: {{$booking->total_guests}} {{format_money($booking->getMeta('base_price'))}}</td>
                            <td class="val no-r-padding">
                                <strong>{{format_money($booking->getMeta('base_price') * $booking->total_guests)}}</strong>
                                <?php $base_price = $type['price'] * $type['number']; ?>
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
                    @php $extra_price = $booking->getJsonMeta('extra_price')@endphp

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
                                @endforeach
                                </table>
                            </td>
                        </tr>

                    @endif

                    @php $discount_by_people = $booking->getJsonMeta('discount_by_people')
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
                                @endforeach
                                </table>
                            </td>
                        </tr>
                    @endif
                    @if(!empty($booking->modify_price))
                    <?php $modify_price = abs($booking->modify_price) * $booking->total_guests;?>
                        <tr>
                            <td class="label">
                               Modify Price
                            </td>
                            <td class="val">
                                 @if($booking->modify_price > 0)
                                <?php  $booking->total_before_fees = $booking->total_before_fees + $modify_price; ?>
                                + {{format_money($modify_price)}}
                                @else
                                <?php  $booking->total_before_fees = $booking->total_before_fees - $modify_price; ?>
                                - {{format_money($modify_price)}}
                                @endif
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
            <td class="label fsz21">{{__('Total')}}</td>
            <td class="val fsz21"><strong style="color: #FA5636">{{format_money($booking->total)}}</strong></td>
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
<div class="text-center mt20">
    <a href="{{ route("user.booking_history") }}" target="_blank" class="btn btn-primary manage-booking-btn">{{__('Manage Bookings')}}</a>
</div>
