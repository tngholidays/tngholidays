
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
}
footer {
              position: fixed;
              bottom:50px;
          }
					#watermark { position: fixed; width:100%; height:100%; margin-left: 180px; margin-right: 0px; margin-top: 190px; opacity: .5;-ms-transform: rotate(-20deg);transform: rotate(-20deg);
					}
					#watermark img { width:100%;}
          /*td {*/
          /*  border: 1px solid #ddd;*/
          /*}*/
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
     ?>
      <img style="width:100%; height: 700px;object-fit: cover;" src="{{ $mainImg }}" />
    </td>
  </tr>
  <tr>
    <td>
      <table style="width:100%;background:#70b5ce; padding: 10px 20px; height:270px;" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
           <td colspan="2" style=" padding:0px 20px;"><h2 style="font-size: 26px; color:#fff; line-height: 32px;">{{$tour->title}} <br><span style="color: #ffff26;">{{$enquiry->name}}</span></h2></td>
          </tr>
          <tr>
            <td style="color: #fff; line-height: 22px; font-size: 15px;padding:10px 0px 10px 20px;">
              {{getTermById($row->duration)->name}} <br>INR {{$row->total_tour_price}} Tour Budget/Cost<br> <span style="font-size:12px;">(Extra 5% GST include)</span> <br>
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
              <td style="font-size: 15px;">
                  <table style="width: 100%;color: #fff;" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <th colspan="2" style="text-align: left; padding: 0px 0px 10px;">INCLUSION</th>
                    </tr>
                    @php
                        $attributes = \Modules\Core\Models\Terms::getTermsById($tour->tour_term->pluck('term_id'));
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
      <td style="color:#000; text-align: center;border-left: 1px solid #000; border-right: 1px solid #000; font-size:13px;"><b>Mo.: +91917823070707</b></td>
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
                 <td><img width="140" src="{{ public_path('uploads/logo.png') }}" /> </td>
               </tr>
               <tr>
                 <td style=" font-size: 15px; padding:100px 0px 0px 25px;color: #888c80;">
                   <p><strong>Dear {{$enquiry->name}}</strong>,</p>
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



</body>

</html>
