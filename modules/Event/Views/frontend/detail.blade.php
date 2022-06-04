@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/event/css/event.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
@endsection
<style>
    .base-block .base-block-head {
        padding: 0 0 0 23px;
        text-transform: capitalize;
    }
    .base-block .base-block-body {
    padding: 10px 30px;
}


.tours-icon-time:before {
  content: "";
}


.variant--non-room .variant__head {
  display: flex;
  align-items: center;
}

.tours-icon-time:before {
  content: "";
}
.variant {
  border-radius: 10px;
  border: solid 0.5px #d8d8d8;
  padding: 20px 15px;
}
@media (max-width: 1023px) {
  .variant {
    margin-top: 20px;
  }
}
.variant__duration {
  font-weight: normal;
  font-size: 12px;
}
.variant__strikethrough-price {
  text-decoration: line-through;
  color: #a5a4a4;
}
.variant__current-price {
  font-weight: 700;
  font-size: 1.5rem;
  margin-bottom: 10px;
}
.variant__inventory-name {
  font-weight: 600;
  font-size: 12px;
}
.variant--non-room {
  border-radius: 12px;
  border: solid 1px #00aeefa8;
  background-color: white;
  padding: 0 30px;
  transition: 0.2s border-color;
  color: #3a3a3a;
  margin-top: 25px;
}
.variant--non-room .variant__head {
  padding: 24px 0;
  outline: none;
}
.variant--non-room .variant__head:hover {
  cursor: pointer;
}
.variant--non-room .variant__radio {
  font-size: 18px;
  margin-right: 30px;
}

.variant--non-room .variant__title {
  font-size: 18px !important;
  font-weight: 600;
  color: #3a3a3a;
  margin-bottom: 12px;
          border-left: none !important;
    padding-left: 0px !important;
}
.variant--non-room .variant__duration {
  color: #707070;
  font-weight: 500;
  margin-bottom: 12px;
}
.variant--non-room .variant__duration .tours-icon-time {
  font-size: 11px;
  font-weight: 600;
  margin-right: 6px;
}
.variant--non-room .variant__toggle-expanded {
  background-color: transparent;
  outline: none;
  border: none;
  color: #00aeef;
  font-weight: 600;
  padding: 0;
}
.variant--non-room .variant__pricing-wrap {
  margin-left: auto;
  flex: 0 0 20%;
}
@media (max-width: 1023px) {
  .variant--non-room .variant__pricing-wrap {
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    text-align: center;
    flex: 0 0 85px;
  }
}
@media (min-width: 1024px) {
  .variant--non-room .variant__pricing-wrap {
    flex: 0 0 28%;
    display: flex;
    flex-flow: column;
    align-items: flex-end;
  }
}
.variant--non-room .variant__strikethrough-price {
  color: #949494;
  line-height: 1.3;
  margin-bottom: 1px;
  text-decoration: line-through;
  white-space: nowrap;
}
.variant--non-room .variant__current-price-wrap {
  display: flex;
}
@media (max-width: 1023px) {
  .variant--non-room .variant__current-price-wrap {
    flex-flow: column nowrap;
    align-items: center;
    margin-top: 5px;
  }
}
@media (min-width: 1024px) {
  .variant--non-room .variant__current-price-wrap {
    flex-flow: row wrap;
    align-items: flex-end;
  }
}
.variant--non-room .variant__current-price {
  font-weight: bold;
  color: #00aeef;
  font-size: 16px;
  line-height: 1;
  white-space: nowrap;
}
@media (min-width: 1024px) {
  .variant--non-room .variant__current-price {
    margin: 0 6px 0 0;
    font-size: 24px;
  }
}
.variant--non-room .variant__inventory-name {
  color: #3a3a3a;
  font-weight: normal;
  line-height: 1.45;
}
@media (max-width: 1023px) {
  .variant--non-room .variant__inventory-name {
    font-size: 12px;
  }
}

