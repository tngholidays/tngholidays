@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{ __('View Order')}}</h1>
           
        </div>
        @include('admin.message')
        <div class="panel"> 
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="60px">#</th>
                                <th>#{{ __('Order Id')}}</th>
                                <th>{{ __('Type')}} </th>
                                <th>{{ __('Country')}} </th>
                                <th>{{__('Pay Type')}} </th>
                                <th>{{__('Forex Amt.')}} </th>
                                <th>{{__('INR Amt')}} </th>
                                <th>{{__('Forex Rate')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td class="title">#{{$row->order_id}}</td>
                                        <td class="title">{{$row->type}}</td>
                                        <td class="title">{{$row->ForexCountry->name}}</td>
                                        <td class="title">{{$row->pay_type}}</td>
                                        <td class="title">{{$row->forex_amount}}</td>
                                        <td class="title">{{$row->inr_amount}}</td>
                                        <td class="title">{{$row->forex_rate}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">{{__("No data")}}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
