<?php
/**
 * @var $translation \Modules\Event\Models\EventTranslation
 * @var $row \Modules\Event\Models\Event
 */
?>



@if($row->getGallery())
<div class="divSection g-gallery" id="section_gallery">
    <h3>{{__("Gallery")}}</h3>
    <div class="fotorama" data-width="100%" data-thumbwidth="135" data-thumbheight="135" data-thumbmargin="15" data-nav="thumbs" data-allowfullscreen="true">
        @foreach($row->getGallery() as $key=>$item)
            <a href="{{$item['large']}}" data-thumb="{{$item['thumb']}}" data-alt="{{ __("Gallery") }}"></a>
        @endforeach
    </div>
    <div class="social">
        <div class="social-share">
            <span class="social-icon">
                <i class="icofont-share"></i>
            </span>
            <ul class="share-wrapper">
                <li>
                    <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Facebook")}}">
                        <i class="fa fa-facebook fa-lg"></i>
                    </a>
                </li>
                <li>
                    <a class="twitter" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Twitter")}}">
                        <i class="fa fa-twitter fa-lg"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
            <i class="fa fa-heart-o"></i>
        </div>
    </div>
</div>
@endif



<div class="bravo-hr"></div>
@includeIf("Hotel::frontend.layouts.details.hotel-surrounding")
<div class="bravo-hr"></div>

@if($row->map_lat && $row->map_lng)
<div class="divSection g-location" id="section_map">
    <h3>{{__("Map")}}</h3>
    <div class="location-map">
        <div id="map_content"></div>
    </div>
</div>
@endif 



