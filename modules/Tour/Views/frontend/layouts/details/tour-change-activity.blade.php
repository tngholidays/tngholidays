<div class="modal-dialog modal-dialog-centered modal-lg change_booking_hotel">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{__("Activities")}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="similar-hotels">
              @if(count($termss) > 0)
                <ul class="HotelCardList">
                @foreach ($termss as $term)
                <?php 
                  $img = get_file_url($term->image_id,'thumb'); 
                  $term['img_url'] = $img;
                  $term['attr_type'] = $term->attribute->type;
                ?>
                    <li class="appendRight20 relative">
                        <div class="altAcc"><span class="altAccoContainer">Acivity</span></div>
                        <img class="borderRadius4 hotelImg" src="{{$img}}" alt="{{$term->name}}" />
                        
                        <p class="hotel-name" title="{{$term->name}}">{{$term->name}}</p>
                  <!--       <p class="hotel-name" title="{{$term->name}}">{{$term->duration}}</p>
                        <p class="hotel-name" title="{{$term->name}}">{{$term->time_zone}}</p> -->
                        <p class="hotel-location" title="Test"></p>
                        <p class="per-person">Price/Person</p>
                        <?php $price = (int)$term->price + (int)$term->transfer_price; ?>

                        <div class="makeFlex">
                            <input type="hidden" class="json_input" value="{{json_encode($term)}}">
                            <p class="font12" style="display: none;">{{$price}}</p>
                            <a href="javascript:void(0);" class="font12 changeActivity" data-price="{{$price}}" data-timezone="{{$term->time_zone}}" data-index="{{$index}}">Add Now</a>
                        </div>
                    </li>
                @endforeach
                </ul>
                @else
                  <div class="ResultNotFound"> <h3>sorry,we did not found.</h3> </div>
                @endif
            </div>
        </div>
    </div>
</div>