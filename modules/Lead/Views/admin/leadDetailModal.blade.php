<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
<style>
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    color: #ffffff;
    background-color: #117a8b;
    border-color: #117a8b #117a8b #117a8b;
    border-radius: 30px;
}
.nav-tabs .nav-link:hover, .nav-tabs .nav-link:focus {
    border-color: #117a8b #117a8b #117a8b;
    border-radius: 30px;
}
.nav-tabs .nav-link {
    border: 1px solid #117a8b;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: .25rem;
    border-radius: 30px;
    color:#333;
    margin-bottom: 10px;
}
.text-muted {
    color: #000000!important;
    font-weight: 600;
}
table.dataTable thead>tr>th {
    color: #00606f;
    background: #d1e8ff;
    border-color: #ebf5ff!important;
    font-size: 14px;
}
.nav-link {
    display: block;
    padding: .5rem 1.5rem;
}
#viewleadInfoModal .modal-dialog .modal-content .modal-header .dropdown .btn-secondary {
    color: #fff;
    background-color: #117a8b;
    border-color: #6c757d;
}
#viewleadInfoModal .modal-dialog .modal-content .modal-header .modal-title { color:#117a8b;}
#viewleadInfoModal .modal-body {
    position: relative;
    flex: 1 1 auto;
    padding: 1rem;
    height: 540px;
    overflow-y: auto;
}
#viewleadInfoModal .modal-lg, #viewleadInfoModal .modal-xl {
    max-width: 74%;
}
.proposalsLead tr th, .proposalsLead tr td {
    font-size: 12px;
    padding-top: 0px;
    padding-bottom: 0px;
    color: #000 !important;
}
.nav-tabs .nav-link.active:hover { color:#fff;}
.nav-tabs .nav-link:hover { color:#117a8b;}
.nav-tabs .nav-item {
    margin-bottom: -1px;
    margin-right: 4px;
}

</style>
<div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" style="width:100%">#{{$row->id}} - {{@$row->name}}</h4>
                <?php $rowPraposal =  $row->bookingProposal(); ?>
                <div class="" style="width:100%">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle float-right" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('Actions')}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          @if(!empty($rowPraposal) && $rowPraposal->booking_status == 1)
                            <a class="dropdown-item" href="{{url('admin/module/report/booking/view_proposal/'.$row->id)}}">{{__('View Praposal')}}</a>
                            <a class="dropdown-item" href="{{url('admin/module/report/booking/custom_tour/'.$row->id.'/'.$rowPraposal->tour_id)}}">{{__('Custom Tour')}}</a>
                              <a class="dropdown-item" href="{{url('admin/module/report/booking/booking_proposal/'.$row->id.'/'.$rowPraposal->tour_id)}}">{{__('Edit Praposal')}}</a>
                              <a class="dropdown-item" href="{{url('admin/module/report/booking/copyEnquiry/'.$row->id)}}">{{__('Copy Enquiry')}}</a>
                              <a class="dropdown-item" href="{{url('admin/module/report/booking/booking-form/'.$row->id)}}" onclick="return confirm('Are you sure to book?')">{{__('Book')}}</a>
                          @else
                            @if(!empty($rowPraposal))
                            <a class="dropdown-item" href="{{url('admin/module/report/booking/custom_tour/'.$row->id.'/'.$rowPraposal->tour_id)}}">{{__('Custom Tour')}}</a>
                              <a class="dropdown-item" href="{{url('admin/module/report/booking/booking_proposal/'.$row->id.'/'.$rowPraposal->tour_id)}}">{{__('Create Praposal')}}</a>
                              <a class="dropdown-item" href="{{url('admin/module/report/booking/view_proposal/'.$row->id)}}">{{__('View Praposal')}}</a>
                              <a class="dropdown-item" href="{{url('admin/module/report/booking/copyEnquiry/'.$row->id)}}">{{__('Copy Enquiry')}}</a>
                              <a class="dropdown-item" href="{{url('admin/module/report/booking/booking-form/'.$row->id)}}" onclick="return confirm('Are you sure to book?')">{{__('Book')}}</a>
        
                            @else
                            <a class="dropdown-item" href="{{url('admin/module/report/booking/custom_tour/'.$row->id)}}">{{__('Custom Tour')}}</a>
                            @endif
                          @endif
                        </div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal">
          <span>×</span>
        </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab1">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab8">Edit Lead</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab2">
                            Praposal
                        </a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab3">
                            E-Mail
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link switchTab" data-tab="reminder" data-phone="{{$row->phone}}" data-id="{{$row->id}}" data-toggle="tab" href="#tab4">
                            Reminders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link switchTab whatsappSync" data-tab="whatsapp" data-phone="{{$row->phone}}" data-id="{{$row->id}}" data-toggle="tab" href="#tab7">
                            Whatsapp
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab5">
                            Comments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link switchTab" data-tab="activity" data-phone="{{$row->phone}}" data-id="{{$row->id}}" data-toggle="tab" href="#tab6">
                            Activity Logs
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab-pane active">
                        <br />
                        <div class="booking-review">
                            <div class="row">
                              <div class="col-md-4 col-xs-12 lead-information-col">
                                        <div class="lead-info-heading">
                                            <h4 class="no-margin font-medium-xs bold">
                                                Lead Info
                                            </h4>
                                        </div>
                                        <p class="text-muted lead-field-heading no-mtop">Name</p>
                                        <p class="bold font-medium-xs lead-name">{{isset($row->name) ? $row->name : '-'}}</p>
                                        <p class="text-muted lead-field-heading">Position</p>
                                        <p class="bold font-medium-xs">-</p>
                                        <p class="text-muted lead-field-heading">Email Address</p>
                                        <p class="bold font-medium-xs"><a href="mailto:sankarsaranvpv@gmail.com">{{isset($row->email) ? $row->email : '-'}}</a></p>
                                        <p class="text-muted lead-field-heading">Website</p>
                                        <p class="bold font-medium-xs">-</p>
                                        <p class="text-muted lead-field-heading">Phone</p>
                                        <p class="bold font-medium-xs"><a href="tel:{{$row->phone}}">{{$row->phone}}</a></p>
                                        <p class="text-muted lead-field-heading">City</p>
                                        <p class="bold font-medium-xs">{{isset($row->city) ? $row->city : '-'}}</p>
        
                                    </div>
                                    <div class="col-md-4 col-xs-12 lead-information-col">
                                        <div class="lead-info-heading">
                                            <h4 class="no-margin font-medium-xs bold">
                                                General Information
                                            </h4>
                                        </div>
                                        <p class="text-muted lead-field-heading no-mtop">Status</p>
                                        <p class="bold font-medium-xs mbot15">{{$row->status}}</p>
                                        <p class="text-muted lead-field-heading">Source</p>
                                        <p class="bold font-medium-xs mbot15">{{$row->source}}</p>
                                        <p class="text-muted lead-field-heading">Default Language</p>
                                        <p class="bold font-medium-xs mbot15">English</p>
                                        <p class="text-muted lead-field-heading">Assigned</p>
                                        <p class="bold font-medium-xs mbot15">@if(!empty($row->update_user) && $row->update_user != 1) {{@$row->UpdateUser->first_name}} {{@$row->UpdateUser->last_name}} @else TNGHOLIDAYS @endif</p>
                                        <p class="text-muted lead-field-heading">Created at</p>
                                        <p class="bold font-medium-xs"><span class="text-has-action" data-toggle="tooltip" data-title="{{time_elapsed_string($row->created_at)}}">{{date("d M y h:i A",strtotime($row->created_at))}} ({{time_elapsed_string($row->created_at)}}) </span></p>
                                        <p class="text-muted lead-field-heading">Updated at</p>
                                        <p class="bold font-medium-xs"><span class="text-has-action" data-toggle="tooltip" data-title="{{time_elapsed_string($row->updated_at)}}">{{date("d M y h:i A",strtotime($row->updated_at))}} ({{time_elapsed_string($row->updated_at)}})</span></p>
                                        <p class="text-muted lead-field-heading">Lead Form</p>
                                        <p class="bold font-medium-xs mbot15">Lead Enquiry Form</p>
                                    </div>
                                    <div class="col-md-4 col-xs-12 lead-information-col">
                                        <div class="lead-info-heading">
                                            <h4 class="no-margin font-medium-xs bold">
                                                Custom Fields
                                            </h4>
                                        </div>
                                        <p class="text-muted lead-field-heading no-mtop">Destination</p>
                                        <p class="bold font-medium-xs">{{isset($row->destination) ? @getLocationById($row->destination)->name : '-'}}</p>
                                        <p class="text-muted lead-field-heading no-mtop">Package Duration</p>
                                        <p class="bold font-medium-xs">{{isset($row->duration) ? @getDurationById(@$row->duration)->name : '-'}}</p>
                                        <p class="text-muted lead-field-heading no-mtop">Adult</p>
                                        <p class="bold font-medium-xs">{{isset($row->person_types[0]['name']) ? $row->person_types[0]['number'] : '-'}}</p>
                                        <p class="text-muted lead-field-heading no-mtop">Child</p>
                                        <p class="bold font-medium-xs">{{isset($row->person_types[1]['name']) ? $row->person_types[1]['number'] : '-'}}</p>
                                        <p class="text-muted lead-field-heading no-mtop">Infant</p>
                                        <p class="bold font-medium-xs">{{isset($row->person_types[2]['name']) ? $row->person_types[2]['number'] : '-'}}</p>
                                        <p class="text-muted lead-field-heading no-mtop">Booking Date</p>
                                        <p class="bold font-medium-xs">{{isset($row->approx_date) ? $row->approx_date : '-'}}</p>
                 
                                    </div>
                            </div>

                        </div>
                    </div>
                    <div id="tab8" class="tab-pane fade">
                        <br />
                        <div class="booking-review">
                           <form action="{{route('Lead.admin.updateLead')}}" method="post" id="updateLead" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{{$row->id}}">
                                @csrf
                                <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="control-label">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name..." value="{{$row->name}}">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="control-label">Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email..." value="{{$row->email}}">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="control-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number..." value="{{$row->phone}}" readonly>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="control-label">City</label>
                                    <input type="text" name="city" class="form-control" placeholder="Email..." value="{{$row->city}}">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group col-sm-6">
                            	<label class="control-label">Destination</label>
                                <select class="form-control" name="destination">
                                    <option value="">Select Destination</option>
                                    @if(count($locations) > 0)
                                        @foreach($locations as $location )
                                            <option value="{{$location->id}}" {{$location->id==$row->destination ? 'selected' : '' }}>{{$location->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                            	<label class="control-label">Duration</label>
                                <select class="form-control" name="duration">
                                    <option value="">Select Duration</option>
                                    @if(count($terms) > 0)
                                        @foreach($terms as $term )
                                            <option value="{{$term->id}}" {{$term->id==$row->duration ? 'selected' : '' }}>{{$term->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                            	<label class="control-label">Approx. Date</label>
                                <input type="text" class="form-control datePicker" name="approx_date" placeholder="Approx. Date" value="{{$row->approx_date}}">
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
												<input type="hidden" name="person_types[0][name]" class="form-control" value="Adult">
												<input type="number" min="0" class="form-control" name="person_types[0][number]" placeholder="Enter No. of Pax." value="{{isset($row->person_types[0]['name']) ? $row->person_types[0]['number'] : 0}}">
											</td>
											<td>
												<input type="hidden" name="person_types[1][name]" class="form-control" value="Child">
												<input type="number" min="0" class="form-control" name="person_types[1][number]" placeholder="Enter No. of Pax." value="{{isset($row->person_types[1]['name']) ? $row->person_types[1]['number'] : 0}}">
											</td>
											<td>
												<input type="hidden" name="person_types[2][name]" class="form-control" value="Kid">
												<input type="number" min="0" class="form-control" name="person_types[2][number]" placeholder="Enter No. of Pax." value="{{isset($row->person_types[2]['name']) ? $row->person_types[2]['number'] : 0}}">
											</td>
										</tr>

									</tbody>
								</table>
                            </div>
                            <?php
                            if(!empty($row->labels) && count($row->labels)){
                                foreach($row->labels as $lbl){
                                    if($lbl == 1){
                                        $lbl1 = true;
                                    }elseif($lbl == 2){
                                        $lbl2 = true;
                                    }elseif($lbl == 3){
                                        $lbl3 = true;
                                    }elseif($lbl == 4){
                                        $lbl4 = true;
                                    }elseif($lbl == 5){
                                        $lbl5 = true;
                                    }elseif($lbl == 6){
                                        $lbl6 = true;
                                    }elseif($lbl == 7){
                                        $lbl7 = true;
                                    }elseif($lbl == 8){
                                        $lbl8 = true;
                                    }
                                }
                            }
                            ?>
                            <div class="col-12 form-group">
                                <div class="row gutters-xs">
                                    <div class="custom-control custom-checkbox mt-2 mb-2">
                                        <input class="custom-control-input" id="labels_1" name="labels[]" type="checkbox" value="1" {{isset($lbl1) ? "checked" : ''}} />
                                        <label for="labels_1" class="custom-control-label ml-4 badge badge-pill text-white badge-primary">Not Picked</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2 mb-2">
                                        <input class="custom-control-input" id="labels_2" name="labels[]" type="checkbox" value="2" {{isset($lbl2) ? "checked" : ''}}/>
                                        <label for="labels_2" class="custom-control-label ml-4 badge badge-pill text-white badge-info">Call Back</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2 mb-2">
                                        <input class="custom-control-input" id="labels_3" name="labels[]" type="checkbox" value="3" {{isset($lbl3) ? "checked" : ''}}/>
                                        <label for="labels_3" class="custom-control-label ml-4 badge badge-pill text-white badge-warning">Not Decide</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2 mb-2">
                                        <input class="custom-control-input" id="labels_4" name="labels[]" type="checkbox" value="4" {{isset($lbl4) ? "checked" : ''}}/>
                                        <label for="labels_4" class="custom-control-label ml-4 badge badge-pill text-white badge-danger">On Hold</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2 mb-2">
                                        <input class="custom-control-input" id="labels_5" name="labels[]" type="checkbox" value="5" {{isset($lbl5) ? "checked" : ''}}/>
                                        <label for="labels_5" class="custom-control-label ml-4 badge badge-pill text-white badge-success">Not Intrested</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2 mb-2">
                                        <input class="custom-control-input" id="labels_5" name="labels[]" type="checkbox" value="6" {{isset($lbl6) ? "checked" : ''}}/>
                                        <label for="labels_5" class="custom-control-label ml-4 badge badge-pill text-white badge-color6">Cold Followup</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2 mb-2">
                                        <input class="custom-control-input" id="labels_5" name="labels[]" type="checkbox" value="7" {{isset($lbl7) ? "checked" : ''}}/>
                                        <label for="labels_5" class="custom-control-label ml-4 badge badge-pill text-white badge-color7">Not Contacted</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2 mb-2">
                                        <input class="custom-control-input" id="labels_5" name="labels[]" type="checkbox" value="8" {{isset($lbl8) ? "checked" : ''}}/>
                                        <label for="labels_5" class="custom-control-label ml-4 badge badge-pill text-white badge-color8">Sales Closed</label>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                                <div class="responseMSG"></div>
                                
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit" name="submit" id="submit">Save</button>
                                </div>
                            </form>

                        </div>
                    </div> 
                    <div id="tab2" class="tab-pane fade">
                        <table class="table table-proposals-lead proposalsLead dataTable no-footer" >
                            <thead>
                                <tr role="row">
                                    <th>#Name</th>
                                    <th>E-Mail</th>
                                    <th>Destination</th>
                                    <th>Approx Date</th>
                                    <th>Person Types</th>
                                    <th>Date</th>
                                    <th>Proposal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($leads)>0)
                                @foreach($leads as $lead)
                                <?php $bookingProposal =  $lead->bookingProposal();  ?>
                                <tr>
                                    <?php $start_date = $lead->approx_date; ?>
                                    <td>#{{$lead->id}} {{$lead->name}}</td>
                                    <td>{{$lead->email}}</td>
                                    <td>{{@getLocationById(@$lead->destination)->name}} <br> {{@getDurationById(@$lead->duration)->name}}</td>
                                    <td>{{$start_date}}</td>
                                    <td>
                                        Adult:{{isset($lead->person_types[0]['name']) ? $lead->person_types[0]['number'] : '0'}}, 
                                        Child:{{isset($lead->person_types[1]['name']) ? $lead->person_types[1]['number'] : '0'}}, 
                                        Kid: {{isset($lead->person_types[2]['name']) ? $lead->person_types[2]['number'] : '0'}}
                                    </td>
                                    <td>{{$lead->created_at}}</td>
                                    <!--<td>@if(!empty($bookingProposal->tour_details)) <a href="{{url('admin/module/report/booking/proposal_pdf/'.$lead->id)}}" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i></a> @endif</td>-->
                                    <td>
                                        <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('Actions')}}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                  <?php
                                                    $bookingProposal =  $lead->bookingProposal();
                                                  ?>
                                                  @if(!empty($bookingProposal) && $bookingProposal->booking_status == 1)
                                                    <a class="dropdown-item" href="{{url('admin/module/report/booking/proposal_pdf/'.$lead->id)}}" target="_blank">{{__('View Praposal')}}</a>
                                                    <a class="dropdown-item" href="{{url('admin/module/report/booking/custom_tour/'.$lead->id.'/'.$bookingProposal->tour_id)}}">{{__('Custom Tour')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/booking_proposal/'.$lead->id.'/'.$bookingProposal->tour_id)}}">{{__('Edit Praposal')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/copyEnquiry/'.$lead->id)}}">{{__('Copy Enquiry')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/booking-form/'.$lead->id)}}" onclick="return confirm('Are you sure to book?')">{{__('Book')}}</a>
                                                  @else
                                                    @if(!empty($bookingProposal))
                                                    <a class="dropdown-item" href="{{url('admin/module/report/booking/custom_tour/'.$lead->id.'/'.$bookingProposal->tour_id)}}">{{__('Custom Tour')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/booking_proposal/'.$lead->id.'/'.$bookingProposal->tour_id)}}">{{__('Create Praposal')}}</a>
                                
                                                    @else
                                                    <a class="dropdown-item" href="{{url('admin/module/report/booking/custom_tour/'.$lead->id)}}">{{__('Custom Tour')}}</a>
                                                    @endif
                                                    @if(!empty($bookingProposal->tour_details))
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/proposal_pdf/'.$lead->id)}}" target="_blank">{{__('View Praposal')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/copyEnquiry/'.$lead->id)}}">{{__('Copy Enquiry')}}</a>
                                                      <a class="dropdown-item" href="{{url('admin/module/report/booking/booking-form/'.$lead->id)}}" onclick="return confirm('Are you sure to book?')">{{__('Book')}}</a>
                                                    @endif
                                                  @endif
                                                </div>
                                            </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <td valign="top" colspan="8" class="dataTables_empty">
                                        No entries found
                                    </td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div id="tab3" class="tab-pane fade">
                        <br />
                        <div class="booking-review">
                            <form action="{{route('Lead.admin.leadMailSend')}}" method="post" id="leadMailSend" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{{$row->id}}">
                                @csrf
                                <div class="col-sm-12 form-group email-id-row">
                                    <label>To</label>
                                    <div class="all-mail">
                                        @if(!empty($row->email))
                                        <span class="email-ids">{{$row->email}} <span class="cancel-email">x</span><input type="hidden" value="{{$row->email}}" name="emails[]"></span>
                                        @endif
                                    </div>
                                    <input type="text" name="email" class="enter-mail-id" placeholder="Enter the email id ..">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Subject</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Subject..." value="">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea name="content" rows="3" class="form-control" placeholder="Write here..."></textarea>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile" name="file">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div class="responseMSG"></div>
                                
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit" name="submit" id="submit"><i class="fa fa-envelope"></i> Send</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div id="tab4" class="tab-pane fade">
                        <div class="section">
                            <br />
                            <div class="booking-review">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal2"><i class="fa fa-bell"></i> Add Reminder</button>
                            </div>

                            <table class="table table-proposals-lead dataTable no-footer" >
                                <thead>
                                    <tr role="row">
                                        <th>#id</th>
                                        <th>Date/Time</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Created At.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($reminders)>0)
                                    @foreach($reminders as $reminder)
                                    <tr>
                                        <td>#{{$reminder->enquiry_id}}</td>
                                        <td>{{$reminder->date}}</td>
                                        <td>{{$reminder->content}}</td>
                                        <td>{{$reminder->status}}</td>
                                        <td>{{$reminder->created_at}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <td valign="top" colspan="4" class="dataTables_empty">
                                            No entries found
                                        </td>
                                    @endif
                                        
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="tab7" class="tab-pane fade">
                        <br />
                        <div class="booking-review">
                          <button class="btn btn-primary" id="sync" type="submit">Sync</button>
                            <form action="{{route('Lead.admin.leadComment')}}" method="post" id="SendWhatsapp">
                                    <input type="hidden" name="id" value="{{$row->id}}">
                                    <input type="hidden" name="type" value="2">
                                    @csrf
                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea name="content" rows="3" class="form-control" placeholder="Write here..."></textarea>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile" name="file">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div class="responseMSG"></div>
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit">Add</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="activity-feed">
                          @if(count($whatsappchat)>0)
                          @foreach($whatsappchat as $his)
                          <div class="feed-item">
                              <div class="date">
                                  <span class="text-has-action" data-toggle="tooltip" data-title="{{date("d M Y h:i A",strtotime($his->created_at))}}" data-original-title="" title=""> 
                                    
                                    {{time_elapsed_string($his->created_at)}} ({{date("d M Y h:i A",strtotime($his->created_at))}})</span>
                              </div>
                              <div class="text">
                                  <strong>
                                   @if($his->from_id=="917737887402@c.us")
                                       Admin
                                   @else
                                      {{$lead->name}} 
                                    @endif
                                  </strong>
                                    <br/>
                                  Send Whatsapp Message - {{$his->message}}
                                 
                              </div>
                          </div>
                          @endforeach
                          @endif
                      </div>
                        
                    </div>
                    <div id="tab5" class="tab-pane fade">
                        <br />
                        <div class="booking-review">
                            <form action="{{route('Lead.admin.leadComment')}}" method="post" id="leadComment">
                                    <input type="hidden" name="id" value="{{$row->id}}">
                                    <input type="hidden" name="type" value="1">
                                    @csrf
                                <div class="form-group">
                                    <label class="control-label">Comment</label>
                                    <textarea name="content" rows="3" class="form-control" placeholder="Write here..."></textarea>
                                    <span class="help-block"></span>
                                </div>
                                <div class="responseMSG"></div>
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div id="tab6" class="tab-pane fade">
                        <div class="section-activity">
                            
                            <br />
                            <div class="booking-review">
                                <div class="activity-feed">
                                    @if(count($history)>0)
                                    @foreach($history as $his)
                                    <div class="feed-item">
                                        <div class="date">
                                            <span class="text-has-action" data-toggle="tooltip" data-title="{{date("d M Y h:i A",strtotime($his->created_at))}}" data-original-title="" title=""> {{time_elapsed_string($his->created_at)}} ({{date("d M Y h:i A",strtotime($his->created_at))}})</span>
                                        </div>
                                        <div class="text">
                                            @if($his->type == 'email')
                                                E-Mail Sent - {{$his->content}}
                                            @elseif($his->type == 'comment')
                                                Comment Added - {{$his->content}}
                                            @elseif($his->type == 'whatsapp')
                                                Send Whatsapp Message - {{$his->content}}
                                            @elseif($his->type == 'reminder')
                                                Reminder Added - {{$his->content}}
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Set Reminder</h4>
                    <button type="button" class="close closeReminder"><span>×</span></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{route('Lead.admin.leadSetReminder')}}" method="post" id="leadSetReminder">
                        <input type="hidden" name="id" value="{{$row->id}}">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <div class="calDiv">
                                <input type="text" name="date" class="form-control datePicker" value="" placeholder="Start Date" readonly="" required />
                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                            <div class="timeDiv">
                                <input type="text" name="time" class="form-control timepicker" value="" placeholder="Time" readonly="" />
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Message</label>
                            <textarea name="content" rows="3" class="form-control" placeholder="Write here..."></textarea>
                            <span class="help-block"></span>
                        </div>
                        <div class="responseMSG"></div>
                        <div class="text-right">
                            <button class="btn btn-primary" type="submit" name="submit" id="submit"><i class="fa fa-bell"></i> Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal3" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">#Test</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

  <style type="text/css">
  @keyframes ldio-6alyp2wejxn-1 {
    0% { top: 36px; height: 128px }
    50% { top: 60px; height: 80px }
    100% { top: 60px; height: 80px }
  }
  @keyframes ldio-6alyp2wejxn-2 {
    0% { top: 41.99999999999999px; height: 116.00000000000001px }
    50% { top: 60px; height: 80px }
    100% { top: 60px; height: 80px }
  }
  @keyframes ldio-6alyp2wejxn-3 {
    0% { top: 48px; height: 104px }
    50% { top: 60px; height: 80px }
    100% { top: 60px; height: 80px }
  }
  .ldio-6alyp2wejxn div { position: absolute; width: 30px }.ldio-6alyp2wejxn div:nth-child(1) {
    left: 35px;
    background: #e15b64;
    animation: ldio-6alyp2wejxn-1 1s cubic-bezier(0,0.5,0.5,1) infinite;
    animation-delay: -0.2s
  }
  .ldio-6alyp2wejxn div:nth-child(2) {
    left: 85px;
    background: #f8b26a;
    animation: ldio-6alyp2wejxn-2 1s cubic-bezier(0,0.5,0.5,1) infinite;
    animation-delay: -0.1s
  }
  .ldio-6alyp2wejxn div:nth-child(3) {
    left: 20px;
    background: #abbd81;
    animation: ldio-6alyp2wejxn-3 1s cubic-bezier(0,0.5,0.5,1) infinite;
    animation-delay: undefineds
  }
  
  .loadingio-spinner-pulse-uinbzec5pta {
    width: 32px;
    height: 32px;
    display: inline-block;
    overflow: hidden;
    background: #0000FF;
  }
  .ldio-6alyp2wejxn {
    width: 100%;
    height: 100%;
    position: relative;
    transform: translateZ(0) scale(1);
    backface-visibility: hidden;
    transform-origin: 0 0; /* see note above */
  }
  .ldio-6alyp2wejxn div { box-sizing: content-box; }
  /* generated by https://loading.io/ */
  </style>

