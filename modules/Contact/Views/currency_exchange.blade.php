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
.select2-container {
    display: inherit!important;
}
.input-error {
    border-color: #d03e3e !important;
    color: #d03e3e !important;
}
.GetForexCountry {
    margin: auto;
    border: 2px solid hsl(220deg 75% 70%);
    border-radius: 4px;
}
.nav-tabs .nav-item {
    margin-bottom: 0px;
    width: 50%;
    text-align: center;
}
.nav-tabs {
    border-bottom: 0px solid #dee2e6;
}
.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    color: #495057;
    background-color: #fff;
    border-color: #ffffff #ffffff #fff;
    border-bottom: 2px solid #15c3a8;
    color: #14c5a4;
}
.nav-tabs .nav-link {
    color: #000;
}
.nav-tabs .nav-link:hover, .nav-tabs .nav-link:focus {
    border-color: #ffffff #ffffff #ffffff;
    border-bottom: 2px solid #15c3a8;
}
span.select2.select2-container {
    width: 100% !important;
    float: left;
}
.select2-container--default .select2-selection--single {
    background-color: #f8f8f8;
    border: 1px solid #aaa;
    border-radius: 4px;
    height: 50px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 49px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 49px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
}
.form-section { width: 100%; float:left; padding: 15px 0px 0px 0px;}
</style>
<div id="bravo_content-wrapper">
    <div class="bravo-contact-block">
        <div class="container">
            <div class="row section">
                <div class="col-md-6 GetForexCountry">
                    @if(session()->has('success'))
                        <div class="alert alert-success"><strong>Success!</strong>{{ session()->get('success') }}</div>
                    @endif
                    <div class="">
                        <div role="form" class="form_wrapper enquiryForm" lang="en-US" dir="ltr">
                            <form class="registration-form-forex" id="registration-form-forex" action="{{ route('forex.forexStore') }}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" id="remove_1" value="0" />
                                <input type="hidden" name="forex_data" id="forex_data" value="" />
                                <input type="hidden" name="type" id="forex_type" value="buy" />
                                <!-- <div class="cardbox"> -->
                                <?php $getForexCountry = getForexCountry(); ?>
                                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link switchTab active" id="buy_tab" data-toggle="tab" href="#buy_form" role="tab" aria-controls="buy" aria-selected="true">Buy Forex</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link switchTab" id="sell_tab" data-toggle="tab" href="#sell_form" role="tab" aria-controls="sell" aria-selected="false">Sell Forex</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="buy_form" role="tabpanel" aria-labelledby="buy">
                                        <div class="form-section" id="buyForm">
                                            <h3 class="text-center">Buy Forex</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Currency You Have</label>
                                                            <select class="form-control select2 sell_currency" name="buy[sell_currency]">
                                                                <option value="IND" selected>India</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Currency You Want</label>
                                                            <select class="form-control required select2 buy_currency getForexRate" name="buy[buy_currency]">
                                                                <option value="">Select Currency</option>
                                                                @foreach($getForexCountry as $country )
                                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Pay Type</label>
                                                    <select class="form-control required pay_type" name="buy[pay_type]">
                                                        <option value="">Select Pay Type</option>
                                                        <option value="Forex">Forex</option>
                                                        <option value="Cash">Cash</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Forex Amount</label>
                                                    <div class="forexAmtDiv">
                                                        <input type="text" name="buy[forex_amount]" placeholder="Enter Forex Amount" class="form-control required forex_amount" />
                                                        <div class="rateDiv">Rate <i class="fa fa-rupee"></i> <span class="forex_rate_text">0.00</span></div>
                                                    </div>
                                                    <input type="hidden" name="buy[forex_rate]" placeholder="Enter Forex Amount" class="form-control forex_rate" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Forex Amount</label>
                                                    <input type="text" name="buy[inr_amount]" placeholder="Enter INR Amount" class="form-control required inr_amount" />
                                                    <input type="hidden" class="inr_amountTemp" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="sell_form" role="tabpanel" aria-labelledby="sell">
                                        <div class="form-section" id="sellForm">
                                            <h3 class="text-center">Sell Forex</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Currency You Have</label>
                                                            <select class="form-control required select2 sell_currency getForexRate" name="sell[sell_currency]">
                                                                <option value="">Select Currency</option>
                                                                @foreach($getForexCountry as $country )
                                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Currency You Want</label>
                                                            <select class="form-control select2 buy_currency" name="sell[buy_currency]">
                                                                <option value="IND" selected>India</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Pay Type</label>
                                                    <select class="form-control required pay_type" name="sell[pay_type]">
                                                        <option value="">Select Pay Type</option>
                                                        <option value="Forex">Forex</option>
                                                        <option value="Cash">Cash</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Forex Amount</label>
                                                    <div class="forexAmtDiv">
                                                        <input type="text" name="sell[forex_amount]" placeholder="Enter Forex Amount" class="form-control required forex_amount" />
                                                        <div class="rateDiv">Rate <i class="fa fa-rupee"></i> <span class="forex_rate_text">0.00</span></div>
                                                    </div>
                                                    <input type="hidden" name="sell[forex_rate]" placeholder="Enter Forex Amount" class="form-control forex_rate" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Forex Amount</label>
                                                    <input type="text" name="sell[inr_amount]" placeholder="Enter INR Amount" class="form-control required inr_amount" />
                                                    <input type="hidden" class="inr_amountTemp" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mob-text-center">
                                            <button type="button" class="btn btn-primary btn-xs addProduct">Add <span class="mobile_hide">Product</span></button>
                                        </div>
                                        <div class="col-md-12 mob-text-center">
                                            <div id="order-summary-tables" style="display: none;">
                                                <table class="col-sm-12 table-condensed cf">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th class="currency_text">Currency</th>
                                                            <th class="product_text">Product</th>
                                                            <th class="forex_text">Forex Amount</th>
                                                            <th class="inr_amount_text">INR Amount</th>
                                                            <th class="action_text">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbodyList"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="total_amount">
                                                <i class="sprite_img cart_icon"></i>
                                                <span>
                                                    <span class="total_text">Total Amount</span>
                                                    <span class="total_rate_text"><i class="fa fa-rupee"></i><span class="buysell-order_total">0.00</span></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Modal -->
                                            <div class="modal fade" id="forexModal" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group col-md-12">
                                                                <label class="control-label">Full Name</label>
                                                                <input type="text" name="name" placeholder="Enter Full Name" class="form-control required" />
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label class="control-label">Mobile No.</label>
                                                                <input type="text" name="phone" placeholder="Enter Mobile No." class="form-control required" />
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-default submitNow">Continue</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn btn-primary btn-sm forexFormSubmit">Submit Now</button>
                                    </div>
                                </div>
                                <div class="form-mess"></div>
                            </form>
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
$(document).ready(function() { 
 $(".select2").select2({dropdownAutoWidth : true});
});
jQuery(document).on("click", ".addProduct", function (e, params) {
        
   var type = $('.nav-item .active').attr('aria-controls');
   if(type == 'sell'){
       var form = $("#sell_form");
       var forex_curreny_text = $(form).find(".sell_currency option:selected" ).text();
       var forex_curreny = $(form).find('.sell_currency').val();

   }else{
       var form = $("#buy_form");
       var forex_curreny_text = $(form).find(".buy_currency option:selected" ).text();
       var forex_curreny = $(form).find('.buy_currency').val();
   }
   var flag = true;
    $(form).find('.required').each(function () {
        if ($(this).val() == "") {
            $(this).addClass('input-error');
            flag = false;
        } else {
            $(this).removeClass('input-error');
        }
    });
    $('.table-condensed .tbodyList tr').each(function () {
        var country_id = $(this).find('.country_id').data('id');
        if (country_id == forex_curreny) {
            alert('country all ready added');
            flag = false;
            return false;
        } 
    });
    if (flag == false) {
        return false;
    }
    

    var type = $('.nav-item .active').attr('aria-controls');
   var sell_currency = $(form).find('.sell_currency').val();
   var buy_currency = $(form).find('.buy_currency').val();
   $('option:selected', this).attr('mytag');
   var pay_type = $(form).find('.pay_type').val();
   var pay_type_text = $(form).find(".pay_type option:selected" ).text();
   var forex_rate = $(form).find('.forex_rate').val();
   var forex_amount = $(form).find('.forex_amount').val();
   var inr_amount = $(form).find('.inr_amount').val();
   var cnt = $('.table-condensed .tbodyList tr').length + 1;
    cnt = parseInt(cnt);

     var content = '<td class="country_id" data-id="'+forex_curreny+'">'+forex_curreny_text+'('+type+')<input type="hidden" name="forex_order['+cnt+'][type]" value="'+type+'" /><input type="hidden" name="forex_order['+cnt+'][country_id]" value="'+forex_curreny+'" /></td>';
     content += '<td>'+pay_type_text+'<input type="hidden" name="forex_order['+cnt+'][pay_type]" value="'+pay_type+'" /></td>';
     content += '<td>'+forex_amount+'<input type="hidden" name="forex_order['+cnt+'][forex_amount]" value="'+forex_amount+'" /></td>';
     content += '<td class="inr_amount_text"> <span class="price"> <i class="fa fa-rupee"></i><span class="totalRate">'+inr_amount+'</span></span> <span class="ratetxt"> Rate: <i class="fa fa-rupee"></i><span class="rateText">'+forex_rate+'</span></span> <input type="hidden" class="inr_amount" name="forex_order['+cnt+'][inr_amount]" value="'+inr_amount+'" /> <input type="hidden" class="forex_rate" name="forex_order['+cnt+'][forex_rate]" value="'+forex_rate+'" /> </td>';
     content += '<td class="action_text"> <button type="button" class="btn btn-success btn-xs removeRow" title="remove"><i class="fa fa-trash"></i></button> </td>';
     var row = $('<tr>'+content+'</tr>');
     $('.table-condensed .tbodyList').append(row);
    
    $('#order-summary-tables').show();
    var totalInr = 0;
    $('.table-condensed .tbodyList tr').each(function () {
        var inr_amount = $(this).find('.inr_amount').val()||0;
        totalInr += parseFloat(inr_amount);
    });
    $('.buysell-order_total').text(totalInr.toFixed(2));
    $(form).find('.forex_amount').val('');
    $(form).find('.inr_amount').val('');
    
});
jQuery(document).on("keyup", ".forex_amount", function (e, params) {
    var type = $('.nav-item .active').attr('aria-controls');
    if(type == 'sell'){
        var form = $("#sell_form");
    }else{
        var form = $("#buy_form");
    }

     var rates = $(form).find('.forex_rate').val()||0;
    var thisValue = $(this).val()||0;
    var inrAmt = parseFloat(thisValue)*parseFloat(rates);
    $(form).find('.inr_amount').val(inrAmt.toFixed(2));
    var trlenght = $('.table-condensed .tbodyList tr').length;
    if(trlenght < 1){
        $('.buysell-order_total').text(inrAmt.toFixed(2));
    }
    
    
});

