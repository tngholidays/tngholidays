@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{ __('All Forex')}}</h1>
            <div class="title-actions">
                <a href="{{route('forex.admin.create')}}" class="btn btn-primary">{{ __('Add Forex')}}</a>
            </div>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left"> 
               
            </div>
            <div class="col-left">
               <form method="get" action="{{url('/admin/module/forex/')}} " class="filter-form filter-form-right d-flex justify-content-end" role="search">
                    <input  type="text" name="page_name" value="{{ Request()->page_name }}" placeholder="{{__('Search by name')}}" class="form-control">
                    <button class="btn-info btn btn-icon btn_search"  type="submit">{{__('Search Page')}}</button>
                </form>
            </div>
        </div>
        <div class="panel"> 
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="60px">#</th>
                                <th >{{ __('Country')}}</th>
                                <th>₹ {{ __('Sell Rates Cash / Card')}} </th>
                                <th>₹ {{__('Buy Rates Cash / Card')}} </th>
                                <th>{{__('Status')}} </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @if($rows->total() > 0)
                                @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td class="title">{{$row->ForexCountry->name}}</td>
                                        <td class="title">₹{{$row->sell_cash}}/ ₹{{$row->sell_card}}</td>
                                        <td class="title">₹{{$row->buy_cash}}/ ₹{{$row->buy_card}}</td>
                                        <td> <span class="badge badge-{{ $row->status }}">{{ $row->status }}</span> </td>
                                        <td>
                                            <a href="{{route('forex.admin.edit',['id'=>$row->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('Edit')}}</a>
                                            <a href="{{route('forex.admin.delete',['id'=>$row->id])}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> {{__('Delete')}}</a>
                                        </td>
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
                {{$rows->appends(request()->query())->links()}}
            </div>
        </div>
    </div>
@endsection
