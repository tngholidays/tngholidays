<style>
    /*! CSS Used from: http://192.168.1.21:8000/libs/bootstrap/css/bootstrap.css */
.dropdown-toggle {
    white-space: nowrap;
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
.dropdown-toggle:empty::after {
    margin-left: 0;
}
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;
}
.dropdown-menu[x-placement^="bottom"] {
    right: auto;
    bottom: auto;
}
.dropdown-menu.show {
    display: block;
}
@media print {
    *,
    *::before,
    *::after {
        text-shadow: none !important;
        box-shadow: none !important;
    }
}
/*! CSS Used from: http://192.168.1.21:8000/libs/font-awesome/css/font-awesome.css */
.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.fa-angle-down:before {
    content: "\f107";
}
/*! CSS Used from: http://192.168.1.21:8000/libs/ionicons/css/ionicons.min.css */
.ion-ios-add:before,
.ion-md-remove:before {
    display: inline-block;
    font-family: "Ionicons";
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    text-rendering: auto;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.ion-ios-add:before {
    content: "\f102";
}
.ion-md-remove:before {
    content: "\f368";
}
/*! CSS Used from: http://192.168.1.21:8000/dist/frontend/css/app.css?_ver=1.2.4 */
.rooms-section .select-guests-dropdown {
    transform: none !important;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    top: 100% !important;
    margin-top: 0;
    right: 0;
    border-color: #dee2e6;
}
@media (max-width: 1023px) {
    .rooms-section .select-guests-dropdown {
        transform: translateY(-1px) !important;
    }
}
.rooms-section .select-guests-dropdown .dropdown-item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 4px 14px 4px 24px;
}
.rooms-section .select-guests-dropdown .dropdown-item-row .btn-add2,
.rooms-section .select-guests-dropdown .dropdown-item-row .btn-minus2 {
    padding: 0 5px;
    cursor: pointer;
}
.rooms-section .select-guests-dropdown .dropdown-item-row .btn-add2 i,
.rooms-section .select-guests-dropdown .dropdown-item-row .btn-minus2 i {
    font-size: 25px;
}
.rooms-section .select-guests-dropdown .dropdown-item-row .count-display {
    color: #5191fa;
    min-width: 25px;
    text-align: center;
}
.rooms-section .select-guests-dropdown .dropdown-item-row .count-display input {
    border: none;
    background: none;
    width: 35px;
    text-align: center;
    color: #5191fa;
    margin-left: 15px;
}
.rooms-section .select-guests-dropdown .dropdown-item-row .val {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
/*! CSS Used from: http://192.168.1.21:8000/dist/frontend/module/hotel/css/hotel.css?_ver=1.2.4 */
.hotel_rooms_form .form-group {
    position: relative;
    margin-bottom: 0;
    cursor: pointer;
}
.hotel_rooms_form .form-group .form-content {
    padding: 15px 5px;
}
.hotel_rooms_form .form-group .form-label {
    font-size: 14px;
    color: #5e6d77;
    margin-bottom: 0;
}
.hotel_rooms_form .form-group .render {
    font-size: 16px;
    color: #5191fa;
}
.hotel_rooms_form .form-group .select-guests-dropdown {
    margin-left: -15px;
    margin-right: -16px;
}
.hotel_rooms_form .dropdown-toggle:after {
    display: none;
}
.hotel_rooms_form .arrow {
    position: absolute;
    top: 50%;
    right: 20px;
    margin-top: -5px;
    font-size: 22px;
    color: #a0a9b2;
}
/*! CSS Used from: http://192.168.1.21:8000/custom-css */
.hotel_rooms_form .form-group .render {
    color: #0751c9;
}
.rooms-section .select-guests-dropdown .dropdown-item-row .count-display {
    color: #0751c9;
}
/*! CSS Used fontfaces */
@font-face {
    font-family: "FontAwesome";
    src: url("http://192.168.1.21:8000/libs/font-awesome/fonts/fontawesome-webfont.eot?v=4.7.0");
    src: url("http://192.168.1.21:8000/libs/font-awesome/fonts/fontawesome-webfont.eot#iefix&v=4.7.0") format("embedded-opentype"), url("http://192.168.1.21:8000/libs/font-awesome/fonts/fontawesome-webfont.woff2?v=4.7.0") format("woff2"),
        url("http://192.168.1.21:8000/libs/font-awesome/fonts/fontawesome-webfont.woff?v=4.7.0") format("woff"), url("http://192.168.1.21:8000/libs/font-awesome/fonts/fontawesome-webfont.ttf?v=4.7.0") format("truetype"),
        url("http://192.168.1.21:8000/libs/font-awesome/fonts/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular") format("svg");
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: "Ionicons";
    src: url("http://192.168.1.21:8000/libs/ionicons/fonts/ionicons.eot?v=4.5.7");
    src: url("http://192.168.1.21:8000/libs/ionicons/fonts/ionicons.eot?v=4.5.7#iefix") format("embedded-opentype"), url("http://192.168.1.21:8000/libs/ionicons/fonts/ionicons.woff2?v=4.5.7") format("woff2"),
        url("http://192.168.1.21:8000/libs/ionicons/fonts/ionicons.woff?v=4.5.7") format("woff"), url("http://192.168.1.21:8000/libs/ionicons/fonts/ionicons.ttf?v=4.5.7") format("truetype"),
        url("http://192.168.1.21:8000/libs/ionicons/fonts/ionicons.svg?v=4.5.7#Ionicons") format("svg");
    font-weight: normal;
    font-style: normal;
}

</style>
<div class="bravo_single_book_wrap @if(setting_item('tour_enable_inbox')) has-vendor-box @endif">
    <div class="bravo_single_book">
        <div id="bravo_tour_book_app" v-cloak>
            @if($row->discount_percent)
                <div class="tour-sale-box">
                    <span class="sale_class box_sale sale_small">{{$row->discount_percent}}</span>
                </div>
            @endif

            <div class="form-head">
                <div class="price">
                    <span class="label">
                        {{__("from")}}
                    </span>
                    <span class="value">
                        <span class="onsale">{{ $row->display_sale_price }}</span>
                        <span class="text-lg">{{ $row->display_price }}</span>
                        <input type="hidden" id="display_price" value="{{$row->sale_price}}">
                    </span>
                </div>
            </div>
            <div class="nav-enquiry" v-if="is_form_enquiry_and_book">
                <div class="enquiry-item active" >
                    <span>{{ __("Book") }}</span>
                </div>
                <div class="enquiry-item" data-toggle="modal" data-target="#enquiry_form_modal">
                    <span>{{ __("Enquiry") }}</span>
                </div>
            </div>
            <div class="form-book" :class="{'d-none':enquiry_type!='book'}">
                <div class="form-content">
                    <div class="form-group form-date-field form-date-search clearfix " data-format="{{get_moment_date_format()}}">
                        <div class="date-wrapper clearfix" @click="openStartDate">
                            <div class="check-in-wrapper">
                                <label>{{__("Start Date")}}</label>
                                <div class="render check-in-render">@{{start_date_html}}</div>
                            </div>
                            <i class="fa fa-angle-down arrow"></i>
                        </div>
                        <input type="text" class="start_date" ref="start_date" style="height: 1px; visibility: hidden">
                    </div>
                    <div class="" v-if="person_types">
                        <div class="form-group form-guest-search" v-for="(type,index) in person_types">
                            <div class="guest-wrapper d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    <label>@{{type.name}}</label>
                                    <div class="render check-in-render">@{{type.desc}}</div>
                                    <div class="render check-in-render">@{{type.display_price}} {{__("per person")}}</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="input-number-group">
                                        <!-- <i class="icon ion-ios-remove-circle-outline" @click="minusPersonType(type)"></i> -->
                                        <span class="input"><input type="number" v-model="type.number" min="1" @change="changePersonType(type)"/  readonly></span>
                                        <!-- <i class="icon ion-ios-add-circle-outline" @click="addPersonType(type)"></i> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-guest-search" v-else>
                        <div class="guest-wrapper d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <label>{{__("Guests")}}</label>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="input-number-group">
                                    <i class="icon ion-ios-remove-circle-outline" @click="minusGuestsType()"></i>
                                    <span class="input"><input type="number" v-model="guests" min="1"/></span>
                                    <i class="icon ion-ios-add-circle-outline" @click="addGuestsType()"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-section-group form-group rooms-section hotel_rooms_form" v-if="hotelrooms.length">
                        <div class="form-group RoomDiv" v-for="(type,index) in hotelrooms">
                            <i class="fa fa-angle-down arrow"></i>
                            <div class="form-content dropdown-toggle" data-toggle="dropdown">
                                <label class="form-label">Room @{{type.room}}</label>
                                <div class="render">
                                    <span class="adults" >
                                        <span class="one" >@{{type.adults}}
                                            <span v-if="type.adults < 2">{{__('Adult')}}</span>
                                            <span v-else>{{__('Adults')}}</span>
                                        </span>
                                    </span>
                                    -
                                    <span class="children" >
                                        <span class="one" >@{{type.children}}
                                            <span v-if="type.children < 2">{{__('Child')}}</span>
                                            <span v-else>{{__('Children')}}</span>
                                        </span>
                                    </span>
                                </div>

                            </div>
                            <div class="dropdown-menu select-guests-dropdown" >
                                <div class="dropdown-item-row">
                                    <div class="label">{{__('Adults')}}</div>
                                    <div class="val">
                                        <span class="btn-minus2" data-input="adults" @click="minusRoomPersonType('adults',index)"><i class="icon ion-md-remove"></i></span>
                                        <span class="count-display"><input type="number" v-model="type.adults" min="1" max="3"/></span>
                                        <span class="btn-add2" data-input="adults" @click="addRoomPersonType('adults',index)"><i class="icon ion-ios-add"></i></span>
                                    </div>
                                </div>
                                <div class="dropdown-item-row">
                                    <div class="label">{{__('Children')}}</div>
                                    <div class="val">
                                        <span class="btn-minus2" data-input="children" @click="minusRoomPersonType('children',index)"><i class="icon ion-md-remove"></i></span>
                                        <span class="count-display"><input type="number" v-model="type.children" min="0"/></span>
                                        <span class="btn-add2" data-input="children" @click="addRoomPersonType('children',index)"><i class="icon ion-ios-add"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="close-room"><i class="fa fa-times-circle" aria-hidden="true" @click="removeRoom(index)"></i></div>
                        </div>

                        <button class="btn btn-sm btn-primary" @click="addMoreRoom()">Add Room</button>
                        <!-- <button class="btn btn-sm btn-primary" @click="roomPriceCalculate()">Calculate</button> -->
                    </div>
                    <div class="form-section-group form-group" v-if="extra_price.length">
                        <h4 class="form-section-title">{{__('Extra Charges:')}}</h4>
                        <div class="form-group" v-for="(type,index) in extra_price">
                            <div class="extra-price-wrap d-flex justify-content-between">
                                <div class="flex-grow-1">
                                    <label><input type="checkbox" v-model="type.enable"> @{{type.name}}</label>
                                    <div class="render" v-if="type.price_type">(@{{type.price_type}})</div>
                                </div>
                                <div class="flex-shrink-0">@{{type.price_html}}</div>
                            </div>
                        </div>
                    </div>
                    
                    <?php /*
                    <div class="form-section-group form-group" v-if="default_hotels">
                        <div class="form-group" v-for="(type,index) in default_hotels" v-bind:data-index="index">

                            <div class="img">
                                <img :src="type.hotel_img" alt="img" width="100px">
                            </div>
                            <div class="otherDetails">
                                <h5 class="name hotelName">@{{type.hotel_name}}</h5>
                                <span class="locationn">@{{type.location_name}}</span>
                                <div class="type">
                                    <!-- <p class="type">Room Type</p> -->
                                    <p class="roomName"><strong>@{{type.room_name}}</strong></p>
                                </div>
                            </div>
                            <input type="hidden" class="hotelDetails">
                            <div class="group-btns">
                                <a href="javascript:void(0);" class="change-btn change-hotel" @click="openHotelsModel($event, index)">Change Hotel</a>
                                <a href="javascript:void(0);" class="change-btn change-room" @click="openRoomsModel($event, index)">Change Room</a>
                            </div>
                        </div>
                    </div>

                    
                @if(isset($booking_data['default_hotels']))
                    <div class="form-section-group form-group">
                    @foreach ($booking_data['default_hotels'] as $indx => $hotel)
                        <div class="form-group" data-index="{{$indx}}">

                            <div class="img">
                                <img src="{{$hotel['hotel_img']}}" alt="img" width="100px">
                            </div>
                            <div class="otherDetails">
                                <h5 class="name hotelName">{{$hotel['hotel_name']}}</h5>
                                <span class="locationn">{{$hotel['location_name']}}</span>
                                <div class="type">
                                    <!-- <p class="type">Room Type</p> -->
                                    <p class="roomName"><strong>{{$hotel['room_name']}}</strong></p>
                                </div>
                            </div>
                            <input type="hidden" class="hotelDetails" location_id="{{$hotel['location_id']}}" hotel="{{$hotel['hotel']}}" room="{{$hotel['room']}}" days="{{$hotel['days']}}" total_price="{{$hotel['total_price']}}">
                            <div class="group-btns">
                                <a href="javascript:void(0);" class="change-btn change-hotel" @click="openHotelsModel($event)">Change Hotel</a>
                                <a href="javascript:void(0);" class="change-btn change-room" @click="openRoomsModel($event)">Change Room</a>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endif */ ?>
                    <div class="form-section-group form-group" v-if="is_coupon_ready">
                        <div class="coupon-block">
                            @if(!empty($row->meta->coupon))
                                @foreach($row->meta->coupon as $key=>$coupon)
                                 <?php

                                 $detail = getCouponById($coupon['coupon_id']);
                                  $couponDetails = json_encode($detail);
                                  $tourCoupon = json_encode($coupon);
                                 ?>
                                    <div class="coupon-list">
                                        <div class="code-block">
                                            <div class="img-block">
                                                <i class="fa fa-gift" aria-hidden="true"></i>
                                                <span class="coupon-code">{{$detail->code}}</span>
                                            </div>
                                            <button class="btn btn-sm btn-primary" @click="applyCoupon({{$couponDetails}}, {{$tourCoupon}}, $event)">APPLY</button>

                                        </div>
                                        <div class="note-block">
                                            <span class="coupon-note">
                                                {{$coupon['note']}}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="coupon-list customeCouponList" v-for="(coupon, index) in custom_coupons" v-if="custom_coupons">
                                <div class="code-block">
                                    <div class="img-block">
                                        <i class="fa fa-gift" aria-hidden="true"></i>
                                        <span class="coupon-code">@{{coupon.code}}</span>
                                    </div>
                                    <button class="btn btn-sm btn-primary" @click="applyCoupon(coupon.couponDetail, '', $event)">APPLY</button>

                                </div>
                                <div class="note-block">
                                    <span class="coupon-note">
                                       @{{coupon.note}}
                                    </span>
                                </div>

                            </div>
                            <div class="cpnCont">
                                <div class="cpnInput">
                                    <input type="text" placeholder="Have a Coupon Code" v-model="enterCouponCode" value="">
                                    <button class="btn btn-sm btn-primary" @click="applyCouponByText">APPLY</button>
                                </div>
                            </div>
                            <div class="errorMsg">

                            </div>
                        </div>

                    </div>
                    <div class="form-section-group form-group-padding" v-if="buyer_fees.length">
                        <div class="extra-price-wrap d-flex justify-content-between" v-for="(type,index) in buyer_fees">
                            <div class="flex-grow-1">
                                <label>@{{type.type_name}}
                                    <i class="icofont-info-circle" v-if="type.desc" data-toggle="tooltip" data-placement="top" :title="type.type_desc"></i>
                                </label>
                                <div class="render" v-if="type.price_type">(@{{type.price_type}})</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="unit" v-if='type.unit == "percent"'>
                                    @{{ type.price }}%
                                </div>
                                <div class="unit" v-else >
                                    @{{ formatMoney(type.price) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="form-section-total list-unstyled" v-if="total_price > 0">
                    <li>
                        <label>{{__("Total")}}</label>
                        <span class="price">@{{total_price_html}}</span>
                    </li>
                    <li v-if="is_modify_ready">
                        <label>{{__("Modify")}}</label>
                        <span class="price">@{{modify_price}}</span>
                    </li>
                    <li v-if="is_deposit_ready">
                        <label for="">{{__("Pay now")}}</label>
                        <span class="price">@{{pay_now_price_html}}</span>
                    </li>
                </ul>
                <?php 
                    if ($bookingType == 'add_by_admin') {
                        $btnText = 'ADD ENQUERY';
                    }else{
                        $btnText = 'BOOK NOW';
                    }
                ?>
                <div v-html="html"></div>
                <div class="submit-group">
                    <a class="btn btn-large" @click="doSubmit($event)" :class="{'disabled':onSubmit,'btn-success':(step == 2),'btn-primary':step == 1}" name="submit">
                        <span>{{$btnText}}</span>
                        <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i>
                    </a>
                    <div class="alert-text mt10" v-show="message.content" v-html="message.content" :class="{'danger':!message.type,'success':message.type}"></div>
                </div>
            </div>
            <div class="form-send-enquiry" v-show="enquiry_type=='enquiry'">
                <button class="btn btn-primary" data-toggle="modal" data-target="#enquiry_form_modal">
                    {{ __("Contact Now") }}
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="change_booking_hotel"></div>
<div class="modal fade" role="dialog" id="change_booking_room"></div>
@include("Booking::frontend.global.enquiry-form",['service_type'=>'tour'])
