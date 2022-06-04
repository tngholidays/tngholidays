@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="item">
    @if($row->is_featured == "1")
        <div class="featured">
            {{__("Featured")}}
        </div>
    @endif
    <div class="header-thumb">
        @if($row->discount_percent)
            <div class="sale_info">{{$row->discount_percent}}</div>
        @endif
        @if($row->image_url)
            @if(!empty($disable_lazyload))
                <img src="{{$row->image_url}}" class="img-responsive" alt="{{$location->name ?? ''}}">
            @else
                {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]) !!}
            @endif
        @endif
        <a class="st-btn st-btn-primary tour-book-now" href="{{$row->getDetailUrl()}}">{{__("Book now")}}</a>
        <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
            <i class="fa fa-heart"></i>
        </div>
    </div>
    <div class="caption clear">
        <div class="title-address">
            <h3 class="title"><a href="{{$row->getDetailUrl()}}"> {!! clean($translation->title) !!} </a></h3>
            <p class="duration">
                {{ $row->tour_duration}}
            </p>
        </div>
        <div class="g-price">
            <div class="price">
                <span class="onsale">{{ $row->display_sale_price }}</span>
                <span class="text-price">{{ $row->display_price }}</span>
            </div>
        </div>
         @php
            $attributes = \Modules\Core\Models\Terms::getTermsById($row->tour_term->pluck('term_id'));
        @endphp
       
    </div>
     <div class="tourFacilities clear">
        <div class="list-star">
            <ul class="booking-item-rating-stars">
            @if(!empty($attributes) and count($attributes[2]) > 0 && count($attributes[2]['child']) > 0)
                @foreach($attributes[2]['child'] as $term )
                <li><i class="{{ $term->icon ?? "icofont-check-circled icon-default" }}"></i></li>
                @endforeach
            @endif
            </ul>
        </div>
    </div>
</div>