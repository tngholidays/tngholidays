@extends ('admin.layouts.app')
@section ('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__('All Enquiries')}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between">
            <div class="col-left">
                @if(!empty($enquiry_update))
                    <form method="post" action="{{url('admin/module/report/enquiry/bulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
                        @csrf
                        <select name="action" class="form-control">
                            <option value="">{{__("-- Bulk Actions --")}}</option>
                            @if(!empty($statues))
                                @foreach($statues as $status)
                                    <option value="{{$status}}">{{__('Mark as: :name',['name'=>booking_status_to_text($status)])}}</option>
                                @endforeach
                            @endif
                            <option value="delete">{{__("DELETE Enquiry")}}</option>
                        </select>
                        <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                    </form>
                @endif
            </div>
            <div class="col-left">
                <form method="get" action="" class="filter-form filter-form-right d-flex justify-content-end">
                    <input type="text" name="s" value="{{ Request()->s }}" placeholder="{{__('Search by email')}}" class="form-control">
                    <button class="btn-info btn btn-icon" type="submit">{{__('Filter')}}</button>
                </form>
            </div>
        </div>
        <div class="text-right">
            <p><i>{{__('Found :total items',['total'=>$rows->total()])}}</i></p>
        </div>
        <div class="panel booking-history-manager">
            <div class="panel-title">{{__('Enquiries')}}</div>
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <table class="table table-hover bravo-list-item">
                        <thead>
                        <tr>
                            <th width="80px"><input type="checkbox" class="check-all"></th>
                            <th>{{__('Service')}}</th>
                            <th>{{__('Customer')}}</th>
                            <th width="80px">{{__('Status')}}</th>
                            <th width="180px">{{__('Created At')}}</th>
                            <th width="180px">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($rows->total() > 0)
                                @foreach($rows as $row)
                                    <tr>
                                        <td><input type="checkbox" class="check-item" name="ids[]" value="{{$row->id}}">
                                            #{{$row->id}}</td>
                                        <td>
                                            @if($service = $row->service)
                                                <a href="{{$service->getDetailUrl()}}" target="_blank">{{$service->title ?? ''}}</a>
                                                @if($service->author)
                                                    <br>
                                                    <span>{{__('by')}}</span>
                                                    <a href="{{url('admin/module/user/edit/'.$service->author->id)}}"
                                                       target="_blank">{{ $service->author->getDisplayName() .' (#'.$service->author->id.')' }}</a>
                                                @endif
                                            @else
                                                {{__("[Deleted]")}}
                                            @endif
                                        </td>
                                        <td>
                                            <ul>
                                                <li>{{__("Name:")}} {{$row->name}}</li>
                                                <li>{{__("Email:")}} {{$row->email}}</li>
                                                <li>{{__("Phone:")}} {{$row->phone}}</li>
                                                <li>{{__("Notes:")}} {{$row->note}}</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="label label-{{$row->status}}">{{$row->statusName}}</span>
                                        </td>
                                        <td>{{display_datetime($row->updated_at)}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('Actions')}}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                  <?php
                                                    $bookingProposal =  $row->bookingProposal();
                                                  ?>
                                                  @if(!empty($bookingProposal) && $bookingProposal->booking_status == 1)
                                                    <a class="dropdown-item" href="{{url('admin/module/report/booking/view_proposal/'.$row->id)}}">{{__('View Praposal')}}</a>
                                                    <a class="dropdown-item" href="{{url('admin/module/report/booking/custom_tour/'.$row->id.'/'.$bookingProposal->tour_id)}}">{{__('Custom Tour')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/booking_proposal/'.$row->id.'/'.$bookingProposal->tour_id)}}">{{__('Edit Praposal')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/copyEnquiry/'.$row->id)}}">{{__('Copy Enquiry')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/booking-form/'.$row->id)}}" onclick="return confirm('Are you sure to book?')">{{__('Book')}}</a>
                                                  @else
                                                    @if(!empty($bookingProposal))
                                                    <a class="dropdown-item" href="{{url('admin/module/report/booking/custom_tour/'.$row->id.'/'.$bookingProposal->tour_id)}}">{{__('Custom Tour')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/booking_proposal/'.$row->id.'/'.$bookingProposal->tour_id)}}">{{__('Create Praposal')}}</a>
                                
                                                    @else
                                                    <a class="dropdown-item" href="{{url('admin/module/report/booking/custom_tour/'.$row->id)}}">{{__('Custom Tour')}}</a>
                                                    @endif
                                                    @if(!empty($bookingProposal->tour_details))
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/view_proposal/'.$row->id)}}">{{__('View Praposal')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/copyEnquiry/'.$row->id)}}">{{__('Copy Enquiry')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/booking-form/'.$row->id)}}" onclick="return confirm('Are you sure to book?')">{{__('Book')}}</a>
                                                    @endif
                                                  @endif

                              <!--                       <a class="dropdown-item" href="{{url('admin/module/report/booking/delete_voucher/'.$row->id)}}">{{__('Delete')}}</a>
                                                    <a class="dropdown-item" href="{{url('admin/module/report/booking/mail_voucher/'.$row->id)}}">{{__('Mail')}}</a> -->
                                                </div>
                                            </div>
                                        </td>
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
        <div class="d-flex justify-content-end">
            {{$rows->links()}}
        </div>
    </div>
@endsection
