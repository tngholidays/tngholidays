<style type="text/css">
    /* Styles go here */

    .page {
        page-break-after: always;
    }
    .pageBreak {
        page-break-before: always !important;
        page-break-inside: avoid !important;
        page-break-after: always !important;
        clear: both;
    }
    .mainStyle {
        max-width:890px;
        display: table;
        margin: 0px auto;
        padding: 25px;
        border: 1px solid #ccc;
        box-shadow: 0px 2px 4px 0px #eee;
        background: #fff;
    }
    body {
        background: #f1f1f1;
    }
    .page-header {
        padding-bottom: 10px;
    }
    @page {
        margin: 2mm 15mm;
    }
    @media print {
        thead {
            display: table-header-group;
        }
        tfoot {
            display: table-footer-group;
        }
        button {
            display: none;
        }
        body {
            margin: 0;
        }
        .page-header,
        .page-header-space {
            height: 100px;
        }
        /*.page-footer, .page-footer-space {height:240px;}*/
        /*.page-footer {position:fixed;bottom:10px;width: 100%;}*/
        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
        }
        body {
            background: transparent;
        }
        .mainStyle {
            max-width: 100%;
            display: inherit;
            margin: inherit;
            padding: 0px;
            border: 0px solid #ccc;
            box-shadow: 0px 0px 0px 0px #eee;
            background: transparent;
        }
        .page-header {
            padding-bottom: 0px;
        }
    }
    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }
    }

</style>
<link href="{{ asset('libs/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<script>
        window.print();
    </script>
<!DOCTYPE html>
<html>
    <head> </head>

    <body style="font-family: 'Open Sans', sans-serif !important;">
        <div class="mainStyle">
            <div class="page-header" style="text-align: center;">
                <table style="width: 100%;" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="6" style="padding-top: 10px;">
                                <table style="width: 100%;" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th>
                                            <table style="width: 100%;" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 160px;">
                                                            <img width="100" src="{{ asset('uploads/SkyredLogo.png') }}" />
                                                        </td>
                                                        <td style="width: 20px; border-left: 1px solid #000;"></td>
                                                        <td style="font-size: 12px; color: #333;">
                                                            77/7 Moo 9 Soi Chalemprakiat , <br />
                                                            Nongrue A. Banglamung, Chonburi Pattaya 20150<br />
                                                            <span style="color: red;">Mobile No : </span> +66-924600943 | +66-97-4600943<br />
                                                            TAT License#: 13/02812
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </th>
                                        <th style="text-align: right;">
                                            @if( !empty($logo = setting_item('logo_invoice_id') ?? setting_item('logo_id') )) <img style="max-width: 140px;" src="{{get_file_url( $logo ,"full")}}" alt="{{setting_item("site_title")}}"> @endif
                                        </th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!--<div class="page-footer">
    I'm The Footer
  </div>-->

            <table style="width: 100%;" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="6">
                            <!--place holder for the fixed-position header-->
                            <div class="page-header-space"></div>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="background: #aedad5; color: #333; font-size: 14px; padding: 10px 15px 10px 15px;" colspan="6">Booking Confirmation</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <table style="width: 100%;" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="padding: 10px 0px 10px 0px;">
                                            <table style="width: 100%;" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 0px 0px 15px 15px;">
                                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">Lead Person Name</p>
                                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">@if(!empty($ManageItinerary->name)) {{$ManageItinerary->name}} @else {{$booking->first_name.' '.$booking->last_name}} @endif</h2>
                                                        </td>
                                                        <td style="padding: 0px 0px 15px;">
                                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">Booking No.</p>
                                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">#{{$booking->id}}</h2>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0px 0px 15px 15px;">
                                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">Quantity</p>
                                                            @php $person_types = $booking->getJsonMeta('person_types') @endphp
                                                         @if(!empty($person_types))
                                                            @foreach($person_types as $idx => $type)
                                                              <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">
                                                                  {{$type['name']}} : {{$type['number']}}  x Participant
                                                              </h2>
                                                              @endforeach
                                                          @else
                                                              <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">
                                                                  Guests : {{$booking->total_guests}}  x Participant
                                                              </h2>
                                                          @endif
                                                        </td>
                                                        <td style="padding: 0px 0px 15px;">
                                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">Date</p>
                                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">{{date('d M Y', strtotime($booking->start_date))}}</h2>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0px 0px 15px 15px;">
                                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">Pickup Time and Airport</p>
                                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">{{$ManageItinerary->meeting_point}}</h2>
                                                        </td>
                                                        <td style="padding: 0px 0px 15px;">
                                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">Agent Name</p>
                                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">{{$ManageItinerary->agent_name}}</h2>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="text-align: center; padding: 10px 0px 10px 0px; width: 180px;">
                                            <img width="130" src="{{get_file_url($service->image_id)}}" />
                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 5px; margin: 0px; color: #999;">Voucher No.</p>
                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">{{$ManageItinerary->voucher}}</h2>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #aedad5; color: #333; font-size: 14px; padding: 10px 15px 10px 15px;" colspan="6">Package Details</td>
                    </tr>

                    <tr>
                        <td colspan="6">
                            <table style="width: 100%;" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="padding: 10px 0px 10px 15px; border-bottom: 1px solid #ccc; width: 42%;">
                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">Package Name</p>
                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">{{$service->title}}</h2>
                                        </td>
                                        <td style="width: 6%;"></td>
                                        <td style="padding: 10px 0px 10px 0px; border-bottom: 1px solid #ccc; width: 42%;"></td>
                                    </tr>
