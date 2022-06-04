<style type="text/css">

</style>
<div class="form-group-item ItinerarySection hasMultipleDropDown">
    <label class="control-label">{{__('Itinerary')}}</label>
    <div class="g-items-header">
        <div class="row">
            <div class="col-md-2 text-left">{{__("Image")}}</div>
            <div class="col-md-4 text-left">{{__("Title - Desc")}}</div>
            <div class="col-md-5">{{__('Content')}}</div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <div class="g-items">
        @if(!empty($translation->itinerary))
            @php if(!is_array($translation->itinerary)) $translation->itinerary = json_decode($translation->itinerary); @endphp
            @foreach($translation->itinerary as $key=>$itinerary)
                <div class="item" data-number="{{$key}}">
                    <div class="row">
                        <div class="col-md-2">
                            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('itinerary['.$key.'][image_id]',$itinerary['image_id'] ?? '') !!}
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="itinerary[{{$key}}][title]" class="form-control DayNumber" value="{{$itinerary['title'] ?? ""}}" placeholder="{{__('Title: Day 1')}}">
                            <input type="text" name="itinerary[{{$key}}][desc]" class="form-control itineraryDesc" value="{{$itinerary['desc'] ?? ""}}" placeholder="{{__('Desc: TP. HCM City')}}">
                        </div>
                        <div class="col-md-5">
                            <textarea name="itinerary[{{$key}}][content]" class="form-control full-h" placeholder="...">{{$itinerary['content'] ?? ""}}</textarea>
                        </div>
                        <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                <span class="btn btn-info btn-sm addItemMiddle" style="margin-top: 10px;"><i class="fa fa-plus"></i></span>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" name="itinerary[{{$key}}][term_sequence]" class="termSequence" value="{{ (isset($itinerary['term_sequence']) ? $itinerary['term_sequence'] : '') }}">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 ismultiple">
                                    <select name="itinerary[{{$key}}][transfer][]" class="form-control uniqueDropDown transferDropdown commonMultiDrop multiselectDrop" data-options='{"placeholder":"-- Select Transfers --"}' multiple="multiple">
                                            <?php $terms = getTermsByAttr(22); ?>
                                            @if(count($terms) > 0)
                                            @foreach ($terms as $term)
                                                <option value="{{$term->id }}" desc="{{ $term->desc }}" {{ (isset($itinerary['transfer']) && in_array($term->id, $itinerary['transfer'])) ? 'selected' : '' }}>{{ $term->name }}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="col-md-6 ismultiple">
                                    <select name="itinerary[{{$key}}][meal][]" class="form-control mealDropdown commonMultiDrop multiselectDrop" data-options='{"placeholder":"-- Select Meals --"}' multiple="multiple">
                                            <?php $terms = getTermsByAttr(24); ?>
                                            @if(count($terms) > 0)
                                            @foreach ($terms as $term)
                                                <option value="{{$term->id }}" desc="{{ $term->desc }}" {{ (isset($itinerary['meal']) && in_array($term->id, $itinerary['meal'])) ? 'selected' : '' }}>{{ $term->name }}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="itinerary[{{$key}}][attribute]" class="form-control getSightseenLocation">
                                            <option value="">Location</option>
                                            <?php $getAllSightseeing = getAllSightseeing(); ?>
                                            @if(count($getAllSightseeing) > 0)
                                                @foreach($getAllSightseeing as $attr )
                                                    <option value="{{$attr->id}}" {{ (isset($itinerary['attribute']) && $itinerary['attribute'] == $attr->id) ? 'selected' : '' }}>{{$attr->name}}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>

                                <div class="col-md-6 ismultiple">
                                    <select name="itinerary[{{$key}}][term][]" class="form-control uniqueDropDown itinerarySightseen commonMultiDrop multiselectDrop" data-tags="true" data-options='{"placeholder":"-- Select Sightseeings --"}' multiple="multiple">
                                            <?php 
                                                $terms = isset($itinerary['attribute']) ? getTermsByAttr($itinerary['attribute']) : array(); 
                                            ?>
                                            @if(count($terms) > 0)
                                            @foreach ($terms as $term)
                                                <option value="{{$term->id }}" desc="{{ $term->desc }}" {{ (isset($itinerary['term']) && in_array($term->id, $itinerary['term'])) ? 'selected' : '' }}>{{ $term->name }}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>
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
                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('itinerary[__number__][image_id]','','__name__') !!}
                </div>
                <div class="col-md-4">
                    <input type="text" __name__="itinerary[__number__][title]" class="form-control DayNumber" placeholder="{{__('Title: Day 1')}}">
                    <input type="text" __name__="itinerary[__number__][desc]" class="form-control itineraryDesc" placeholder="{{__('Desc: TP. HCM City')}}">
                </div>
                <div class="col-md-5">
                    <textarea __name__="itinerary[__number__][content]" class="form-control full-h" placeholder="..."></textarea>
                </div>
                <div class="col-md-1">
                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                    <span class="btn btn-info btn-sm addItemMiddle" style="margin-top: 10px;"><i class="fa fa-plus"></i></span>

                </div>
            </div>
            <div class="row">
                <input type="hidden" __name__="itinerary[__number__][term_sequence]" class="termSequence" value="">
                <div class="col-md-12">
                    <div class="row">
                         <div class="col-md-6 ismultiple">
                            <select __name__="itinerary[__number__][transfer]" class="form-control uniqueDropDown transferDropdown commonMultiDrop multiselectDrop2" data-options='{"placeholder":"-- Select Transfers --"}' multiple="multiple">
                                    <?php $terms = getTermsByAttr(22); ?>
                                    @if(count($terms) > 0)
                                    @foreach ($terms as $term)
                                        <option value="{{$term->id }}" desc="{{ $term->desc }}">{{ $term->name }}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                        <div class="col-md-6 ismultiple">
                            <select __name__="itinerary[__number__][meal]" class="form-control mealDropdown commonMultiDrop multiselectDrop2" data-options='{"placeholder":"-- Select Meals --"}' multiple="multiple">
                                    <?php $terms = getTermsByAttr(24); ?>
                                    @if(count($terms) > 0)
                                    @foreach ($terms as $term)
                                        <option value="{{$term->id }}" desc="{{ $term->desc }}">{{ $term->name }}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <select __name__="itinerary[__number__][attribute]" class="form-control getSightseenLocation">
                                    <option value="">Location</option>
                                    <?php $getAllSightseeing = getAllSightseeing(); ?>
                                    @if(count($getAllSightseeing) > 0)
                                        @foreach($getAllSightseeing as $attr )
                                            <option value="{{$attr->id}}" >{{$attr->name}}</option>
                                        @endforeach
                                    @endif
                            </select>
                        </div>
                        <div class="col-md-6 ismultiple">
                            
                            <select __name__="itinerary[__number__][term]" class="form-control uniqueDropDown itinerarySightseen commonMultiDrop multiselectDrop2" data-options='{"placeholder":"-- Select Sightseeings --"}' multiple="multiple">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>