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
            <h1 class="title-bar">{{__('Leads Report')}}</h1>
        </div>
        @include('admin.message')
<div class="filter-div d-flex">
            <div class="col-left">
               <form method="get"method="get" action="" class="filter-form filter-form-right d-flex justify-content-end" role="search">
                   <div class="row">
                        <div class="form-group col-2">
                           <input  type="text" name="search" value="{{ Request()->search }}" placeholder="{{__('Search by name')}}" class="form-control">
                        </div>
                        <div class="form-group col-2">
                            <select class="form-control" name="status">
                                <option value="">Select Status</option>
                                <option value="pending" {{'pending'==Request()->status ? 'selected' : '' }}>New Leads</option>
                                <option value="processing" {{'processing'==Request()->status ? 'selected' : '' }}>Processing</option>
                                <option value="interested" {{'interested'==Request()->status ? 'selected' : '' }}>Interested</option>
                                <option value="notinterested" {{'notinterested'==Request()->status ? 'selected' : '' }}>Not Interested</option>
                                <option value="quotation_send" {{'quotation_send'==Request()->status ? 'selected' : '' }}>Quotation Send</option>
                                <option value="completed" {{'completed'==Request()->status ? 'selected' : '' }}>Completed</option>
                                <option value="payment_done" {{'payment_done'==Request()->status ? 'selected' : '' }}>Payment Done</option>
                                <option value="cancel" {{'cancel'==Request()->status ? 'selected' : '' }}>Cancel</option>
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <select class="form-control" name="assigned_to">
                                <option value="">Select Assign</option>
                                @foreach($staffs as $staff )
					            	<option value="{{$staff->id}}" {{$staff->id == request()->assigned_to ? 'selected' : '' }}>{{$staff->first_name.' '.$staff->last_name}}</option>
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
                        	<?php $locations = getLocations() ?>
                            <select class="form-control" name="destination">
                                <option value="">Select Destination</option>
                                @if(count($locations) > 0)
                                    @foreach($locations as $location )
                                        <option value="{{$location->id}}" {{$location->id==Request()->destination ? 'selected' : '' }}>{{$location->name}}</option>
                                    @endforeach
                                @endif
                            </select>
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
                           <a href="{{route('report.admin.leadsReport')}}" class="btn-info btn btn-icon btn_search">{{__('Clear')}}</a>
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
                            <th>{{__('Booking ID')}}</th>
                            <th>{{__('Name')}}</th>
                            <!-- <th>{{__('Email ID')}}</th> -->
                            <th>{{__('Destination')}}</th>
                            <th>{{__('Approx Date')}}</th>
                            <th>{{__('No. Pax')}}</th>
                            <th>{{__('Created At')}}</th>
                            <th>{{__('Proposal Price')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Call Status')}}</th>
                            <th>AssignUser</th>
                            <th>CreateUser</th>
                            <th>Last Comment</th>
                            <!-- <th>UpdateUser</th> -->
                        </tr>
                        </thead>
                        <tbody>
                            @if($rows->count() > 0)
                                @foreach($rows as $row)
                                <?php
                                    $total_sale_price = @$row->booking->total ?? 0;
                                    if ($row->has('booking') && !empty($row->booking->proposal_discount)) {
                                        if ($row->booking->proposal_discount < 0) {
                                            $total_sale_price = $row->booking->total - abs($row->booking->proposal_discount);
                                        }else{
                                            $total_sale_price = $row->booking->total + abs($row->booking->proposal_discount);
                                        }
                                    }
                                 ?>
                                    <tr>
                                        <td><a href="#" target="_blank">#{{@$row->booking_id}}</a></td>
                                        <td>{{$row->name}} ({{$row->id}})</td>
                                        <!-- <td>{{$row->email}}</td> -->
                                        <td>{{@getLocationById(@$row->destination)->name}}</td>
                                        <td>{{display_date($row->approx_date)}}</td>
                                        <td>
                                            Adult:{{$row->person_types[0]['number'] ?? 0}}, 
                                            Child: {{$row->person_types[1]['number'] ?? 0}},
                                            Kid: {{$row->person_types[2]['number'] ?? 0}}
                                        </td>
                                        <td>{{$row->created_at}}</td>
                                        <td>{{$total_sale_price}}</td>
                                        <td> <span class="badge badge-secondary">{{$row->status}}</span></td>
                                        <td>
                                        @if(!empty($row->labels) && count($row->labels))
                                            @foreach($row->labels as $lbl)
                                                <?php $label = getLeadLabel($lbl); ?>
                                                <span class="badge badge-pill {{$label['color']}} mr-1" data-toggle="tooltip" title="{{$label['text']}}"> {{$label['text']}} </span>
                                            @endforeach
                                        @endif
                                        </td>
                                        <td>{{@$row->AssignUser->name ?? '-'}}</td>
                                        <td>{{@$row->CreateUser->name ?? '-'}}</td>
                                        <td>{{$row->getLastUserActivity()}}</td>
                                        <!-- <td>{{@$row->UpdateUser->name ?? '-'}}</td> -->
                                        
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