<script>
    function successMsg(status, text) {
        if (status == '2') {
            var msg = '<div class="alert alert-danger"><strong>Error!</strong>opps! Something Went Wrong</div>';
        }else{
            var msg = '<div class="alert alert-success"><strong>Success! </strong>'+text+'</div>';
        }
        return msg;
    }
    $(function() {
    $('.datePicker').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            cancelLabel: 'Clear',
            format: 'DD/MM/YYYY'
        }
    });
    $(".timepicker").datetimepicker({
        format: "LT",
        useCurrent: false, 
        ignoreReadonly: true,
         // debug:true,
        icons: {
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down"
        }
    });
});
$('.datePicker').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
});
   // Wait for the DOM to be ready
$(document).ready(function(){
        $( "#sync" ).click(function() {
          $( "#sync" ).html('Syncing ...');
          console.log("{!! route('Lead.admin.sync',['mobileno' => $row->phone]) !!}");
          $.ajax({
             type: "GET",
             dataType : "JSON",
             url: "{!! route('Lead.admin.sync',['mobileno' => $row->phone]) !!}",
             contentType: false,
             cache: false,
             processData:false,
             success: function(data)
                {
                  $( "#sync" ).html('Sync');
                  alert("Sync has been completed");
                  $('.whatsappSync').click();
              }
          });
          
        });
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("#leadMailSend").validate({
    // Specify validation rules
    rules: {
      subject: "required",
      content: "required"
    },
    // Specify validation error messages
    messages: {
     
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent().find('.help-block'));
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
    $.ajax({
       type: "POST",
       dataType : "JSON",
       url: "{!! route('Lead.admin.leadMailSend') !!}",
       data:  new FormData(form),
       contentType: false,
       cache: false,
       processData:false,
       success: function(data)
          {
            if(data==1)
            {
              $(form).find(".loding").hide();
              $(form).find('.submit').attr('disabled',false);
              $(form)[0].reset();
              $('.all-mail').find('.email-ids').remove();
              var msg = successMsg(1, 'E-Mail Sent Successfully');
              $(form).find('.responseMSG').append(msg);
              setTimeout(function(){$(form).find('.responseMSG .alert').remove(); }, 3000);
             
            }
            else 
            {
              $(form).find(".loding").show();
              $(form).find('.submit').attr('disabled',true);
              alert("Error! Something goes Wrong.");
            }
        }
    });
    }
  });
   $("#updateLead").validate({
    // Specify validation rules
    rules: {
        
    },
    // Specify validation error messages
    messages: {
     
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent().find('.help-block'));
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
    $.ajax({
       type: "POST",
       dataType : "JSON",
       url: "{!! route('Lead.admin.updateLead') !!}",
       data:  new FormData(form),
       contentType: false,
       cache: false,
       processData:false,
       success: function(data)
          {
            if(data==1)
            {
              $(form).find(".loding").hide();
              $(form).find('.submit').attr('disabled',false);
              var msg = successMsg(1, 'Lead Updated Successfully');
              $(form).find('.responseMSG').append(msg);
              setTimeout(function(){$(form).find('.responseMSG .alert').remove(); }, 3000);
             
            }
            else 
            {
              $(form).find(".loding").show();
              $(form).find('.submit').attr('disabled',true);
              alert("Error! Something goes Wrong.");
            }
        }
    });
    }
  });

