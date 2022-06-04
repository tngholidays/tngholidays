<div class="modal fade" id="modal-paid-{{$booking->id}}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{__("Booking ID")}}: #{{$booking->id}}</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="booking-review">
                    <div class="booking-review-content">
                        <div class="review-section total-review">
                            <ul class="review-list">
                                <li class="final-total d-block border-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between">
                                                <div class="label">{{__("Ticket Hotel Name:")}}</div>
                                                <div class="val"><input class="form-control" type="text" id="set_hotel_name" name="hotel_name" placeholder="Ticket Hotel Name"  value="{{$booking->hotel_name}}"/></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <div class="d-flex justify-content-between">
                                                <div class="label">{{__("Ticket Confirmation No. ")}}</div>
                                                <div class="val"><input class="form-control" type="text" id="set_ticket_conf_no" name="ticket_conf_no" placeholder="Ticket Confirmation No."  value="{{$booking->getMeta('ticket_conf_no')}}"/></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <div class="label">{{__("Total:")}}</div>
                                        <div class="val">{{format_money($booking->total)}}</div>
                                    </div>
                                    @if($booking->status !='draft')
                                        <div class="d-flex justify-content-between">
                                            <div class="label">{{__("Paid:")}}</div>
                                            <div class="val">{{format_money($booking->paid)}}</div>
                                        </div>
                                        @if($booking->paid < $booking->total )
                                            <div class="d-flex justify-content-between">
                                                <div class="label">{{__("Remain:")}}</div>
                                                <div class="val">{{currency_symbol()}}<input class="text-right" type="number" min="0" max="{{$booking->total}}" id="set_paid_input" value="{{($booking->total - $booking->paid)}}" />
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <span class="btn btn btn-primary" id="set_paid_btn" data-id="{{$booking->id}}">{{__("Save")}}</span>
                <span class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</span>
            </div>
        </div>
    </div>
</div>
