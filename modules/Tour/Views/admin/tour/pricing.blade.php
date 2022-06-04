<div class="panel">
    <div class="panel-title"><strong>{{__("Pricing")}}</strong></div>
    <div class="panel-body">
        @if(is_default_lang())
            <h3 class="panel-body-title">{{__("Tour Price")}}</h3>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{__("Price")}}</label>
                        <input type="number" min="0" name="price" class="form-control" value="{{$row->price}}" placeholder="{{__("Tour Price")}}">
                    </div>
                </div>
                           <?php $hotelPrice = 0; ?>
                @if(!empty($row->meta->default_hotels))
                    @foreach($row->meta->default_hotels as $key=>$default_hotels)
                    <?php $hotelPrice += $default_hotels['total_price']; ?>
                    @endforeach
                @endif
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{__("Sightseeing Price")}}</label>
                        <input type="text" name="sightseeing_Price" class="form-control sightseeingPrice" value="{{$row->sightseeing_Price}}" placeholder="{{__("Tour Sightseeing Price")}}" readonly="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{__("Transfers Price")}}</label>
                        <input type="text" name="transfers_price" class="form-control transfersPrice" value="{{$row->transfers_price}}" placeholder="{{__("Tour Transfers Price")}}" readonly="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{__("Hotel Price")}}</label>
                        <input type="text" name="hotel_price" class="form-control totalHotelPrice" value="{{$hotelPrice}}" placeholder="{{__("Tour Hotel Price")}}" readonly="">
                    </div>
                </div>
     
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label">{{__("Sale Price")}}</label>
                        <!-- <input type="text" name="hotel_price" class="form-control totalHotelPrice" value="{{$hotelPrice}}"> -->
                        <input type="text" name="before_sale_price" class="form-control beforeSalePrice" value="{{$row->before_sale_price}}" placeholder="{{__("Tour Sale Price")}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label">{{__("Total Sale Price")}}</label>
                        <input type="text" name="sale_price" class="form-control totalSalePrice" value="{{$row->sale_price}}" placeholder="{{__("Tour Sale Price")}}" readonly="">
                    </div>
                </div>
                <div class="col-lg-12">
                    <span>
                        {{__("If the regular price is less than the discount , it will show the regular price")}}
                    </span>
                </div>
            </div>
            <hr>
        @endif
        @if(is_default_lang())
            <h3 class="panel-body-title">{{__('Person Types')}}</h3>
            <div class="form-group">
                <label><input type="checkbox" name="enable_person_types" @if(!empty($row->meta->enable_person_types)) checked @endif value="1"> {{__('Enable Person Types')}}
                </label>
            </div>
            <div class="form-group-item" data-condition="enable_person_types:is(1)">
                <label class="control-label">{{__('Person Types')}}</label>
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-5">{{__("Person Type")}}</div>
                        <div class="col-md-2">{{__('Min')}}</div>
                        <div class="col-md-2">{{__('Max')}}</div>
                        <div class="col-md-2">{{__('Price')}}</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    <?php  $languages = \Modules\Language\Models\Language::getActive();  ?>
                    @if(!empty($row->meta->person_types))
                        @foreach($row->meta->person_types as $key=>$person_type)
                            <div class="item" data-number="{{$key}}">
                                <div class="row">
                                    <div class="col-md-5">
                                        @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                            @foreach($languages as $language)
                                                <?php $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                                <div class="g-lang">
                                                    <div class="title-lang">{{$language->name}}</div>
                                                    <input type="text" name="person_types[{{$key}}][name{{$key_lang}}]" class="form-control personName" value="{{$person_type['name'.$key_lang] ?? ''}}" placeholder="{{__('Eg: Adults')}}">
                                                    <input type="text" name="person_types[{{$key}}][desc{{$key_lang}}]" class="form-control" value="{{$person_type['desc'.$key_lang] ?? ''}}" placeholder="{{__('Description')}}">
                                                </div>
                                            @endforeach
                                        @else
                                            <input type="text" name="person_types[{{$key}}][name]" class="form-control" value="{{$person_type['name'] ?? ''}}" placeholder="{{__('Eg: Adults')}}">
                                            <input type="text" name="person_types[{{$key}}][desc]" class="form-control" value="{{$person_type['desc'] ?? ''}}" placeholder="{{__('Description')}}">
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" min="0" name="person_types[{{$key}}][min]" class="form-control" value="{{$person_type['min'] ?? 0}}" placeholder="{{__("Minimum per booking")}}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" min="0" name="person_types[{{$key}}][max]" class="form-control" value="{{$person_type['max'] ?? 0}}" placeholder="{{__("Maximum per booking")}}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" min="0" name="person_types[{{$key}}][price]" class="form-control totalPersonPrice" value="{{$person_type['price'] ?? 0}}" placeholder="{{__("per 1 item")}}">
                                    </div>
                                    <div class="col-md-1">
                                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                    <?php 
                      $default_person_types = array(['name'=>'Adult','desc'=>'Age 12+','min'=>2,'max'=>20],['name'=>'Child','desc'=>'Age 6-12','min'=>null,'max'=>null]);
                    ?>
                    @foreach($default_person_types as $key=>$person_type)
                            <div class="item" data-number="{{$key}}">
                                <div class="row">
                                    <div class="col-md-5">
                                        @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                            @foreach($languages as $language)
                                                <?php $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                                <div class="g-lang">
                                                    <div class="title-lang">{{$language->name}}</div>
                                                    <input type="text" name="person_types[{{$key}}][name{{$key_lang}}]" class="form-control personName" value="{{$person_type['name']}}" readonly="">
                                                    <input type="text" name="person_types[{{$key}}][desc{{$key_lang}}]" class="form-control" value="{{$person_type['desc']}}" >
                                                </div>
                                            @endforeach
                                        @else
                                            <input type="text" name="person_types[{{$key}}][name]" class="form-control" value="{{$person_type['name']}}" placeholder="{{__('Eg: Adults')}}">
                                            <input type="text" name="person_types[{{$key}}][desc]" class="form-control" value="{{$person_type['desc']}}" placeholder="{{__('Description')}}">
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" min="0" name="person_types[{{$key}}][min]" class="form-control" value="{{$person_type['min']}}" placeholder="{{__("Minimum per booking")}}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" min="0" name="person_types[{{$key}}][max]" class="form-control" value="{{$person_type['max']}}" placeholder="{{__("Maximum per booking")}}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" min="0" name="person_types[{{$key}}][price]" class="form-control totalPersonPrice" value="" placeholder="{{__("per 1 item")}}">
                                    </div>
                                    <div class="col-md-1">
                                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                </div>
                <div class="g-more hide">
                    <div class="item" data-number="__number__">
                        <div class="row">
                            <div class="col-md-5">
                                @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                    @foreach($languages as $language)
                                        <?php $key = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                        <div class="g-lang">
                                            <div class="title-lang">{{$language->name}}</div>
                                            <input type="text" __name__="person_types[__number__][name{{$key}}]" class="form-control personName" value="" placeholder="{{__('Eg: Adults')}}">
                                            <input type="text" __name__="person_types[__number__][desc{{$key}}]" class="form-control" value="" placeholder="{{__('Description')}}">
                                        </div>
                                    @endforeach
                                @else
                                    <input type="text" __name__="person_types[__number__][name]" class="form-control" value="" placeholder="{{__('Eg: Adults')}}">
                                    <input type="text" __name__="person_types[__number__][desc]" class="form-control" value="" placeholder="{{__('Description')}}">
                                @endif
                            </div>
                            <div class="col-md-2">
                                <input type="number" min="0" __name__="person_types[__number__][min]" class="form-control" value="" placeholder="{{__("Minimum per booking")}}">
                            </div>
                            <div class="col-md-2">
                                <input type="number" min="0" __name__="person_types[__number__][max]" class="form-control" value="" placeholder="{{__("Maximum per booking")}}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" min="0" __name__="person_types[__number__][price]" class="form-control totalPersonPrice" value="{{$row->sale_price}}" placeholder="{{__("per 1 item")}}">
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(is_default_lang())
            <hr>
            <h3 class="panel-body-title app_get_locale">{{__('Extra Price')}}</h3>
            <div class="form-group app_get_locale">
                <label><input type="checkbox" name="enable_extra_price" @if(!empty($row->meta->enable_extra_price)) checked @endif value="1"> {{__('Enable extra price')}}
                </label>
            </div>
            <div class="form-group-item" data-condition="enable_extra_price:is(1)">
                <label class="control-label">{{__('Extra Price')}}</label>
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-5">{{__("Name")}}</div>
                        <div class="col-md-3">{{__('Price')}}</div>
                        <div class="col-md-3">{{__('Type')}}</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    @if(!empty($row->meta->extra_price))
                        @foreach($row->meta->extra_price as $key=>$extra_price)
                            <div class="item" data-number="{{$key}}">
                                <div class="row">
                                    <div class="col-md-5">
                                        @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                            @foreach($languages as $language)
                                                <?php $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                                <div class="g-lang">
                                                    <div class="title-lang">{{$language->name}}</div>
                                                    <input type="text" name="extra_price[{{$key}}][name{{$key_lang}}]" class="form-control" value="{{$extra_price['name'.$key_lang] ?? ''}}" placeholder="{{__('Extra price name')}}">
                                                </div>
                                            @endforeach
                                        @else
                                            <input type="text" name="extra_price[{{$key}}][name]" class="form-control" value="{{$extra_price['name'] ?? ''}}" placeholder="{{__('Extra price name')}}">
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" min="0" name="extra_price[{{$key}}][price]" class="form-control" value="{{$extra_price['price']}}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="extra_price[{{$key}}][type]" class="form-control">
                                            <option @if($extra_price['type'] ==  'one_time') selected @endif value="one_time">{{__("One-time")}}</option>
                                            <option @if($extra_price['type'] ==  'per_hour') selected @endif value="per_hour">{{__("Per hour")}}</option>
                                            <option @if($extra_price['type'] ==  'per_day') selected @endif value="per_day">{{__("Per day")}}</option>
                                        </select>

                                        <label>
                                            <input type="checkbox" min="0" name="extra_price[{{$key}}][per_person]" value="on" @if($extra_price['per_person'] ?? '') checked @endif >
                                            {{__("Price per person")}}
                                        </label>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                </div>
                <div class="g-more hide">
                    <div class="item" data-number="__number__">
                        <div class="row">
                            <div class="col-md-5">
                                @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                    @foreach($languages as $language)
                                        <?php $key = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                        <div class="g-lang">
                                            <div class="title-lang">{{$language->name}}</div>
                                            <input type="text" __name__="extra_price[__number__][name{{$key}}]" class="form-control" value="" placeholder="{{__('Extra price name')}}">
                                        </div>
                                    @endforeach
                                @else
                                    <input type="text" __name__="extra_price[__number__][name]" class="form-control" value="" placeholder="{{__('Extra price name')}}">
                                @endif
                            </div>
                            <div class="col-md-3">
                                <input type="text" min="0" __name__="extra_price[__number__][price]" class="form-control" value="">
                            </div>
                            <div class="col-md-3">
                                <select __name__="extra_price[__number__][type]" class="form-control">
                                    <option value="one_time">{{__("One-time")}}</option>
                                    <option value="per_hour">{{__("Per hour")}}</option>
                                    <option value="per_day">{{__("Per day")}}</option>
                                </select>

                                <label>
                                    <input type="checkbox" min="0" __name__="extra_price[__number__][per_person]" value="on">
                                    {{__("Price per person")}}
                                </label>
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif  

        @if(is_default_lang())
            <hr>
            <h3 class="panel-body-title app_get_locale">Default Hotels</h3>
            <div class="form-group app_get_locale">
                <label><input type="checkbox" name="enable_default_hotels" @if(!empty($row->meta->enable_default_hotels)) checked @endif value="1"> {{__('Enable default hotel')}}
                </label>
            </div>
            <div class="form-group-item defaultHotels" data-condition="enable_default_hotels:is(1)">
                <label class="control-label">Default Hotels</label>
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-3">Location</div>
                        <div class="col-md-3">Hotel</div>
                        <div class="col-md-2">Room</div>
                        <div class="col-md-2 pad-02">Days</div>
                        <div class="col-md-2 pad03">Total</div>
                    </div>
                </div>
                <div class="g-items">
                    @if(!empty($row->meta->default_hotels))
                        @foreach($row->meta->default_hotels as $key=>$default_hotels)
                            <div class="item" data-number="{{$key}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="default_hotels[{{$key}}][location_id]" class="form-control hotelLocation">
                                            <option value="">{{__("-- Please Select --")}}</option>
                                            <?php
                                            $traverse = function ($locations, $prefix = '') use (&$traverse, $default_hotels) {
                                                foreach ($locations as $location) {
                                                    $selected = '';
                                                    if ($default_hotels['location_id'] == $location->id)
                                                        $selected = 'selected';
                                                    printf("<option value='%s' %s>%s</option>", $location->id, $selected, $prefix . ' ' . $location->name);
                                                    $traverse($location->children, $prefix . '-');
                                                }
                                            };
                                            $traverse($tour_location);
                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-md-3">
                                        <select name="default_hotels[{{$key}}][hotel]" class="form-control hotelDropDown">
                                                <option value="">Select Hotel</option>
                                                @foreach (getHotelsByLocation($default_hotels['location_id']) as $hotel)
                                                    <option value="{{ $hotel->id }}" @if($default_hotels['hotel'] == $hotel->id) selected @endif>{{ $hotel->title }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="default_hotels[{{$key}}][room]" class="form-control hotelroomDropDown">
                                                <option value="">Select Room</option>
                                                @foreach (getRoomsByHotel($default_hotels['hotel']) as $room)
                                                    <option value="{{$room->id }}" price="{{$room->price}}" @if($default_hotels['room'] == $room->id) selected @endif>{{ $room->title }}</option>
                                                @endforeach
                                        </select>
                                        <input type="text" min="0" name="default_hotels[{{$key}}][room_price]" class="form-control roomPrice" value="{{$default_hotels['room_price']}}" readonly>
                                    </div>
                                    <div class="col-md-2 pad-02">
                                        <select name="default_hotels[{{$key}}][days]" class="form-control RoomDays">
                                            @for ($i = 0.5; $i <= 10; $i += 0.5))
                                                <option value="{{$i}}" @if($default_hotels['days'] == $i) selected @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-2 pad03">
                                        <div class="TotalDiv">
                                        <input type="text" min="0" name="default_hotels[{{$key}}][total_price]" class="form-control totalPrice" value="{{$default_hotels['total_price']}}" readonly>
                                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                         </div>
                                         <label>
                                            <input type="checkbox" name="default_hotels[{{$key}}][remove_status]" @if(isset($default_hotels['remove_status']) && !empty($default_hotels['remove_status'])) checked @endif value="1"> {{__("Disable Remove")}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                </div>
                <div class="g-more hide">
                    <div class="item" data-number="__number__">
                        <div class="row">
                            <div class="col-md-3">
                                <select __name__="default_hotels[__number__][location_id]" class="form-control hotelLocation">
                                    <option value="">{{__("-- Please Select --")}}</option>
                                    <?php
                                    $traverse = function ($locations, $prefix = '') use (&$traverse, $row) {
                                        foreach ($locations as $location) {
                                            $selected = '';
                                            if ($row->location_id == $location->id)
                                                $selected = 'selected';
                                            printf("<option value='%s' %s>%s</option>", $location->id, $selected, $prefix . ' ' . $location->name);
                                            $traverse($location->children, $prefix . '-');
                                        }
                                    };
                                    $traverse($tour_location);
                                    ?>
                                </select>

                            </div>
                            <div class="col-md-3">
                                <select __name__="default_hotels[__number__][hotel]" class="form-control hotelDropDown">
                                        <option value="">Select Hotel</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select __name__="default_hotels[__number__][room]" class="form-control hotelroomDropDown">
                                        <option value="">Select Room</option>
                                </select>
                                <input type="text" min="0" __name__="default_hotels[__number__][room_price]" class="form-control roomPrice" value="" readonly>
                            </div>
                            <div class="col-md-2 pad-02">
                                <select __name__="default_hotels[__number__][days]" class="form-control RoomDays">
                                    @for ($i = 0.5; $i <= 10; $i += 0.5))
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2 pad03">
                                <div class="TotalDiv">
                                <input type="text" min="0" __name__="default_hotels[__number__][total_price]" class="form-control totalPrice" value="" readonly>
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                                <label>
                                    <input type="checkbox"  __name__="default_hotels[__number__][remove_status]" value="1" >
                                    {{__("Disable Remove")}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(is_default_lang())
            <hr>
            <h3 class="panel-body-title app_get_locale">Coupon</h3>
            <div class="form-group app_get_locale">
                <label><input type="checkbox" name="enable_coupon" @if(!empty($row->meta->enable_coupon)) checked @endif value="1"> {{__('Enable Coupon')}}
                </label>
            </div>
            <div class="form-group-item" data-condition="enable_coupon:is(1)">
                <label class="control-label">Coupon</label>
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-3">Coupons</div>
                        <div class="col-md-2">Min Pax</div>
                        <div class="col-md-2">Billing Price</div>
                        <div class="col-md-4">Note</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    @if(!empty($row->meta->coupon))
                        @foreach($row->meta->coupon as $key=>$tour_coupon)
                            <div class="item" data-number="{{$key}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="coupon[{{$key}}][coupon_id]" class="form-control tourCoupons">
                                            <option value="">{{__("-- Please Select --")}}</option>
                                            @if(count($coupons) > 0)
                                                @foreach($coupons as $coupon )
                                                    <option value="{{$coupon->id}}" discount_type="{{$coupon->discount_type}}" discount="{{$coupon->discount}}" code="{{$coupon->code}}" {{$tour_coupon['coupon_id'] == $coupon->id ? "selected" : ""}}>{{$coupon->code}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <input type="hidden" name="coupon[{{$key}}][discount_type]" class="discount_type" value="{{$tour_coupon['discount_type']}}">
                                        <input type="hidden" name="coupon[{{$key}}][discount]" class="discount" value="{{$tour_coupon['discount']}}">
                                        <input type="hidden" name="coupon[{{$key}}][code]" class="code" value="{{$tour_coupon['code']}}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" min="0" name="coupon[{{$key}}][min_pax]" class="form-control" value="{{$tour_coupon['min_pax']}}" placeholder="Min Pax">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="coupon[{{$key}}][min_price]" class="form-control" value="{{$tour_coupon['min_price']}}" placeholder="Billing Price">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="coupon[{{$key}}][note]" class="form-control" value="{{$tour_coupon['note']}}" placeholder="Note">
                                    </div>
                                    <div class="col-md-1">
                                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                </div>
                <div class="g-more hide">
                    <div class="item" data-number="__number__">
                        <div class="row">
                            <div class="col-md-3">
                                <select __name__="coupon[__number__][coupon_id]" class="form-control tourCoupons">
                                    <option value="">{{__("-- Please Select --")}}</option>
                                    @if(count($coupons) > 0)
                                        @foreach($coupons as $coupon )
                                            <option value="{{$coupon->id}}" discount_type="{{$coupon->discount_type}}" discount="{{$coupon->discount}}" code="{{$coupon->code}}">{{$coupon->code}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="hidden" __name__="coupon[__number__][discount_type]" class="discount_type">
                                <input type="hidden" __name__="coupon[__number__][discount]" class="discount">
                                <input type="hidden" __name__="coupon[__number__][code]" class="code">
                            </div>
                            <div class="col-md-2">
                                <input type="number" min="0" __name__="coupon[__number__][min_pax]" class="form-control" value="" placeholder="Min Pax">
                            </div>
                            <div class="col-md-2">
                                <input type="text" __name__="coupon[__number__][min_price]" class="form-control" value="" placeholder="Billing Price">
                            </div>
                            <div class="col-md-4">
                                <input type="text" __name__="coupon[__number__][note]" class="form-control" value="" placeholder="Note">
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(is_default_lang())
            <hr>
            <h3 class="panel-body-title app_get_locale">Flight</h3>
            <div class="form-group app_get_locale">
                <label><input type="checkbox" name="enable_flight" @if(!empty($row->meta->enable_flight)) checked @endif value="1"> {{__('Enable Flight')}}
                </label>
            </div>
            <div class="form-group-item defaultHotels" data-condition="enable_flight:is(1)">
                <label class="control-label">Default Flight</label>
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-2">From</div>
                        <div class="col-md-2">To</div>
                        <div class="col-md-3">Flight</div>
                        <div class="col-md-2">Departure time</div>
                        <div class="col-md-2">Arrival time</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    @if(!empty($row->meta->flight))
                        @foreach($row->meta->flight as $key=>$flight)
                            <div class="item" data-number="{{$key}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="flight[{{$key}}][from_airport]" class="form-control from_airport">
                                                <option value="">Select From</option>
                                                @foreach (getAirports() as $airport)
                                                    <option value="{{ $airport->id }}" @if(isset($flight['from_airport']) && $flight['from_airport'] == $airport->id) selected @endif>{{ $airport->name }}</option>
                                                @endforeach
                                        </select>
                                        <input type="text" name="flight[{{$key}}][note]" class="form-control" value="{{ isset($flight['note']) ? $flight['note'] : '' }}" placeholder="{{__("Note...")}}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="flight[{{$key}}][to_airport]" class="form-control to_airport">
                                                <option value="">Select To</option>
                                                @foreach (getAirports() as $airport)
                                                    <option value="{{ $airport->id }}" @if(isset($flight['to_airport']) && $flight['to_airport'] == $airport->id) selected @endif>{{ $airport->name }}</option>
                                                @endforeach
                                        </select>
                                        <input type="text" name="flight[{{$key}}][flight_no]" class="form-control" value="{{ isset($flight['flight_no']) ? $flight['flight_no'] : '' }}" placeholder="{{__("Flight No...")}}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="flight[{{$key}}][flight_id]" class="form-control">
                                                <option value="">Select Airline</option>
                                                @foreach (getAirlines() as $air)
                                                    <option value="{{ $air->id }}" @if($flight['flight_id'] == $air->id) selected @endif>{{ $air->name }}</option>
                                                @endforeach
                                        </select>
                                        <input type="number" name="flight[{{$key}}][price]" class="form-control" value="{{ isset($flight['price']) ? $flight['price'] : '' }}" placeholder="{{__("Price")}}">
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <input type="text" name="flight[{{$key}}][departure_time]" class="form-control has-datetimepicker" value="{{ isset($flight['departure_time']) ? $flight['departure_time'] : '' }}" placeholder="{{__("Departure time")}}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="flight[{{$key}}][arrival_time]" class="form-control has-datetimepicker" value="{{ isset($flight['arrival_time']) ? $flight['arrival_time'] : '' }}" placeholder="{{__("Arrival time")}}">
                                    </div>
                                    <div class="col-md-1">
                                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                </div>
                <div class="g-more hide">
                    <div class="item" data-number="__number__">
                        <div class="row">
                            <div class="col-md-3">
                                <select __name__="flight[__number__][from_airport]" class="form-control from_airport">
                                        <option value="">Select From</option>
                                        @foreach (getAirports() as $airport)
                                            <option value="{{ $airport->id }}">{{ $airport->name }}</option>
                                        @endforeach
                                </select>
                                <input type="text" __name__="flight[__number__][note]" class="form-control" value="" placeholder="{{__("Note...")}}">
                            </div>
                            <div class="col-md-2">
                                <select __name__="flight[__number__][to_airport]" class="form-control to_airport">
                                        <option value="">Select To</option>
                                        @foreach (getAirports() as $airport)
                                            <option value="{{ $airport->id }}">{{ $airport->name }}</option>
                                        @endforeach
                                </select>
                                <input type="text" __name__="flight[__number__][flight_no]" class="form-control" value="" placeholder="{{__("Flight No...")}}">
                            </div>
                            <div class="col-md-2">
                                <select __name__="flight[__number__][flight_id]" class="form-control">
                                        <option value="">Select Flight</option>
                                        @foreach (getAirlines() as $air)
                                            <option value="{{ $air->id }}">{{ $air->name }}</option>
                                        @endforeach
                                </select>
                                <input type="number" __name__="flight[__number__][price]" class="form-control" value="" placeholder="{{__("Price")}}">
                            </div>
                            
                            <div class="col-md-2">
                                <input type="text" __name__="flight[__number__][departure_time]" class="form-control has-datetimepicker" value="" placeholder="{{__("Departure time")}}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" __name__="flight[__number__][arrival_time]" class="form-control has-datetimepicker" value="" placeholder="{{__("Arrival time")}}">
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(is_default_lang())
                <hr>
                <h3 class="panel-body-title">{{__('Discount by number of people')}}</h3>
                <div class="form-group-item">
                    <div class="g-items-header">
                        <div class="row">
                            <div class="col-md-4">{{__("No of people")}}</div>
                            <div class="col-md-3">{{__('Discount')}}</div>
                            <div class="col-md-3">{{__('Type')}}</div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="g-items">
                        @if(!empty($row->meta->discount_by_people))
                            @foreach($row->meta->discount_by_people as $key=>$item)
                                <div class="item" data-number="{{$key}}">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="number" min="0" name="discount_by_people[{{$key}}][from]" class="form-control" value="{{$item['from']}}" placeholder="{{__('From')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" min="0" name="discount_by_people[{{$key}}][to]" class="form-control" value="{{$item['to']}}" placeholder="{{__('To')}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" min="0" name="discount_by_people[{{$key}}][amount]" class="form-control" value="{{$item['amount']}}">
                                        </div>
                                        <div class="col-md-3">
                                            <select name="discount_by_people[{{$key}}][type]" class="form-control">
                                                <option @if($item['type'] ==  'fixed') selected @endif value="fixed">{{__("Fixed")}}</option>
                                                <option @if($item['type'] ==  'percent') selected @endif value="percent">{{__("Percent (%)")}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="text-right">
                        <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                    </div>
                    <div class="g-more hide">
                        <div class="item" data-number="__number__">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="number" min="0" __name__="discount_by_people[__number__][from]" class="form-control" value="" placeholder="{{__('From')}}">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" min="0" __name__="discount_by_people[__number__][to]" class="form-control" value="" placeholder="{{__('To')}}">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" min="0" __name__="discount_by_people[__number__][amount]" class="form-control" value="">
                                </div>
                                <div class="col-md-3">
                                    <select __name__="discount_by_people[__number__][type]" class="form-control">
                                        <option value="fixed">{{__("Fixed")}}</option>
                                        <option value="percent">{{__("Percent")}}</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @if(is_default_lang())
            <hr>
            <h3 class="panel-body-title app_get_locale">{{__('Service fee')}}</h3>
            <div class="form-group app_get_locale">
                <label><input type="checkbox" name="enable_service_fee" @if(!empty($row->enable_service_fee)) checked @endif value="1"> {{__('Enable service fee')}}
                </label>
            </div>
            <div class="form-group-item" data-condition="enable_service_fee:is(1)">
                <label class="control-label">{{__('Buyer Fees')}}</label>
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-5">{{__("Name")}}</div>
                        <div class="col-md-3">{{__('Price')}}</div>
                        <div class="col-md-3">{{__('Type')}}</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    <?php  $languages = \Modules\Language\Models\Language::getActive();?>
                    @if(!empty($service_fee = $row->service_fee))
                        @foreach($service_fee as $key=>$item)
                            <div class="item" data-number="{{$key}}">
                                <div class="row">
                                    <div class="col-md-5">
                                        @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                            @foreach($languages as $language)
                                                <?php $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                                <div class="g-lang">
                                                    <div class="title-lang">{{$language->name}}</div>
                                                    <input type="text" name="service_fee[{{$key}}][name{{$key_lang}}]" class="form-control" value="{{$item['name'.$key_lang] ?? ''}}" placeholder="{{__('Fee name')}}">
                                                    <input type="text" name="service_fee[{{$key}}][desc{{$key_lang}}]" class="form-control" value="{{$item['desc'.$key_lang] ?? ''}}" placeholder="{{__('Fee desc')}}">
                                                </div>

                                            @endforeach
                                        @else
                                            <input type="text" name="service_fee[{{$key}}][name]" class="form-control" value="{{$item['name'] ?? ''}}" placeholder="{{__('Fee name')}}">
                                            <input type="text" name="service_fee[{{$key}}][desc]" class="form-control" value="{{$item['desc'] ?? ''}}" placeholder="{{__('Fee desc')}}">
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" min="0"  step="0.1"  name="service_fee[{{$key}}][price]" class="form-control" value="{{$item['price'] ?? ""}}">
                                        <select name="service_fee[{{$key}}][unit]" class="form-control">
                                            <option @if(($item['unit'] ?? "") ==  'fixed') selected @endif value="fixed">{{ __("Fixed") }}</option>
                                            <option @if(($item['unit'] ?? "") ==  'percent') selected @endif value="percent">{{ __("Percent") }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="service_fee[{{$key}}][type]" class="form-control d-none">
                                            <option @if($item['type'] ?? "" ==  'one_time') selected @endif value="one_time">{{__("One-time")}}</option>
                                        </select>
                                        <label>
                                            <input type="checkbox" min="0" name="service_fee[{{$key}}][per_person]" value="on" @if($item['per_person'] ?? '') checked @endif >
                                            {{__("Price per person")}}
                                        </label>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                </div>
                <div class="g-more hide">
                    <div class="item" data-number="__number__">
                        <div class="row">
                            <div class="col-md-5">
                                @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                    @foreach($languages as $language)
                                        <?php $key = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                        <div class="g-lang">
                                            <div class="title-lang">{{$language->name}}</div>
                                            <input type="text" __name__="service_fee[__number__][name{{$key}}]" class="form-control" value="" placeholder="{{__('Fee name')}}">
                                            <input type="text" __name__="service_fee[__number__][desc{{$key}}]" class="form-control" value="" placeholder="{{__('Fee desc')}}">
                                        </div>

                                    @endforeach
                                @else
                                    <input type="text" __name__="service_fee[__number__][name]" class="form-control" value="" placeholder="{{__('Fee name')}}">
                                    <input type="text" __name__="service_fee[__number__][desc]" class="form-control" value="" placeholder="{{__('Fee desc')}}">
                                @endif
                            </div>
                            <div class="col-md-3">
                                <input type="number" min="0" step="0.1"  __name__="service_fee[__number__][price]" class="form-control" value="">
                                <select __name__="service_fee[__number__][unit]" class="form-control">
                                    <option value="fixed">{{ __("Fixed") }}</option>
                                    <option value="percent">{{ __("Percent") }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select __name__="service_fee[__number__][type]" class="form-control d-none">
                                    <option value="one_time">{{__("One-time")}}</option>
                                </select>
                                <label>
                                    <input type="checkbox" min="0" __name__="service_fee[__number__][per_person]" value="on">
                                    {{__("Price per person")}}
                                </label>
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
