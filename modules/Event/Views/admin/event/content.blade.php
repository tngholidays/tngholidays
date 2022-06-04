<div class="panel">
    <div class="panel-title"><strong>{{__("Event Content")}}</strong></div>
    <div class="panel-body">
        <div class="form-group">
            <label>{{__("Title")}}</label>
            <input type="text" value="{!! clean($translation->title) !!}" placeholder="{{__("Name of the event")}}" name="title" class="form-control">
        </div>
        <div class="form-group">
            <label class="control-label">{{__("About Content")}}</label>
            <div class="">
                <textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->content}}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">{{__("Highlight Content")}}</label>
            <div class="">
                <textarea name="highlight_content" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->highlight_content}}</textarea>
            </div>
        </div>
        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Youtube Video")}}</label>
                <input type="text" name="video" class="form-control" value="{{$row->video}}" placeholder="{{__("Youtube link video")}}">
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label">{{__("Duration (hour)")}}</label>
                        <input type="text" name="duration" class="form-control" value="{{$row->duration}}" placeholder="{{__("Ex: 3")}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label">{{__("Start Time")}}</label>
                        <input type="text" name="start_time" class="form-control" value="{{$row->start_time}}" placeholder="{{__("Ex: 19:00")}}">
                    </div>
                </div>
            </div>
        @endif


        <div id="accordion">
            <div class="card">
                <div class="card-header">
                    <a class="card-link" data-toggle="collapse" href="#collapseOne">
                        {{__('FAQs')}}
                    </a>
                </div>
                <div id="collapseOne" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group-item">
                            <label class="control-label">{{__('FAQs')}}</label>
                            <div class="g-items-header">
                                <div class="row">
                                    <div class="col-md-5">{{__("Title")}}</div>
                                    <div class="col-md-5">{{__('Content')}}</div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                            <div class="g-items hasAppendCkEditor">
                                @if(!empty($translation->faqs)) @php if(!is_array($translation->faqs)) $translation->faqs = json_decode($translation->faqs); @endphp @foreach($translation->faqs as $key=>$faq)
                                <div class="item" data-number="{{$key}}">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <input type="text" name="faqs[{{$key}}][title]" class="form-control" value="{{$faq['title']}}" placeholder="{{__('Eg: When and where does the tour end?')}}" />
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea name="faqs[{{$key}}][content]" class="has-ckeditor" placeholder="...">{{$faq['content']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach @endif
                            </div>
                            <div class="text-right">
                                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                            </div>
                            <div class="g-more hide">
                                <div class="item" data-number="__number__">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <input type="text" __name__="faqs[__number__][title]" class="form-control" placeholder="{{__('Eg: Can I bring my pet?')}}" />
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea __name__="faqs[__number__][content]" class="appendCKEditor" placeholder=""></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                $extraAttribute = getAttributeByType(9);
                $getExtraContentTypes = getTermsByAttr($extraAttribute->id);
        ?>
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                        {{__('Policy and Extra Content')}}
                    </a>
                </div>
                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group-item">
                            <label class="control-label">{{__('Policy Content')}}</label>
                            <div class="g-items-header">
                                <div class="row">
                                    <div class="col-md-5">{{__("Title")}}</div>
                                    <div class="col-md-5">{{__('Content')}}</div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                            <div class="g-items hasAppendCkEditor">
                                @if(!empty($translation->extra_content)) @php if(!is_array($translation->extra_content)) $translation->extra_content = json_decode($translation->extra_content); @endphp @foreach($translation->extra_content as $key=> $extra_content)
                                <div class="item" data-number="{{$key}}">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <select name="extra_content[{{$key}}][type]" class="form-control chooseExtraType">
                                                <option value="">Select Type</option>
                                                @foreach ($getExtraContentTypes as $type_key => $extra)
                                                    <option value="{{ $extra->type }}" desc="{{$extra->desc}}" @if($extra_content['type'] == $extra->type) selected @endif>{{ $extra->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="extra_content[{{$key}}][title]" class="form-control title" value="{{$extra_content['title'] ?? ''}}" placeholder="{{__('Eg: Title ?')}}" />
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea name="extra_content[{{$key}}][content]" class="d-none has-ckeditor" placeholder="...">{{$extra_content['content']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach @endif
                            </div>
                            <div class="text-right">
                                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                            </div>
                            <div class="g-more hide">
                                <div class="item" data-number="__number__">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <select __name__="extra_content[__number__][type]" class="form-control chooseExtraType">
                                                <option value="">Select Type</option>
                                                @foreach ($getExtraContentTypes as $type_key => $extra)
                                                    <option value="{{ $extra->type }}" desc="{{$extra->desc}}">{{ $extra->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" __name__="extra_content[__number__][title]" class="form-control title" placeholder="{{__('Eg: Title ?')}}" />
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                    <div class="row textareaDiv">
                                        <div class="col-md-12">
                                            <textarea __name__="extra_content[__number__][content]" class="appendCKEditor" placeholder=""></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        
        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Banner Image")}}</label>
                <div class="form-group-image">
                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('banner_image_id',$row->banner_image_id) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">{{__("Gallery")}}</label>
                {!! \Modules\Media\Helpers\FileHelper::fieldGalleryUpload('gallery',$row->gallery) !!}
            </div>
        @endif
    </div>
</div>
