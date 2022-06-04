    <style type="text/css">

        .invoice-amount {
            margin-top: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 20px;
            display: inline-block;
            text-align: center;
        }
        .label { text-align: left;}
        .text-center { width: 100%; text-align: center;}
    
        #invoice-print-zone {
            background: white;
            padding: 15px;
            width: 100%;
            border-radius: 7px;
        }
        .invoice-company-info{
            margin-top: 15px;
        }
        .invoice-company-info p{
            margin-bottom: 2px;
            font-weight: normal;
        }
        .servive-name{
            font-size: 18px;
            font-weight: bold;
            color: #5191fa;

        }
        .service-location{

            font-style: italic;
        }
        .service-info{
            margin-bottom: 14px;
        }
        .ticket-body{

            border-top: dashed 1px #dfdfdf;
            padding-top: 20px;
        }
        .ticket-body td{
            padding-bottom: 20px;
            vertical-align: top;
        }
        .ticket-body .label{
            color: #868686;
            margin-bottom: 5px;
        }
        .ticket-body .val{
            font-weight: 600;
            font-size: 15px;
        }
        .ticket-footer{
            margin-top: 20px;
            border-top: dashed 1px #dfdfdf;
            padding-top: 20px;
        }
        @media(max-width: 400px){
            #invoice-print-zone{
                margin-left: 15px;
                margin-right: 15px;
            }
        }
                td.ticketTD {
    padding-bottom: 0px;
}
        /*---------------------------new css-------------------------*/

        .v_detail .info-block {
    padding: 24px 16px 32px;
    margin-bottom: 16px;
    border-radius: 5px;
    background-color: #fff;
}

.v_user_detail {
    font-size: 10px;
}

.s-title {
    font-size: 24px;
    color: rgba(0, 0, 0, 0.87);
    line-height: 1.3;
    margin-bottom: 24px;
}
.v_user_detail h1 {
    font-size: 2em;
    margin: 0;
    padding-top: 24px;
    padding-bottom: 8px;
    font-weight: 100;
}

