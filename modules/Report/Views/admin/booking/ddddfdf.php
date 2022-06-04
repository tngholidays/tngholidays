<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">

.pageBreak{
     page-break-before: always !important;
     page-break-inside: avoid !important;
     page-break-after: always !important; clear: both;}
@page {
  margin: 1mm 4mm
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
</style>
<!DOCTYPE html>
<html>

<head>
</head>

<body style="font-family: 'Open Sans', sans-serif !important;">
  <div class="mainStyle">

  <!--<div class="page-footer">
    I'm The Footer
  </div>-->

  <table style="width:100%;" cellpadding="0" cellspacing="0">

    <thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

    <tbody>
    <tr>
    	<td style="position: relative"><div class="logo" style="position: absolute; top: 0px; left: 0px;box-shadow: 6px 5px 7px 0px rgb(0 0 0 / 18%); background: #fff; padding: 10px;"><img width="200" src="{{ public_path('uploads/0000/1/2020/06/17/logo-150-1new.png') }}" />
      </div>
    		<img style="width:785px; height: 1035px;" src="{{ public_path('uploads/TNG-bg-1.jpg') }}" />

    		<div style=" position: absolute; bottom: 0px;padding: 25px 30px; left: 0px; right: 0px;">
  					<table style="width:100%;" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>

       <td colspan="2"><h2 style="font-size: 40px; color:#fff; line-height: 51px;">{{$tour->title}} <br><span style="color: #ffff26;">{{$enquiry->name}}  </span></h2></td>
      </tr>
      <tr>

          <td style="color: #fff; line-height: 28px; font-size: 18px;">
            {{getTermById($row->duration)->name}} <br>INR {{$row->total_tour_price}} Tour Budget/Cost <br>
            @if(!empty($row->person_types))
            <?php $flag = false; ?>
                @foreach($row->person_types as $key=>$person_type)
                @if($person_type['number'] > 0)
                @if($flag == true) and @endif
                {{$person_type['number']}} {{$person_type['name']}}
                <?php $flag = true; ?>
                @endif
                @endforeach
            @endif<br>
           <b>Departure dates:</b> {{ date('d M, Y', strtotime($row->start_date))}}
          </td>
          <td style="font-size: 18px;">
              <table style="width: 100%;color: #fff;" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <th colspan="2" style="text-align: left; padding: 0px 0px 10px;">INCLUSION</th>
                </tr>
                @php
                    $facilitiesAttr = \Modules\Core\Models\Terms::getTermsById($tour->tour_term->pluck('term_id'));
                      $ii = 0;
                @endphp
                @if(!empty($facilitiesAttr) and count($facilitiesAttr[2]) > 0)
                    @if(count($facilitiesAttr[2]['child']) > 0)
                      @foreach($facilitiesAttr[2]['child'] as $term )
                      @if(($ii % 2) == 0) <tr> @endif
                      <td style="padding: 0px 0px 10px;">{{$term['name']}}</td>
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
  					</div>
    		</td>
    </tr>
    <tr>
     	<td style="width: 150px; padding: 60px 0px 20px 0px;">
     		<img width="140" src="{{ public_path('uploads/0000/1/2020/06/17/logo-150-1new.png') }}" />
     	</td>
     </tr>
     <tr>
     	<td style=" font-size: 18px; padding:100px 0px 0px 25px;">
       {!! $row->welcome_note !!}
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
 <div class="pageBreak">
 	<table cellpadding="0" cellspacing="0" style="width: 100%;">
 		<thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

 		<tbody>
 		<tr>
 			<td style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px; width:150px;"><img width="140" src="{{ public_path('uploads/0000/1/2020/06/17/logo-150-1new.png') }}" /></td>
 		</tr>
 		<tr>
 			<td style="background: #81d5f3; color:#fff; font-size:30px; padding: 0px 20px 15px 20px; font-weight: 700;">{{$tour->title}} <br>
Daywise Itinerary
</td>
 		</tr>


  @if(!empty($row->itinerary))
  @foreach($row->itinerary as $i_key=>$itinerary)
  <?php
  $start_date = str_replace("/", "-", $itinerary['date']);
  ?>
 		<tr>
 			<td>
 				<table>
 					<tbody>
 						<tr>
 							<td>
 								<table cellpadding="0" cellspacing="0" style="width: 100%">
 									<tbody>
 										<tr>
 											<td style=" color: #07a7e5; font-size: 28px; font-weight: 700; padding: 10px 20px 10px;"><span style="border-bottom: 2px dashed #07A7E4;padding-bottom: 7px;">DAY {{$i_key+1}} | {{ date('d M, Y', strtotime($start_date))}}</span></td>
 										</tr>
 									</tbody>
 								</table>
 							</td>
 						</tr>
 						<tr>
 							<td style="padding: 20px 20px 15px;">
 								<table cellpadding="0" cellspacing="0" style="width: 100%">
 									<tbody>
 										<tr>
 								<td style="width: 66px;"><img style="width: 38px;" src="{{ public_path('uploads/pro_image_icon.png') }}" /></td><td style=" color: #cd853f; font-weight: 700; font-size: 24px;">{{$itinerary['desc']}}</td>
 							          </tr>
 									</tbody>
 								</table>
 							</td>
 						</tr>
 						<tr>
 							<td>
 								<table cellpadding="0" cellspacing="0" style="width: 100%;">
 					<tbody>
 							<tr>
 								<td style="padding: 0px 0px 10px 84px; text-align:right; vertical-align: top; width: 150px;"><img style="height: 90px;width: 150px;object-fit: cover;" src="" /></td><td style="font-weight:400; font-size: 18px; padding: 0px 20px 0px; vertical-align: top;">{!! $itinerary['content'] !!}</td>
 							</tr>

 					</tbody>
 				</table>
 							</td>
 						</tr>
 					</tbody>
 				</table>
 			</td>
 		</tr>
    @endforeach
    @endif




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
 </div>

 <div class="pageBreak">
 	<table cellpadding="0" cellspacing="0" style="width: 100%;">
 		<thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>
    @php
        $attributes = \Modules\Core\Models\Terms::getTermsById($tour->tour_term->pluck('term_id'));
    @endphp
 		<tbody>
 		<tr>
 			<td style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px; width: 150px;"><img width="140" src="{{ public_path('uploads/0000/1/2020/06/17/logo-150-1new.png') }}" /></td>
 		</tr>
 		<tr>
 			<td style="background: #81d5f3; color:#fff; font-size:30px; padding: 0px 20px 15px 20px; font-weight: 700;">Sightseeing/Activities
</td>
 		</tr>
@if(!empty($tour->tour_term) and !empty($attributes))
  @foreach($attributes as $attribute)
  @if(empty($attribute['parent']['hide_in_single']) && strpos($attribute['parent']->slug, 'sightseeing') !== false)
 		<tr>
 			<td>
 				<table>
 					<tbody>

 						<tr>
 							<td style="padding: 15px 20px 0px;">
 								<table cellpadding="0" cellspacing="0" style="width: 100%">
 									<tbody>
 										<tr>
 								<td style="width: 66px;"><img style="width: 38px;" src="{{ public_path('uploads/pro_image_icon.png') }}" /></td><td style=" color: #cd853f; font-weight: 700; font-size: 24px;">{{$attribute['parent']->name}}</td>
 							          </tr>
 									</tbody>
 								</table>
 							</td>
 						</tr>
 						<tr>
 							<td>
 								<table cellpadding="0" cellspacing="0" style="width: 100%;">
 					<tbody>
            @if(count($attribute['child']) > 0)
            @foreach($attribute['child'] as $term )
 							<tr>
 								<td style="padding: 20px 0px 20px 84px; text-align:right; vertical-align: top; width: 150px;"><p style="width: 100%; margin: 0px; padding: 0px 0px 8px; font-weight: 700; font-size:18px; text-align: left;">{{$term->name}}</p><img style="height: 90px;width: 150px;object-fit: cover;" src="" /></td>
 								<td style=" font-weight:400; font-size: 18px; padding: 40px 20px 20px; vertical-align: top;">{!! $term->desc !!}</td>
 							</tr>
              @endforeach
            @endif

 					</tbody>
 				</table>
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
 		 <tfoot>
      <tr>
        <td>
          <!--place holder for the fixed-position footer-->
          <div class="page-footer-space"></div>
        </td>
      </tr>
    </tfoot>
 	</table>
 </div>


 <div class="pageBreak">
 	<table cellpadding="0" cellspacing="0" style="width: 100%;">
 		<thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

 		<tbody>

  @if(count($row->default_hotels) > 0)
  <?php $bookingDate = $row->start_date;?>
  @foreach ($row->default_hotels as $indx => $hotel)
  <?php
    $hotelDDetail = getHotelById($hotel['hotel']);
    $noDays = $hotel['days'] * 2;
    $dayPlus = "+$noDays day";
$checkInDate = date('d M, Y', strtotime($bookingDate));
$checkOutDate = date('d M, Y', strtotime($bookingDate . $dayPlus));
$date = str_replace('/', '-', $checkOutDate);
$bookingDate = date('Y-m-d', strtotime($date));
  ?>
 		<tr>
 			<td>
 				<table cellpadding="0" cellspacing="0" style="width: 100%; background: #81d5f3; padding: 15px 0px;">
 					<tbody>
 						<tr>
 							<td>
 								<table cellpadding="0" cellspacing="0" style="width: 100%;">
 									<tr>
 										<td style="font-size: 28px;">
 											<table cellpadding="0" cellspacing="0" style="width: 200px; background: #07a7e3;font-weight: 700;font-size: 18px;color: #fff; border-radius: 0px 30px 30px 0px;padding: 3px 10px 5px 10px;">
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
 									<!-- <tr>
 										<td colspan="2" style=" padding: 20px 20px 0px; color: #f5cb58; font-size: 24px;">
 											<i style="color:#ff7600; padding-left: 2px;" class="fa fa-star" aria-hidden="true"></i>
                      <i style="color:#ff7600; padding-left: 2px;" class="fa fa-star" aria-hidden="true"></i>
                      <i style="color:#ff7600; padding-left: 2px;" class="fa fa-star" aria-hidden="true"></i>
                      <i style="color: #ececec; padding-left: 2px;" class="fa fa-star" aria-hidden="true"></i>
                      <i style="color: #ececec; padding-left: 2px;" class="fa fa-star" aria-hidden="true"></i>
 										</td>
 									</tr> -->
 									<tr>
 										<td colspan="2" style=" color: #fff; font-size: 20px; padding: 10px 20px 10px;">
                      <h3>{{$hotelDDetail->title}}</h3>
                      <div class="rating-star" style="padding-top: 8px;">
                        @if($hotelDDetail->star_rate)
                            <div class="star-rate">
                                @for ($star = 1 ;$star <= $hotelDDetail->star_rate ; $star++)
                                    <i class="fa fa-star" style="color: #ff6a00;"></i>
                                @endfor
                            </div>
                        @endif
                      </div>
                      {{$hotelDDetail->address}} <br>
                      <strong>Check-In on </strong> {{$checkInDate}}<br>
                      <strong>Check-Out on</strong> {{$checkOutDate}}<br>
                      {{getRoomsById($hotel['room'])->title}}
 										</td>
 									</tr>
 								</table>
 							</td>
 							<td style="text-align: right; padding: 15px 20px 15px; width: 150px;"><img width="140" src="{{ public_path('uploads/0000/1/2020/06/17/logo-150-1new.png') }}" /> </td>
 						</tr>
 					</tbody>
 				</table>
 			</td>
 		</tr>
 		<tr>
 			<td>
 				<table cellpadding="0" cellspacing="0" style="width:100%;">
 					<tbody>
 						<tr>
              @if($hotelDDetail->getGallery())
                @foreach($hotelDDetail->getGallery() as $key=>$item)
   							<td style="padding: 20px 15px 20px; text-align: center;"><img width="150" src="" /></td>
                @endforeach
              @endif
 						</tr>
 						<tr>
 							<td style="font-size:18px; padding: 0px 20px 20px 20px" colspan="4">{{$hotelDDetail->content}}</td>
 						</tr>
 					</tbody>
 				</table>
 			</td>
 		</tr>
  @endforeach
@endif

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
 </div>

<div class="pageBreak">
 	<table cellpadding="0" cellspacing="0" style="width: 100%;">
 		<thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

 		<tbody>
 		<tr>
 			<td style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px; width: 150px;"><img width="140" src="{{ public_path('uploads/0000/1/2020/06/17/logo-150-1new.png') }}" /></td>
 		</tr>
 		<tr>
 			<td style="background: #81d5f3; color:#fff; font-size:30px; padding: 0px 20px 15px 20px; font-weight: 700;">Transportation Details
</td>
 		</tr>
    @if(isset($tour->surrounding[3]) && count($tour->surrounding[3]) > 0)
      @foreach($tour->surrounding[3] as $key=>$surrounding)
 		<tr>
 			<td style="padding: 15px 20px 15px 20px; border-bottom: 2px solid #f1f1f1;">
 				<table cellpadding="0" cellspacing="0" style="width: 100%;">
 					<tbody>
 						<tr>
 							<td style="width:90px; vertical-align: top;"><img width="70" src="{{ public_path('uploads/bus-icon.jpg') }}" /></td>
 							<td>
 								<h2 style="color:#b78829; font-size: 24px;">{{$surrounding['name']}}</h2>
 								<p style="color:#000; font-size: 18px;">{{$surrounding['content']}}</p>
 							</td>
 						</tr>
 					</tbody>
 				</table>
 			</td>
 		</tr>
    @endforeach
  @endif
 		<tr>
 			<td style="background: #81d5f3; color:#fff; font-size:30px; padding: 25px 20px 30px 20px; font-weight: 700;">Inclusion & Exclusion / Cost, Terms & <br>
Condition / Cancellation
</td>
 		</tr>
 		<tr>
 			<td>
 				<table cellpadding="0" cellspacing="0" style="width: 100%;">
 					<tbody>
 						<tr>
 							<td style="vertical-align: top; padding: 15px 20px 15px;">
 								<h2 style="color:#b78829; font-size: 24px; padding: 0px 0px 0px; margin: 0px;">Inclusion:</h2>
 								<ul style="width: 100%; margin:0px; padding:0px 0px 0px 18px; font-size: 18px;">
                  @if($tour->include)
                    @foreach($tour->include as $key=>$include)
                    <li>{{$include['title']}}</li>
                    @endforeach
                  @endif
 								</ul>
 							</td>
 							<td style="vertical-align: top; padding:15px 20px 15px;">
 								<h2 style="color:#b78829; font-size: 24px;padding: 0px 0px 0px; margin: 0px;">Exclusion:</h2>
 								<ul style="width:100%; margin:0px; padding:0px 0px 0px 18px; font-size: 18px;">
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
 		<tr>
 			<td style="vertical-align: top; padding:15px 20px 15px;">
 				<h2 style="color:#b78829; font-size: 24px;padding: 20px 0px 0px; margin: 0px;">Terms & Conditions:</h2>
        <div style="font-size: 18px;">
          {!! $row->term_condations !!}
        </div>
 			</td>
 		</tr>
 		<tr>
 			<td style="vertical-align: top; padding:15px 20px 15px;">
 				<h2 style="color:#b78829; font-size: 24px;padding: 20px 0px 0px; margin: 0px;">Cancellation:</h2>
        <div style="font-size: 18px;">
          {!! $row->cancellation_note !!}
        </div>

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
 </div>





 <div class="pageBreak">
 	<table cellpadding="0" cellspacing="0" style="width: 100%;">
 		<thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

 		<tbody>
 		<tr>
 			<td style="background: #81d5f3; text-align: right; padding: 15px 20px 8px 20px; width: 150px;"><img width="140" src="{{ public_path('uploads/0000/1/2020/06/17/logo-150-1new.png') }}" /></td>
 		</tr>
 		<tr>
 			<td style="background: #81d5f3; color:#fff; font-size:30px; padding: 0px 20px 15px 20px; font-weight: 700;">Tips & Other / Visa Information</td>
 		</tr>

 		<tr>
 			<td style="vertical-align: top; padding:15px 20px 15px;">
 				<h2 style="color:#b78829; font-size: 24px;padding: 20px 0px 0px; margin: 0px;">Tips:</h2>
        <div style="font-size: 18px;">
          {!! $row->tips !!}
        </div>
 				</td>
 		</tr>
 		<tr>
 			<td style="vertical-align: top; padding:15px 20px 15px;">
 				<h2 style="color:#b78829; font-size: 24px;padding: 20px 0px 0px; margin: 0px;">Other / Visa Information:</h2>
        <div style="font-size: 18px;">
          {!! $row->other_note !!}
        </div>
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
 </div>

 <div class="pageBreak">
 	<table cellpadding="0" cellspacing="0" style="width: 100%;">
 		<thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

 		<tbody>
 		<tr>
 			<th><img src="{{ public_path('uploads/thankyou.png') }}" /></th>
 		</tr>
 		<tr>
 			<td style="padding: 20px 20px 30px 20px; font-size: 18px;"><p>Thank you very much.</p></td>
 		</tr>
 		<tr>
 			<td style="padding: 20px 20px 30px 20px; font-size: 18px;">
        <div style="font-size: 18px;">
          {!! $row->thankyou_note !!}
        </div>
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
 </div>
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
</div>
  </div>
</body>

</html>