$("#SendWhatsapp").validate({
    // Specify validation rules
    rules: {
      subject: "required",
      content: "required"
    },
    // Specify validation error messages
    messages: {
     
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent().find('.help-block'));
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
    $.ajax({
       type: "POST",
       dataType : "JSON",
       url: "{!! route('Lead.admin.leadComment') !!}",
       data:  new FormData(form),
       contentType: false,
       cache: false,
       processData:false,
       success: function(data)
          {
            if(data==1)
            {
              $(form).find(".loding").hide();
              $(form).find('.submit').attr('disabled',false);
               $(form)[0].reset();
              var msg = successMsg(1, 'Whatsapp Message Sent Successfully');
              $(form).find('.responseMSG').append(msg);
              setTimeout(function(){$(form).find('.responseMSG .alert').remove(); }, 3000);
             
            }
            else 
            {
               $(form).find(".loding").show();
              $(form).find('.submit').attr('disabled',true);
              alert("Error! Something goes Wrong.");
            }
        }
    });
    }
  });
$("#leadComment").validate({
    // Specify validation rules
    rules: {
      subject: "required",
      content: "required"
    },
    // Specify validation error messages
    messages: {
     
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent().find('.help-block'));
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
    $.ajax({
       type: "POST",
       dataType : "JSON",
       url: "{!! route('Lead.admin.leadComment') !!}",
       data:  new FormData(form),
       contentType: false,
       cache: false,
       processData:false,
       success: function(data)
          {
            if(data==1)
            {
              $(form).find(".loding").hide();
              $(form).find('.submit').attr('disabled',false);
               $(form)[0].reset();
              var msg = successMsg(1, 'Comment Added Successfully');
              $(form).find('.responseMSG').append(msg);
              setTimeout(function(){$(form).find('.responseMSG .alert').remove(); }, 3000);
             
            }
            else 
            {
               $(form).find(".loding").show();
              $(form).find('.submit').attr('disabled',true);
              alert("Error! Something goes Wrong.");
            }
        }
    });
    }
  });
$("#leadSetReminder").validate({
    // Specify validation rules
    rules: {
      reminderDate: "required",
      content: "required"
    },
    // Specify validation error messages
    messages: {
     
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent('.form-group').find('.help-block'));
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
    $.ajax({
       type: "POST",
       dataType : "JSON",
       url: "{!! route('Lead.admin.leadSetReminder') !!}",
       data:  new FormData(form),
       contentType: false,
       cache: false,
       processData:false,
       success: function(data)
          {
            if(data==1)
            {
              $(form).find(".loding").hide();
              $(form).find('.submit').attr('disabled',false);
               $(form)[0].reset();

              var msg = successMsg(1, 'Reminder Set Successfully');
              $(form).find('.responseMSG').append(msg);
              setTimeout(function(){$(form).find('.responseMSG .alert').remove(); }, 3000);
             
            }
            else 
            {
               $(form).find(".loding").show();
              $(form).find('.submit').attr('disabled',true);
              alert("Error! Something goes Wrong.");
            }
        }
    });
    }
  });
});

</script>