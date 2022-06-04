<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page_title ?? 'Dashboard'}} - {{setting_item('site_title') ?? 'Booking Core'}}</title>

    @php
        $favicon = setting_item('site_favicon');
    @endphp
    @if($favicon)
        @php
            $file = (new \Modules\Media\Models\MediaFile())->findById($favicon);
        @endphp
        @if(!empty($file))
            <link rel="icon" type="{{$file['file_type']}}" href="{{asset('uploads/'.$file['file_path'])}}" />
        @else:
        <link rel="icon" type="image/png" href="{{url('images/favicon.png')}}" />
        @endif
    @endif

    <meta name="robots" content="noindex, nofollow" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/flags/css/flag-icon.min.css') }}" rel="stylesheet">
<!-- <script src="{{ asset('js/bootstrap_multiselect.js') }}" ></script> -->
    <link href="{{ asset('dist/admin/css/vendors.css?_ver='.config('app.version')) }}" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    <link href="{{ asset('dist/admin/css/app.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <script src="{{ asset('dist/admin/js/app.js?_ver='.config('app.version')) }}" ></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}" >
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css'>
       <link href="{{ asset('css/dragula.css?_ver='.config('app.version')) }}" rel="stylesheet">

    {!! \App\Helpers\Assets::css() !!}
    {!! \App\Helpers\Assets::js() !!}
    <script>
        var bookingCore  = {
            url:'{{url('/')}}',
            map_provider:'{{setting_item('map_provider')}}',
            map_gmap_key:'{{setting_item('map_gmap_key')}}',
            csrf:'{{csrf_token()}}',
            date_format:'{{get_moment_date_format()}}',
            markAsRead:'{{route('core.admin.notification.markAsRead')}}',
            markAllAsRead:'{{route('core.admin.notification.markAllAsRead')}}',
            loadNotify : '{{route('core.admin.notification.loadNotify')}}',
            pusher_api_key : '{{setting_item("pusher_api_key")}}',
            pusher_cluster : '{{setting_item("pusher_cluster")}}',
            isAdmin : {{is_admin() ? 1 : 0}},
            currentUser: {{(int)Auth::id()}},
        };
        var i18n = {
            warning:"{{__("Warning")}}",
            success:"{{__("Success")}}",
            confirm_delete:"{{__("Do you want to delete?")}}",
            confirm_recovery:"{{__("Do you want to restore?")}}",
            confirm:"{{__("Confirm")}}",
            cancel:"{{__("Cancel")}}",
        };
        var daterangepickerLocale = {
            "applyLabel": "{{__('Apply')}}",
            "cancelLabel": "{{__('Cancel')}}",
            "fromLabel": "{{__('From')}}",
            "toLabel": "{{__('To')}}",
            "customRangeLabel": "{{__('Custom')}}",
            "weekLabel": "{{__('W')}}",
            "first_day_of_week": {{ setting_item("site_first_day_of_the_weekin_calendar","1") }},
            "daysOfWeek": [
                "{{__('Su')}}",
                "{{__('Mo')}}",
                "{{__('Tu')}}",
                "{{__('We')}}",
                "{{__('Th')}}",
                "{{__('Fr')}}",
                "{{__('Sa')}}"
            ],
            "monthNames": [
                "{{__('January')}}",
                "{{__('February')}}",
                "{{__('March')}}",
                "{{__('April')}}",
                "{{__('May')}}",
                "{{__('June')}}",
                "{{__('July')}}",
                "{{__('August')}}",
                "{{__('September')}}",
                "{{__('October')}}",
                "{{__('November')}}",
                "{{__('December')}}"
            ],
        };
    </script>
    <script src="{{ asset('libs/tinymce/js/tinymce/tinymce.min.js') }}" ></script>
       <script src="{{ asset('js/dragula.js?_ver='.config('app.version')) }}" ></script>
    @yield('script.head')

</head>
<body class="{{($enable_multi_lang ?? '') ? 'enable_multi_lang' : '' }} @if(setting_item('site_enable_multi_lang')) site_enable_multi_lang @endif">
<div id="app">
    <div class="main-header d-flex">
        @include('Layout::admin.parts.header')
    </div>
    <div class="main-sidebar">
        @include('Layout::admin.parts.sidebar')
    </div>
    <div class="main-content">
        @include('Layout::admin.parts.bc')
        @yield('content')
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 copy-right" >
                        {{date('Y')}} &copy; {{__('TNG Holidays')}}
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="{{__('https://www.bookingcore.org')}}" target="_blank">{{__('About Us')}}</a>
                            <a href="{{__('https://m.me/bookingcore')}}" target="_blank">{{__('Contact Us')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="backdrop-sidebar-mobile"></div>
</div>

@include('Media::browser')

<!-- Scripts -->
{!! \App\Helpers\Assets::css(true) !!}
<script src="{{ asset('libs/pusher.min.js') }}"></script>
<script src="{{ asset('dist/admin/js/manifest.js?_ver='.config('app.version')) }}" ></script>
<script src="{{ asset('dist/admin/js/vendor.js?_ver='.config('app.version')) }}" ></script>
<script src="{{ asset('js/bootstrap_multiselect.js') }}" ></script>
<script src="{{ asset('dist/admin/js/app.js?_ver='.config('app.version')) }}" ></script>
<script type="text/javascript" src="{{ asset("libs/daterange/moment.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("libs/daterange/daterangepicker.min.js") }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}" ></script>
<script src="{{ asset('libs/bootbox/bootbox.min.js') }}"></script>
 


{!! \App\Helpers\Assets::js(true) !!}

@yield('script.body')

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
    $(".timepicker").datetimepicker({
        format: "LT",
        useCurrent: false, 
        ignoreReadonly: true,
        debug:false,
        icons: {
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down"
        }
    });
});
$('.datePicker').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
});
$(document).ready(function(){


 function refresh(time) {
     if(new Date().getTime() - time >= 60000) 
         window.location.reload(true);
     else 
         setTimeout(refresh, 10000);
 }
 var route = "{{Route::currentRouteName()}}";
 var time = new Date().getTime();
 $(document.body).bind("mousemove keypress", function(e) {
     time = new Date().getTime();
 });
    if(route == 'Lead.admin.index'){
        setInterval(function() {
            refresh(time);
            console.log(time);
        }, 10000); 
        
    }
});
$(document).on('click', '.has-datetimepicker', function(){
    $(this).daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        showCalendar: false,
        autoUpdateInput: false, //disable default date
        sameDate: true,
        autoApply           : true,
        disabledPast        : true,
        enableLoading       : true,
        showEventTooltip    : true,
        classNotAvailable   : ['disabled', 'off'],
        disableHightLight: true,
        timePicker24Hour: true,

        locale:{
            format:'YYYY/MM/DD HH:mm:ss'
        }
    }).on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm:ss'));
    }).focus();
    $(this).removeClass('has-datetimepicker');
});

</script>
<!-- <script src='https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js'></script> -->
<script src='https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js'></script>

</body>
</html>
