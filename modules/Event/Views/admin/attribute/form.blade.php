<div class="form-group">
    <label>{{__("Name")}}</label>
    <input type="text" value="{{$translation->name}}" placeholder="{{__("Attribute name")}}" name="name" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Attribute Types")}}</label>
    <?php $attrs = getAttrTypes() ?>
     <select name="type" class="form-control">
        <option value="">{{__("-- Please Select --")}}</option>
            @foreach($attrs as $key=> $attr )
                <option value="{{$key}}" {{$translation->type == $key ? "selected" : ""}}>{{$attr}}</option>
            @endforeach
    </select>
</div>
<div class="form-group">
    <label>{{__("Location")}}</label>
    <?php $locations = getLocations() ?>
     <select name="location" class="form-control">
        <option value="">{{__("-- Please Select --")}}</option>
        @if(count($locations) > 0)
            @foreach($locations as $location )
                <option value="{{$location->id}}" {{$translation->location == $location->id ? "selected" : ""}}>{{$location->name}}</option>
            @endforeach
        @endif
    </select>
</div>

@if(is_default_lang())
    <div class="form-group">
        <label>{{__("Display Type in detail service")}}</label>
        <select name="display_type" class="form-control">
            <option  @if($row->display_type == "icon_left") selected @endif value="icon_left">{{__("Display Left Icon")}}</option>
            <option  @if($row->display_type == "icon_center") selected @endif value="icon_center">{{__("Display Center Icon")}}</option>
        </select>
    </div>
    <div class="form-grou">
        <label>{{__('Hide in detail service')}}</label>
        <br>
        <label>
            <input type="checkbox" name="hide_in_single" @if($row->hide_in_single) checked @endif value="1"> {{__("Enable hide")}}
        </label>
    </div>
@endif