<!--                                     <tr>
                                        <td style="padding: 10px 0px 10px 20px; border-bottom: 1px solid #ccc; width: 42%;">
                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">City Cover</p>
                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">{{$service->address}}</h2>
                                        </td>
                                        <td style="width:6%;"></td>
                                        <td style="padding: 10px 0px 10px 0px; border-bottom: 1px solid #ccc; width: 42%;">
                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">Duratiion</p>
                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">{{duration_format($service->duration,true)}}</h2>
                                        </td>
                                    </tr> -->
                                    @php
                                        $attributes = \Modules\Core\Models\Terms::getTermsById(json_decode($booking->tour_attributes));
                                        $ii = 0;
                                    @endphp
                                @if(!empty($booking->tour_attributes) and !empty($attributes))
                                    @foreach($attributes as $attribute )
                                    @php $translate_attribute = $attribute['parent']->translateOrOrigin(app()->getLocale()) @endphp
                                    @if(empty($attribute['parent']['hide_in_single']) && strpos($attribute['parent']->slug, 'restaurant') === false)


                                    @if(($ii % 2) == 0) <tr> @endif
                                        <td style="padding: 10px 0px 10px @if(($ii % 2) != 0) 0px @else 15px @endif; border-bottom: 1px solid #ccc; vertical-align: top;">
                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">{{ $translate_attribute->name }}</p>
                                        @php $terms = $attribute['child'] @endphp
                                         @foreach($terms as $term )
                                            @php $translate_term = $term->translateOrOrigin(app()->getLocale()) @endphp
                                            <h2 style="width:100%;font-size:16px;padding:0px 0px 0px 13px;margin:0px;color:#333;position:relative;">
                                                @if(strpos($attribute['parent']->slug, 'duration') === false)
                                                <i class="fa fa-circle" style="font-size:8px;left:0px;top:0px;position:absolute;color:#000;bottom:0px;margin:auto;height: 8px;"></i>
                                                @endif

                                                {{$translate_term->name}}</h2>
                                        @endforeach
                                    </td>
                                    @if(($ii % 2) == 0)<td style="width: 50px;"></td>@endif
                                    @if(($ii % 2) != 0) </tr> @endif
                                    <?php $ii++; ?>
                                    @endif

                                    @endforeach
                                @endif

                                @php
                                    $extra_prices = $booking->getJsonMeta('extra_price');
                                @endphp
                                @if(count($extra_prices) > 0 and !empty($extra_prices))
                                     @if(($ii % 2) == 0) <tr> @endif
                                        <td style="padding: 10px 0px 10px @if(($ii % 2) != 0) 0px @else 15px @endif; border-bottom: 1px solid #ccc; vertical-align: top;">
                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">Extra Prices</p>
                                         @foreach($extra_prices as $extra_price)
                                            <h2 style="width:100%;font-size:16px;padding:0px 0px 0px 13px;margin:0px;color:#333;position:relative;">
                                                <i class="fa fa-circle" style="font-size:8px;left:0px;top:0px;position:absolute;color:#000;bottom:0px;margin:auto;height: 8px;"></i>{{$extra_price['name']}}</h2>
                                        @endforeach
                                    </td>
                                    @if(($ii % 2) == 0)<td style="width: 50px;"></td>@endif
                                    @if(($ii % 2) != 0) </tr> @endif
                                @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr style="page-break-before: always;page-break-inside: avoid;page-break-after: always;clear: both;">
                        <td style="padding-top: 60px;" colspan="6"></td>
                    </tr>
                    <tr>
                        <td style="background: #aedad5; color: #333; font-size: 14px; padding: 10px 15px 10px 15px;" colspan="6">Hotel Confirmation</td>
                    </tr>

                @if(count($ManageItinerary->hotels) > 0)
                @foreach ($ManageItinerary->hotels as $indx => $hotel)
                <?php $hotelDDetail = getHotelById($hotel['hotel']); ?>
                    <tr>
                        <td colspan="6" style="border-bottom: 1px solid #ccc; padding: 10px 0px 10px 15px;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width: 180px; padding: 0px 10px; vertical-align: top;">
                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #999;">{{@getLocationById($hotel['location_id'])->name}} Hotel</p>
                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;">{{$hotelDDetail->title}}</h2>
                                            <span style="width: 100%; font-size: 12px; color: #333;">
                                                {{$hotelDDetail->address}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: top;">
                                            <table style="width: 100%;" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-size:14px; color:#999; width: 130px; vertical-align: top;">Check-in</td>
                                                        <td style="text-align:center;width:15px; vertical-align: top;">:</td>
                                                        <td style="font-size:16px;color:#333;width:190px; vertical-align: top;">{{$hotel['check_in']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 14px; color: #999; width: 130px; vertical-align: top;">Check-out</td>
                                                        <td style="text-align: center;width: 15px; vertical-align: top;">:</td>
                                                        <td style="font-size: 16px; color: #333; width: 190px; vertical-align: top;">{{$hotel['check_out']}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="font-size:14px;color:#999;width:130px; vertical-align: top;">Room Type</td>
                                                        <td style="text-align:center;width:15px; vertical-align: top;">:</td>
                                                        <td style="font-size:16px;color:#333;width:190px; vertical-align: top;">{{@getRoomsById($hotel['room'])->title}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:14px;color:#999;width:130px; vertical-align: top;">No. of Room</td>
                                                        <td style="text-align:center;width:15px; vertical-align: top;">:</td>
                                                        <td style="font-size:16px;color:#333;width:190px; vertical-align: top;">
                                                        {{isset($hotel['no_of_room']) ? $hotel['no_of_room'] : ''}}

                                                    </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:14px;color:#999;width:130px; vertical-align: top;">Confirmation No</td>
                                                        <td style="text-align:center;width:15px; vertical-align: top;">:</td>
                                                        <td style="font-size:16px;color:#333;width:190px; vertical-align: top;">{{$hotel['conf_no']}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width: 180px; text-align:center;">
                                            <img width="130" style="width: 120px; height: 120px;object-fit: cover;" src="{{get_file_url($hotelDDetail->image_id)}}" />
                                            <div class="rating-star" style="padding-top: 8px;">
                                              @if($hotelDDetail->star_rate)
                                                  <div class="star-rate">
                                                      @for ($star = 1 ;$star <= $hotelDDetail->star_rate ; $star++)
                                                          <i class="fa fa-star" style="color: #ff6a00;"></i>
                                                      @endfor
                                                  </div>
                                              @endif
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
                @endif
                @if(isset($tour->meta->flight) and count($tour->meta->flight) > 0 )
                <tr>
                    <td colspan="6">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="background: #aedad5; color: #333; font-size: 14px; padding: 10px 15px 10px 15px;" colspan="6">Flight Details</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                 @foreach($tour->meta->flight as $fkey => $flight )
                 <?php
                    $flight['departure_time'] = str_replace("/", "-", $flight['departure_time']);
                    $flight['arrival_time'] = str_replace("/", "-", $flight['arrival_time']);
                 ?>
                <tr>
                    <td colspan="6">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="font-size: 16px; color: #0697cd; text-transform: uppercase; padding: 25px 0px 10px 15px;" colspan="6">
                                    <?php
                                        $days = 1;
                                        if($fkey > 0){
                                            $pkey = $fkey - 1;
                                            $pdate = $tour->meta->flight[$pkey]['departure_time'];
                                            $days = getDaysDiff(date('Y-m-d', strtotime($pdate)), date('Y-m-d', strtotime($flight['departure_time'])));
                                        }
                                    ?>
                                    
                                    {{ date('d M, Y', strtotime($flight['departure_time']))}}
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <?php
                        $airline = getAirlines($flight['flight_id']);
                         $airIMG = "";
                          if (!empty($airline->image_id)) {
                          $airIMG = URL::asset('public/uploads').'/'.getImageUrlById($airline->image_id);
                          
                         }
                    ?>
                    <td style="background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 15px 0px 15px 15px; width: 110px;"><img src="{{ $airIMG }}" width="70" /></td>
                    <td style="background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 15px 0px 15px; width: 100px;">{{isset($flight['flight_no']) ? $flight['flight_no'] : ''}}</td>
                    <td style="background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 15px 0px 15px; width: 150px;">
                        <table cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="vertical-align: top; padding-right: 4px;"><img width="15" src="{{ URL::asset('public/uploads/flight-icon-1.png') }}" /></td>
                                    <td sty>
                                        <span>
                                            {{ date('h:i A', strtotime($flight['departure_time']))}}<br />
                                            {{ date('D d M, Y', strtotime($flight['departure_time']))}}<br />
                                            {{@getAirports($flight['from_airport'])->name}}<br />
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td colspan="2" style="background: #f7f7f7; border-bottom: 3px solid #f2f2f2; text-align: center; padding: 15px 0px 15px; width: 170px;">
                        {{getTimeDiff(date('Y-m-d h:i:s A', strtotime($flight['departure_time'])), date('Y-m-d h:i:s A', strtotime($flight['arrival_time'])))}}
                        <hr style="width: 100px;">
                        <span style="font-size:12px;">{{$flight['note']}}</span><br>
                    </td>
                    <td style="background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 15px 0px 15px; width: 150px;">
                        <table cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="vertical-align: top; padding-right: 4px;"><img width="15" src="{{ URL::asset('public/uploads/flight-icon-1.png') }}" /></td>
                                    <td>
                                        <span>
                                           {{ date('h:i A', strtotime($flight['arrival_time']))}}<br />
                                                        {{ date('D d M, Y', strtotime($flight['arrival_time']))}}<br />
                                                        {{@getAirports($flight['to_airport'])->name}}<br />
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="font-size: 14px; color: #0697cd; text-transform: uppercase; padding: 5px 0px 15px 15px; border-bottom: 2px solid #ccc;" colspan="6"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                @endforeach
                @endif
                @if(!empty($booking->tour_summary) > 0)
                <?php 
                    $tour_summary =  json_decode($booking->tour_summary, true);
                    
                ?>
                @foreach ($tour_summary as $sumIndex => $summary)
                <?php
                    $rowspan = 1;
                    if (!empty($summary['transfer'])) {
                         $rowspan += count($summary['transfer']);
                    }
                    if (!empty($summary['hotel'])) {
                        $rowspan += 1;
                    }
                    if (!empty($summary['morning_activity'])) {
                        $rowspan += count($summary['morning_activity']);
                    }
                    if (!empty($summary['activity'])) {
                        $rowspan += count($summary['activity']);
                    }
                    if (!empty($summary['evening_activity'])) {
                        $rowspan += count($summary['evening_activity']);
                    }
                    $summary['breakfast'] = false;
                    $summary['dinner'] = false;
                    if ($sumIndex > 0) {
                        $summary['breakfast'] = true;
                        $rowspan += 1;
                    }
                    $dayDate = str_replace('/', '-', $summary['date']);
                    $dayDate = date('d M Y', strtotime($dayDate)) ;



                    // if ($sumIndex < count($tour_summary)) {
                    //     $summary['dinner'] = true;
                    //     $rowspan += 1;
                    // }
                    // dd($rowspan);
                    
                ?>
            @if(!empty($summary['hotel']))
                <tr>
                    <td style="text-align: left; border: 1px solid #f1f1f1; background: #aedad5; font-size: 19px; padding: 8px 10px;"><img src="{{ URL::asset('uploads/location-icon.png') }}" style="width: 22px; float: left; margin: -4px 7px 0px 0px;" /><strong>{{$summary['location']}} </strong></td>
                    <td style="text-align: left; border: 1px solid #f1f1f1; background: #aedad5; font-size: 19px; padding: 8px 10px;"><b>Time</b></td>
                    <td colspan="4" style="text-align: left; border: 1px solid #f1f1f1; background: #aedad5; font-size: 19px; padding: 8px 10px;"></td>
                </tr>
            @endif
             <tr>
                <td rowspan="{{$rowspan}}" style="text-align: left; vertical-align: top; border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; background: #f8f8f8; width: 144px;"><b> {{$dayDate}}, {{$summary['day']}}</b></td>
                <td></td>
                <td colspan="3"></td>
             </tr>
              @if($sumIndex != 0)
            <tr>
                <td style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;">8.00AM</td>
                <td style="text-align: left; border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; width: 30px; border-right: 0px;"><img src="{{ URL::asset('uploads/food-icon.png') }}" style="width: 22px;" /></td>
                <td colspan="3" style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;">Breakfast at Hotel Restaurant</td>
            </tr>
            @endif
            @if(!empty($summary['transfer']))
            @foreach ($summary['transfer'] as $indx => $transfer)
            <?php 
                $key = array_search($transfer['id'], array_column($ManageItinerary->itinerary, 'id'));
                $time = null;
                if (isset($ManageItinerary->itinerary[$key])) {
                    $time = $ManageItinerary->itinerary[$key]['time'];
                }
            ?>
                <tr>
                    <td style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;">{{$time}}</td>
                    <td style="text-align: left; border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; width: 30px; border-right: 0px;"><img src="{{ URL::asset('uploads/car.png') }}" style="width: 22px;" /></td>
                    <td colspan="3" style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;"> {{$transfer['name']}}</td>
                </tr>
            @endforeach
            @endif
            @if(!empty($summary['hotel']))
                <tr>
                    <td style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;">2.00PM</td>
                    <td style="text-align: left; border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; width: 30px; border-right: 0px;"><img src="{{ URL::asset('uploads/home-icon.png') }}" style="width: 22px;" /></td>
                    <td colspan="3" style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;">Check in to {{$summary['hotel']['hotel_name']}}</td>
                </tr>
            @endif
           
            @if(!empty($summary['morning_activity']))
            @foreach ($summary['morning_activity'] as $indx => $activity)
            <?php 
                $key = array_search($activity['id'], array_column($ManageItinerary->itinerary, 'id'));
                $time = null;
                if (isset($ManageItinerary->itinerary[$key])) {
                    $time = $ManageItinerary->itinerary[$key]['time'];
                }
            ?>
                <tr>
                    <td style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;">{{$time}}</td>
                    <td style="text-align: left; border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; width: 30px; border-right: 0px;"><img src="{{ URL::asset('uploads/book-icon.png') }}" style="width: 22px;" /></td>
                    <td colspan="3" style="border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; border-left: 0px;">{{$activity['name']}}</td>
                </tr>
            @endforeach
            @endif
            @if(!empty($summary['activity']))
            @foreach ($summary['activity'] as $indx => $activity)
            <?php 
                $key = array_search($activity['id'], array_column($ManageItinerary->itinerary, 'id'));
                $time = null;
                if (isset($ManageItinerary->itinerary[$key])) {
                    $time = $ManageItinerary->itinerary[$key]['time'];
                }
            ?>
                <tr>
                    <td style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;">{{$time}}</td>
                    <td style="text-align: left; border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; width: 30px; border-right: 0px;"><img src="{{ URL::asset('uploads/book-icon.png') }}" style="width: 22px;" /></td>
                    <td colspan="3" style="border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; border-left: 0px;">{{$activity['name']}}</td>
                </tr>
            @endforeach
            @endif
            @if(!empty($summary['evening_activity']))
            @foreach ($summary['evening_activity'] as $indx => $activity)
            <?php 
                $key = array_search($activity['id'], array_column($ManageItinerary->itinerary, 'id'));
                $time = null;
                if (isset($ManageItinerary->itinerary[$key])) {
                    $time = $ManageItinerary->itinerary[$key]['time'];
                }
            ?>
                <tr>
                    <td style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;">{{$time}}</td>
                    <td style="text-align: left; border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; width: 30px; border-right: 0px;"><img src="{{ URL::asset('uploads/book-icon.png') }}" style="width: 22px;" /></td>
                    <td colspan="3" style="border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; border-left: 0px;">{{$activity['name']}}</td>
                </tr>
            @endforeach

            <?php /*
            @if($sumIndex != 0)
            <tr>
                <td style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;"></td>
                <td style="text-align: left; border: 1px solid #f1f1f1; font-size: 14px; padding: 8px 10px; width: 30px; border-right: 0px;"><img src="{{ URL::asset('uploads/food-icon.png') }}" style="width: 22px;" /></td>
                <td colspan="3" style="border: 1px solid #f1f1f1; font-size: 14px; padding: 5px 8px; border-left: 0px;">Dinner at Nearest Restaurant (No Transfer)</td>
            </tr>
            @endif
            */ ?>
            @endif
                @endforeach
                @endif
                <tr>
                    <td colspan="6" style="padding: 10px 0px 10px 0px;"></td>
                </tr>
                <?php /*
                <tr>
                    <td style="background: #aedad5; color: #333; font-size: 14px; padding: 10px 15px 10px 15px;" colspan="6">Day Wise Itinerary</td>
                </tr>
					
                @if(count($ManageItinerary->itinerary) > 0)
                @foreach ($ManageItinerary->itinerary as $indx => $itinerary)
                    <tr>
                        <td colspan="6" style="border-bottom: 1px solid #ccc; padding: 10px 0px 10px 15px;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width: 380px;">
                                            <p style="width: 100%; font-size: 14px; padding: 0px 0px 6px; margin: 0px; color: #3b41ff;">Date : {{$itinerary['date']}}</p>
                                            <h2 style="width: 100%; font-size: 16px; padding: 0px; margin: 0px; color: #333;"> {{$itinerary['desc']}}</h2>
                                        </td>
                                        <td>
                                            <p>{{$itinerary['time']}}</p>
                                        </td>
                                        <td style="width:180px; text-align:center;"><img width="130" style="width: 120px; height: 115px;object-fit: cover;" src="{{get_file_url($itinerary['image_id'])}}" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
                
                @endif */ ?>
                    <tr>
                        <td style="background: #aedad5; color: #333; font-size: 14px; padding: 10px 15px 10px 15px;" colspan="6">Customer Details</td>
                    </tr>
                    <tr>
                        <td style="padding-top: 10px;" colspan="6"></td>
                    </tr>
                    <tr>
                        <th style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc; text-align: left;">S.No</th>
                        <th style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc; text-align: left;"></th>
                        <th style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc; text-align: left;">First Name</th>
                        <th style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc; text-align: left;">Surname</th>
                        <th style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc; text-align: left;">DOB DD/MM/YY</th>
                        <th style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc; text-align: left;">Passport No.</th>
                    </tr>
                @if(count($ManageItinerary->guests) > 0)
                @foreach ($ManageItinerary->guests as $indx => $guest)
                    <tr>
                        <td style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc;">{{$indx+1}}.</td>
                        <td style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc;">{{$guest['name_prefix']}}</td>
                        <td style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc;">{{$guest['first_name']}}</td>
                        <td style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc;">{{$guest['surname']}}</td>
                        <td style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc;">{{date('d/m/Y', strtotime($guest['dob']))}}</td>
                        <td style="padding: 8px 10px 8px 10px; font-size: 16px; border: 1px solid #ccc;">{{$guest['passport_no']}}</td>
                    </tr>
                @endforeach
                @endif
                <tr>
                    <td colspan="6" style="padding:10px 0px 10px; font-size: 14px;"> <strong style="color:red;">Remark : </strong>{{$ManageItinerary->remark}} </td>
                </tr>
                <tr>
                    <td colspan="6" style="padding-top: 40px;">
                        <table class="page-footer22" style="color: red; font-size: 14px; clear: both; padding:0% 0px 10px;">
    <tbody>
        <tr>
            <td>
                <p style=" margin: 0px; text-align: right;"><img width="180" src="{{ asset('uploads/sign_stamp.png') }}" /></p>
                </td>
                </tr>
                <tr>
            <td>
               <h2 style="color: #000; font-size: 16px;">Note</h2>
                </td>
                </tr>

                <tr>
            <td>
              Standard Check in Time – 14:00 PM and Check Out Time – 12:00 PM (some hotels check in time is 15:00 PM)
                </td>
                </tr>

                <tr>
            <td>
               Hotel is entitled to collect refundable security deposit as per hotel policy.
                </td>
                </tr>

                <tr>
            <td>
               Double/Twin Bed reference is subject to availability.
                </td>
                </tr>

                <tr>
            <td>
               SIC Pick Up Time may vary by 30-45 minutes due to traffic but guest must wait as per time and location mentioned.
                </td>
                </tr>

                <tr>
            <td>
               Private Pick up will be ON TIME – If guest is late beyond 15 Minutes in given time, charges will be applicable which has to be paid directly by the customer to the driver. 
                </td>
                </tr>
               <tr>
            <td style="color: #000; text-align: center; font-size: 16px;">
              *** Thank You ***
                </td>
                </tr>
                <p style="color: #000; text-align: center; font-size: 16px;"></p>
            </tbody>
            </table>
                    </td>
                </tr>
                </tbody>

            </table>


        </div>
    </body>
</html>
