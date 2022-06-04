@if(is_default_lang())
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__("Price")}} <span class="text-danger">*</span></label>
                <input type="number" required value="{{$row->price}}" min="1" placeholder="{{__("Price")}}" name="price" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__("Sale Price")}} <span class="text-danger">*</span></label>
                <input type="number" required value="{{$row->sale_price}}" min="1" placeholder="{{__("Sale Price")}}" name="sale_price" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__("Number of tickets")}} <span class="text-danger">*</span></label>
                <input type="number" required value="{{$row->number ?? 1}}" min="1" max="100" placeholder="{{__("Number")}}" name="number" class="form-control">
            </div>
        </div>
    </div>
    <hr>
        @if(is_default_lang())
            <h3 class="panel-body-title">{{__('Person Types')}}</h3>
            <div class="form-group-item">
                <label class="control-label">{{__('Person Types')}}</label>
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-5">{{__("Time Slot")}}</div>
                        <div class="col-md-3">{{__('Adult Price')}}</div>
                        <div class="col-md-3">{{__('Child Price')}}</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    @if(!empty($row->timeslots))
                        @foreach($row->timeslots as $key=>$slot)
                        <div class="item" data-number="{{$key}}">
                            <input type="hidden" name="time_slots[{{$key}}][id]" value="{{$slot->id}}">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="time_slots[{{$key}}][time]" class="form-control timepicker" value="{{$slot->time}}" placeholder="Time" readonly="">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" min="0" name="time_slots[{{$key}}][adult_price]" class="form-control" value="{{$slot->adult_price}}" placeholder="Adult Price">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" min="0" name="time_slots[{{$key}}][child_price]" class="form-control" value="{{$slot->child_price}}" placeholder="Child Price">
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
                                <input type="text" __name__="time_slots[__number__][time]" class="form-control timepicker" value="" placeholder="Time" readonly="">
                            </div>
                            <div class="col-md-3">
                                <input type="text" min="0" __name__="time_slots[__number__][adult_price]" class="form-control" value="0" placeholder="Adult Price">
                            </div>
                            <div class="col-md-3">
                                <input type="text" min="0" __name__="time_slots[__number__][child_price]" class="form-control" value="0" placeholder="Child Price">
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    <hr>
@endif