.variant--non-room .variant__body {
    border-top: 1px solid #00aeef94;
    padding: 24px 0 30px;
}
.variant--non-room .variant__images {
    display: flex;
    /*flex-flow: row nowrap;*/
    flex-flow: wrap;
    /*overflow: auto;*/
    margin-bottom: 24px;
}
.variant--non-room .variant__image-btn {
    flex: 0 0 179px;
    height: 130px;
    margin-right: 10px;
    background-color: transparent;
    outline: none;
    border: none;
    outline: none;
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    margin: 10px;
    padding: 0;
}
.variant--non-room .variant__image {
    -o-object-fit: cover;
    object-fit: cover;
    height: 100%;
    width: 100%;
    border-radius: 8px;
    overflow: hidden;
}
.variant__overview {
    -webkit-line-clamp: 3;
    line-height: 1.67;
    overflow: hidden;
    color: #848484;
    margin-bottom: 20px;
}
.base-block-body p:last-child {
    margin-bottom: 0;
}

@media (max-width: 1024px) {
  .sticky-top-bar {
        margin-bottom: -30px;
    }
    .sticky-top-bar .container {
        overflow: hidden;
        display: flex;
        width: 100%;
    }
}
.sticky-top-bar {
    background-color: #fff;
    border: 0.5px solid #ececec;
    display: flex;
    flex-flow: row nowrap;
    overflow-x: visible;
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    z-index: 10;
    height: 47px;
}
/**/
.sticky-top-bar .container .top-bar-item:not(:last-child) {
    border-right: 1px solid #ececec;
}
.sticky-top-bar .container .top-bar-item-active {
    border-bottom: 2px solid #00aeef;
}
.sticky-top-bar .container .top-bar-item {
    line-height: 14px;
    font-weight: 600;
    padding: 15px;
    box-sizing: border-box;
    display: inline-block;
    display: inline-flex;
    flex: 1 1;
    min-width: 15%;
    justify-content: center;
}
.sticky-top-bar .container .top-bar-item button {
    color: #444;
    padding: 0;
    border: none;
    outline: none;
    background-color: transparent;
}

.base-block-head {
    font-size: 20px;
    font-weight: 600;
    color: #000;
    padding-left: 10px;
    border-left: 4px solid #00aeef;
    z-index: 0;
    padding: 0 0 0 23px;
        display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
    align-items: center;
    margin: 40px 0px 0px 0px;
}
/*--------------------policies-------------------------------*/

/*! CSS Used from: Embedded */

.policies__inner {
  display: flex;
  flex-flow: row wrap;
  overflow: hidden;
}
@media (min-width: 1024px) {
  .policies__inner {
    flex-flow: row nowrap;
  }
}
.policies__layout-item {
  flex: 0 0 100%;
}
@media (max-width: 1023px) {
  .policies__layout-item:first-child .policies__unit:first-child {
    margin-top: 10px;
  }
}
@media (min-width: 1024px) {
  .policies__layout-item {
    flex: 1 1;
  }
  .policies__layout-item:nth-child(2) {
    border-left: 1px solid #ececec;
    margin-left: 30px;
    padding-left: 40px;
  }
}
.policies__title {
  font-size: 16px !important;
  border-left: none !important;
  font-weight: 600;
  color: #555353;
  margin: 0;
  padding-left:0px !important;
}
.policies__content {
  padding-top: 15px;
}
.policies__content ul {
  padding: 0;
  list-style: none;
}
.policies__content ul li {
  line-height: 1.67;
  display: flex;
  margin-top: 5px;
}
.policies__content ul li:before {
  content: "";
  background-color: #00aeef;
  display: inline-block;
  height: 5px;
  flex: 0 0 5px;
  border-radius: 50%;
  margin-right: 14px;
  margin-top: 8px;
}
.policies__unit {
  margin-top: 30px;
}
@media (min-width: 1024px) {
  .policies__unit:first-child {
    margin-top: 0;
  }
}
.policies__title-wrap {
  display: flex;
  border: none;
  background: transparent;
  padding: 0;
  outline: none;
  line-height: 1.54;
}



/*-----------------------------------------------------------------------------------------------------------*/
/*! CSS Used from: Embedded */

.animated {
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}
.animated.animated-fast {
    -webkit-animation-duration: 0.3s;
    animation-duration: 0.3s;
}
.fadeIn {
    -webkit-animation-name: fadeIn;
    animation-name: fadeIn;
}
.inventory,
.inventory__pricing,
.inventory__counter {
    display: flex;
    align-items: center;
}
.ticketsBox{
    position: relative;
}

