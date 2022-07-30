@extends ('admin.layouts.app')
@section ('content')
<style>
    .table th, .table td {
        padding: 5px !important;
        font-size: 13px !important;
    }
</style>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__('Reminder Report')}}</h1>
        </div>
        @include('admin.message')
<div class="filter-div d-flex">
            <div class="col-left">
               <form method="get"method="get" action="" class="filter-form filter-form-right d-flex justify-content-end" role="search">
                   <div class="row">
                        <div class="form-group col-2">
                            <select class="form-control" name="status">
                                <option value="">Select Status</option>
                                <option value="1" {{'1'==Request()->status ? 'selected' : '' }}>Read</option>
                                <option value="2" {{'2'==Request()->status ? 'selected' : '' }}>Not Read</option>
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <select class="form-control" name="user">
                                <option value="">Select Assign</option>
                                @foreach($staffs as $staff )
                                    <option value="{{$staff->id}}" {{$staff->id == request()->user ? 'selected' : '' }}>{{$staff->first_name.' '.$staff->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-2">
                           <div class="calDiv">
                                <input type="text" name="from_date" class="form-control datePicker" value="{{ Request()->from_date }}" placeholder="From Date" readonly="" />
                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <div class="calDiv">
                                <input type="text" name="to_date" class="form-control datePicker" value="{{ Request()->to_date }}" placeholder="To Date" readonly="" />
                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>
                       
                        <div class="form-group col-2">
                            <select class="form-control" name="file_type">
                                <option value="">Select Export</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>
                        <div class="form-group col-2">
                           <button class="btn-info btn btn-icon btn_search"  type="submit">{{__('Search Page')}}</button>
                        </div>
                        <div class="form-group col-2">
                           <a href="{{route('report.admin.reminderReport')}}" class="btn-info btn btn-icon btn_search">{{__('Clear')}}</a>
                        </div>
                   </div>
                </form>
            </div>
        </div>
        <div class="text-right">
            <p><i>{{__('Found :total items',['total'=>$rows->count()])}}</i></p>
        </div>
        <div class="panel booking-history-manager">
            <div class="panel-title">{{__('Enquiries')}}</div>
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <table class="table table-hover bravo-list-item">
                        <thead>
                        <tr>
                            <th>{{__('Enquery ID')}}</th>
                            <th>{{__('Reminder Date/Time')}}</th>
                            <th>{{__('Message')}}</th>
                            <th>{{__('Created At')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>CreateUser</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($rows->count() > 0)
                                @foreach($rows as $row)
                                </tr>
                                <td>#{{$row->enquiry_id}}</td>
                                <td>{{$row->date}}</td>
                                <td>{{$row->content}}</td>
                                <td>{{$row->created_at}}</td>
                                <td> <span class="badge badge-{{$row->read_status==1 ? 'success' : 'danger'}}">{{$row->read_status==1 ? 'Read' : 'Not Read'}}</span></td>
                                <td>{{@$row->CreateUser->name ?? '-'}}</td>
                                </tr>
                            
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">{{__("No data")}}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
