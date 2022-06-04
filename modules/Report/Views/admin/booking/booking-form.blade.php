@extends('admin.layouts.app') @section('content')
<div class="container-fluid">
    @include('admin.message')
    <div class="lang-content-box">
      <form action="{{route('report.admin.bookingByAdmin',['id'=>$enquiry->id])}}" method="post">
        @csrf
        <input type="hidden" name="term" value="on">
        <div class="row">
            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-body">
                      <div class="form-section">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label >{{__("First Name")}} <span class="required">*</span></label>
                                      <input type="text" placeholder="{{__("First Name")}}" class="form-control" value="{{$user->first_name ?? ''}}" name="first_name" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label >{{__("Last Name")}} <span class="required">*</span></label>
                                      <input type="text" placeholder="{{__("Last Name")}}" class="form-control" value="{{$user->last_name ?? ''}}" name="last_name" required>
                                  </div>
                              </div>
                              <div class="col-md-6 field-email">
                                  <div class="form-group">
                                      <label >{{__("Email")}} <span class="required">*</span></label>
                                      <input type="email" placeholder="{{__("email@domain.com")}}" class="form-control" value="{{$user->email ?? ''}}" name="email" readonly>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label >{{__("Phone")}} <span class="required">*</span></label>
                                      <input type="email" placeholder="{{__("Your Phone")}}" class="form-control" value="{{$user->phone ?? ''}}" name="phone" readonly>
                                  </div>
                              </div>
                              <div class="col-md-6 field-address-line-1">
                                  <div class="form-group">
                                      <label >{{__("Address line 1")}} </label>
                                      <input type="text" placeholder="{{__("Address line 1")}}" class="form-control" value="{{$user->address ?? ''}}" name="address_line_1">
                                  </div>
                              </div>
                              <div class="col-md-6 field-address-line-2">
                                  <div class="form-group">
                                      <label >{{__("Address line 2")}} </label>
                                      <input type="text" placeholder="{{__("Address line 2")}}" class="form-control" value="{{$user->address2 ?? ''}}" name="address_line_2">
                                  </div>
                              </div>
                              <div class="col-md-6 field-city">
                                  <div class="form-group">
                                      <label >{{__("City")}} </label>
                                      <input type="text" class="form-control" value="{{$user->city ?? ''}}" name="city" placeholder="{{__("Your City")}}">
                                  </div>
                              </div>
                              <div class="col-md-6 field-state">
                                  <div class="form-group">
                                      <label >{{__("State/Province/Region")}} </label>
                                      <input type="text" class="form-control" value="{{$user->state ?? ''}}" name="state" placeholder="{{__("State/Province/Region")}}">
                                  </div>
                              </div>
                              <div class="col-md-6 field-zip-code">
                                  <div class="form-group">
                                      <label >{{__("ZIP code/Postal code")}} </label>
                                      <input type="text" class="form-control" value="{{$user->zip_code ?? ''}}" name="zip_code" placeholder="{{__("ZIP code/Postal code")}}">
                                  </div>
                              </div>
                              <div class="col-md-6 field-country">
                                  <div class="form-group">
                                      <label >{{__("Country")}} <span class="required">*</span> </label>
                                      <select name="country" class="form-control" required>
                                          <option value="">{{__('-- Select --')}}</option>
                                          @foreach(get_country_lists() as $id=>$name)
                                              <option @if(($user->country ?? '') == $id) selected @endif value="{{$id}}">{{$name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-12">
                                  <label >{{__("Special Requirements")}} </label>
                                  <textarea name="customer_notes" cols="30" rows="6" class="form-control" placeholder="{{__('Special Requirements')}}"></textarea>
                              </div>
                              <div class="col-md-6 field-state">
                                  <div class="form-group">
                                      <label >{{__("GSTIN")}} </label>
                                      <input type="text" class="form-control" value="{{$user->gstn ?? ''}}" name="gstn" placeholder="{{__("GSTIN")}}">
                                  </div>
                              </div>
                              <div class="col-md-6 field-zip-code">
                                  <div class="form-group">
                                      <label >{{__("GST Holder Name")}} </label>
                                      <input type="text" class="form-control" value="{{$user->gst_holder_name ?? ''}}" name="gst_holder_name" placeholder="{{__("GST Holder Name")}}">
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-title">
                        <strong>Booking</strong>
                    </div>
                    <div class="panel-body">
                        <button class="btn btn-primary" type="submit">{{__('Book Now')}}</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