.v_detail article ul li {
    list-style: initial;
    margin-left: 36px;
    margin-top: 8px;
    margin-bottom: 8px;
    font-size: 14px;
    line-height: 1.6;
}
@page {
    margin: 5mm 10mm 5mm 10mm; /* this affects the margin in the printer settings */
}
/*.section-div, .invoice-print-zone {
    border: 1px solid red;
}*/
    </style>
    <link href="{{ public_path('libs/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <div id="invoice-print-zone" class="container" style="width: 100%;">
        
        
        <div class="ticket-content" style="width: 100%;">
            <div class="ticket-header d-flex justify-content-between">
                <div class="print">
                    <img width="100" src="{{ public_path('uploads/SkyredLogo.png') }}" />
                </div>
                <div class="service-info">
                    <div class="service-location"><i class="fa fa-map-marker"></i> {{$booking->service->address ??''}}</div>
                    <div class="servive-name">{{$booking->service->title ?? ''}}</div>
                    

                </div>

            </div>
        <div class="row top-boarder">
          <div class="col-sm-8 right-boarder">
              <div class="ticket-body">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="50%"><div class="label"><i class="fa fa-calendar"></i> {{__("Date")}}</div>
                        <div class="val">{{display_date($booking->start_date)}}</div>
                        </td>
                        <!-- <td>
                            <div class="label"><i class="fa fa-money"></i> {{__("Price")}}</div>
                            <div class="val">{{format_money($booking->total)}}</div>
                        </td> -->
                        <td>
                            <div class="label">{{__("Package Name")}}</div>
                            <div class="val">{{$booking->service->title ?? ''}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td><div class="label"><i class="fa fa-user"></i> {{__("Lead Person Name")}}</div>
                            <div class="val">{{$booking->first_name}} {{$booking->last_name}}
                            </div>
                        </td>
                        <td>
                            <div class="label"># {{__("Booking ID")}}</div>
                            <div class="val"># {{$booking->id}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ticketTD"><div class="label"><i class="fa fa-ticket"></i> {{__("Ticket")}}</div>
                        <td class="ticketTD"><div class="label"><i class="fa fa-users"></i> {{__("Quantity")}}</div></td>
                    </tr>
                    @php $ticket_types = $booking->getJsonMeta('selected_tickets') @endphp
                    @if(count($ticket_types) > 0)
                    @foreach($ticket_types as $ticket_type)
                    <?php 
                            $timeslot =  getArrayByColumn($ticket_type['timeslots'], 'id', $ticket_type['timeslot_id']);
                         ?>
                    <tr>
                        <td>
                            <p> <i>{{$ticket_type['title']}}</i> </p>
                                <p> <i>{{$timeslot['time']}}</i> </p>
                        </td>
                        <td>
                        <div class="val">
                             @if(!empty($ticket_type['adult_ticket']))
                            <p>Adult x {{$ticket_type['adult_ticket']}}</p>
                            @endif
                            @if(!empty($ticket_type['child_ticket']))
                            <p>Child x {{$ticket_type['child_ticket']}}</p>
                            @endif
                        </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <td><div class="label"><i class="fa fa-hotel"></i> {{__("Hotel Pickup Name")}}</div>
                            <div class="val">{{$booking->hotel_name}}
                            </div>
                        </td>
                        <td><div class="label"><i class="fa fa-check"></i> {{__("Confirmation No.")}}</div>
                            <div class="val">{{$booking->getMeta('ticket_conf_no')}}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
          </div>
          <div class="col-sm-4">
              <div class="ticket-footer">
                    <div class="qr-content text-center">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($booking->id.'.'.\Illuminate\Support\Facades\Hash::make($booking->id))) !!} ">
                    </div>
                    <div class="text-center">{{__("Show QR Code at the counter")}}</div>

                </div>
          </div>
          
        </div>
        <?php 
            $getExtraContent = $booking->service->getExtraContentArray(); 
        ?>
        <div class="row" style="page-break-before: always;">
            <div class="col-md-12">
                <section class="v_detail bfc">
                    <article class="v_user_detail info-block" data-role="menu">
                        <header class="s-title border3">Package description</header>

                        @if(count($ticket_types) > 0)
                            @foreach($ticket_types as $ticket_type)
                            <?php $ticket = $booking->service->getTicketById($ticket_type['id']); ?>
                                @if(isset($ticket->content))
                                <div class="section-div">
                                    <div class="contentDiv">
                                        {!! $ticket->content !!}
                                    </div>
                                </div>
                                 @endif
                            @endforeach
                        @endif

                         @if(isset($getExtraContent['what_to_bring']))
                        <?php $what_to_bring = $getExtraContent['what_to_bring']; ?>
                        <div class="section-div">
                            <h1>{{ $what_to_bring['title'] }}:</h1>
                            <div class="contentDiv">
                                {!! $what_to_bring['content'] !!}
                            </div>
                        </div>
                         @endif

                        @if(isset($getExtraContent['how_to_use_ticket']))
                        <?php $how_to_use_ticket = $getExtraContent['how_to_use_ticket']; ?>
                        <div class="section-div">
                            <h1>{{ $how_to_use_ticket['title'] }}:</h1>
                            <div class="contentDiv">
                                {!! $how_to_use_ticket['content'] !!}
                            </div>
                        </div>
                         @endif
                         @if(isset($getExtraContent['remarks']))
                        <?php $remarks = $getExtraContent['remarks']; ?>
                        <div class="section-div">
                            <h1>{{ $remarks['title'] }}:</h1>
                            <div class="contentDiv">
                                {!! $remarks['content'] !!}
                            </div>
                        </div>
                         @endif

                         @if(isset($getExtraContent['pick_up_information']))
                        <?php $pick_up_information = $getExtraContent['pick_up_information']; ?>
                        <div class="section-div">
                            <h1>{{ $pick_up_information['title'] }}:</h1>
                            <div class="contentDiv">
                                {!! $pick_up_information['content'] !!}
                            </div>
                        </div>
                         @endif
                         @if(isset($getExtraContent['what_to_bring']))
                        <?php $what_to_bring = $getExtraContent['what_to_bring']; ?>
                        <div class="section-div">
                            <h1>{{ $what_to_bring['title'] }}:</h1>
                            <div class="contentDiv">
                                {!! $what_to_bring['content'] !!}
                            </div>
                        </div>
                         @endif
                    </article>

                  <!--   <article class="info-block" data-role="menu">
                        <header class="s-title border3">
                            CONTACT US
                        </header>
                        <section class="clear_last _table">
                            <div class="link-klook">
                                <div class="link-title">Klook</div>
                                <div>
                                    <p>Questions or concerns? Click the 'Ask Klook' button and get in touch with us.</p>
                                    <a class="btn_lg u_btn_main_border" href="/ask_klook/?ref_source=Voucher" target="_blank" data-track-event="Vouchers Page|Ask Klook Button Clicked">Ask Klook</a>
                                </div>
                            </div>

                            <div class="link-operator">
                                <div>+66-063 -1142423 (Tour 6:00am-6:00pm); +66-097-1176137 (Ticket 8:00am-10:00pm); +66-080-0656558 (Custom Tour 8:00am~8:00pm)</div>
                                <div>service@akgotour.com</div>
                            </div>
                        </section>
                    </article> -->
                </section>
            </div>

        </div>

        </div>
    </div>