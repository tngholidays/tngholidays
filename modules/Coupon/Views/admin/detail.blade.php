@extends('admin.layouts.app')

@section('content')

    <form action="{{route('coupon.admin.store',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post">
        @csrf
        <div class="container">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{$row->id ? __('Edit: ') .$row->title :  __('Add New Coupon') }}</h1>
                </div>

            </div>
            @include('admin.message')
            @if($row->id)
                @include('Language::admin.navigation')
            @endif
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="panel-title">
                                <strong>{{ __('Coupon Content')}}</strong>
                            </div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Coupon Title')}}</label>
                                            <input type="text" value="{{ $row->title }}" placeholder="Coupon title" name="title" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Coupon Code</label>
                                            <input type="text" name="code" class="form-control" value="{{ $row->code }}" placeholder="Coupon Code" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Coupon Discount Type</label>
                                            <select class="form-control" name="discount_type" required>
                                                <option value="">Select Discount Type</option>
                                                <option value="1" {{ $row->discount_type==1 ? "Selected" : "" }}>₹</option>
                                                <option value="2" {{ $row->discount_type==2 ? "Selected" : "" }}>%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Coupon Discount</label>
                                            <input type="text" name="discount" class="form-control" value="{{ $row->discount }}" placeholder="Coupon Discount" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Expire Date</label>
                                            <?php
                                             $expire_date = date('d/m/Y', strtotime($row->expire_date));
                                            ?>
                                            <div class="calDiv">
                                                <input type="text" name="expire_date" class="form-control datePicker" value="{{$expire_date}}" placeholder="Expire Date" required readonly />
                                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                          </div>
                                    </div>
                                </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label">Special Note</label>
                                            <textarea name="note" class="form-control full-h" rows="3" placeholder="write here...">{{ $row->note }}</textarea>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
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
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save Changes')}}</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section ('script.body')
@endsection
