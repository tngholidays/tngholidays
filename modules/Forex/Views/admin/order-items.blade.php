@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{ __('Forex Orders')}}</h1>
           
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
                                <th>#{{ __('Order Id')}}</th>
                                <th>{{ __('Name')}} </th>
                                <th>{{ __('E-Mail')}} </th>
                                <th>{{__('Mobile No.')}} </th>
                                <th>{{__('Status')}} </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($rows->total() > 0)
                                @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td class="title">#{{$row->id}}</td>
                                        <td class="title">{{$row->name}}</td>
                                        <td class="title">{{$row->email}}</td>
                                        <td class="title">{{$row->phone}}</td>
                                        <td> <span class="badge badge-{{ $row->status }}">{{ $row->status }}</span> </td>
                                        <td>
                                            <a href="{{route('forex.admin.edit',['id'=>$row->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> {{__('View')}}</a>
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
