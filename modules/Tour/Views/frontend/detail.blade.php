@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/tour/css/tour.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
@endsection
<style>
.search-hide {
     visibility: hidden;
      opacity: 0;
      transition: visibility 0s linear 0.33s, opacity 0.33s linear;
      display: none!important;
}
.capText {
    text-transform: uppercase;
}
.capitalizeText {
    text-transform: capitalize;
}
.pointer {
    cursor: pointer;
}
.vrtTop {
    vertical-align: top;
}
.blackText {
    color: #000000;
}
.darkText {
    color: #4a4a4a;
}
.greyText {
    color: #9b9b9b;
}
.whiteText {
    color: #ffffff;
}
.font9 {
    font-size: 9px;
    line-height: 9px;
}
.font10 {
    font-size: 10px;
    line-height: 10px;
}
.font12 {
    font-size: 12px;
    line-height: 12px;
}
.font14 {
    font-size: 14px;
    line-height: 14px;
}
.font16 {
    font-size: 16px;
    line-height: 16px;
}
.font18 {
    font-size: 18px;
    line-height: 18px;
}
.latoBold {
    font-weight: 700;
}
.latoBlack {
    font-weight: 900;
}
.lineHeight18 {
    line-height: 18px !important;
}
.lineHeight20 {
    line-height: 20px !important;
}
.lineHeight22 {
    line-height: 22px !important;
}
.borderRadius4 {
    border-radius: 4px;
    overflow: hidden;
}
.wdth210 {
    width: 210px;
}
.makeFlex {
    display: flex;
}
.makeFlex .flexOne {
    flex: 1;
}
.makeFlex.column {
    flex-direction: column;
}
.makeFlex.hrtlCenter {
    align-items: center;
}
.makeFlex.spaceBetween {
    justify-content: space-between;
}
.makeFlex.bottom {
    align-items: flex-end;
}
.makeFlex.inlineFlex {
    display: inline-flex;
}
.pushRight {
    margin-left: auto;
}
.flexOne {
    flex: 1;
}
.inlineFlex {
    display: inline-flex;
}
.appendTop20 {
    margin-top: 20px;
}
.appendRight3 {
    margin-right: 3px;
}
.appendRight5 {
    margin-right: 5px;
}
.appendRight10 {
    margin-right: 10px;
}
.appendRight15 {
    margin-right: 15px;
}
.appendRight26 {
    margin-right: 26px;
}
.appendBottom2 {
    margin-bottom: 2px;
}
.appendBottom3 {
    margin-bottom: 3px;
}
.appendBottom5 {
    margin-bottom: 5px;
}
.appendBottom6 {
    margin-bottom: 6px;
}
.appendBottom10 {
    margin-bottom: 10px;
}
.appendBottom15 {
    margin-bottom: 15px;
}
.appendBottom22 {
    margin-bottom: 22px;
}
.appendLeft5 {
    margin-left: 5px;
}
.padding10 {
    padding: 10px;
}
.brdrContainer {
    border: 1px solid #c8c8c8;
    box-shadow: 0 4px 8px 0 rgba(138, 107, 118, 0.08);
}
.itinararyRightSection {
    margin-left: 15px;
    width: 100%;
}
.greenGradient {
    background-image: linear-gradient(70deg, #26bd99, #219393);
    padding: 3px;
}
.holidaySprite.rating_blank {
    width: 60px;
    height: 12px;
    background-position: 0 -348px;
}
.holidaySprite.rating_fill {
    width: 60px;
    height: 12px;
    background-position: 0 -336px;
}
.holidaySprite.ratingThree {
    width: 37px;
}
.activityThumb {
    width: 100%;
}
.holidaySprite {
    background: url("https://jsak.mmtcdn.com/holidays/images/dynamicDetails/holidaySprite13.png") no-repeat;
    display: inline-block;
    background-size: 480px 480px;
    font-size: 0px;
    flex-shrink: 0;
}
.taIcon {
    width: 14px;
    height: 10px;
    background-position: -63px -337px;
}
.transferCardImgPlaceholder {
    background: #fff;
    width: 209px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    padding-left: 10px;
    padding-right: 10px;
    overflow: hidden;
}
.card {
    min-height: 175px;
}
.transfer.card {
    min-height: 109px;
}
.card.clickable:hover {
    border-color: #008cff;
    background: #f4faff;
}
.card-image {
    width: 209px;
    height: 151px;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 4px;
}
.link-separator {
    margin-left: 9px;
    margin-right: 6px;
    color: #bababa;
}
.joining-line {
    border-left: 1px solid #cecece;
    padding-top: 14px;
    padding-bottom: 14px;
    margin-left: 20px;
    padding-left: 12px;
    font-size: 12px;
    font-weight: 700;
    color: #9b9b9b;
    position: relative;
}
.joining-line.bubble.first::before {
    width: 10px;
    height: 10px;
    content: "";
    position: absolute;
    left: -6px;
    top: 0px;
    border-radius: 100px;
    border: 5px solid #cecece;
}
.lineHeight22 {
    line-height: 22px;
}
.end-day-banner {
    background: #fafdff;
    border-radius: 5px;
    border: 1px solid #bababa;
    padding: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.end-day-icon {
    width: 49px;
    height: 46px;
}
.end-day-info {
    margin-left: 6px;
    align-items: center;
}
.altAccoContainer {
    background-image: linear-gradient(87deg, #6a11cb 0%, #2575fc);
    padding: 3px 8px;
    font-size: 10px;
    font-weight: bold;
    display: inline-block;
    word-wrap: break-word;
    max-width: 100%;
}
.transferHeader {
    flex: 1;
}
.transfer.card {
    overflow: inherit;
}
.font18 {
    font-size: 18px;
}
.latoBold {
    font-weight: 700;
}
.latoBlack {
    font-weight: 900;
}
.font9 {
    font-size: 9px;
    line-height: 9px;
}
.font10 {
    font-size: 10px;
    line-height: 10px;
}
.font12 {
    font-size: 12px;
    line-height: 12px;
}
.font14 {
    font-size: 14px;
    line-height: 14px;
}
.font16 {
    font-size: 16px;
    line-height: 16px;
}
.font18 {
    font-size: 18px;
    line-height: 18px;
}
.blackText {
    color: #000000;
}
.darkText {
    color: #4a4a4a;
}
.whiteText {
    color: #ffffff;
}
.appendBottom10 {
    margin-bottom: 10px;
}
div,
span,
p,
a,
img,
sub,
b {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    font-size: 100%;
    background: transparent;
}
:focus {
    outline: 0;
}
p {
    line-height: normal;
}
.pointer {
    cursor: pointer;
}
/*! CSS Used from: Embedded */
:root .greyText {
    --borderColor: #9b9b9b;
}
/*! CSS Used from: Embedded */
.greyText {
    color: #9b9b9b;
}
/*! CSS Used from: Embedded */
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
p {
    margin: 0;
    padding: 0;
    list-style: none;
}
a {
    color: #008cff;
    cursor: pointer;
}
a,
a:focus,
a:hover {
    text-decoration: none;
}
a:focus,
a:hover {
    outline: none;
}
.capText {
    text-transform: uppercase;
}
.appendBottom2 {
    margin-bottom: 2px;
}
.appendBottom5 {
    margin-bottom: 5px;
}
.appendBottom6 {
    margin-bottom: 6px;
}
.appendBottom10 {
    margin-bottom: 10px;
}
.appendBottom15 {
    margin-bottom: 15px;
}
html[dir="ltr"] .appendLeft5 {
    margin-left: 5px;
}
html[dir="ltr"] .appendRight5 {
    margin-right: 5px;
}
html[dir="ltr"] .appendRight8 {
    margin-right: 8px;
}
html[dir="ltr"] .appendRight10 {
    margin-right: 10px;
}
html[dir="ltr"] .appendRight15 {
    margin-right: 15px;
}
.appendTop20 {
    margin-top: 20px;
}
.font9 {
    font-size: 9px;
    line-height: 9px;
}
.font10 {
    font-size: 10px;
    line-height: 10px;
}
.font12 {
    font-size: 12px;
    line-height: 12px;
}
.font14 {
    font-size: 14px;
    line-height: 14px;
}
.font16 {
    font-size: 16px;
    line-height: 16px;
}
.font18 {
    font-size: 18px;
    line-height: 18px;
}
.latoBlack {
    font-weight: 900;
}
.latoBold {
    font-weight: 700;
}
.whiteText {
    color: #fff;
}
.blackText {
    color: #000;
}
html[dir="ltr"] .pushRight {
    margin-left: auto;
}
.makeFlex {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
}
.flexOne {
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -moz-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
}
.makeFlex.column {
    -webkit-box-orient: vertical;
    -webkit-flex-direction: column;
    -moz-box-orient: vertical;
    -ms-flex-direction: column;
    flex-direction: column;
}
.makeFlex.column {
    -webkit-box-direction: normal;
    -moz-box-direction: normal;
}
.makeFlex.hrtlCenter {
    -webkit-box-align: center;
    -webkit-align-items: center;
    -moz-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}
.makeFlex.spaceBetween {
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -moz-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}
.makeFlex.bottom {
    -webkit-box-align: end;
    -webkit-align-items: flex-end;
    -moz-box-align: end;
    -ms-flex-align: end;
    align-items: flex-end;
}
img {
    max-width: 100%;
}
.itiDay {
    color: #000;
    font-weight: 900;
    font-size: 16px;
        margin-bottom: 15px;
        line-height: 22px !important;
}
.dayStrip {
        background: #e2f7ff;
    border-radius: 5px;
    border: 1px solid #78daff;
    padding: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

</style>
<?php $bookingType = request()->get('type'); ?>
@section('content')
    <div class="bravo_detail_tour">
        @include('Tour::frontend.layouts.details.tour-banner')
        <div class="bravo_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-9">
                        @php $review_score = $row->review_data @endphp @include('Tour::frontend.layouts.details.tour-detail')
                        <div class="tour-item tourActivities">
                            <div class="modal-body" id="bravo_tour_book_app_2" v-cloak>
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tab1">Day Plan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab2">
                                            Hotels
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab3">
                                            Transfers
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab4">
                                            Activity
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab5">
                                            Summary
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content" :class="{'d-none':enquiry_type!='book'}">
                                    <div id="tab1" class="tab-pane active">
                                        <h1>Itinerarys</h1>
                                        <div class="form-section-group form-group" v-if="itineraries">
                                        
                                        <div class="itinararyRightSection" v-for="(type,index) in itineraries" v-bind:data-index="index">
                                            <div class="dayStrip itiDay">
                                                <div class="flexOne">
                                                    <p class="">@{{type.day}} - <span class="darkText"> @{{type.location}} </span></p>
                                                </div>
                                                <a class="font12 latoBold"  @click="openMealModel($event, index)">ADD MEAL</a>
                                            </div>
                                            
                                            <div class="flexOne transfer-section" v-if="type.transfer" v-for="(transfer,transIndex) in type.transfer">
                                                <div class="joining-line" v-if="transIndex > 0 && index == 0"></div>
                                                <div class="card padding10">
                                                    <div class="transferCardImgPlaceholder"><img class="activityThumb" src="//imgak.mmtcdn.com/holidays/images/dynamicDetails/private_transfer.png" /></div>
                                                    <div class="flexOne makeFlex column spaceBetween">
                                                        <div class="makeFlex">
                                                            <div>
                                                                <div class="makeFlex appendBottom5"><div class="appendBottom2 appendRight8 transferHeader">@{{transfer.name}}</div></div>
                                                                <p class="latoBlack blackText font16 appendBottom15">Private Transfer</p>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="makeFlex spaceBetween">
                                                            <div class="makeFlex flexOne">
                                                                <div class="appendRight26">
                                                                    <p class="font10 greyText appendBottom6">DURATION</p>
                                                                    <p class="font14 blackText">@{{transfer.duration}} hrs</p>
                                                                </div>
                                                                <div class="flexOne">
                                                                    <p class="font10 greyText appendBottom6">INCLUDES</p>
                                                                    <p class="font14 blackText lineHeight18">@{{transfer.inclusions_name}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="activity-section" v-if="type.morning_activity" v-for="(value,actIndex) in type.morning_activity">
                                                <div class="joining-line"></div>
                                                @include('Tour::frontend.layouts.details.tour-activity',['typeActivity' => 1])

                                            </div>
                                            <div class="joining-line" v-if="type.hotel">Check-in to <b>Hotel in @{{type.location}}</b></div>

                                            <div class="makeFlex padding10 card hotelSection form-group" v-if="type.hotel" v-bind:data-index="type.index">
                                                    <div class="wdth210 pointer appendRight15 vrtTop">
                                                        <img :src="default_hotels[type.index].hotel_img" alt="img" class="card-image" width="100px" />
                                                    </div>
                                                    <div class="flexOne makeFlex column spaceBetween">
                                                        <div class="makeFlex">
                                                            <div class="flexOne">
                                                                <div class="makeFlex hrtlCenter appendBottom5"></div>
                                                                <div class="makeFlex hrtlCenter appendBottom5">
                                                                    <span class="altAccoContainer appendRight5 borderRadius4 whiteText latoBold">Hotel</span>
                                                                </div>
                                                                <p class="latoBold blackText font16 appendBottom3">
                                                                    <span class="appendRight10 pointer lineHeight18">@{{default_hotels[type.index].hotel_name}} </span>
                                                                </p>
                                                                <p class="font12 lineHeight18 appendBottom10">@{{default_hotels[type.index].location_name}}</p>
                                                            </div>
                                                            <div class="font12 latoBold" v-if="!default_hotels[type.index].remove_status">
                                                                <a href="javascript:void(0);" class="change-btn change-hotel" @click="openHotelsModel($event, type.index)">Change Hotel</a>
                                                            </div>
                                                        </div>
                                                        <div class="makeFlex">
                                                            <div class="appendRight26">
                                                                <p class="font10 greyText appendBottom6">DATES</p>
                                                                <p class="appendBottom15 font14 blackText">@{{default_hotels[type.index].check_in}} - @{{default_hotels[type.index].check_out}}</p>
                                                            </div>
                                                            <div>
                                                                <p class="font10 greyText appendBottom6">INCLUDES</p>
                                                                <p class="appendBottom15 font14 blackText">Breakfast</p>
                                                            </div>
                                                        </div>
                                                        <div class="makeFlex spaceBetween">
                                                            <p class="font10 greyText appendBottom6">ROOM TYPE</p>
                                                            <p class="font14 blackText">
                                                                <span>@{{default_hotels[type.index].room_name}}</span>
                                                                <a href="javascript:void(0);" class="change-btn change-room" @click="openRoomsModel($event, type.index)">Change Room</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>




                                            <div class="eveningTourActivitySection">
                                                <div class="activity-section" v-if="type.activity" v-for="(value,actIndex) in type.activity">
                                                    <div class="joining-line"></div>
                                                    @include('Tour::frontend.layouts.details.tour-activity',['typeActivity' => 2])
                                                       
                                                </div>
                                                <div class="activity-section" v-if="type.evening_activity" v-for="(value,actIndex) in type.evening_activity">
                                                    <div class="joining-line"></div>
                                                    @include('Tour::frontend.layouts.details.tour-activity',['typeActivity' => 3])
                                                </div>
                                            </div>

                                            <!-- <div class="joining-line" v-if="index != Object.keys(itineraries).length - 1"></div> -->
                                            <div class="joining-line"></div>
                                            <div class="end-day-banner">
                                                <div class="makeFlex flexOne hrtlCenter">
                                                    <div class="icon"><i class="icofont-beach"></i></div>
                                                    <div class="flexOne end-day-info">
                                                        <p class="font16 blackText latoBold appendBottom3">End of day</p>
                                                        <p class="font12 darkText">Spend time at leisure or add an activity</p>
                                                    </div>
                                                </div>
                                                <a class="font12 latoBold" @click="openActivityModel($event, index)">ADD ACTIVITY</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div id="tab2" class="tab-pane fade">
                                        <div class="form-section-group form-group" v-if="itineraries">
                                            <div class="itinararyRightSection" v-for="(type,index) in itineraries" v-bind:data-index="index">
                                                <div class="dayStrip itiDay" v-if="type.hotel">
                                                    <div class="flexOne">
                                                        <p class="">@{{type.day}} - <span class="darkText"> @{{type.location}} </span></p>
                                                    </div>
                                                    <a class="font12 latoBold"  @click="openMealModel($event, index)">ADD MEAL</a>
                                                </div>
                                                
                                                <div class="transferandHotels" v-if="type.hotel">
                                                    <div class="makeFlex padding10 card hotelSection form-group" v-if="type.hotel" v-bind:data-index="type.index">
                                                        <div class="wdth210 pointer appendRight15 vrtTop">
                                                            <img :src="default_hotels[type.index].hotel_img" alt="img" class="card-image" width="100px" />
                                                        </div>
                                                        <div class="flexOne makeFlex column spaceBetween">
                                                            <div class="makeFlex">
                                                                <div class="flexOne">
                                                                    <div class="makeFlex hrtlCenter appendBottom5"></div>
                                                                    <div class="makeFlex hrtlCenter appendBottom5">
                                                                        <span class="altAccoContainer appendRight5 borderRadius4 whiteText latoBold">Hotel</span>
                                                                    </div>
                                                                    <p class="latoBold blackText font16 appendBottom3">
                                                                        <span class="appendRight10 pointer lineHeight18">@{{default_hotels[type.index].hotel_name}} </span>
                                                                    </p>
                                                                    <p class="font12 lineHeight18 appendBottom10">@{{default_hotels[type.index].location_name}}</p>
                                                                </div>
                                                                <div class="font12 latoBold" v-if="!default_hotels[type.index].remove_status">
                                                                    <a href="javascript:void(0);" class="change-btn change-hotel" @click="openHotelsModel($event, type.index)">Change Hotel</a>
                                                                </div>
                                                            </div>
                                                            <div class="makeFlex">
                                                                <div class="appendRight26">
                                                                    <p class="font10 greyText appendBottom6">DATES</p>
                                                                    <p class="appendBottom15 font14 blackText">@{{default_hotels[type.index].check_in}} - @{{default_hotels[type.index].check_out}}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="font10 greyText appendBottom6">INCLUDES</p>
                                                                    <p class="appendBottom15 font14 blackText">Breakfast</p>
                                                                </div>
                                                            </div>
                                                            <div class="makeFlex spaceBetween">
                                                                <p class="font10 greyText appendBottom6">ROOM TYPE</p>
                                                                <p class="font14 blackText">
                                                                    <span>@{{default_hotels[type.index].room_name}}</span>
                                                                    <a href="javascript:void(0);" class="change-btn change-room" @click="openRoomsModel($event, type.index)">Change Room</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="joining-line" v-if="index != Object.keys(itineraries).length - 1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab3" class="tab-pane fade">
                                        <div class="form-section-group form-group" v-if="itineraries">
                                            <div class="itinararyRightSection" v-for="(type,index) in itineraries" v-bind:data-index="index">
                                                <div class="dayStrip itiDay"  v-if="type.transfer.length > 0">
                                                    <div class="flexOne">
                                                        <p class="">@{{type.day}} - <span class="darkText"> @{{type.location}} </span></p>
                                                    </div>
                                                    <a class="font12 latoBold" @click="openMealModel($event, index)">ADD MEAL</a>
                                                </div>

                                                <div class="flexOne transfer-section" v-if="type.transfer" v-for="(transfer,transIndex) in type.transfer">
                                                <div class="joining-line" v-if="transIndex > 0 && index == 0"></div>
                                                <div class="card padding10">
                                                    <div class="transferCardImgPlaceholder"><img class="activityThumb" src="//imgak.mmtcdn.com/holidays/images/dynamicDetails/private_transfer.png" /></div>
                                                    <div class="flexOne makeFlex column spaceBetween">
                                                        <div class="makeFlex">
                                                            <div>
                                                                <div class="makeFlex appendBottom5"><div class="appendBottom2 appendRight8 transferHeader">@{{transfer.name}}</div></div>
                                                                <p class="latoBlack blackText font16 appendBottom15">Private Transfer</p>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="makeFlex spaceBetween">
                                                            <div class="makeFlex flexOne">
                                                                <div class="appendRight26">
                                                                    <p class="font10 greyText appendBottom6">DURATION</p>
                                                                    <p class="font14 blackText">@{{transfer.duration}} hrs</p>
                                                                </div>
                                                                <div class="flexOne">
                                                                    <p class="font10 greyText appendBottom6">INCLUDES</p>
                                                                    <p class="font14 blackText lineHeight18">@{{transfer.inclusions_name}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab4" class="tab-pane fade">
                                        <div class="form-section-group form-group" v-if="itineraries">
                                            <div class="itinararyRightSection" v-for="(type,index) in itineraries" v-bind:data-index="index">
                                                <div class="dayStrip itiDay" v-if="type.transfer.length > 0">
                                                    <div class="flexOne">
                                                        <p class="">@{{type.day}} - <span class="darkText"> @{{type.location}} </span></p>
                                                    </div>
                                                    <a class="font12 latoBold"  @click="openMealModel($event, index)">ADD MEAL</a>
                                                </div>
                                                <div class="activity-section" v-if="type.morning_activity" v-for="(value,actIndex) in type.morning_activity">
                                                    @include('Tour::frontend.layouts.details.tour-activity',['typeActivity' => "1"])
                                                </div>
                                                <div class="activity-section" v-if="type.activity" v-for="(value,actIndex) in type.activity">
                                                    @include('Tour::frontend.layouts.details.tour-activity',['typeActivity' => "2"])
                                                </div>
                                                <div class="activity-section" v-if="type.evening_activity" v-for="(value,actIndex) in type.evening_activity">
                                                    @include('Tour::frontend.layouts.details.tour-activity',['typeActivity' => "3"])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab5" class="tab-pane fade">
                                        <div id="secondaryTabContainer" v-if="itineraries">
                                        <div class="summary-container TableTopHeader123" >
                                            <table class="table table-bordered">
                                                <tbody v-for="(type,index) in itineraries" v-bind:data-index="index">
                                                    <tr v-if="type.hotel">
                                                        <th colspan="3" class="TableTopHeader"><img src="{{ URL::asset('uploads/location-icon.png') }}" width="30" /><strong>@{{type.location}} </strong><span></span></th>
                                                    </tr>
                                                    
                                                    <tr v-if="type.transfer" v-for="(value,transIndex) in type.transfer">
                                                        <th scope="rowgroup">@{{type.date}}, @{{type.day}}</th>
                                                        <td><img src="{{ URL::asset('uploads/car.png') }}" width="30" /></td>
                                                        <td>@{{value.name}}</td>
                                                    </tr>

                                                    <tr v-if="type.morning_activity" v-for="(value,actIndex) in type.morning_activity">
                                                        <th v-if="actIndex == 0" v-bind:rowspan="type.morning_activity.length" scope="rowgroup">@{{type.date}}, @{{type.day}}</th>
                                                        <td><img src="{{ URL::asset('uploads/book-icon.png') }}" /></td>
                                                        <td>@{{value.name}}</td>
                                                    </tr>
                                                    <tr v-if="type.hotel">
                                                        <th>@{{type.date}}, @{{type.day}}</th>
                                                        <td><img src="{{ URL::asset('uploads/home-icon.png') }}" /></td>
                                                        <td>Check in to @{{default_hotels[type.index].hotel_name}}</td>
                                                    </tr>
                                                    <tr v-if="type.activity" v-for="(value,actIndex) in type.activity">
                                                        <th v-if="actIndex == 0" v-bind:rowspan="type.activity.length" scope="rowgroup">@{{type.date}}, @{{type.day}}</th>
                                                        <td><img src="{{ URL::asset('uploads/book-icon.png') }}" /></td>
                                                        <td>@{{value.name}}</td>
                                                    </tr>
                                                    <tr v-if="type.evening_activity" v-for="(value,actIndex) in type.evening_activity">
                                                        <th v-if="actIndex == 0" v-bind:rowspan="type.evening_activity.length" scope="rowgroup">@{{type.date}}, @{{type.day}}</th>
                                                        <td><img src="{{ URL::asset('uploads/book-icon.png') }}" /></td>
                                                        <td>@{{value.name}} </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('Tour::frontend.layouts.details.tour-review')
                    </div>
                    <div class="col-md-12 col-lg-3">
                        @include('Tour::frontend.layouts.details.vendor') 
                        @include('Tour::frontend.layouts.details.tour-form-book') 
                        @include('Tour::frontend.layouts.details.open-hours')
                    </div>
                </div>
                <div class="row end_tour_sticky">
                    <div class="col-md-12">
                        @include('Tour::frontend.layouts.details.tour-related')
                    </div>
                </div>
            </div>
        </div>
        <div class="bravo-more-book-mobile">
            <div class="container">
                <div class="left">
                    <div class="g-price">
                        <div class="prefix">
                            <span class="fr_text">{{__("from")}}</span>
                        </div>
                        <div class="price">
                            <span class="onsale">{{ $row->display_sale_price }}</span>
                            <span class="text-price">{{ $row->display_price }}</span>
                        </div>
                    </div>
                    @if(setting_item('tour_enable_review'))
                    <?php
                        $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total']; ?>
                    <div class="service-review tour-review-{{$score_total}}">
                        <div class="list-star">
                            <ul class="booking-item-rating-stars">
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                            </ul>
                            <div class="booking-item-rating-stars-active" style="width: {{  $score_total * 2 * 10 ?? 0  }}%">
                                <ul class="booking-item-rating-stars">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                            </div>
                        </div>
                        <span class="review">
                            @if($reviewData['total_review'] > 1) {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }} @else {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }} @endif
                        </span>
                    </div>
                    @endif
                </div>
                <div class="right">
                    @if($row->getBookingEnquiryType() === "book")
                    <a class="btn btn-primary bravo-button-book-mobile">{{__("Book Now")}}</a>
                    @else
                    <a class="btn btn-primary" data-toggle="modal" data-target="#enquiry_form_modal">{{__("Contact Now")}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" id="change_tour_activity"></div>
    <div class="loading-all" style="display: none;"><span><img src="{{ asset("images/loader.gif") }}"></span></div>
@endsection

@section('footer')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            @if($row->map_lat && $row->map_lng)
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [{{$row->map_lat}}, {{$row->map_lng}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {}
                    });
                }
            });
            @endif
        })
    </script>
    <script>
        var bravo_booking_data = {!! json_encode($booking_data) !!}
        var bravo_booking_i18n = {
                no_date_select:'{{__('Please select Start date')}}',
                no_guest_select:'{{__('Please select at least one guest')}}',
                load_dates_url:'{{route('tour.vendor.availability.loadDates')}}',
                name_required:'{{ __("Name is Required") }}',
                email_required:'{{ __("Email is Required") }}',
            };
    </script>
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/tour/js/single-tour.js?_ver='.config('app.version')) }}"></script>
@endsection
