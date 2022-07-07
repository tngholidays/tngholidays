<div class="modal-dialog modal-dialog-centered modal-lg change_booking_room">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Hotel Rooms</h2>


                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body dataFilterDiv">
                <div class="row">
                  <div class="form-group col-md-12">
                      <input type="text" value="" placeholder="{{__("Search...")}}" name="search" data-search="hotels" class="form-control searchInputBox">
                  </div>
                </div>
              <input type="hidden" id="changeFromHotel" value="">
                <div class="hotel-rooms">
                  @if(count($rooms) > 0)
                    <ul class="HotelCardList dataFilter">
                    @foreach ($rooms as $room)
                        <?php
                          $default_hotels = array();
                          $default_hotels = $current;
                           $room->getCustomDatesInRange($start_date,'','single');
                           $img = get_file_url($room->image_id,'thumb');
                           $roomPrice = @$room->price * $current['days'];
                           $currentRoomPrice = $current['default_room_price'];

                           $totalRoomPrice = $currentRoomPrice - $roomPrice;
                           $rateFlag = true;
                           if ($currentRoomPrice == $roomPrice) {
                               $sign = "";
                           }else if ($currentRoomPrice > $roomPrice) {
                              $sign = "-";
                              $rateFlag = false;
                           }
                           else{
                               $sign = "+";
                           }
                           
                           $default_hotels['room'] = @$room->id;
                           $default_hotels['room_name'] = $room->title;
                           $default_hotels['room_price'] = $room->price;
                           $default_hotels['total_price'] = $roomPrice;
                           $default_hotels['rateFlag'] = $rateFlag;
                           $default_hotels['totalDiffPrice'] = abs($totalRoomPrice);
                        ?>
                        <li class="appendRight20 relative data_filter" data-filter-hotels="{{strtolower($room->title)}}">
                            <div class="altAcc"><span class="altAccoContainer">Room</span></div>
                            <img class="borderRadius4" src="{{$img}}" alt="{{$room->title}}" />
                            <p class="hotel-name" title="{{$room->title}}">{{$room->title}}</p>
                            <div class="makeFlex">
                                <p class="font12">{{$sign}} ₹{{abs($totalRoomPrice)}}</p>
                                <input type="hidden" class="default_hotels" value="{{json_encode($default_hotels)}}">
                                <span class="wdth140"><a data-index="0" href="javascript:void(0);" class="primaryBtnWhite changeRoomNow">Include</a></span>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                  @else
                    <div class="ResultNotFound"> <h3>sorry,we did not found rooms.</h3> </div>
                  @endif
                </div>
            </div>
        </div>
    </div>