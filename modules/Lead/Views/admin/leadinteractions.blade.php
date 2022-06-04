@extends('admin.layouts.app')

@section('content')
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
    width: 14.2%;
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
<?php
function sec_to_time($seconds) {
  $hours = floor($seconds / 3600);
  $minutes = floor($seconds % 3600 / 60);
  $seconds = $seconds % 60;

  return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
} 
?>
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{ __('Leads interactions')}}</h1>

        </div>
        @include('admin.message')
        <div class="filter-div d-flex">
            <div class="col-left">
               <form method="get" action="{{url('/admin/module/Lead/lead-interactions')}} " class="filter-form filter-form-right d-flex justify-content-end" role="search">
                   <div class="row">
                        <div class="form-group col-4">
                           <div class="calDiv">
                                <input type="text" name="from_date" class="form-control datePicker" value="{{ Request()->from_date }}" placeholder="From Date" readonly="" />
                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <!--<div class="form-group col-2">-->
                        <!--    <div class="calDiv">-->
                        <!--        <input type="text" name="to_date" class="form-control datePicker" value="{{ Request()->to_date }}" placeholder="To Date" readonly="" />-->
                        <!--        <span><i class="fa fa-calendar" aria-hidden="true"></i></span>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="form-group col-4">
                           <button class="btn-info btn btn-icon btn_search"  type="submit">{{__('Search Page')}}</button>
                        </div>
                        <div class="form-group col-2">
                           <a href="{{route('Lead.admin.index')}}" class="btn-info btn btn-icon btn_search">{{__('Clear')}}</a>
                        </div>
                   </div>
                    
                    
                </form>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>E-Mail</th>
                                <th>Destination</th>
                                <th>No.of persons</th>
                                <th>Booking Date</th>
                                <th>Status</th>
                                <th class="date">Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                        @if(count($result['data']) > 0)
                            @foreach($result['data']['data'] as $row)
                            <tr>
                                <td>{{$i}}</td>
                                <td class="title">{{$row['customer']['name']}}</td>
                                <td>{{$row['customer']['phoneNumber']}}</td>
                                <td>{{$row['customer']['email']}}</td>
                                <td>{{$row['customer']['company']['name']}}</td>
                                <td>{{$row['customer']['company']['kdm']['name']}}</td>
                                <td>{{$row['customer']['company']['kdm']['phoneNumber']}}</td>
                                <td>
                                    @foreach($row['userFields'] as $status)
                                    <p>{{$status['name']}}:<strong>{{is_numeric($status['value']) ? date('d/m/Y', $status['value'])  : $status['value'] }}</strong> </p>
                                    <hr>
                                    @endforeach
                                </td>
                                <td>{{date('d/m/Y', $row['createdAt'])}} </td>
                                <td><button class="btn btn-info viewleadInfoModal" data-phone="{{$row['customer']['phoneNumber']}}"><i class="fa fa-eye"></i></button></td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="viewleadInfoModal" role="dialog"></div>

@endsection