jQuery(document).on("keyup", ".inr_amount", function (e, params) {
    var type = $('.nav-item .active').attr('aria-controls');
    if(type == 'sell'){
        var form = $("#sell_form");
    }else{
        var form = $("#buy_form");
    }
     var thisValue = $(this).val()||0;
     var rates = $(form).find('.forex_rate').val()||0;
     console.log(rates);
     forex_amount = parseFloat(thisValue) / parseFloat(rates);
      console.log(forex_amount);
     forex_amount = Math.round(forex_amount);
      console.log(forex_amount);
     $(form).find('.forex_amount').val(forex_amount);
    var inrAmt = parseFloat(forex_amount)*parseFloat(rates);
    $(form).find('.inr_amountTemp').val(inrAmt.toFixed(2));
    if (e.type == 'blur') {
        myFunction();
    }
    console.log(inrAmt);
});
jQuery(document).on("blur", ".inr_amount", function (e, params) {
    var type = $('.nav-item .active').attr('aria-controls');
    if(type == 'sell'){
        var form = $("#sell_form");
    }else{
        var form = $("#buy_form");
    }
    var inrAmt = $(form).find('.inr_amountTemp').val();
    $(form).find('.inr_amount').val(inrAmt);
});
 jQuery(document).on("click", ".removeRow", function (e, params) {
     $(this).closest('tr').remove();
 });
 jQuery(document).on("click", ".switchTab", function (e, params) {
     var type = $(this).attr('aria-controls');
     $('#forex_type').val(type);
 });
