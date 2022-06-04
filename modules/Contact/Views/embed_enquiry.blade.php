<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
         <link rel="stylesheet" type="text/css" href=" {{ asset('libs/daterange/daterangepicker.css?_ver='.config('app.version')) }}">
<style>
 iframe { width: 100%; float: left; height: 100%; }

            .InquiryFrom {
                width: 100%;
                float: none;
                padding: 0px;
                margin: 0px auto;
            }
            .InquiryFrom {
            
                background: #ffffff;
                box-shadow: 0px 7px 14px 0px #dadada;
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
            .UsserImgTop {
    text-align: center;
}
.UsserImgTop img { width: 100px;}
            .md-form p {
    width: 70%;
    float: left;
    padding: 5px 0px 0px 16px;
    margin: 0px;
    font-size: 14px;
}
            .md-form p label.form-check-label input {
                height: auto;
                width: auto;
                margin-right: 3px;
            }
            .md-form p label.form-check-label {
                width: auto;
                float: left;
                padding: inherit;
                margin: inherit;
                margin-right: 10%;
            }
            .stepsDiv {
    width: 201px;
    float: none;
    padding: 10px 0px 0px 0px;
    margin: auto;
    display: table;
}
           .stepsDivNum {
    width: 169px;
    float: left;
    padding: 0px;
    position: relative;
}
            .stepsDivNum span {
                width: 30px;
                height: 30px;
                border: 2px solid #0d2949;
                border-radius: 50%;
                text-align: center;
                float: left;
                padding-top: 0px;
            }
            .stepsDivNum:after {
    content: "";
    position: absolute;
    height: 2px;
    width: 79%;
    background: #0d2949;
    top: 14px;
    right: 2px;
}
            .stepsDivNum.last:after {
                content: "";
                position: absolute;
                height: 2px;
                width: 71%;
                background: #0d2949;
                top: 12px;
                right: 2px;
                display: none;
            }
            .stepsDivNum.last {
                width: auto;
            }
            .stepsDivNum.Active span {
                width: 30px;
                height: 30px;
                border: 2px solid #0aadbd;
                border-radius: 50%;
                text-align: center;
                float: left;
                padding-top: 7px;
                color: #fff;
                background: #0aadbd;
            }
            .stepsDivNum.Active:after {
    content: "";
    position: absolute;
    height: 2px;
    width: 79%;
    background: #0aadbd;
    top: 14px;
    right: 2px;
}
.form-group.md-form .btn.btn-next {
    color: #fff;
    background-color: #0062cc;
    border-color: #005cbf;
}
.btn.btn-previous {
    color: #fff;
    background-color: #0062cc;
    border-color: #005cbf;
}
.btn.btn-primary {
    color: #fff;
    background-color: #0062cc;
    border-color: #005cbf;
}
.enquiryForm input[type="text"],
.enquiryForm input[type="email"],
.enquiryForm input[type="number"],
.enquiryForm input[type="date"],
.enquiryForm select.form-control {
    height:50px;
    margin:0;
    padding:10px 20px;
    vertical-align:middle;
    background:#f8f8f8;
    border:2px solid #ddd;
    font-family:'Roboto', sans-serif;
    font-size:16px;
    font-weight:300;
    line-height:50px;
    color:#888;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border-radius:4px;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    box-shadow:none;
    -o-transition:all .3s;
    -moz-transition:all .3s;
    -webkit-transition:all .3s;
    -ms-transition:all .3s;
    transition:all .3s;
}
.enquiryForm button.btn {
    height:50px;
    margin:0;
    padding:0 20px;
    vertical-align:middle;
    background:#0751c9;
    border:0;
    font-family:'Roboto', sans-serif;
    font-size:16px;
    font-weight:300;
    line-height:50px;
    color:#fff;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border-radius:4px;
    text-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    box-shadow:none;
    -o-transition:all .3s;
    -moz-transition:all .3s;
    -webkit-transition:all .3s;
    -ms-transition:all .3s;
    transition:all .3s;
}
.enquiryForm button.btn:hover {
    opacity:0.6;
    color:#fff;
}
.enquiryForm button.btn:active {
    outline:0;
    opacity:0.6;
    color:#fff;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    box-shadow:none;
}
/***** Top content *****/

.enquiryForm .form-top p{margin:0px;}
.enquiryForm {
    margin: 10px;
    padding: 15px;
    background:#eee;
    -moz-border-radius:0 0 4px 4px;
    -webkit-border-radius: 0 0 4px 4px;
    border-radius:0 0 4px 4px;
    text-align:left;
    transition:all .4s ease-in-out;
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
        </style>

        <div class="container-flude">
                <div role="form" class="form_wrapper InquiryFrom InquiryFromBlock" lang="en-US" dir="ltr">
                    <div class="enquiryForm">
                        <div class="UsserImgTop">
                             @if( !empty($logo = setting_item('logo_invoice_id') ?? setting_item('logo_id') )) <img width="70" src="{{get_file_url( $logo ,"full")}}" alt="{{setting_item("site_title")}}"> @endif
                        </div>
                        <form class="registration-form bravo-contact-block-form" action="{{ route('enquiry.store') }}" method="post">
                            {{csrf_field()}}
                            <div class="stepsDiv">
                                <div class="stepsDivNum" id="firstStep">
                                    <span>1</span>
                                </div>
        
                                <div class="stepsDivNum last" id="lastStep">
                                    <span>2</span>
                                </div>
                            </div>
                            <fieldset>
                                <div class="form-bottom">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text" name="name" placeholder="Enter Name" class="form-control required" id="name" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="text" name="email" placeholder="Enter Email" class="form-email form-control" id="email" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Phone Number</label>
                                        <input type="Number" min="0" minlength="10" maxlength="10" name="phone" class="form-control required" placeholder="Enter Phone Number" id="contact_number" required />
                                    </div>
                                    <div class="form-group md-form">
                                        <button type="button" class="btn btn-next btn-primary">Next</button>
                                        <p>
                                            <label class="form-check-label" for="defaultCheck1">
                                                <input class="form-check-input" type="checkbox" name="enquiry_type" value="0" id="defaultCheck1" checked="" />
                                                Tour
                                            </label>

                                            <label class="form-check-label" for="defaultCheck1">
                                                <input class="form-check-input" type="checkbox" name="enquiry_type" value="1" id="defaultCheck1" />
                                                Farm House
                                            </label>
                                        </p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset style="display: none;">
                                <div class="form-bottom">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <input type="text" name="city" placeholder="Enter City" class="form-control required"  />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Date</label>
                                        <input type="text" name="date" placeholder="Select Date" class="form-email datePicker form-control required" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">No of Person</label>
                                        <input type="Number" min="0" minlength="10" maxlength="10" name="num_of_person" class="form-control required" placeholder="Enter No of Person" />
                                    </div>
                                    <button type="button" class="btn btn-previous">Previous</button>
                                    <button class="btn btn-primary submit" type="button">
                                        {{ __('Submit') }}
                                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    </button>
                                </div>
                            </fieldset>
                            <fieldset style="display: none;">
                                <div class="form-bottom">
                                    <div class="form-group">
                                        <label class="control-label">Destination</label>
                                        <select class="form-control required" name="destination">
                                            <option value="">Select Destination</option>
                                            @if(count($locations) > 0) @foreach($locations as $location )
                                            <option value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Duration</label>
                                        <select class="form-control required" name="duration">
                                            <option value="">Select Duration</option>
                                            @if(count($terms) > 0) @foreach($terms as $term )
                                            <option value="{{$term->id}}">{{$term->name}}</option>
                                            @endforeach @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">No. of Pax.</label>
                                        <table class="table">
                                            <tbody>
                                                <?php $person_types = array('Adult','Child','Kid'); ?>
                                                @foreach($person_types as $key=>$person_type)
                                                <tr>
                                                    <td>{{$person_type}}</td>
                                                    <td>
                                                        <input type="hidden" name="person_types[{{$key}}][name]" class="form-control" value="{{$person_type}}" readonly />
                                                        <input type="number" min="0" class="form-control" name="person_types[{{$key}}][number]" placeholder="Enter No. of Pax." @if($person_type=="Adult") required @endif>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Approx. Date</label>
                                        <input type="text" class="form-control datePicker required" name="approx_date" placeholder="Approx. Date" readonly />
                                    </div>
                                    
                                    <button style="margin-bottom: 60px;" type="button" class="btn btn-previous">Previous</button>
                                    <button style="margin-bottom: 60px;" class="btn btn-primary submit" type="button">
                                        {{ __('Submit') }}
                                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    </button>
                                </div>
                            </fieldset>
                            <div class="form-group recaptcha_field">
                                                                {{recaptcha_field('contact')}}
                                                        </div>
                            <div class="form-mess"></div>
                        </form>
                    </div>
                    
                    
                </div>
        </div>
<script type="text/javascript" src="{{ asset('libs/daterange/moment.min.js?_ver='.config('app.version')) }}"></script>
<script type="text/javascript" src="{{ asset('libs/daterange/daterangepicker.min.js?_ver='.config('app.version')) }}"></script>
    <script>
$(function() {
    $('.datePicker').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            cancelLabel: 'Clear',
            format: 'DD/MM/YYYY'
        }
    });
});
$('.datePicker').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
});
</script>
<script>
    $(document).ready(function () {
  $('.registration-form fieldset:eq(0)').fadeIn('slow');
});
var onSubmitContact = false;
//Contact box
$('.bravo-contact-block-form').submit(function (e) {
    e.preventDefault();
    if (onSubmitContact) return;
    $(this).addClass('loading');
    var me = $(this);
    me.find('.form-mess').html('');
    $.ajax({
        url: me.attr('action'),
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (json) {
            onSubmitContact = false;
            me.removeClass('loading');
            if (json.message) {
                me.find('.form-mess').html('<span class="' + (json.status ? 'text-success' : 'text-danger') + '">' + json.message + '</span>');
            }
            if (json.status) {
                me.find('input').val('');
                me.find('textarea').val('');
            }
            if (json.status == 1) {
                $('#firstStep').removeClass('Active');
                $('#firstStep').find('span').html('1');
                $('.stepsDiv').fadeOut();
                $('.recaptcha_field').fadeOut();
                
                 $('.registration-form fieldset').fadeOut();
                 $('.registration-form fieldset').fadeOut();
                 setTimeout(function(){ location.reload(); }, 3000);
            }
        },
        error: function (e) {
            console.log(e);
            onSubmitContact = false;
            me.removeClass('loading');
            if(parseErrorMessage(e)){
                me.find('.form-mess').html('<span class="text-danger">' + parseErrorMessage(e) + '</span>');
            }else
            if (e.responseText) {
                me.find('.form-mess').html('<span class="text-danger">' + e.responseText + '</span>');
            }
        }
    });
    return false;
});
$(document).ready(function () {

  $('.registration-form input[type="text"]').on('focus', function () {
      $(this).removeClass('input-error');
  });
  $('.registration-form input[type="number"]').on('focus', function () {
      $(this).removeClass('input-error');
  });
   $('.registration-form .form-check-input').on('change', function () {
    $('.form-check-input').prop("checked",false);
    $(this).prop("checked",true);
 });
  // next step
  $('.registration-form .btn-next').on('click', function () {
      var parent_fieldset = $(this).parents('fieldset');
      var next_step = true;

      parent_fieldset.find('.required').each(function () {
          if ($(this).val() == "") {
              $(this).addClass('input-error');
              next_step = false;
          } else {
              $(this).removeClass('input-error');
          }
      });
      var type = $('.form-check-input:checked').val();
      if (next_step) {
          parent_fieldset.fadeOut(400, function () {
            $('#firstStep').addClass('Active');
            var imgPath = "{{ asset('uploads/right-icon-1.png') }}";
            var img = '<img width="15" src="'+imgPath+'" />'
            $('#firstStep').find('span').html(img);
              if (type == 0) {
                     $('.registration-form fieldset:eq(2)').fadeIn('slow');
                }else{
                  $(this).next().fadeIn();
                }
          });
      }

  });

  // previous step
  $('.registration-form .btn-previous').on('click', function () {
      $(this).parents('fieldset').fadeOut(400, function () {
         // $('#firstStep').removeClass('Active');
         $('#firstStep').find('span').html('1');
         $('.registration-form fieldset:eq(0)').fadeIn('slow');
      });
  });
    $('.registration-form .submit').on('click', function (e) {
        var parent_fieldset = $(this).parents('fieldset');
        var flag = true;
        parent_fieldset.find('.required').each(function () {
            if ($(this).val() == "") {
                $(this).addClass('input-error');
                flag = false;
            } else {
                $(this).removeClass('input-error');
            }
        });
        if (flag == true) {
            $('.registration-form').submit();
        }
      });
});
</script>
        @php \App\Helpers\ReCaptchaEngine::scripts() @endphp