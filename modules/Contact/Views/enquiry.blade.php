@extends('layouts.app')
@section('head')

@endsection
@section('content')
<style>
    .md-form p {
    width: 70%;
    float: left;
    padding: 9px 0px 0px 16px;
    margin: 0px;
    font-size: 14px;
}
            .md-form p label.form-check-label input  {
    width: auto;
    margin-right: 3px;
    float: left;
    position: initial;
    margin-top: 2px;
}
            .md-form p label.form-check-label {
                width: auto;
                float: left;
                padding: inherit;
                margin: inherit;
                margin-right: 10%;
            }
            .md-form .btn-primary {
                background: #0750c9;
                color: #fff;
                font-size: 15px;
                border: 0px;
                border-radius: 4px;
                padding: 8px 15px 8px 15px;
                float: left;
                margin-right: 3px;
            }
            .md-form .btn-primary {
    float: left;
    margin-right: 3px;
}
.enquiryForm form .form-bottom .enquiryForm button.btn {
    min-width:105px;
}
.enquiryForm form .form-bottom .input-error {
    border-color: #d03e3e;
    color: #d03e3e;
}
.enquiryForm form.registration-form fieldset {
    display: none;
}
</style>
<div id="bravo_content-wrapper">
	<div class="bravo-contact-block">
    <div class="container">
        <div class="row section">
            <div class="col-md-12 col-lg-5">
                <div role="form" class="form_wrapper enquiryForm" lang="en-US" dir="ltr">
                    <form class="registration-form bravo-contact-block-form" action="{{ route('enquiry.store') }}" method="post">
                    {{csrf_field()}}
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>Enquiry</h3>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="form-group">
                            	<label class="control-label">Name</label>
                                <input type="text" name="name" placeholder="Enter Name" class="form-control required" id="name" required>
                            </div>
                            <div class="form-group">
                            	<label class="control-label">Email</label>
                                <input type="text" name="email" placeholder="Enter Email" class="form-email form-control" id="email">
                            </div>
                            <div class="form-group">
                            	<label class="control-label">Phone Number</label>
                                <input type="Number" min="0" minlength="10" maxlength="10" name="phone" class="form-control required" placeholder="Enter Phone Number" id="contact_number" required>
                            </div>

                            <div class="form-group md-form">
                                <button type="button" class="btn btn-next btn-primary">Next</button>
                                <p>
                                    <label class="form-check-label" for="defaultCheck1">
                                        <input class="form-check-input" type="checkbox" name="enquiry_type" value="0" id="defaultCheck1" checked="" />
                                        Tour
                                    </label>

                                    <label class="form-check-label" for="defaultCheck1">
                                        <input class="form-check-input" type="checkbox" name="enquiry_type" value="1" id="defaultCheck1" />
                                        Farm House
                                    </label>
                                </p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset style="display: none;">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span> Enquiry</h3>
                            </div>
                        </div>
                                <div class="form-bottom">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <input type="text" name="city" placeholder="Enter City" class="form-control required" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Date</label>
                                        <input type="text" name="date" placeholder="Select Date" class="form-email datePicker form-control required" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">No of Person</label>
                                        <input type="Number" min="0" minlength="10" maxlength="10" name="num_of_person" class="form-control required" placeholder="Enter No of Person" />
                                    </div>
                                    <button type="button" class="btn btn-previous">Previous</button>
                                    <button class="btn btn-primary submit" type="button">
                                        {{ __('Submit') }}
                                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    </button>
                                </div>
                            </fieldset>
                    <fieldset style="display: none;">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span> Enquiry</h3>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="form-group">
                            	<label class="control-label">Destination</label>
                                <select class="form-control required" name="destination">
                                    <option value="">Select Destination</option>
                                    @if(count($locations) > 0)
                                        @foreach($locations as $location )
                                            <option value="{{$location->id}}">{{$location->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                            	<label class="control-label">Duration</label>
                                <select class="form-control required" name="duration">
                                    <option value="">Select Duration</option>
                                    @if(count($terms) > 0)
                                        @foreach($terms as $term )
                                            <option value="{{$term->id}}">{{$term->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
															<label class="control-label">No. of Pax.</label>
															<table class="table">
																<tbody>
																	<?php $person_types = array('Adult','Child','Kid'); ?>
																  @foreach($person_types as $key=>$person_type)
																	<tr>
																		<td>{{$person_type}}</td>
																		<td>
																			<input type="hidden" name="person_types[{{$key}}][name]" class="form-control" value="{{$person_type}}" readonly>
																			<input type="number" min="0" class="form-control" name="person_types[{{$key}}][number]" placeholder="Enter No. of Pax." @if($person_type=="Adult") @endif>
																		</td>
																	</tr>
																	@endforeach

																</tbody>
															</table>
                            </div>
                            <div class="form-group">
                            	<label class="control-label">Approx. Date</label>
                                <input type="text" class="form-control datePicker required" name="approx_date" placeholder="Approx. Date" readonly>
                            </div>
														<div class="form-group">
																{{recaptcha_field('contact')}}
														</div>
                            <button type="button" class="btn btn-previous">Previous</button>
                                    <button class="btn btn-primary submit" type="button">
                                        {{ __('Submit') }}
                                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    </button>
                        </div>
                    </fieldset>
                    <div class="form-mess"></div>
                </form>

                </div>
            </div>
            <div class="offset-lg-2 col-md-12 col-lg-5">
                <div class="contact-info">
                    <div class="info-bg">
                        @if($bg = get_file_url(setting_item("page_contact_image"),"full"))
                            <img src="{{$bg}}" class="img-responsive" alt="{{ setting_item_with_lang("page_contact_title") }}">
                        @endif
                    </div>
                    <div class="info-content">
                        <div class="sub">
                            <p>{!! setting_item_with_lang("page_contact_desc") !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('footer')
<script>

</script>
@endsection