.booking-details__rooms-wrap {
    border-radius: 8px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.4);
    background-color: #fff;
    padding: 20px 24px;
    color: #555353;
    font-size: 14px;
    position: absolute;
    top: 72%;
    left: 0;
    width: 100%;
    max-height: 200px;
    overflow: auto;
    scrollbar-width: 0;
    -ms-overflow-style: none;
    display: none;
}
.booking-details__rooms-wrap::-webkit-scrollbar {
    display: none;
}
@media (max-width: 1023px) {
    .booking-details__rooms-wrap {
        bottom: calc(100% + 10px);
        top: unset;
    }
}
.booking-details__rooms-text {
    font-weight: 600;
    display: flex;
    justify-content: space-between;
}
.booking-details__close-rooms-dropdown {
    background-color: transparent;
    color: #0751c9;
    border: none;
    outline: none;
    text-decoration: underline;
    font-size: 12px;
    font-weight: 600;
}
.inventory {
    flex-flow: row nowrap;
}
.inventory:first-child {
    margin-top: 8px;
}
.inventory__name {
    line-height: 1;
}
.inventory__pricing {
    margin-left: auto;
    margin-right: 5px;
}
.inventory__counter {
    margin-left: auto;
        margin-top: 10px
}
.inventory__counter-btn {
    height: 15px;
    width: 15px;
    border: 1px solid #0751c9;
    color: #0751c9;
    border-radius: 4px;
    background-color: transparent;
    padding: 0;
    line-height: 1;
}
.inventory__quantity {
    margin: 0 13px;
    /*min-width: 15px;*/
    text-align: center;
}
.inventory__strike-through-amount {
    font-size: 11px;
    text-decoration: line-through;
    margin-right: 10px;
}
.inventory__current-amount {
    font-size: 12px;
    color: #0751c9;
    font-weight: bold;
}

/*! CSS Used keyframes */
@-webkit-keyframes fadeIn {
    0% {
        opacity: 0;
        visibility: hidden;
    }
    100% {
        opacity: 100%;
        visibility: unset;
    }
}
@keyframes fadeIn {
    0% {
        opacity: 0;
        visibility: hidden;
    }
    100% {
        opacity: 100%;
        visibility: unset;
    }
}
@-webkit-keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
/*.dd-menu li {
  padding: 10px 20px;
  cursor: pointer;
  white-space: nowrap;
}*/

/*.dd-menu li:hover {
  background-color: #f6f6f6;
}*/

