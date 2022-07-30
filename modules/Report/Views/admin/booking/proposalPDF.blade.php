
<!--<style type="text/css">
/* Styles go here */

.page-header, .page-header-space {
  height:0px;
}
.page {
  page-break-after: always;
}
.pageBreak{
     page-break-before: always !important;
     page-break-inside: avoid !important;
     page-break-after: always !important; clear: both;}
@page {
	margin: 2mm 2mm 0mm 0mm; /* this affects the margin in the printer settings */
}
@media print {
   thead { display: table-header-group;}
   tfoot { display: table-footer-group; }
   button { display: none; }
   body { margin: 0; }
.page-header, .page-header-space {height:20px;}
.page-footer, .page-footer-space {height:60px;}
.page-footer {position:fixed;bottom:0px;width: 100%;}
.page-header {position: fixed;top: 0mm;width: 100%;}
body { background:transparent;}
.page-header { padding-bottom: 0px;}
}
@media print {
  body {-webkit-print-color-adjust: exact;}
}
</style>-->
<style media="screen">
@page {
	margin: 3mm 3mm 0mm 3mm; /* this affects the margin in the printer settings */
	tr {
      page-break-inside: always!important; 
    }
}
footer {
              position: fixed;
              bottom:50px;
          }
          .DaywiseItinerary td {
            border: 1px solid #ddd0;
          }
          /*.flightTable tr, td {*/
          /*    border: 1px solid black;*/
          /*}*/
					#watermark { position: fixed; width:100%; height:100%; margin-left: 180px; margin-right: 0px; margin-top: 190px; opacity: .3;-ms-transform: rotate(-20deg);transform: rotate(-20deg);
					}
					#watermark img { width:100%;}
</style>
<!DOCTYPE html>
<html>

<head>
<link href="{{ public_path('libs/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans', sans-serif !important;">
	<div id='watermark'><img src="{{ public_path('uploads/water_mark.png') }}" /></div>
  <table style="width:100%; page-break-after: always;" cellpadding="0" cellspacing="0">
<tbody>
  <tr>
    <td style="background: #81d5f4; text-align: center; padding: 20px 10px 20px;"><img width="150" src="{{ public_path('uploads/logo.png') }}" /></td>
  </tr>
  <tr>
    <td>
      <?php
      $mainImg = "";
     if (!empty($tour->image_id)) {
       $mainImg = public_path('uploads/').getImageUrlById($tour->image_id);
      }
      $persns = 0;
      if(!empty($row->person_types)){
          foreach($row->person_types as $key=>$person_type){
              if($person_type['number'] > 0){
                  $persns += $person_type['number'];
              }
          }
      }
      $flightPrice = 0;
      $flightss = null;
      if(isset($tour->meta->flight) and count($tour->meta->flight) > 0){
          $flightss = $tour->meta->flight;
          foreach($flightss as $key=>$flight){
              $flightPrice += $flight['price'];
          }
          
      }
      $flightPrice = ($flightPrice*$persns);

      $hotel_rooms = json_decode($booking->getMeta('hotel_rooms'), true); $persons = 0;
        $nurooms = 0;
        $nuadult = 0;
        $nuchild = 0;
        if($hotel_rooms > 0){
            foreach($hotel_rooms as $indx => $room){
                $nurooms++;
                $nuadult += $room['adults'];
                $nuchild += $room['children'];
                $persons += ($room['adults']+$room['children']);
            }
        }
        $tour_activities = $booking->allActivities();
        $totalTransfer = 0;
        $totalHotel = 0;
        $totalActivity = 0;
           $tour_activities = $booking->activities();

           foreach ($tour_activities as $key => $summary) {
            if (!empty($summary['transfer']) && count($summary['transfer']) > 0) {
                 $totalTransfer += count($summary['transfer']);

            }
            if (!empty($summary['morning_activity']) && count($summary['morning_activity']) > 0) {
                $totalActivity += count($summary['morning_activity']);

            }
            if (!empty($summary['hotel']) && count($summary['hotel']) > 0) {
                 $totalHotel += 1;

            }
            if (!empty($summary['activity']) && count($summary['activity']) > 0) {
                $totalActivity += count($summary['activity']);

            }

            if (!empty($summary['evening_activity']) && count($summary['evening_activity']) > 0) {
                $totalActivity += count($summary['evening_activity']);

            }
           }
     ?>
      <img style="width:100%; height: 700px;object-fit: cover;" src="{{$mainImg}}" />
    </td>
  </tr>
  <tr>
    <td>
      <table style="width:100%;background:#70b5ce; padding: 10px 20px; height:270px;" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
           <td colspan="2" style=" padding:0px 20px;"><h2 style="font-size: 26px; color:#fff; line-height: 32px;">{{@$tour->title}} <br><span style="color: #ffff26;">{{@$row->name}}</span></h2></td>
          </tr>
          <tr>
            <td style="color: #fff; line-height: 22px; font-size: 15px;padding:10px 0px 10px 20px;">
              {{@getTermById(@$row->duration)->name}} <br>INR {{@$row->total_tour_price}} Tour Budget/Cost
              @if($flightss) <br>INR {{$flightPrice}}/-* Tour Flight Charge (T&C Apply) @endif

              
              <br> <span style="font-size:12px;">(Extra 5% GST)</span> <br>
              {{$nuadult}} Adult and {{$nuchild}} Child 
              <br>
               Rooms {{$nurooms}} 
              <br>
             <b>Departure dates:</b> {{ date('d M, Y', strtotime($row->start_date))}}
            </td>
              <td style="font-size: 15px;">
                  <table style="width: 100%;color: #fff;" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <th colspan="2" style="text-align: left; padding: 0px 0px 10px;">INCLUSION</th>
                    </tr>
                    @php
                          $ii = 0;
                    @endphp
                    @if(!empty($attributes) and count($attributes[2]) > 0)
                        @if(count($attributes[2]['child']) > 0)
                          @foreach($attributes[2]['child'] as $term )
                          @if(($ii % 2) == 0) <tr> @endif
                          <td style="padding: 0px 0px 10px;">&#8226; {{$term['name']}}</td>
                          <?php $ii++; ?>
                          @endforeach
                          @if(($ii % 2) != 0) </tr> @endif
                        @endif
                    @endif
                </tbody>
                </table>
              </td>
          </tr>
        </tbody>
        </table>
    </td>
  </tr>
