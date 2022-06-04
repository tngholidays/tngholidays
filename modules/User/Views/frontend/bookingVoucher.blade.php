<!DOCTYPE html>
<html>
<head>
<style type="text/css">
    body {
        font-family: Verdana, Geneva, sans-serif !important
    }
    table {
        border: 0px;
        font-size: 14px;
        padding: 0px;
    }
    td {
        font-size: 15px;
        color: #333;
        line-height: 19px;
    }
    td span {
        font-size: 13px;
        width: 100%;
        color: #999;
        display: block;
    }
    .bdr {
        border-bottom: 1px solid #ddd;
        padding: 8px 0px;
    }
    .page {
        page-break-after: always;
    }
    body {
        background: #f1f1f1;
    }
    .page-header {
        padding-bottom: 10px;
    }
</style>
</head>

<body style="background:#fff;">
<div class="mainStyle" style=" background:#fff;">
  <table cellpadding="0" cellspacing="0" style="width: 100%; background:#fff;">
    <tbody>

    @if(count($rows) > 0)
    @foreach ($rows as $indx => $row)
    <tr>
      <td>
      	<table cellpadding="0" cellspacing="0" border="0" style=" padding-bottom:20px; width:100%;">
          <tbody>
            <tr>
              <td colspan="2" style="background: #aedad5; padding: 5px 20px 5px; vertical-align: middle;"><img width="70" style="display: inline-block; margin-top: 5px;" src="{{ public_path('uploads/SkyredLogo.png') }}" /> <span style="width: 1px; border-left: 1px solid #000; height: 20px;display: inline-block; margin: 0px 10px;"></span>
                <div style="color: #222; font-size: 15px;display: inline-block; width: auto;">Voucher</div></td>
            </tr>
            <tr>
              <td style=" width:400px; padding-left:20px; padding-top: 15px;">
              <table cellpadding="0" cellspacing="0" style="width:100%;">
                  <tr>
                    <td colspan="2" class="bdr" style="padding-bottom: 8px;"><span>{{$row->voucher_type == 1 ? 'Sightseeing' : 'Restaurant'}} Name</span>{{$row->term->name}} </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="bdr" style="padding-top: 8px;padding-bottom: 8px;"><span>Package</span> {{$row->package_details}}</td>
                  </tr>
                  <tr>
                    <td valign="top" style="padding-top: 8px;padding-bottom: 8px;"><span>Lead Person Name</span>@if(!empty($row->name)) {{$row->name}} @else {{$booking->first_name.' '.$booking->last_name}} @endif</td>
                    <td style="padding-top: 8px;"><span>Booking No.</span> #{{$row->booking_id}}</td>
                  </tr>
                  <tr>
                    <td valign="top"><span>Quantity</span>
                       @if(!empty($row->person_types))
                          @foreach($row->person_types as $idx => $type)
                          <p style="width: 100%; font-size: 15px; padding: 0px; margin: 0px; color: #333;">
                              {{$type['type']}} : {{$type['no_of_pax']}}  x Participant
                          </p>
                          @endforeach
                      @endif
                    </td>
                    <td valign="top"><span>Date</span> {{$row->date}}</td>
                  </tr>
                  <tr>
                    <td valign="top"><span>{{$row->voucher_type == 1 ? 'Pickup' : ''}} Time</span>{{$row->time}}</td>
                  </tr>
                  @if(!empty($row->remark))
                  <tr>
                    <td valign="top" style="font-size: 14px; padding-top:15px;" colspan="2"><strong style="color:red;">Remark : </strong>{{$row->remark}}</td>
                  </tr>
                  @endif
                </table>
                </td>
                <?php
                 $img = "";
                if ($row->term->image_id != null) {
                  $img = public_path('uploads/').getImageUrlById($row->term->image_id);
                 }
                ?>
              	<td  align="center" style="color: #999; font-size: 16px; text-align: center; width: auto; padding-top: 15px;">
              		<img width="140px;" src="{{$img}}" />
                	<p style="width: 100%; font-size: 13px; padding: 0px 0px 5px; margin: 0px; color: #999;">Confirmation No.</p>
                	<h2 style="width: 100%; font-size: 15px; padding: 0px; margin: 0px; color: #333;">{{$row->conf_no}}</h2>
                	 <p><img width="120px;" src="{{ public_path('uploads/sign_stamp.png') }}" /></p>
                </td>
             </tr>
            <tr>
              <td colspan="2">
                  <table cellpadding="0" cellspacing="0" style=" width: 100%;">
                      <tbody>
                        <tr>
                          <td style="width: 20px;"><img width="20" src="{{ public_path('uploads/scissor.png') }}" /></td>
                          <td><p style="border-bottom: 1px dashed #eaeaea; width: 100%; height: 1px;">&nbsp;</p></td>
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

  </table>
</div>
</body>
</html>