/*.dd-menu li a {
  display: block;
  margin: -10px -20px;
  padding: 10px 20px;
}
*/
button:focus {
     outline: none!important; 
     outline: none !important; 
}
</style>
@section('content')
<?php $getExtraContent = $row->getExtraContentArray(); ?>
    <div class="bravo_detail_event">
        @include('Event::frontend.layouts.details.banner')
        <div class="bravo_content">
            <div class="container" id="bravo_event_book_app" v-cloak>
                <div class="row">
                    <div class="col-md-12 col-lg-9">
                         @php $review_score = $row->review_data @endphp
                        <div class="g-header">
                            <div class="left">
                                <h1>{!! clean($translation->title) !!}</h1>
                                @if($translation->address)
                                    <p class="address"><i class="fa fa-map-marker"></i>
                                        {{$translation->address}}
                                    </p>
                                @endif
                            </div>
                            <div class="right">
                                @if($row->getReviewEnable())
                                    @if($review_score)
                                        <div class="review-score">
                                            <div class="head">
                                                <div class="left">
                                                    <span class="head-rating">{{$review_score['score_text']}}</span>
                                                    <span class="text-rating">{{__("from :number reviews",['number'=>$review_score['total_review']])}}</span>
                                                </div>
                                                <div class="score">
                                                    {{$review_score['score_total']}}<span>/5</span>
                                                </div>
                                            </div>
                                            <div class="foot">
                                                {{__(":number% of guests recommend",['number'=>$row->recommend_percent])}}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <?php /*
                        @if(!empty($row->duration)  or !empty($row->location->name))
                        <div class="g-event-feature">
                            <div class="row">
                                <div class="col-xs-6 col-lg-3 col-md-6">
                                    <div class="item">
                                        <div class="icon">
                                            <i class="icofont-heart-beat"></i>
                                        </div>
                                        <div class="info">
                                            <h4 class="name">{{__("Wishlist")}}</h4>
                                            <p class="value">
                                                {{ __("People interest: :number",['number'=>$row->getNumberWishlistInService()]) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @if($row->start_time)
                                    <div class="col-xs-6 col-lg-3 col-md-6">
                                        <div class="item">
                                            <div class="icon">
                                                <i class="icofont-wall-clock"></i>
                                            </div>
                                            <div class="info">
                                                <h4 class="name">{{__("Start Time")}}</h4>
                                                <p class="value">
                                                    {{ $row->start_time }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($row->duration)
                                    <div class="col-xs-6 col-lg-3 col-md-6">
                                        <div class="item">
                                            <div class="icon">
                                                <i class="icofont-infinite"></i>
                                            </div>
                                            <div class="info">
                                                <h4 class="name">{{__("Duration")}}</h4>
                                                <p class="value">
                                                    {{duration_format($row->duration)}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($row->location->name))
                                    @php $location =  $row->location->translateOrOrigin(app()->getLocale()) @endphp
                                    <div class="col-xs-6 col-lg-3 col-md-6">
                                        <div class="item">
                                            <div class="icon">
                                                <i class="icofont-island-alt"></i>
                                            </div>
                                            <div class="info">
                                                <h4 class="name">{{__("Location")}}</h4>
                                                <p class="value">
                                                    {{$location->name ?? ''}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif */ ?>
                        <div class="g-overview">
                            <div class="description">
                                <div class="section-div">
                                    @include('Event::frontend.layouts.details.attributes')
                                </div>
                                <div class="section-div">
                                     <h3>{{ strtolower($translation->title) }} {{__("Heighlights")}}</h3>
                                     <div class="contentDiv">
                                        {!!  $translation->highlight_content !!}
                                            
                                     </div>
                                </div>
                                <div class="section-div">
                                     <h3>{{ strtolower($translation->title) }} {{__("Overview")}}</h3>
                                     <div class="contentDiv aboutDiv">
                                        {!!  $translation->content !!}
                                     </div>
                                     <button type="button" class="moreless-button link-btn-v2 read-more-btn">Read More</button>
                                </div>
                                 
                            </div>
                        </div>
                        <div class="sticky-top-bar" id="sticky-variant-table-bar">
                            <div class="container" id="sticky-top-bar-container">
                                <span class="top-bar-item top-bar-item-active"><button type="button" data-section="packages">Options</button></span>
                                <span class="top-bar-item"><button type="button" data-section="gallery">Gallery</button></span>
                                <span class="top-bar-item"><button type="button" data-section="map">Map</button></span>
                                <span class="top-bar-item"><button type="button" data-section="reviews">Reviews</button></span>
                                <span class="top-bar-item"><button type="button" data-section="policies">Policies</button></span>
                                <span class="top-bar-item"><button type="button" data-section="faqs">FAQs</button></span>
                            </div>
                        </div>
                        <div class="divSection ticketsSection" id="section_packages">
                            <div id="tab1" class="tab-pane active">
                                <div class="ticket-container">
                                    <h2 class="base-block-head">Select Package Option</h2>
                                @if(!empty($row->tickets) and count($row->tickets) > 0)
                                    @foreach($row->tickets as $key => $ticket )
                                    <div class="ticket-row base-block-body">
                                        <div class="variant variant--non-room variant--unselected">
                                            <div class="variant__head">
                                                 <div class="radio-button variant__radio tours-icon-radio-unselected">
                                                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" @click="selectTicket('{{$key}}', $event)" is_checked="false">
                                                </div>
                                                <div class="variant__head-content" for="flexRadioDefault1">
                                                    <h3 class="variant__title">{{$ticket->title}}</h3>
                                                    <div class="variant__duration"><i class="fa fa-clock-o" aria-hidden="true"></i> {{$row->duration}} Hours</div>
                                                    <button type="button" class="variant__toggle-expanded collapseButton" data-toggle="collapse" data-target="#collapse_{{$key}}" @click="onHideShow($event)">Show Details</button>
                                                </div>
                                                <div class="variant__pricing-wrap">
                                                    <div class="variant__pricing">
                                                        <div class="variant__strikethrough-price">₹ {{$ticket->price}}</div>
                                                        <div class="variant__current-price-wrap">
                                                            <div class="variant__current-price">₹ {{$ticket->sale_price}}</div>
                                                            <div class="variant__inventory-name">Per Adult</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapse_{{$key}}" class="collapse ticketCollapse">
                                               <div class="variant__body">
                                                @if($ticket->getGallery())
                                                    <div class="variant__images">
                                                        @foreach($ticket->getGallery() as $key=>$item)
                                                        <button type="button" class="variant__image-btn">
                                                            <img
                                                                src="{{$item['large']}}"
                                                                alt="{{$ticket->title}}"
                                                                class="variant__image"
                                                            />
                                                        </button>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    <div class="variant__overview">
                                                        {!! $ticket->content !!}
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

                        <div class="g-overview">
                            <div class="description">
                                 @if(isset($getExtraContent['duration_timings']))
                                 <?php $duration_timings = $getExtraContent['duration_timings']; ?>
                                <div class="section-div">
                                     <h3>{{ $duration_timings['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $duration_timings['content'] !!}
                                     </div>
                                </div>
                                @endif

                                @if(isset($getExtraContent['itinerary']))
                                 <?php $itinerary = $getExtraContent['itinerary']; ?>
                                <div class="section-div">
                                     <h3>{{ $itinerary['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $itinerary['content'] !!}
                                     </div>
                                </div>
                                @endif

                                @if(isset($getExtraContent['tickets_eligibility']))
                                 <?php $tickets_eligibility = $getExtraContent['tickets_eligibility']; ?>
                                <div class="section-div">
                                     <h3>{{ $tickets_eligibility['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $tickets_eligibility['content'] !!}
                                     </div>
                                </div>
                                @endif


                                @if(isset($getExtraContent['how_to_use_ticket']))
                                 <?php $how_to_use_ticket = $getExtraContent['how_to_use_ticket']; ?>
                                <div class="section-div">
                                     <h3>{{ $how_to_use_ticket['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $how_to_use_ticket['content'] !!}
                                     </div>
                                </div>
                                @endif
                                @if(isset($getExtraContent['remarks']))
                                 <?php $remarks = $getExtraContent['remarks']; ?>
                                <div class="section-div">
                                     <h3>{{ $remarks['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $remarks['content'] !!}
                                     </div>
                                </div>
                                @endif

                                @if(isset($getExtraContent['inclusive']))
                                 <?php $inclusive = $getExtraContent['inclusive']; ?>
                                <div class="section-div">
                                     <h3>{{ $inclusive['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $inclusive['content'] !!}
                                     </div>
                                </div>
                                @endif

                                @if(isset($getExtraContent['not_inclusive']))
                                 <?php $not_inclusive = $getExtraContent['not_inclusive']; ?>
                                <div class="section-div">
                                     <h3>{{ $not_inclusive['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $not_inclusive['content'] !!}
                                     </div>
                                </div>
                                @endif
                                @if(isset($getExtraContent['pick_up_information']))
                                 <?php $pick_up_information = $getExtraContent['pick_up_information']; ?>
                                <div class="section-div">
                                     <h3>{{ $pick_up_information['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $pick_up_information['content'] !!}
                                     </div>
                                </div>
                                @endif
                                @if(isset($getExtraContent['what_to_bring']))
                                 <?php $what_to_bring = $getExtraContent['what_to_bring']; ?>
                                <div class="section-div">
                                     <h3>{{ $what_to_bring['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $what_to_bring['content'] !!}
                                     </div>
                                </div>
                                @endif
                                @if(isset($getExtraContent['more_details_about']))
                                 <?php $more_details_about = $getExtraContent['more_details_about']; ?>
                                <div class="section-div">
                                     <h3>{{ $more_details_about['title'] }}</h3>
                                     <div class="contentDiv">
                                        {!! $more_details_about['content'] !!}
                                     </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @include('Event::frontend.layouts.details.detail')

                        <div class="divSection policies" id="section_policies">
                            <div class="base-block">
                                <div class="container">
                                    <h2 class="base-block-head">{{ strtolower($translation->title) }} Policies</h2>
                                    <div class="base-block-body">
                                        <div class="policies__inner">
                                            <div class="policies__layout-item">
                                                @if(isset($getExtraContent['confirmation_policy']))
                                                <?php $confirmation_policy = $getExtraContent['confirmation_policy'];?>
                                                <div class="policies__unit">
                                                    <button type="button" class="policies__title-wrap">
                                                        <h3 class="policies__title">{{ $confirmation_policy['title'] }}</h3>
                                                    </button>
                                                    <div class="ReactCollapse--collapse" style="height: auto; overflow: initial;">
                                                        <div class="ReactCollapse--content">
                                                            <div class="policies__content">
                                                                {!! $confirmation_policy['content'] !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if(isset($getExtraContent['refund_policy']))
                                                <?php $refund_policy = $getExtraContent['refund_policy']; ?>
                                                <div class="policies__unit">
                                                    <button type="button" class="policies__title-wrap">
                                                        <h3 class="policies__title">{{ $refund_policy['title'] }}</h3>
                                                    </button>
                                                    <div class="ReactCollapse--collapse" style="height: auto; overflow: initial;">
                                                        <div class="ReactCollapse--content">
                                                            <div class="policies__content">
                                                                {!! $refund_policy['content'] !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if(isset($getExtraContent['booking_policy']))
                                                <?php $booking_policy = $getExtraContent['booking_policy']; ?>
                                                <div class="policies__unit">
                                                    <button type="button" class="policies__title-wrap">
                                                        <h3 class="policies__title">{{ $booking_policy['title'] }}</h3>
                                                    </button>
                                                    <div class="ReactCollapse--collapse" style="height: auto; overflow: initial;">
                                                        <div class="ReactCollapse--content">
                                                            <div class="policies__content">
                                                                {!! $booking_policy['content'] !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="policies__layout-item">
                                                @if(isset($getExtraContent['cancellation_policy']))
                                                <?php $cancellation_policy = $getExtraContent['cancellation_policy']; ?>
                                                <div class="policies__unit">
                                                    <button type="button" class="policies__title-wrap">
                                                        <h3 class="policies__title">{{ $cancellation_policy['title'] }}</h3>
                                                    </button>
                                                    <div class="ReactCollapse--collapse" style="height: auto; overflow: initial;">
                                                        <div class="ReactCollapse--content">
                                                            <div class="policies__content">
                                                                {!! $cancellation_policy['content'] !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if(isset($getExtraContent['payment_terms_policy']))
                                                <?php $payment_terms_policy = $getExtraContent['payment_terms_policy']; ?>
                                                <div class="policies__unit">
                                                    <button type="button" class="policies__title-wrap">
                                                        <h3 class="policies__title">{{ $payment_terms_policy['title'] }}</h3>
                                                    </button>
                                                    <div class="ReactCollapse--collapse" style="height: auto; overflow: initial;">
                                                        <div class="ReactCollapse--content">
                                                            <div class="policies__content">
                                                                {!! $payment_terms_policy['content'] !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divSection" id="section_reviews">
                            @include('Event::frontend.layouts.details.review')
                        </div>
                        
                        @if($translation->faqs)
                        <div class="divSection g-faq" id="section_faqs">
                            <h3> {{__("FAQs")}} </h3>
                            @foreach($translation->faqs as $item)
                                <div class="item">
                                    <div class="header">
                                        <i class="field-icon icofont-support-faq"></i>
                                        <h5>{{$item['title']}}</h5>
                                        <span class="arrow"><i class="fa fa-angle-down"></i></span>
                                    </div>
                                    <div class="body">
                                        {!! $item['content'] !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                        
                    </div>
                    <div class="col-md-12 col-lg-3">
                        @include('Tour::frontend.layouts.details.vendor')
                        @include('Event::frontend.layouts.details.form-book')
                    </div>
                </div>
                <div class="row end_tour_sticky">
                    <div class="col-md-12">
                        @include('Event::frontend.layouts.details.related')
                    </div>
                </div>
            </div>
        </div>
        @include('Event::frontend.layouts.details.form-book-mobile')
    </div>
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
			no_date_select:'{{__('Please select Start and End date')}}',
            no_guest_select:'{{__('Please select at least one number')}}',
            load_dates_url:'{{route('event.vendor.availability.loadDates')}}'
        };
    </script>
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/event/js/single-event.js?_ver='.config('app.version')) }}"></script>
@endsection
