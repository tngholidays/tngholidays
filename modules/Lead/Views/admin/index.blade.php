@extends('admin.layouts.app')
<style>
    .lead-info-heading {
    background: #f9fafc;
    padding: 7px;
    border-radius: 3px;
    margin-bottom: 15px;
}
.lead-info-heading:first-child {
    margin-left: -15px;
    padding-left: 15px;
}
.lead-info-heading h4 {
    color: #005c86;
}
.font-medium-xs {
    font-size: 13px!important;
}
.lead-field-heading {
    margin-top: 10px;
    margin-bottom: 0;
}
.no-mtop {
    margin-top: 0!important;
}
.text-muted {
    color: #777;
}
.font-medium-xs {
    font-size: 13px!important;
}
table.dataTable {
    clear: both;
    margin-top: 6px!important;
    margin-bottom: 6px!important;
    max-width: none!important;
    border-collapse: separate!important;
}
table.dataTable thead>tr>th {
    color: #4e75ad;
    background: #f6f8fa;
    vertical-align: middle;
    border-bottom: 1px solid;
    border-color: #ebf5ff!important;
    font-size: 13px;
    padding-top: 9px;
    padding-bottom: 8px;
}
table.dataTable thead th:first-child {
    border-top-left-radius: 2px;
}

.table thead tr th:first-child {
    border-left: 1px solid #dcdcdc;
}
.activity-feed {
    padding: 15px;
    word-wrap: break-word;
}
 .activity-feed .feed-item:first-child {
    border-top-right-radius: 3px;
}

.activity-feed .feed-item {
    padding-top: 20px;
    border-right: 1px solid #eaeaea;
    border-top: 1px solid #eaeaea;
    padding-bottom: 15px;
    background: #fdfdfd;
}
.activity-feed .feed-item {
    position: relative;
    padding-bottom: 30px;
    padding-left: 30px;
    border-left: 2px solid #84c529;
}
.activity-feed .feed-item .date {
    position: relative;
    top: -5px;
    color: #4b5158;
    text-transform: uppercase;
    font-size: 12px;
    font-weight: 500;
}
.feed-item .text-has-action {
    margin-bottom: 7px;
    display: inline-block;
}
.text-has-action {
    border-bottom: 1px dashed #bbb;
    padding-bottom: 2px;
}
.activity-feed .feed-item .text {
    position: relative;
    top: -3px;
}
.lead-modal .activity-feed .feed-item:after {
    top: -5px;
    border: 1px solid #84c529;
}

.activity-feed .feed-item:after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    left: -6px;
    width: 10px;
    height: 10px;
    border-radius: 6px;
    background: #fff;
    border: 1px solid #4b5158;
}
.mright5 {
    margin-right: 5px;
}
.staff-profile-xs-image {
    width: 20px;
    height: 20px;
    border-radius: 50%;
}
.pull-left {
    float: left!important;
}

