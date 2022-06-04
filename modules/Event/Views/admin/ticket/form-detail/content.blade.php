<div class="form-group">
    <label>{{__("Ticket Name")}} <span class="text-danger">*</span></label>
    <input type="text" required value="{!! clean($row->title) !!}" placeholder="{{__("Ticket name")}}" name="title" class="form-control">
</div>


<div class="form-group">
    <label class="control-label">{{__("Content")}}</label>
    <div class="">
        <textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{$row->content}}</textarea>
    </div>
</div>
@if(is_default_lang())
    <div class="form-group">
        <label >{{__('Feature Image')}} </label>
        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
    </div>

    <div class="form-group">
        <label >{{__('Gallery')}}</label>
        {!! \Modules\Media\Helpers\FileHelper::fieldGalleryUpload('gallery',$row->gallery) !!}
    </div>
    <hr>
@endif