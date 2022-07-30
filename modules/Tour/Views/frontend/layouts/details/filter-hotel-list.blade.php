@if(count($hotels) > 0)
    <ul class="HotelCardList dataFilter">
    @foreach ($hotels as $hotel)
        <?php
           $default_hotels = $current;
           $img = get_file_url($hotel->image_id,'thumb');
           $getHotelStandardRoom = getHotelStandardRoom($hotel->id);
           $getHotelStandardRoom->getCustomDatesInRange($start_date,'','single');
           $StandardRoomPrice = @$getHotelStandardRoom->price * $current['days'];
           $currentRoomPrice = $current['default_room_price'];
           $totalRoomPrice = $currentRoomPrice - $StandardRoomPrice;
           $rateFlag = true;
           if ($currentRoomPrice == $StandardRoomPrice) {
               $sign = "";
           }else if ($currentRoomPrice > $StandardRoomPrice) {
              $sign = "-";
              $rateFlag = false;
           }
           else{
               $sign = "+";
           }
           $default_hotels['hotel'] = $hotel->id;
           $default_hotels['hotel_img'] = $img;
           $default_hotels['hotel_name'] = $hotel->title;
           $default_hotels['room'] = @$getHotelStandardRoom->id;
           $default_hotels['room_name'] = $getHotelStandardRoom->title;
           $default_hotels['room_price'] = @$getHotelStandardRoom->price;
           $default_hotels['total_price'] = $StandardRoomPrice;
           $default_hotels['rateFlag'] = $rateFlag;
           $default_hotels['totalDiffPrice'] = abs($totalRoomPrice)

        ?>
        <li class="appendRight20 relative data_filter" data-filter-hotels="{{strtolower($hotel->title)}}">
            <div class="altAcc"><span class="altAccoContainer">Hotel</span></div>
            <img class="borderRadius4 hotelImg changeRoomFromHotel" src="{{$img}}" alt="{{$hotel->title}}" />
            
            <p class="hotel-name" title="{{$hotel->title}}">{{$hotel->title}}</p>
            <div class="rating-star">
              @if($hotel->star_rate)
                  <div class="star-rate">
                      @for ($star = 1 ;$star <= $hotel->star_rate ; $star++)
                          <i class="fa fa-star"></i>
                      @endfor
                  </div>
              @endif
            </div>
            <p class="hotel-location" title="South Pattaya">{{@$hotel->location->name}}</p>
            <p class="per-person">Price/Person</p>
            <div class="makeFlex">
                <p class="font12" style="display: none;">{{$sign}} ₹{{abs($totalRoomPrice)}}</p>
                <input type="hidden" class="default_hotels" value="{{json_encode($default_hotels)}}">
                <a href="javascript:void(0);" class="font12 changeHotelNow {{$hotel->slug=='no-hotel' ? 'NoHotelDiv':''}}" data-type="{{$hotel->slug=='no-hotel' ? '1':'0'}}">change</a>
            </div>
        </li>
    @endforeach
    </ul>
    @else
      <div class="ResultNotFound"> <h3>sorry,we did not found similar hotels.</h3> </div>
    @endif