.proposalsLead tr th, .proposalsLead tr td{
    font-size: 14px;
    padding-top: 0px;
    padding-bottom: 0px;
}
.kanban-card span.cancelLead  {
    position: absolute;
    right: -6px;
    background: #fb4a00;
    width: 23px;
    text-align: center;
    height: 23px;
    color: #fff;
    border-radius: 50%;
    padding-top: 4px;
    top: -8px;
    z-index: 9;
}
.mainTopClass {
    width: 100%;
    float: left;
    padding: 10px 0px 10px 0px;
}
.mainTopClass12 {
    width: 12.2%;
    float: left;
    padding: 0px 10px 0px 24px;
    border-right: 1px solid #ccc;
}
.col-left .form-group .btn-info.btn.btn-icon.btn_search {
    text-align: center;
    width: auto;
    float: left;
}
.spanCritDate {
    width: 100%;
    float: right;
    text-align: right;
    font-size: 11px;
    color: #9c9c9c;
    position: absolute;
    bottom: 2px;
    right: 7px;
}
.mainTopClass12:last-child {border-right: 0px solid #ccc;}
.Clor-1 { color:#fb4a00;}
.Clor-2 { color:#17a2b8;}
.Clor-3 { color:#a64ee4;}
.Clor-4 { color:#1d28d8;}
.Clor-5 { color:#28a745;}
.Clor-6 { color:#cabe0a;}
.Clor-7 { color:red;}

.kanban-card { position: relative; margin-top: 10px !important;}
.boards.count-0 .board:nth-child(1) .board-body.border-default{ border-top: 2px #fb4a00 solid;}
.boards.count-0 .board:nth-child(3) .board-body.border-purple{ border-top: 2px #a64ee4 solid;}
.boards.count-0 .board:nth-child(4) .board-body.border-default{border-top: 2px #1d28d8 solid;}
.boards.count-0 .board:nth-child(5) .board-body.border-default{border-top: 2px #1d28d8 solid;}
.boards.count-0 .board:nth-child(6) .board-body.border-purple{border-top: 2px #cabe0a solid}
.col-left .calDiv span {
    top: 9px!important;
}
.leadBadge .badge {
    min-width: 25px !important;
}
</style>
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{ __('All Leads')}}</h1>
            <div class="title-actions">
                <a class="btn btn-info btn-icon" href="javascript::void(0);" title="Add Lead" data-toggle="modal" data-target="#addLeadModal"> Add Lead </a>
                <a class="btn btn-warning btn-icon" href="javascript::void(0);" title="Whatsapp Campagin" data-toggle="modal" data-target="#campaignModal"> Compaign </a>
            </div>

        </div>
        @include('admin.message')
        <div class="filter-div d-flex">
            <div class="col-left">
               <form method="get" action="{{url('/admin/module/Lead/')}} " class="filter-form filter-form-right d-flex justify-content-end" role="search">
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
                            <select class="form-control" name="labels">
                                <option value="">Select Label</option>
                                <option value="1" {{'1'==Request()->labels ? 'selected' : '' }}>Not Picked</option>
                                <option value="2" {{'2'==Request()->labels ? 'selected' : '' }}>Call Back</option>
                                <option value="3" {{'3'==Request()->labels ? 'selected' : '' }}>Not Decide</option>
                                <option value="4" {{'4'==Request()->labels ? 'selected' : '' }}>On Hold</option>
                                <option value="5" {{'5'==Request()->labels ? 'selected' : '' }}>Not Intrested</option>
                                <option value="6" {{'6'==Request()->labels ? 'selected' : '' }}>Cold Followup</option>
                                <option value="7" {{'7'==Request()->labels ? 'selected' : '' }}>Not Contacted</option>
                                <option value="8" {{'8'==Request()->labels ? 'selected' : '' }}>Sales Closed</option>
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <select class="form-control" name="user">
                                <option value="">Select User</option>
                                @if(count($staffs) > 0)
                                    @foreach($staffs as $user )
                                        <option value="{{$user->id}}" {{$user->id==Request()->user ? 'selected' : '' }}>{{$user->first_name}} {{$user->last_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <select class="form-control" name="date_type">
                                <option value="1" {{'1'==Request()->date_type ? 'selected' : '' }}>Created At</option>
                                <option value="2" {{'2'==Request()->date_type ? 'selected' : '' }}>Booking Date</option>
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
                            <select class="form-control" name="duration">
                                <option value="">Select Duration</option>
                                @if(count($terms) > 0)
                                    @foreach($terms as $term )
                                        <option value="{{$term->id}}" {{$term->id==Request()->duration ? 'selected' : '' }}>{{$term->name}}</option>
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
                           <a href="{{route('Lead.admin.index')}}" class="btn-info btn btn-icon btn_search">{{__('Clear')}}</a>
                        </div>
                   </div>
                    
                    
                </form>
            </div>
        </div>
        <div class="panel kanban "> 
        <div class="mainTopClass">
            <div class="mainTopClass12">
                <h2>{{count($new_leads)}}</h2>
                <p class="Clor-1">New Leads</p>
            </div>
             <div class="mainTopClass12">
                <h2>{{count($processing)}}</h2>
                <p class="Clor-2">Processing</p>
            </div>
             <div class="mainTopClass12">
                <h2>{{count($interested)}}</h2>
                <p class="Clor-3">Interested</p>
            </div>
            <div class="mainTopClass12">
                <h2>{{count($notinterested)}}</h2>
                <p class="Clor-3">Not Interested</p>
            </div>
            
             <div class="mainTopClass12">
                <h2>{{count($quotation_send)}}</h2>
                <p class="Clor-4">Quotation Send</p>
            </div>
             <div class="mainTopClass12">
                <h2>{{count($complete_leads)}}</h2>
                <p class="Clor-5">Completed </p>
            </div>
             <div class="mainTopClass12">
                <h2>{{count($payment_done)}}</h2>
                <p class="Clor-6">Payment Done</p>
            </div>
            <div class="mainTopClass12">
                <h2>{{count($cancel_leads)}}</h2>
                <p class="Clor-7">Cancel</p>
            </div>
        </div>
            <div class="panel-body">
                <div class="row kanban-wrapper">
                        <div class="col-12" id="tasks-layout-wrapper">
                            <!--main table view-->
                            <div class="boards count-0" id="tasks-view-wrapper">
                                <!--each board-->
                                <!--board-->
                                <div class="board">
                                    <div class="board-body border-default">
                                        <div class="board-heading clearfix">
                                            <div class="pull-left">New Leads <span class="totalLeads">({{count($new_leads)}})</span></div>
                                            <div class="pull-right x-action-icons">
                                                <!--action add-->
                                            </div>
                                        </div>
                                        <!--cards-->
                                        <div class="content kanban-content" id="kanban-board-wrapper-new" data-board-name="pending">
                                            <!--dynamic content-->
                                            <!--each card-->
                                        @if(count($new_leads)>0)
                                        @foreach($new_leads as $row)
                                            <div class="kanban-card" data-task-id="{{$row->id}}" data-action="view" data-toggle="tooltip" title="{{$row->getLastUserActivity()}}">
                                                @if(!empty($row->labels) && count($row->labels))
                                                <h6 class="leadBadge">
                                                @foreach($row->labels as $lbl)
                                                    <?php
                                                        $label = getLeadLabel($lbl);
                                                    ?>
                                                    <span class="badge badge-pill {{$label['color']}} mr-1" data-toggle="tooltip" title="{{$label['text']}}"> </span>
                                                @endforeach
                                                </h6>
                                                @endif
                                                <span class="cancelLead" data-action="cancel" title="Cancel Lead"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                <span class="spanCritDate">{{date("d-M-Y",strtotime($row->created_at))}}</span>
                                                <div class="viewLead">
                                                        <div class="x-title wordwrap">#{{$row->id}} {{$row->name}}</div>
                                                    <div class="x-meta">
                                                        <span><strong>E-Mail:</strong> {{$row->email}}</span>
                                                        <span><strong>Phone:</strong>: {{$row->phone}}</span>
                                                        <span><strong>Destination:</strong>: {{$row->getLocationById()}}</span>
                                                        <span><strong>Booking Date:</strong>: {{$row->approx_date}}</span>
                                                        <span><strong>Assign To:</strong>: {{@$row->AssignUser->name}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <!--board-->
                                <div class="board">
                                    <div class="board-body border-info">
                                        <div class="board-heading clearfix">
                                            <div class="pull-left">Processing <span class="totalLeads">({{count($processing)}})</span></div>
                                            <div class="pull-right x-action-icons">
                                                <!--action add-->
                                            </div>
                                        </div>
                                        <!--cards-->
                                        <div class="content kanban-content" id="kanban-board-wrapper-processing" data-board-name="processing">
                                            <!--dynamic content-->
                                            <!--each card-->
                                        @if(count($processing)>0)
                                        @foreach($processing as $row)
                                            <div class="kanban-card" data-task-id="{{$row->id}}" data-action="view" data-toggle="tooltip" title="{{$row->getLastUserActivity()}}">
                                                @if(!empty($row->labels) && count($row->labels))
                                                <h6 class="leadBadge">
                                                @foreach($row->labels as $lbl)
                                                    <?php
                                                        $label = getLeadLabel($lbl);
                                                    ?>
                                                    <span class="badge badge-pill {{$label['color']}} mr-1" data-toggle="tooltip" title="{{$label['text']}}"> </span>
                                                @endforeach
                                                </h6>
                                                 @endif
                                                <span class="cancelLead" data-action="cancel" title="Cancel Lead"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                <span class="spanCritDate">{{date("d-M-Y",strtotime($row->created_at))}}</span>
                                                <div class="viewLead">
                                                        <div class="x-title wordwrap">#{{$row->id}} {{$row->name}}</div>
                                                    <div class="x-meta">
                                                        <span><strong>E-Mail:</strong> {{$row->email}}</span>
                                                        <span><strong>Phone:</strong>: {{$row->phone}}</span>
                                                        <span><strong>Destination:</strong>: {{$row->getLocationById()}}</span>
                                                        <span><strong>Booking Date:</strong>: {{$row->approx_date}}</span>
                                                        <span><strong>Assign To:</strong>: {{@$row->AssignUser->name}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                    <!--board-->
                                <div class="board">
                                    <div class="board-body border-default">
                                        <div class="board-heading clearfix">
                                            <div class="pull-left">Quotation Send <span class="totalLeads">({{count($quotation_send)}})</span></div>
                                            <div class="pull-right x-action-icons">
                                                <!--action add-->
                                            </div>
                                        </div>
                                        <!--cards-->
                                        <div class="content kanban-content" id="kanban-board-wrapper-quotation" data-board-name="quotation_send">
                                            <!--dynamic content-->
                                            <!--each card-->
                                        @if(count($quotation_send)>0)
                                        @foreach($quotation_send as $row)
                                            <div class="kanban-card" data-task-id="{{$row->id}}" data-action="view" data-toggle="tooltip" title="{{$row->getLastUserActivity()}}">
                                                @if(!empty($row->labels) && count($row->labels))
                                                <h6 class="leadBadge">
                                                @foreach($row->labels as $lbl)
                                                    <?php
                                                        $label = getLeadLabel($lbl);
                                                    ?>
                                                    <span class="badge badge-pill {{$label['color']}} mr-1" data-toggle="tooltip" title="{{$label['text']}}"> </span>
                                                @endforeach
                                                </h6>
                                                 @endif
                                                <span class="cancelLead" data-action="cancel" title="Cancel Lead"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                <span class="spanCritDate">{{date("d-M-Y",strtotime($row->created_at))}}</span>
                                                <div class="viewLead">
                                                        <div class="x-title wordwrap">#{{$row->id}} {{$row->name}}</div>
                                                    <div class="x-meta">
                                                        <span><strong>E-Mail:</strong> {{$row->email}}</span>
                                                        <span><strong>Phone:</strong>: {{$row->phone}}</span>
                                                        <span><strong>Destination:</strong>: {{$row->getLocationById()}}</span>
                                                        <span><strong>Booking Date:</strong>: {{$row->approx_date}}</span>
                                                        <span><strong>Assign To:</strong>: {{@$row->AssignUser->name}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <!--board-->
                                <!--board-->
                                <div class="board">
                                    <div class="board-body border-purple">
                                        <div class="board-heading clearfix">
                                            <div class="pull-left">Not Interested <span class="totalLeads">({{count($notinterested)}})</span></div>
                                            <div class="pull-right x-action-icons">
                                                <!--action add-->
                                            </div>
                                        </div>
                                        <!--cards-->
                                        <div class="content kanban-content" id="kanban-board-wrapper-notinterested" data-board-name="notinterested">
                                            <!--dynamic content-->
                                            <!--each card-->
                                        @if(count($notinterested)>0)
                                        @foreach($notinterested as $row)
                                            <div class="kanban-card" data-task-id="{{$row->id}}" data-action="view" data-toggle="tooltip" title="{{$row->getLastUserActivity()}}">
                                                @if(!empty($row->labels) && count($row->labels))
                                                <h6 class="leadBadge">
                                                @foreach($row->labels as $lbl)
                                                    <?php
                                                        $label = getLeadLabel($lbl);
                                                    ?>
                                                    <span class="badge badge-pill {{$label['color']}} mr-1" data-toggle="tooltip" title="{{$label['text']}}"> </span>
                                                @endforeach
                                                </h6>
                                                 @endif
                                                <span class="cancelLead" data-action="cancel" title="Cancel Lead"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                <span class="spanCritDate">{{date("d-M-Y",strtotime($row->created_at))}}</span>
                                                <div class="viewLead">
                                                        <div class="x-title wordwrap">#{{$row->id}} {{$row->name}}</div>
                                                    <div class="x-meta">
                                                        <span><strong>E-Mail:</strong> {{$row->email}}</span>
                                                        <span><strong>Phone:</strong>: {{$row->phone}}</span>
                                                        <span><strong>Destination:</strong>: {{$row->getLocationById()}}</span>
                                                        <span><strong>Booking Date:</strong>: {{$row->approx_date}}</span>
                                                        <span><strong>Assign To:</strong>: {{@$row->AssignUser->name}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="board">
                                    <div class="board-body border-purple">
                                        <div class="board-heading clearfix">
                                            <div class="pull-left">Interested <span class="totalLeads">({{count($interested)}})</span></div>
                                            <div class="pull-right x-action-icons">
                                                <!--action add-->
                                            </div>
                                        </div>
                                        <!--cards-->
                                        <div class="content kanban-content" id="kanban-board-wrapper-interested" data-board-name="interested">
                                            <!--dynamic content-->
                                            <!--each card-->
                                        @if(count($interested)>0)
                                        @foreach($interested as $row)
                                            <div class="kanban-card" data-task-id="{{$row->id}}" data-action="view" data-toggle="tooltip" title="{{$row->getLastUserActivity()}}">
                                                @if(!empty($row->labels) && count($row->labels))
                                                <h6 class="leadBadge">
                                                @foreach($row->labels as $lbl)
                                                    <?php
                                                        $label = getLeadLabel($lbl);
                                                    ?>
                                                    <span class="badge badge-pill {{$label['color']}} mr-1" data-toggle="tooltip" title="{{$label['text']}}"> </span>
                                                @endforeach
                                                </h6>
                                                 @endif
                                                <span class="cancelLead" data-action="cancel" title="Cancel Lead"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                <span class="spanCritDate">{{date("d-M-Y",strtotime($row->created_at))}}</span>
                                                <div class="viewLead">
                                                        <div class="x-title wordwrap">#{{$row->id}} {{$row->name}}</div>
                                                    <div class="x-meta">
                                                        <span><strong>E-Mail:</strong> {{$row->email}}</span>
                                                        <span><strong>Phone:</strong>: {{$row->phone}}</span>
                                                        <span><strong>Destination:</strong>: {{$row->getLocationById()}}</span>
                                                        <span><strong>Booking Date:</strong>: {{$row->approx_date}}</span>
                                                        <span><strong>Assign To:</strong>: {{@$row->AssignUser->name}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            
                                <!--board-->
                                <div class="board">
                                    <div class="board-body border-success">
                                        <div class="board-heading clearfix">
                                            <div class="pull-left">Completed <span class="totalLeads">({{count($complete_leads)}})</span></div>
                                            <div class="pull-right x-action-icons">
                                                <!--action add-->
                                            </div>
                                        </div>
                                        <!--cards-->
                                        <div class="content kanban-content" id="kanban-board-wrapper-completed" data-board-name="completed">
                                            <!--dynamic content-->
                                            <!--each card-->
                                             @if(count($complete_leads)>0)
                                                @foreach($complete_leads as $row)
                                                    <div class="kanban-card" data-task-id="{{$row->id}}" data-action="view" data-toggle="tooltip" title="{{$row->getLastUserActivity()}}">
                                                        @if(!empty($row->labels) && count($row->labels))
                                                        <h6 class="leadBadge">
                                                        @foreach($row->labels as $lbl)
                                                            <?php
                                                                $label = getLeadLabel($lbl);
                                                            ?>
                                                            <span class="badge badge-pill {{$label['color']}} mr-1" data-toggle="tooltip" title="{{$label['text']}}"> </span>
                                                        @endforeach
                                                        </h6>
                                                         @endif
                                                        <span class="cancelLead" data-action="cancel" title="Cancel Lead"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                        <span class="spanCritDate">{{date("d-M-Y",strtotime($row->created_at))}}</span>
                                                        <div class="viewLead">
                                                                <div class="x-title wordwrap">#{{$row->id}} {{$row->name}}</div>
                                                            <div class="x-meta">
                                                                <span><strong>E-Mail:</strong> {{$row->email}}</span>
                                                                <span><strong>Phone:</strong>: {{$row->phone}}</span>
                                                                <span><strong>Destination:</strong>: {{$row->getLocationById()}}</span>
                                                                <span><strong>Booking Date:</strong>: {{$row->approx_date}}</span>
                                                                <span><strong>Assign To:</strong>: {{@$row->AssignUser->name}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                                <!--board-->
                                <div class="board">
                                    <div class="board-body border-purple">
                                        <div class="board-heading clearfix">
                                            <div class="pull-left">Payment Done <span class="totalLeads">({{count($payment_done)}})</span></div>
                                            <div class="pull-right x-action-icons">
                                                <!--action add-->
                                            </div>
                                        </div>
                                        <!--cards-->
                                        <div class="content kanban-content" id="kanban-board-wrapper-done" data-board-name="payment_done">
                                            <!--dynamic content-->
                                            <!--each card-->
                                            @if(count($payment_done)>0)
                                                @foreach($payment_done as $row)
                                                    <div class="kanban-card" data-task-id="{{$row->id}}" data-action="view" data-toggle="tooltip" title="{{$row->getLastUserActivity()}}">
                                                        @if(!empty($row->labels) && count($row->labels))
                                                        <h6 class="leadBadge">
                                                        @foreach($row->labels as $lbl)
                                                            <?php
                                                                $label = getLeadLabel($lbl);
                                                            ?>
                                                            <span class="badge badge-pill {{$label['color']}} mr-1" data-toggle="tooltip" title="{{$label['text']}}"> </span>
                                                        @endforeach
                                                        </h6>
                                                         @endif
                                                        <span class="cancelLead" data-action="cancel" title="Cancel Lead"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                        <span class="spanCritDate">{{date("d-M-Y",strtotime($row->created_at))}}</span>
                                                        <div class="viewLead">
                                                                <div class="x-title wordwrap">#{{$row->id}} {{$row->name}}</div>
                                                            <div class="x-meta">
                                                                <span><strong>E-Mail:</strong> {{$row->email}}</span>
                                                                <span><strong>Phone:</strong>: {{$row->phone}}</span>
                                                                <span><strong>Destination:</strong>: {{$row->getLocationById()}}</span>
                                                                <span><strong>Booking Date:</strong>: {{$row->approx_date}}</span>
                                                                <span><strong>Assign To:</strong>: {{@$row->AssignUser->name}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            <!--Update Card Poistion (team only)-->
                            <span id="js-tasks-kanban-wrapper" class="hidden"></span>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewleadInfoModal" role="dialog"></div>
    <div class="modal fade" id="campaignModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Whatsapp Campagin</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <form action="{{route('Lead.admin.campagin')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h4>Total Recepent - {{count($mobile_nos)}}</h4>
                    <input type="hidden" name="mobile_nos" value="{{json_encode($mobile_nos)}}" ?>
                    <div class="form-group">
                        <label class="control-label">Message</label>
                        <textarea name="content" rows="3" class="form-control" placeholder="Write here..."></textarea>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group custom-file mb-3">
                        <input type="file" class="custom-file-input" id="customFile" name="file">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addLeadModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Lead</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <form action="{{route('Lead.admin.updateLead')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name..." value="" />
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Email..." value="" />
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone Number..." value="" required />
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">City</label>
                                <input type="text" name="city" class="form-control" placeholder="Email..." value=""  />
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">Destination</label>
                                <select class="form-control" name="destination">
                                    <option value="">Select Destination</option>
                                    @if(count($locations) > 0) @foreach($locations as $location )
                                    <option value="{{$location->id}}">{{$location->name}}</option>
                                    @endforeach @endif
                                </select>
                            </div>
                        
                            <div class="form-group col-sm-6">
                                <label class="control-label">Duration</label>
                                <select class="form-control" name="duration">
                                    <option value="">Select Duration</option>
                                    @if(count($terms) > 0) @foreach($terms as $term )
                                    <option value="{{$term->id}}">{{$term->name}}</option>
                                    @endforeach @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">Approx. Date</label>
                                <input type="text" class="form-control datePicker" name="approx_date" placeholder="Approx. Date" value="" readonly />
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="control-label">No. of Pax.</label>
                                <table class="table">
                                    <tbody>
                                        <?php $person_types = array('Adult','Child','Kid'); ?>
                                        <tr>
                                            <th>Adult</th>
                                            <th>Child</th>
                                            <th>Kid</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="person_types[0][name]" class="form-control" value="Adult" />
                                                <input type="number" min="0" class="form-control" name="person_types[0][number]" placeholder="Enter No. of Pax." value="" />
                                            </td>
                                            <td>
                                                <input type="hidden" name="person_types[1][name]" class="form-control" value="Child" />
                                                <input type="number" min="0" class="form-control" name="person_types[1][number]" placeholder="Enter No. of Pax." value="" />
                                            </td>
                                            <td>
                                                <input type="hidden" name="person_types[2][name]" class="form-control" value="Kid" />
                                                <input type="number" min="0" class="form-control" name="person_types[2][number]" placeholder="Enter No. of Pax." value="" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="responseMSG"></div>
                                
                        <div class="text-right">
                            <button class="btn btn-primary" type="submit" name="submit" id="submit">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    

@endsection
