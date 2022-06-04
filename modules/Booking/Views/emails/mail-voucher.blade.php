<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <title></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!--<![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>
            .b-email-wrap {
                background: #ebeef2;
                padding: 40px 0px;
                color: #1a2b48;
                font-size: 14px;
                font-family: "Poppins", sans-serif !important;
                font-weight: normal;
                line-height: 1.5;
                overflow-x: hidden;
                margin: 0px;
            }
            .b-header {
                background: #0751c9;
                padding: 30px;
                color: white;
            }
            .b-header .site-title,
            .b-header h1,
            .b-header h2,
            .b-header h3,
            .b-header h4,
            .b-header h5,
            .b-header p {
                margin: 0px;
                display: block;
                text-align: center;
            }
            .b-container {
                max-width: 600px;
                margin: 0px auto;
            }

            .b-panel {
                border: 1px solid rgba(0, 0, 0, 0.1);
                margin-bottom: 30px;
                padding: 30px;
                background: white;
            }
            .b-panel .b-panel {
                padding: 0px;
                box-shadow: none;
            }
            .b-panel-title {
                text-align: center;
                margin-bottom: 30px;
                font-size: 24px;
                font-weight: 600;
            }
            .b-table-wrap {
                overflow-x: auto;
            }
            .b-table {
                width: 100%;
            }
            .b-table tr td,
            .b-table .b-tr,
            .b-table tr th {
                padding: 10px;
            }
            .b-table .b-tr {
                clear: both;
                border-bottom: 1px solid #eaeef3;
            }
            .b-table .b-tr:after {
                display: table;
                clear: both;
                content: "";
            }
            .b-table tr td {
                border-bottom: 1px solid #eaeef3;
            }
            .b-table tbody tr:nth-child(even) td {
                /*background: #f5f7fd;*/
            }
            .b-table tbody tr td.label,
            .b-table .b-tr .label {
                font-weight: 600;
            }
            .b-table tbody tr td.val,
            .b-table .b-tr .val {
                text-align: right;
            }

            .b-table .b-tr .label,
            .b-table .b-tr .val {
                float: left;
                width: 50%;
            }
            .pricing-list {
                text-align: left;
                margin: 0px;
                padding: 0px;
                list-style: none;
            }
            .pricing-list td {
                padding: 7px 0px;
            }
            .pricing-list td .val {
                text-align: right;
            }
            .pricing-list .no-flex {
                display: block;
            }
            .email-headline {
                margin-top: 0px;
            }

            .text-center {
                text-align: center;
            }

            .btn {
                display: inline-block;
                color: #212529;
                text-align: center;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-color: #ebeef2;
                line-height: 1.5;
                border: none;
                -webkit-box-shadow: none;
                box-shadow: none;
                border-radius: 3px;
                padding: 7px 20px;
                -webkit-transition: background 0.2s, color 0.2s;
                transition: background 0.2s, color 0.2s;
                font-size: 14px;
                font-weight: 500;
                text-decoration: none;
            }
            .btn.btn-primary {
                background: #5191fa;
                color: white;
            }
            .mt20 {
                margin-top: 20px;
            }
            .no-padding {
                padding: 0px;
            }
            .no-r-padding {
                padding-right: 0px !important;
            }
            .fsz21 {
                font-size: 21px;
            }
            .no-b-border {
                border-bottom: 0px !important;
            }
            @media screen and (max-width: 768px) {
                .b-panel {
                    padding: 15px;
                }
                .b-table tr td,
                .b-table tr th {
                    padding-right: 2px;
                    padding-left: 2px;
                }
                .b-panel-title {
                    font-size: 18px;
                    font-weight: bold;
                    margin-bottom: 15px;
                }
                .b-email-wrap {
                    padding: 0px;
                }

                .b-table .b-tr .label,
                .b-table .b-tr .val {
                    float: none;
                }

                .b-table .b-tr .val {
                    text-align: left;
                }
            }
        </style>
    </head>
    <body>
        <?php $hotelDDetail = getHotelById($row->term_id); ?>
        <div class="b-email-wrap">
            <div class="" style="">
                <div class="b-container">
                    <div class="b-header">
                        <h1 class="site-title">{{$row->voucher_type==3 ? $hotelDDetail->title : $row->term->name}}</h1>
                    </div>
                </div>
            </div>

            <div class="b-container">
                <div class="b-panel">
                    <h3 class="email-headline"><strong>Hello</strong></h3>
                    <p>Kindly send me confirmation of  below details:</p>

                    <div class="b-panel-title">Booking information</div>
                    <div class="b-table-wrap">
                        <table class="b-table" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="label">Booking Number</td>
                                <td class="val">#{{$row->booking_id}}</td>
                            </tr>
                            <tr>
                                <td class="label">Lead Person Name</td>
                                <td class="val">@if(!empty($row->name)) {{$row->name}} @else {{$booking->first_name.' '.$booking->last_name}} @endif</td>
                            </tr>
                            <tr>
                                <td class="label">No. of Person</td>
                                <td class="val">
                                    @php $person_types = $booking->getJsonMeta('person_types') @endphp
                                      @if(!empty($person_types))
                                        @foreach($person_types as $idx => $type)
                                          <p> <strong>{{$type['name']}} : {{$type['number']}}  x Participant</strong></p>
                                          @endforeach
                                      @else
                                          <p> <strong>Guests : {{$booking->total_guests}}  x Participant</strong></p>
                                      @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Package</td>
                                <td class="val">{{$row->package_details}}</td>
                            </tr>
                            <tr>
                                <td class="label">Date</td>
                                <td class="val">{{$row->date}}</td>
                            </tr>
                            
                              @if($row->voucher_type==3 && !empty($row->hotel))
                            <tr>
                                <td class="label">Check In</td>
                                <td class="val">{{$row->hotel ? $row->hotel['check_in'] : ''}}</td>
                            </tr>
                            <tr>
                                <td class="label">Check Out</td>
                                <td class="val">{{$row->hotel ? $row->hotel['check_out'] : ''}}</td>
                            </tr>
                            <tr>
                                <td class="label">Room Type</td>
                                <td class="val">{{$row->hotel ? $row->hotel['room_type'] : ''}}</td>
                            </tr>
                            <tr>
                                <td class="label">No. Of Room</td>
                                <td class="val">{{$row->hotel ? $row->hotel['no_of_room'] : ''}}</td>
                            </tr>
                            <tr>
                                <td class="label">Remark</td>
                                <td class="val">{{$row->remark}}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