</tbody>
</table>

  <footer>
    <table cellpadding="0" cellspacing="0" style="width: 100%;background: #81d5f4; padding: 10px 0px;">
  <tbody>
    <tr>
      <td style="color:#000; padding: 0px 10px 0px; text-align: center; font-size:13px;"><b>Email.: tngholidays@gmail.com</b></td>
      <td style="color:#000; text-align: center;border-left: 1px solid #000; border-right: 1px solid #000; font-size:13px;"><b>Mo.: +91-7823070707</b></td>
      <td style="color:#000; text-align: center; font-size:13px;"><b>Website: www.tngholidays.com</b></td>
    </tr>
  </tbody>
</table>
  </footer>


  <div class="pageBreak">
   <table cellpadding="0" cellspacing="0" style="width:100%;">
     <tbody>
       <tr>
         <td style="width: 150px; padding: 60px 0px 20px 0px;">
           <table cellpadding="0" cellspacing="0" style="width:100%;">
             <tbody>
               <tr>
                 <td style="padding:0px 20px 0px 20px;"><img width="140" src="{{ public_path('uploads/logo.png') }}" /> </td>
               </tr>
               <tr>
                 <td style=" font-size: 15px; padding:100px 20px 0px 20px;color: #888c80;">
                   <p><strong>Dear {{@$row->name}}</strong>,</p>
                 {!! $row->welcome_note !!}
                 </td>
               </tr>

             </tbody>
           </table>

         </td>
        </tr>
       </tbody>
     </table>
  <div>

 <div class="pageBreak DaywiseItinerary">
  <table cellpadding="0" cellspacing="0" style="width:100%; page-break-before: always;">
    <tbody>
    <tr>
      <td>
        <table cellpadding="0" cellspacing="0" style="width: 100%; padding: 15px 0px 0px; width:100%; table-layout: fixed;">
            <tbody>
                <tr>
                  <td>
                  <table cellpadding="0" cellspacing="0" style="width:100%;">
                    <tbody>
                      <tr>
                      <td style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px;"><img width="140" src="{{ public_path('uploads/logo.png') }}" /></td>
                      </tr>
                      <tr>
            	          <td style="background: #81d5f3; color:#fff; font-size:24px; padding: 0px 20px 15px 20px; font-weight: 700;">Daywise Itinerary</td>
                      </tr>
                    </tbody>
                  </table>
                  </td>
                </tr>
                <tr>
                    <td style="text-align: right; width: 195px;">
                        <table cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="10" style="text-align:right; padding: 0px 5px 10px 0px;">Highlights</td>
                                </tr>
                                <tr>
                                    <td style="width:70px; border: 1px solid #000; padding: 6px; text-align: center; background: #fff; height: 60px; border-radius: 10px;">
                                        <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <i style="background: #ececec; width: 30px; height: 30px; margin: auto; border-radius: 100%; text-align: center; display: inline-block; vertical-align: middle;">
                                                            <img style="width: 49%;  margin-top: 7px;" src="{{ public_path('uploads/home-icon.png') }}" />
                                                        </i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 13px; text-align: center;">{{$totalHotel}} Hotel</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="width: 10px;">&nbsp;</td>
                                    <td style="width:70px; border: 1px solid #000; padding: 6px; text-align: center; background: #fff; height: 60px; border-radius: 10px;">
                                        <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <i style="background: #ececec; width: 30px; height: 30px; margin: auto; border-radius: 100%; text-align: center; display: inline-block; vertical-align: middle;">
                                                            <img style="width: 49%;  margin-top: 7px;" src="{{ public_path('uploads/book-icon.png') }}" />
                                                        </i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 13px; text-align: center;">{{$totalActivity}} Activities</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="width: 10px;">&nbsp;</td>
                                    <td style="width:70px; border: 1px solid #000; padding: 6px; text-align: center; background: #fff; height: 60px; border-radius: 10px;">
                                        <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <i style="background: #ececec; width: 30px; height: 30px; margin: auto; border-radius: 100%; text-align: center; display: inline-block; vertical-align: middle;">
                                                            <img style="width: 49%;  margin-top: 7px;" src="{{ public_path('uploads/car.png') }}" />
                                                        </i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 13px; text-align: center;">{{$totalTransfer}} Transfers</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="width: 10px;">&nbsp;</td>
                                    <td style="width:70px; border: 1px solid #000; padding: 6px; text-align: center; background: #fff; height: 60px; border-radius: 10px;">
                                        <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <i style="background: #ececec; width: 30px; height: 30px; margin: auto; border-radius:100%; text-align: center; display: inline-block; vertical-align: middle;">
                                                            <img style="width: 49%;  margin-top: 7px;" src="{{ public_path('uploads/people.jpg') }}" />
                                                        </i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 13px; text-align: center;">{{$persons}} Pax</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="width: 10px;">&nbsp;</td>
                                    <?php /*
                                    <td style="width:70px; border: 1px solid #000; padding: 6px; text-align: center; background: #fff; height:60px; border-radius: 10px;">
                                        <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <i style="background: #ececec; width: 30px; height: 30px; margin: auto; border-radius: 100%; text-align: center; display: inline-block; vertical-align: middle;">
                                                            <img style="width: 49%; margin-top: 7px;" src="{{ public_path('uploads/food-icon.png') }}" />
                                                        </i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 13px; text-align: center;">0 Meal</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="width:5px;">&nbsp;</td> */ ?>

                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="4" style="padding-top: 8px;"></td></tr>

                @php $extra_price = $booking->getJsonMeta('extra_price'); @endphp
                @if(!empty($extra_price))
                <tr>
                    <td colspan="4">
                        <table cellpadding="0" cellspacing="0" style="width: 100%; table-layout: fixed;">
                            <tr>
                                <td colspan="3" style="border: 1px solid #81d5f3;text-align: left; background: #81d5f3; font-size: 19px; padding: 8px 10px;"><strong>Extra Services (inluded in package) </strong>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4" style="border: 1px solid #ccc;  font-size: 20px; padding: 8px 8px 8px;">
                                    @foreach($extra_price as $type)
                                         <span style="font-size: 25px;"> &#8226;</span> {{$type['name']}},
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="4" style="padding-top: 8px;"></td></tr>
                @endif
                
                @if(!empty($tour_activities))
                @foreach($tour_activities as $key=>$summary)
                
                <tr>
                    <td colspan="4">
                        <table cellpadding="0" cellspacing="0" style="width: 100%; clear: both; table-layout: fixed;page-break-inside: always;">
                            <tbody>
                                 @if(count($summary['hotel']) > 0)
                                <tr>
                                    <td style="text-align: left; background: #aedad5; font-size: 19px; padding: 8px 10px;">
                                        <img src="{{ public_path('uploads/location-icon.png') }}" style="width: 22px; float: left; margin: -4px 7px 0px 0px;" /><strong>{{$summary['location']}} </strong>
                                    </td>
                                    <td colspan="3" style="text-align: left; background: #aedad5; font-size: 19px; padding: 0px 0px;"></td>
                                </tr>
                                @endif
                                <tr class="NewRow">
                                    <td rowspan="{{$summary['rowspan']}}"  style="text-align: left;font-size: 14px;border: 1px solid #ccc;  padding: 8px 10px 0px; background: #fff; width: 144px;vertical-align: top;"><strong>{{$summary['date']}}, {{$summary['day']}}</strong></td>
                                    <td colspan="3" style="float: left; margin: -10px;border-left: 1px solid #ccc;border-right: 1px solid #ccc;"></td>
                                </tr>
                                @if(!empty($summary['breackfast']))
                                <tr>
                                    <td colspan="3" style="border: 1px solid #ccc;border-top:0px; font-size: 14px; padding: 8px 8px 8px; border-left: 0px;">
                                        <img src="{{ public_path('uploads/food-icon.png') }}" style="width: 22px; margin-right: 5px;" />{{$summary['breackfast'] ?? ""}}
                                    </td>
                                </tr>
                                @endif
                                @if(count($summary['transfer']) > 0)
                                @foreach($summary['transfer'] as $key=>$transfer)
                                <tr>
                                    <td colspan="3" style="border: 1px solid #ccc;border-top:0px; font-size: 14px; padding: 8px 8px 8px; border-left: 0px;">
                                        <img src="{{ public_path('uploads/car.png') }}" style="width: 22px; margin-right: 5px;" />{{$transfer['name'] ?? ""}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                
                                @if(count($summary['hotel']) > 0)
                                <tr>
                                    <td colspan="3" style="border: 1px solid #ccc;border-top:0px; font-size: 14px; padding: 8px 8px 8px; border-left: 0px;">
                                        <img src="{{ public_path('uploads/home-icon.png') }}" style="width: 22px; margin-right: 5px;" />Check in to {{$summary['hotel']['hotel_name'] ?? ""}}
                                        <div style="padding-left:27px;font-size: 12px;">
                                                <span>Room: {{$summary['hotel']['room_name'] ?? ""}}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                
                                @if(count($summary['morning_activity']) > 0)
                                @foreach($summary['morning_activity'] as $key => $activity)
                                <tr>
                                    <td colspan="3" style="border: 1px solid #ccc;border-top:0px; font-size: 14px; padding: 8px 8px 8px; border-left: 0px;">
                                        <img src="{{ public_path('uploads/book-icon.png') }}" style="width: 22px; margin-right: 5px;" />{{$activity['name'] ?? ""}}
                                         @if(!empty($activity['inclusions_name']) || !empty($activity['exclude']) || !empty($activity['duration']))
                                            <div style="padding-left:27px;font-size: 12px;">
                                                @if(!empty($activity['duration']))
                                                <span>Duration: {{$activity['duration'] ?? ""}}</span>
                                                <br>
                                                @endif
                                                @if(!empty($activity['inclusions_name']))
                                                <span>Inclusions: {{$activity['inclusions_name'] ?? ""}}</span>
                                                <br>
                                                @endif
                                                @if(!empty($activity['exclude']))
                                                <span>Exclusions: {{$activity['exclude'] ?? ""}}</span>
                                                @endif
                                            </div>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                @if(count($summary['activity']) > 0)
                                @foreach($summary['activity'] as $key => $activity)
                                <tr>
                                    <td colspan="3" style="border: 1px solid #ccc;border-top:0px; font-size: 14px; padding: 8px 8px 8px; border-left: 0px;">
                                        <img src="{{ public_path('uploads/book-icon.png') }}" style="width: 22px; margin-right: 5px;" />{{$activity['name'] ?? ""}}
                                         @if(!empty($activity['inclusions_name']) || !empty($activity['exclude']) || !empty($activity['duration']))
                                            <div style="padding-left:27px;font-size: 12px;">
                                                @if(!empty($activity['duration']))
                                                <span>Duration: {{$activity['duration'] ?? ""}}</span>
                                                <br>
                                                @endif
                                                @if(!empty($activity['inclusions_name']))
                                                <span>Inclusions: {{$activity['inclusions_name'] ?? ""}}</span>
                                                <br>
                                                @endif
                                                @if(!empty($activity['exclude']))
                                                <span>Exclusions: {{$activity['exclude'] ?? ""}}</span>
                                                @endif
                                            </div>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                @if(count($summary['evening_activity']) > 0)
                                @foreach($summary['evening_activity'] as $key => $activity)
                                <tr>
                                    <td colspan="3" style="border: 1px solid #ccc;border-top:0px; font-size: 14px; padding: 8px 8px 8px; border-left: 0px;">
                                        <img src="{{ public_path('uploads/book-icon.png') }}" style="width: 22px; margin-right: 5px;" />{{$activity['name'] ?? ""}}
                                         @if(!empty($activity['inclusions_name']) || !empty($activity['exclude']) || !empty($activity['duration']))
                                            <div style="padding-left:27px;font-size: 12px;">
                                                @if(!empty($activity['duration']))
                                                <span>Duration: {{$activity['duration'] ?? ""}}</span>
                                                <br>
                                                @endif
                                                @if(!empty($activity['inclusions_name']))
                                                <span>Inclusions: {{$activity['inclusions_name'] ?? ""}}</span>
                                                <br>
                                                @endif
                                                @if(!empty($activity['exclude']))
                                                <span>Exclusions: {{$activity['exclude'] ?? ""}}</span>
                                                @endif
                                            </div>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
      </td>
    </tr>
  </tbody>
  </table>
 </div>
<?php /*
 <div class="pageBreak">
    <table cellpadding="0" cellspacing="0" style="width: 100%;page-break-before: always;">
        <thead>
      <tr>
        <td colspan="2" style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px;">
      <img width="140" src="{{ public_path('uploads/logo.png') }}" />
      </td>
      </tr>
      <tr>
        <td colspan="2" style="background: #81d5f3; color:#fff; font-size:30px; padding: 0px 20px 15px 20px; font-weight: 700;">
      Sightseeing/Activities
  </td>
      </tr>
      <tr>
                <td colspan="2" style="padding: 20px 0px 0px;"></td>
            </tr>
    </thead>
        <tbody>
             @if(!empty($tour->tour_term) and !empty($attributes))
      @foreach($attributes as $attribute)
      @if(empty($attribute['parent']['hide_in_single']) && strpos($attribute['parent']->slug, 'sightseeing') !== false)
            <tr>
                <td colspan="2" style="padding:0px 20px;">
                    <table>
                        <tbody>
                          <tr>
            <td style="width:40px;"><img style="width: 25px;" src="{{ public_path('uploads/pro_image_icon.png') }}" /></td>
    		<td style=" color: #cd853f; font-weight: 700; font-size: 15px;">{{$attribute['parent']->name}}</td>
                    </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

             @if(count($attribute['child']) > 0)
        @foreach($attribute['child'] as $term )
        <?php
         $termIMG = "";
        if (!empty($term['image_id'])) {
          $termIMG = public_path('uploads/').getImageUrlById($term['image_id']);
         }
        ?>
            <tr>
                <td style="padding: 10px 0px 10px 50px; text-align: right; vertical-align: top; width: 150px;">
                    <p style="width: 100%; margin: 0px; padding: 0px 0px 8px; font-weight: 700; font-size: 14px; text-align: left;">{{$term->name}}</p>
                    <img style="height: 90px; width: 150px; object-fit: cover;" src="{{$termIMG}}" />
                </td>
                <td style="font-weight: 400; font-size: 14px; padding: 40px 20px 20px; vertical-align: top;color: #888c80;text-align: justify;">
                    {!! $term->desc !!}
                </td>
            </tr>
        @endforeach
        @endif
        @endif
    @endforeach
  @endif
        </tbody>
    </table>
</div>

*/ ?>
<?php /*
 <div class="pageBreak">
  <table cellpadding="0" cellspacing="0" style="width: 100%;table-layout: auto;page-break-before: always;">
    <thead>
      <tr>
        <td style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px;">
      <img width="140" src="{{ public_path('uploads/logo.png') }}" />
      </td>
      </tr>
      <tr>
        <td style="background: #81d5f3; color:#fff; font-size:30px; padding: 0px 20px 15px 20px; font-weight: 700;">
      Sightseeing/Activities
  </td>
      </tr>
    </thead>
    <tbody>

    @if(!empty($tour->tour_term) and !empty($attributes))
      @foreach($attributes as $attribute)
      @if(empty($attribute['parent']['hide_in_single']) && strpos($attribute['parent']->slug, 'sightseeing') !== false)
       <tr>
         <td style="padding: 15px 20px 0px;">
            <table>
              <tbody>
                <tr>
            <td style="width: 60px;"><img style="width: 38px;" src="{{ public_path('uploads/pro_image_icon.png') }}" /></td>
    		<td style=" color: #cd853f; font-weight: 700; font-size: 15px;">{{$attribute['parent']->name}}</td>
                    </tr>
              </tbody>
            </table>
          </td>
        </tr>
        @if(count($attribute['child']) > 0)
        @foreach($attribute['child'] as $term )
        <?php
         $termIMG = "";
        if (!empty($term['image_id'])) {
          $termIMG = public_path('uploads/').getImageUrlById($term['image_id']);
         }
        ?>
        <tr>
          <td>
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
              <tbody>

              <tr>
                <td style="padding: 10px 0px 10px 50px; text-align:right; vertical-align: top; width:150px;">
				<p style="width: 100%; margin: 0px; padding: 0px 0px 8px; font-weight: 700; font-size:14px; text-align: left;">{{$term->name}}</p>
				<img style="height: 90px;width: 150px;object-fit: cover;" src="{{$termIMG}}" />
				</td>
                <td style=" font-weight:400; font-size: 14px; padding: 40px 20px 20px; vertical-align: top;color: #888c80;">{!! $term->desc !!}</td>
              </tr>

             </tbody>
            </table>
          </td>
        </tr>
        @endforeach
        @endif

    @endif
    @endforeach
  @endif
    </tbody>

  </table>
 </div> */ ?>
 <div class="pageBreak">
   @if(!empty(json_decode($booking->default_hotels, true)))
   <?php $bookingDate = $row->start_date;?>
   @foreach (json_decode($booking->default_hotels, true) as $indx => $hotel)
   <?php
     $hotelDDetail = getHotelById($hotel['hotel']);
     $noDays = $hotel['days'] * 2;
     $dayPlus = "+$noDays day";
		 $checkInDate = date('d M, Y', strtotime($bookingDate));
		 $checkOutDate = date('d M, Y', strtotime($bookingDate . $dayPlus));
		 $date = str_replace('/', '-', $checkOutDate);
		 $bookingDate = date('Y-m-d', strtotime($date));
   ?>
  <table cellpadding="0" cellspacing="0" style="width: 100%;page-break-before: always;">

    <tbody>
    <tr>
      <td>
        <table cellpadding="0" cellspacing="0" style="width: 100%; background: #81d5f3; padding: 15px 0px;">
          <tbody>
            <tr>
              <td>
                <table cellpadding="0" cellspacing="0" style="width: 100%;">
                  <tr>
                    <td style="font-size:24px;">
                      <table cellpadding="0" cellspacing="0" style="width: 200px; background: #07a7e3;font-weight: 700;font-size: 18px;color: #fff;border-bottom-right-radius: 20px; border-top-right-radius: 30px;padding: 3px 10px 5px 10px;">
                        <tbody>
                          <tr>
                            <td>
                            <img width="30" src="{{ public_path('uploads/hotel_icon.png') }}" />
                            </td>
                            <td>Hotel Details</td>
                          </tr>
                        </tbody>
                      </table>

                    </td>
                  </tr>
                  <tr><td colspan="2" style=" color: #fff; font-size: 20px; padding: 0px 20px 0px;">
                    <h3 style="margin:5px 0px 5px 0px;">{{$hotelDDetail->title}}</h3>
                    <div class="rating-star" style="padding-top: 0px;">
                      @if($hotelDDetail->star_rate)
                          <div class="star-rate">
                              @for ($star = 1 ;$star <= $hotelDDetail->star_rate ; $star++)
                                  <i class="fa fa-star" style="color: #ff6a00; font: normal normal normal 20px/1 FontAwesome !important; font-family: FontAwesome;"></i>
                              @endfor
                          </div>
                      @endif
                    </div>
                    <p style="margin:0px;font-size:13px;">{{$hotelDDetail->address}} <br>
                    <strong>Check-In Date : </strong> {{$checkInDate}}<br>
                    <strong>Check-Out Date : </strong> {{$checkOutDate}}<br>
                    <strong>Room Type : </strong>{{getRoomsById($hotel['room'])->title}}</p>
                  </td>
                  </tr>
                </table>
              </td>
              <td style="text-align: right; padding: 10px 20px 10px; vertical-align:top;"><img width="140" src="{{ public_path('uploads/logo.png') }}" /> </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>

      <td>
        <table cellpadding="0" cellspacing="0" style="width:100%;">
          <tbody>
              @if(!empty($hotelDDetail->getGallery()))
              <?php $iii = 0; ?>
                @foreach($hotelDDetail->getGallery() as $key=>$item)
                @if($iii < 8)
                @if(($iii % 4) == 0) <tr> @endif
            <?php /*<td style="padding: 10px 15px 10px; text-align: center;"><img width="160" style="height:150px;object-fit: cover;" src="{{$item['thumb']}}" /></td> */ ?>
   					<td style="padding: 10px 15px 10px; text-align: center;"><img width="160" style="height:150px;object-fit: cover;" src="{{$item['thumb']}}" /></td>
                <?php $iii++; ?>
                @if(($iii % 4) == 0) </tr> @endif
                @endif
                @endforeach
              @endif

            <tr>
              <td style="font-size:14px; padding: 0px 0px 10px 0px color: #888c80!important;" colspan="4">
                  <div style="font-size:14px; padding: 10px 15px; color: #888c80!important;text-align: justify;">{!! $hotelDDetail->content !!}</div>

              </td>
            </tr>
						<tr>
              <td style="font-size:14px; padding: 0px 0px 10px 0px color: #888c80;" colspan="4">
                  <div style="font-size:14px; padding: 10px 15px; color: red;text-align: justify;"> <i>Above are standard feature available with hotels as per our record but that might be upgrade or downgrade in hotel actual property. Please connect with hotel for precise feature List.</i> </div>

              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>



    </tbody>

  </table>
  @endforeach
@endif
 </div>
 
 
 @if(!empty($flightss))
<div class="pageBreak">
    <table cellpadding="0" cellspacing="0" style="width: 100%; page-break-before: always;" class="flightTable">
        <tbody>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" style="width: 100%; background: #81d5f3; padding: 15px 0px;">
                        <tbody>
                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                        <tr>
                                            <td style="font-size: 24px;">
                                                <table
                                                    cellpadding="0"
                                                    cellspacing="0"
                                                    style="width: 200px; background: #07a7e3; font-weight: 700; font-size: 18px; color: #fff; border-bottom-right-radius: 20px; border-top-right-radius: 30px; padding: 3px 10px 5px 10px;"
                                                >
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <img width="30" src="{{ public_path('uploads/flight-icon.png') }}" />
                                                            </td>
                                                            <td>Flight Details</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="text-align: right; padding: 10px 20px 10px; vertical-align: top;"><img width="140" src="{{ public_path('uploads/logo.png') }}" /></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <?php $flightPricePP = 0; ?>
        @if(isset($tour->meta->flight) and count($tour->meta->flight) > 0 )
            @foreach($tour->meta->flight as $fkey => $flight )
            <?php
            $flight['departure_time'] = str_replace("/", "-", $flight['departure_time']);
            $flight['arrival_time'] = str_replace("/", "-", $flight['arrival_time']);
            ?>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td colspan="6" style="font-size: 16px; color: #0697cd; text-transform: uppercase; padding: 25px 0px 10px 0px;">
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
                            <tr>
                                <?php
                                    $airline = getAirlines($flight['flight_id']);
                                     $airIMG = "";
                                      if (!empty($airline->image_id)) {
                                      $airIMG = public_path('uploads/').getImageUrlById($airline->image_id);
                                     }
                                ?>
                                <td style="background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 15px 0px 15px;width: 100px;"><img src="{{$airIMG}}" width="70" /></td>
                                <td style="background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 15px 0px 15px;width: 100px;"><?php /* {{isset($flight['flight_no']) ? $flight['flight_no'] : ''}} */ ?></td>
                                <td style="background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 15px 0px 15px;width: 150px;">
                                    <table cellpadding="0" cellspacing="0" style="width:100%;">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align: top;padding-right: 4px;"><img width="15" src="{{ public_path('uploads/flight-icon-1.png') }}" /></td>
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
                                <td style="background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 15px 0px 15px;width: 150px;">
                                    <table cellpadding="0" cellspacing="0" style="width:100%;">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align: top;padding-right: 4px;"><img width="15" src="flight-icon-1.png" /></td>
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
                                <?php $flightPricePP += $flight['price']; ?>
                                <th style="text-align: left; background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 2px 0px 2px;" colspan="6"><span style="font-size:12px; color:#07a7e3;"><b>Per Person Flight Charges {{$flight['price']}}/-</b></span></th>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
             @endforeach
             <tr>
                <td style="text-align: right; background: #f7f7f7; border-bottom: 3px solid #f2f2f2; padding: 2px 0px 2px;">
              <div> <i>Total Flight Fare Per Person {{$flightPricePP}}/-</i> </div>
    
          </td>
            </tr>
             <tr>
                <td style="font-size:14px; padding: 0px 0px 10px 0px color: #888c80;">
              <div style="font-size:14px; padding: 10px 15px; color: red;text-align: justify;"> <i>All Prices are in Indian Rupees and subject to change without prior notice.<br><br> Price quoted are subject to availability at time of confirmation, we are currently not holding any blocking against the sent quotation.<br><br> Booking confirmations are subject to availability.<br><br> Any overstay expenses due to delay or change or cancellation in flight will be on the guests own & TNG Holidays will not be held liable for such expenses however we will provide best possible assistance.</i> </div>
    
          </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
 @endif
 <?php /*
 <?php
 $extra_prices = [];
 if (!empty($row->extra_price) and count($row->extra_price) > 0) {
	 	foreach ($row->extra_price as $key => $extra_price) {
	 		if (isset($extra_price['enable'])) {
	 				$extra_prices[] = $extra_price;
	 		}
	 	}
 }
  ?>

 @if((isset($attributes[22]) && count($attributes[22]['child']) > 0) || (isset($attributes[24]) && count($attributes[24]['child'])) || (count($extra_prices) > 0))
 <div class="pageBreak">
   <table cellpadding="0" cellspacing="0" style="width: 100%;page-break-before: always;">
     <tbody>
			 @if(isset($attributes[22]) && count($attributes[22]['child']) > 0)
     <tr>
       <td style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px;"><img width="140" src="{{ public_path('uploads/logo.png') }}" /></td>
     </tr>
     <tr>
       <td style="background: #81d5f3; color:#fff; font-size:30px; padding: 0px 20px 15px 20px; font-weight: 700;">Transportation Details
 </td>
     </tr>
		 @endif
   @if(!empty($attributes) and isset($attributes[22]) and count($attributes[22]) > 0 && count($attributes[22]['child']) > 0)
         @foreach($attributes[22]['child'] as $term )
     <tr>
       <td style="padding: 10px 20px 10px 20px; border-bottom: 2px solid #f1f1f1;">
         <table cellpadding="0" cellspacing="0" style="width: 100%;">
           <tbody>
             <tr>
               <td style="width:90px; vertical-align: top;"><img width="70" src="{{ public_path('uploads/bus-icon.jpg') }}" /></td>
               <td>
                 <h2 style="color:#b78829; font-size: 15px;">{{$term->name}}</h2>
                     <p style="color:#000; font-size: 14px; color: #888c80;text-align: justify;">{!! $term->desc !!}</p>
               </td>
             </tr>
           </tbody>
         </table>
       </td>
     </tr>
     @endforeach
   @endif
		@if((isset($attributes[24]) && count($attributes[24]['child']) > 0) || (count($extra_prices) > 0))
	   <tr>
	     <td style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px;"><img width="140" src="{{ public_path('uploads/logo.png') }}" /></td>
	   </tr>
	   <tr>
	     <td style="background: #81d5f3; color:#fff; font-size:30px; padding: 0px 20px 15px 20px; font-weight: 700;">Meal Plan and Extra Services
	   </td>
	   </tr>
		@endif
   @if(!empty($attributes) and isset($attributes[24]) > 0 && count($attributes[24]['child']) > 0)
         @foreach($attributes[24]['child'] as $term )
         <tr>
           <td style="padding: 10px 20px 10px 20px; border-bottom: 2px solid #f1f1f1;">
             <table cellpadding="0" cellspacing="0" style="width: 100%;">
               <tbody>
                 <tr>
                   <td style="width:90px; vertical-align: top;"><img width="50" src="{{ public_path('uploads/meal-icon.png') }}" /></td>
                   <td>
                     <h2 style="color:#b78829; font-size: 15px;">{{$term->name}}</h2>
                     <p style="color:#000; font-size: 14px;color: #888c80;text-align: justify;">{!! $term->desc !!}</p>
                   </td>
                 </tr>
               </tbody>
             </table>
           </td>
         </tr>
   @endforeach
 @endif
 @if(count($extra_prices) > 0)
       @foreach($extra_prices as $extra_price )
       @if(isset($extra_price['enable']))
       <tr>
         <td style="padding: 10px 20px 10px 20px; border-bottom: 2px solid #f1f1f1;">
           <table cellpadding="0" cellspacing="0" style="width: 100%;">
             <tbody>
               <tr>
                 <td style="width:90px; vertical-align: top;"> </td>
                 <td>
                   <h2 style="color:#b78829; font-size: 15px;">&#8226; {{$extra_price['name']}} (Extra Services in Packages)</h2>
                 </td>
               </tr>
             </tbody>
           </table>
         </td>
       </tr>
       @endif
 @endforeach
@endif


     </tbody>

   </table>
  </div>
	@endif

  */ ?>
  <div class="pageBreak">
    <table cellpadding="0" cellspacing="0" style="width: 100%;page-break-before: always;">
      <tbody>
        <tr>
          <td style="background: #81d5f3; color:#fff; font-size:30px; padding: 25px 20px 30px 20px; font-weight: 700;">Cost, Terms & <br>
    Condition / Cancellation
    </td>
        </tr>
        <?php /*
        <tr>
          <td>
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
              <tbody>
                <tr>
                  <td style="vertical-align: top; padding: 10px 20px 10px;">
                    <h2 style="color:#b78829; font-size: 15px; padding: 0px 0px 0px; margin: 0px;">Inclusion:</h2>
                    <ul style="width: 100%; margin:0px; padding:0px 0px 0px 18px; font-size: 14px;color: #888c80;">
                      @if($tour->include)
                        @foreach($tour->include as $key=>$include)
                        <li>{{$include['title']}}</li>
                        @endforeach
                      @endif
                    </ul>
                  </td>
                  <td style="vertical-align: top; padding:10px 20px 10px;">
                    <h2 style="color:#b78829; font-size: 15px;padding: 0px 0px 0px; margin: 0px;">Exclusion:</h2>
                    <ul style="width:100%; margin:0px; padding:0px 0px 0px 18px; font-size: 14px;color: #888c80;">
                      @if($tour->exclude)
                        @foreach($tour->exclude as $key=>$exclude)
                        <li>{{$exclude['title']}}</li>
                        @endforeach
                      @endif
                    </ul>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        */?>
        <tr>
          <td style="vertical-align: top; padding:10px 20px 10px;">
            <h2 style="color:#b78829; font-size: 15px;padding: 20px 0px 0px; margin: 0px;">Terms & Conditions:</h2>
            <div style="font-size: 14px;color: #888c80;text-align: justify;">
              {!! $row->term_condations !!}
            </div>
          </td>
        </tr>
        <tr>
          <td style="vertical-align: top; padding:10px 20px 10px;">
            <h2 style="color:#b78829; font-size:15px;padding: 20px 0px 0px; margin: 0px;">Cancellation:</h2>
            <div style="font-size: 14px;color: #888c80;text-align: justify;">
              {!! $row->cancellation_note !!}
            </div>
          </td>
        </tr>
      </tbody>

    </table>
   </div>
  <div class="pageBreak">
   <table cellpadding="0" cellspacing="0" style="width: 100%;page-break-before: always;">


     <tbody>
     <tr>
       <td style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px;"><img width="140" src="{{ public_path('uploads/logo.png') }}" /></td>
     </tr>
     <tr>
       <td style="background: #81d5f3; color:#fff; font-size:30px; padding: 0px 20px 15px 20px; font-weight: 700;">Payment Policy & Other / Visa Information
       </td>
     </tr>
     <tr>
       <td style="vertical-align: top; padding:10px 20px 10px;">
         <h2 style="color:#b78829; font-size: 15px;padding: 20px 0px 0px; margin: 0px;">Payment Policy:</h2>
         <div style="font-size: 14px;color: #888c80;text-align: justify;">
           {!! $row->tips !!}
         </div>
         </td>
				 
     </tr>
     <tr>
       <td style="vertical-align: top; padding:10px 20px 10px;">
         <h2 style="color:#b78829; font-size: 15px;padding: 20px 0px 0px; margin: 0px;">Other / Visa Information:</h2>

         <div style="font-size: 14px;color: #888c80;text-align: justify;">
           {!! $row->other_note !!}
         </div>
       </td>
     </tr>
     </tbody>

   </table>
  </div>

  <div class="pageBreak">
   <table cellpadding="0" cellspacing="0" style="width: 100%;page-break-before: always;">


     <tbody>
     <tr>
       <th><img src="{{ public_path('uploads/thankyou.png') }}" /></th>
     </tr>

     <tr>
       <td style="padding: 20px 20px 30px 20px; font-size: 14px;">
         <div style="font-size: 14px;color: #888c80;text-align:justify; height:500px;">
             <p>Thank you very much.</p>
					 <p><strong>Dear {{$row->name}}</strong>,</p>
         {!! $row->thankyou_note !!}

       </div></td>
     </tr>
     <tr>
         <td>
             <table style="width:100%;" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
           <td style="padding: 0px 20px;"><img width="120" src="{{ public_path('uploads/logo.png') }}" /></td>
          </tr>
          <tr>
              <td style="padding: 10px 20px 0px 20px; font-size: 15px; color: #808080;">TNG Holidays</td>
          </tr>
          <tr>
            <td style="padding: 10px 20px 0px 20px; font-size: 14px; color: #808080;">
                E513, 3rd Floor Lal Kothi, Jaipur, <br>
                Rajasthan - 302015, India <br>
                Mo.: +91-7823070707 | Website: www.tngholidays.com | Email.: tngholidays@gmail.com <br>
            </td>
        </tr>
        <tr>
            <td style="padding: 0px 20px 0px 20px; font-size: 12px; color: #d3d3d3;text-align: justify;">
                Disclaimer : <br>
                This email/pdf/document/itinerary/link and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they
are addressed. Any information presented in this email/pdf/document/itinerary/link or attachment in form of digital images or text content or any other data is
as per the best knowledge of the author. In some cases images & content presented are only for the visual display purpose and might not reflect same as
offered in tour or hotel locations. If you have received this email in error please notify the system manager. Please note that any views or opinions presented
in this email are solely those of the author and do not necessarily represent those of the company. Finally, the recipient should check this email and any
attachments for the presence of viruses. The company accepts no liability for any damage caused by any virus transmitted by this email
            </td>
        </tr>


        </tbody>
        </table>
         </td>
     </tr>
     </tbody>
      <tfoot>
       <tr>
         <td>
           <!--place holder for the fixed-position footer-->
           <div class="page-footer-space"></div>
         </td>
       </tr>
     </tfoot>
   </table>
  <!-- </div>
<div class="page-footer">
   <div style="position:inherit;width:100%;">
    <table cellpadding="0" cellspacing="0" style="width: 100%;background: #81d5f4; padding: 10px 0px;">
  <tbody>
    <tr>
      <td style="color:#000; padding: 0px 10px 0px; text-align: center;"><b>Email.: tngholidays@gmail.com</b></td>
      <td style="color:#000; text-align: center;border-left: 1px solid #000; border-right: 1px solid #000;"><b>Mo.: +91917823070707</b></td>
      <td style="color:#000; text-align: center;"><b>Website: www.tngholidays.com</b></td>
    </tr>
  </tbody>
</table>
    </div>
</div> -->
  </div>
</body>

</html>