jQuery(document).on("change", ".getForexRate", function (e, params) {
    var id = this.value;
    jQuery.ajax({
        url: '{{route("forex.getForexRate")}}',
        type : "POST",
        dataType : "JSON",
        data:{'id':id},
        success: function(result){
          $('#forex_data').val(JSON.stringify(result));
          var type = $('.nav-item .active').attr('aria-controls');
            if(type == 'sell'){
                var form = $("#sell_form");
                var forex_rate_card = result.sell_card;
                var forex_rate_cash = result.sell_cash;
            }else{
                var form = $("#buy_form");
                var forex_rate_card = result.buy_card;
                var forex_rate_cash = result.buy_cash;
            }
            $(form).find('.forex_rate_text').text(forex_rate_card);
            $(form).find('.forex_rate').val(forex_rate_card);
          console.log(result);
    }});
  });
jQuery(document).on("click", ".forexFormSubmit", function (e, params) {
    
    e.preventDefault();
    $('#forexModal').modal('show');
    
    // e.preventDefault();
    // var form = $('#registration-form-forex')[0];
    // jQuery.ajax({
    //     type: "POST",
    //     dataType: "JSON",
    //     url: "{!! route('forex.forexStore')!!}",
    //     data: new FormData(form),
    //     contentType: false,
    //     cache: false,
    //     processData: false,
    //     success: function (data) {
    //         // jQuery(".loading-all").hide();
    //         // jQuery("#submit").attr("disabled", false);
    //         // if (data == 1) {
    //         //     alert("IPD Requested Successfully");
    //         //     location.reload();
    //         // } else if (data == 3) {
    //         //     alert("This Patient is already in IPD");
    //         // } else {
    //         //     alert("System Problem");
    //         // }
    //     },
    // });

});
</script>
@endsection
