@extends('admin.layouts.app')

@section('content')
    <form action="{{route('report.admin.storeCustomTour',['id'=>($praposal->id) ? $praposal->id : '-1','lang'=>request()->query('lang')])}}" method="post">
        @csrf
        <input type="hidden" name="enquiry_id" value="{{$enquiry->id}}">
        <input type="hidden" name="step" value="0">
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{$row->id ? __('Custom Tour: ').$row->title : __('Add new tour')}}</h1>
                </div>
                <div class="">
                    @if($row->slug)
                        <a class="btn btn-primary btn-sm" href="{{url('admin/module/report/booking/booking_proposal/'.$enquiry->id.'/'.$praposal->tour_id)}}" target="_blank">{{__("Create Praposal")}}</a>
                    @endif
                </div>
            </div>
            @include('admin.message')
            @if($row->id)
                @include('Language::admin.navigation')
            @endif
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                          <div class="panel hasMultipleDropDown">
                            <div class="panel-title"><strong>Basic Info</strong></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                            <?php $name = !empty($praposal->name) ? $praposal->name : $enquiry->name; ?>
                                            <input type="text" name="name" class="form-control" value="{{$name}}" placeholder="Name" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">Destinations</label>
                                            <?php
                                                $locations = getLocations();
                                                $destination_id = !empty($praposal->destination) ? $praposal->destination : $enquiry->destination;
                                            ?>
                                            <select class="form-control DestinationChange" name="destination" required>
                                                <option value="">Select Hotel</option>
                                                @if(count($locations) > 0)
                                                    @foreach($locations as $location )
                                                        <option value="{{$location->id}}" {{$destination_id==$location->id ? 'selected' : ''}}>{{$location->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                        $attributess = getTermsById($attributesIds);
                                    ?>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">Durations</label>
                                            <?php
                                                $duration_id = !empty($praposal->duration) ? $praposal->duration : $enquiry->duration;
                                            ?>
                                            <select class="form-control DurationChange" name="proposalDuration" required>
                                                <option value="">Select Duration</option>
                                                @if(isset($attributess[12]) and count($attributess[12]) > 0 && count($attributess[12]['child']) > 0)
                                                    @foreach($attributess[12]['child'] as $term )
                                                        <option value="{{$term->id}}" {{$duration_id==$term->id ? 'selected' : ''}}>{{$term->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 ismultiple">
                                        <div class="">
                                            <label>Select Sightseeings:</label>
                                            <select name="sightseeing" id="multiple-checkboxes" multiple="multiple">
                                                @if(!empty($attributess))
                                                @foreach($attributess as $attribute)
                                                    @if(strpos($attribute['parent']->slug, 'sightseeing') !== false)
                                                        @foreach($attribute['child'] as $term )
                                                            <option value="{{$term->id}}">{{$term->name}} ({{$attribute['parent']->name}})</option>
                                                        }
                                                        }
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">Packages</label>
                                            <?php
                                                $tours = getToursByLocation($destination_id);
                                                $tour_id = (!empty($row->id) ? $row->id : $enquiry->object_id);
                                            ?>
                                            <select class="form-control TourChange" name="tour_id" required>
                                                <option value="">Select Package</option>
                                                @if(count($tours) > 0)
                                                    @foreach($tours as $pack )
                                                        <option value="{{$pack->id}}" {{$tour_id==$pack->id ? 'selected' : ''}}>{{$pack->title}} - ({{$pack->tour_duration}})</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">Start Date</label>
                            <?php
                            if (!empty($praposal->start_date)) {
                              $start_date = str_replace("-", "/", $praposal->start_date);
                            }else {
                              $start_date = $enquiry->approx_date;
                            }


                            ?>
                                            <div class="calDiv">
                                                <input type="text" name="start_date" class="form-control datePicker" value="{{$start_date}}" placeholder="Start Date" required />
                                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php /*
                    @if(!empty($praposal->tour_id))
                        <div class="CustomTour">
                            @include('Tour::admin/tour/tour-content')
                        </div>
                        <div style="display: none;">
                        @include('Tour::admin/tour/tour-location')
                        @include('Hotel::admin.hotel.surrounding')
                        </div>

                    @if(is_default_lang())
                            @include('Tour::admin/tour/pricing')
                            <div style="display: none;">
                            @include('Tour::admin/tour/availability')
                            </div>
                        @endif
                        <div style="display: none;">
                            @include('Core::admin/seo-meta/seo-meta')
                        </div>
                    @endif */
                     ?>
                    </div>
                    <div class="col-md-3">
                        <div class="panel">
                            <div class="panel-title"><strong>{{__('Publish')}}</strong></div>
                            <div class="panel-body">
                                @if(is_default_lang())
                                    <div>
                                        <label><input @if($row->status=='publish') checked @endif type="radio" name="status" value="publish"> {{__("Publish")}}
                                        </label></div>
                                    <div>
                                        <label><input @if($row->status=='draft') checked @endif type="radio" name="status" value="draft"> {{__("Draft")}}
                                        </label></div>
                                @endif
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> @if(empty($praposal->tour_id))   {{__('Save and next')}} @else {{__('Save Changes')}} @endif</button>
                                </div>
                            </div>
                        </div>
                        <?php /*
                    @if(!empty($praposal->tour_id))
                        @if(is_default_lang())
                        <div class="panel" style="display: none;">
                            <div class="panel-title"><strong>{{__("Author Setting")}}</strong></div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <?php
                                    $user = !empty($row->create_user) ? App\User::find($row->create_user) : false;
                                    \App\Helpers\AdminForm::select2('create_user', [
                                        'configs' => [
                                            'ajax'        => [
                                                'url' => url('/admin/module/user/getForSelect2'),
                                                'dataType' => 'json'
                                            ],
                                            'allowClear'  => true,
                                            'placeholder' => __('-- Select User --')
                                        ]
                                    ], !empty($user->id) ? [
                                        $user->id,
                                        $user->getDisplayName() . ' (#' . $user->id . ')'
                                    ] : false)
                                    ?>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(is_default_lang())
                            <div class="panel" style="display: none;">
                                <div class="panel-title"><strong>{{__("Tour Featured")}}</strong></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <input type="checkbox" name="is_featured" @if($row->is_featured) checked @endif value="1"> {{__("Enable featured")}}
                                    </div>
                                    <div class="form-group">
                                        <label >{{__('Default State')}}</label>
                                        <br>
                                        <select name="default_state" class="custom-select">
                                            <option value="1" @if(old('default_state',$row->default_state ?? -1) == 1) selected @endif>{{__("Always available")}}</option>
                                            <option value="0" @if(old('default_state',$row->default_state ?? -1) == 0) selected @endif>{{__("Only available on specific dates")}}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            @foreach ($attributes as $attribute)
                            <?php
                                $flag = false;
                                if($attribute->type == 1 || $attribute->type == 3 || $attribute->type == 5){
                                    $flag = true;
                                }
                            ?>
                                <div class="panel">
                                    <div class="panel-title"><strong>{{__('Attribute: :name',['name'=>$attribute->name])}}</strong></div>
                                    <div class="panel-body">
                                        <div class="terms-scrollable">
                                            @foreach($attribute->terms as $term)
                                                <label class="term-item">
                                                    <input @if(!empty($selected_terms) and in_array($term->id, $selected_terms)) checked @endif price="{{$term->price}}" transfer="{{$term->transfer_price}}" type="checkbox" name="terms[]"  @if($flag) class="SightSeeing" @endif value="{{$term->id}}">
                                                    <span class="term-name">
                                                        {{$term->name}} 
                                                        @if(!empty($term->price)) Sightseen: ({{format_money($term->price)}}) @endif
                                                        @if(!empty($term->transfer_price)) Transfer: ({{format_money($term->transfer_price)}}) @endif
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="panel" style="display: none;">
                                <div class="panel-title"><strong>{{__('Feature Image')}}</strong></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
                                    </div>
                                </div>
                            </div>
                            <div style="display: none;">
                                @include('Tour::admin/tour/ical')
                            </div>
                        @endif
                        @endif */ ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section ('script.body')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [{{$row->map_lat ?? "51.505"}}, {{$row->map_lng ?? "-0.09"}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    @if($row->map_lat && $row->map_lng)
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {}
                    });
                    @endif
                    engineMap.on('click', function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                    engineMap.on('zoom_changed', function (zoom) {
                        $("input[name=map_zoom]").attr("value", zoom);
                    });
                    engineMap.searchBox($('#customPlaceAddress'),function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                    engineMap.searchBox($('.bravo_searchbox'),function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                }
            });
        })
    </script>
@endsection
