@extends('admin.layouts.app')

@section('content')

    <form action="{{route('forex.admin.store',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post">
        @csrf
        <div class="container">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{$row->id ? __('Edit: ') .$row->title :  __('Add New Forex') }}</h1>
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
                                <strong>{{ __('Forex Content')}}</strong>
                            </div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Forex Country</label>
                                            <select class="form-control" name="country_id">
                                                <option value="">Select Destination</option>
                                                    @foreach(getForexCountry() as $country )
                                                        <option value="{{$country->id}}" {{$country->id==$row->country_id ? 'selected' : '' }}>{{$country->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Buy Cash Rate</label>
                                            <input type="text" name="buy_cash" class="form-control" value="{{$row->buy_cash}}" placeholder="Buy Cash Rate" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Buy Card Rate</label>
                                            <input type="text" name="buy_card" class="form-control" value="{{$row->buy_card}}" placeholder="Buy Card Rate" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Sell Cash Rate</label>
                                            <input type="text" name="sell_cash" class="form-control" value="{{$row->sell_cash}}" placeholder="Sell Cash Rate" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Sell Card Rate</label>
                                            <input type="text" name="sell_card" class="form-control" value="{{$row->sell_card}}" placeholder="Sell Card Rate" required>
                                        </div>
                                    </div>
                                    <!--<div class="col-lg-12">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label class="control-label">Special Note</label>-->
                                    <!--        <textarea name="note" class="form-control full-h" rows="3" placeholder="write here...">{{ $row->note }}</textarea>-->
                                    <!--    </div>-->
                                    <!--</div>-->
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
