<div class="form-group">
    <label>{{__("Email")}}</label>
    <input type="text" value="{{$row->email}}" placeholder="{{__("Email")}}" name="email" class="form-control">
</div>
<div class="form-group">
    <label>{{__("First name")}}</label>
    <input type="text" value="{{$row->first_name}}" placeholder="{{__("First name")}}" name="first_name" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Last name")}}</label>
    <input type="text" value="{{$row->last_name}}" placeholder="{{__("Last name")}}" name="last_name" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Whatsapp Number")}}</label>
    <input type="Number" min="0" value="{{$row->phone}}" placeholder="{{__("Whatsapp Number")}}" name="phone" class="form-control">
</div>