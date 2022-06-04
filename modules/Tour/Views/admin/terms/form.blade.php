
@if(!empty($attr))
    <input type="hidden" name="attr_id" value="{{$attr->id}}">
@endif
<div class="form-group">
    <label>{{__("Name")}}</label>
    <input type="text" value="{{$translation->name}}" placeholder="{{__("Term name")}}" name="name" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Price")}}</label>
    <input type="text" value="{{$translation->price}}" placeholder="{{__("Price")}}" name="price" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Transfer Price")}}</label>
    <input type="text" value="{{$translation->transfer_price}}" placeholder="{{__("Transfer Price")}}" name="transfer_price" class="form-control">
</div>
<div class="col-sm-12 email-id-row">
    <label>{{__("E-Mail Ids")}}</label>
        <div class="all-mail">
             @if(!empty($translation->emails))
                 @foreach (json_decode($translation->emails) as $email)
                 <span class="email-ids">{{$email}} <span class="cancel-email">x</span><input type="hidden" value="{{$email}}" name="emails[]"></span>
                 @endforeach
             @endif
         </div>
        <input type="text" name="email" class="enter-mail-id" placeholder="Enter the email id .." />
</div>
<div class="form-group">
    <label>{{__("Description")}}</label>
    <textarea name="desc" rows="3" class="form-control" placeholder="Enter description...">{{$translation->desc}}</textarea>
</div>
@if(is_default_lang())
    <div class="form-group">
        <label>{{__('Class Icon')}} - {!!  __("get icon in <a href=':link_1' target='_blank'>fontawesome.com</a> or <a href=':link_2' target='_blank'>icofont.com</a>",['link_1'=>'https://fontawesome.com/v4.7.0/icons/','link_2'=>'https://icofont.com/icons'])  !!}</label>
        <input type="text" value="{{$row->icon}}" placeholder="{{__("Ex: fa fa-facebook")}}" name="icon" class="form-control">
    </div>
    <div class="form-group">
        <label >{{__('Upload image size 30px')}}</label>
        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
        <i>
            {{ __("All the Term's image are same size") }}
        </i>
    </div>
@endif
<div class="form-group">
    <label>{{__("Inclusions")}}</label>
    <br>
    @foreach (getInclusions() as $key=>$row)
    <label class="checkbox-inline"><input type="checkbox" name="inclusions[]" value="{{$key}}" @if(!empty($translation->inclusions) && in_array($key, json_decode($translation->inclusions, true))) checked @endif>{{$row}}</label>
    @endforeach
</div>
<div class="form-group">
    <label>{{__("Time Duration")}}</label>
    <input type="number" value="{{$translation->duration}}" placeholder="{{__("Duration")}}" name="duration" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Directions")}}</label>
    <br>
    @foreach (getDirections() as $key=>$row)
    <label class="checkbox-inline"><input type="radio" name="direction" value="{{$key}}" @if($translation->direction == $key) checked @endif>{{$row}}</label>
    @endforeach
</div>
<div class="form-group">
    <label>{{__("Day/Evening")}}</label>
    <br>
    <label class="checkbox-inline"><input type="radio" name="time_zone" value="1" @if($translation->time_zone == 1) checked @endif>Morning</label>
    <label class="checkbox-inline"><input type="radio" name="time_zone" value="2" @if($translation->time_zone == 2) checked @endif>Day</label>
    <label class="checkbox-inline"><input type="radio" name="time_zone" value="3" @if($translation->time_zone == 3) checked @endif>Evening</label>
</div>
<div class="form-group">
    <label>{{__("Exclude")}}</label>
    <input type="text" value="{{$translation->exclude}}" placeholder="{{__("Exclude")}}" name="exclude" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Must")}}</label>
    <br>
    <label class="checkbox-inline"><input type="radio" name="must" value="1" @if($translation->must == 1) checked @endif>Yes</label>
    <label class="checkbox-inline"><input type="radio" name="must" value="2" @if(empty($translation->must)) checked @endif @if($translation->must == 2) checked @endif >No</label>
</div>
<div class="form-group">
    <label>{{__('Hide in detail service')}}</label>
    <br>
    <label>
        <input type="checkbox" name="hide_in_single" @if($translation->hide_in_single) checked @endif value="1"> {{__("Enable hide")}}
    </label>
</div>


