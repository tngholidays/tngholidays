<script src="{{ asset('libs/jquery-3.3.1.min.js') }}"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    let $currency = '{{ strtoupper($booking->payment['currency']) }}';
    let $amount = '{{ $booking->payment['amount'] }}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    var options = {
        "key": "{{ $key }}",
        "amount": {{ ($booking->payment['converted_amount'] > 0) ? ($booking->payment['converted_amount'] * 100) :
        $booking->payment['amount'] * 100 }},

        "currency": "{{($booking->payment['converted_currency'] != '') ? strtoupper($booking->payment['converted_currency']) : strtoupper($booking->payment['currency'])}}",

        "name": '{{ setting_item("site_title")." - #".$booking->id }}',
        "description": '{{ setting_item("site_title")." - #".$booking->id }}',
        "image": "",
        "order_id": "{{ $booking->getMeta('razorpay_order_id') }}",
        "handler": function (response){
                let data = response;
                data['_token'] = '{{ csrf_token() }}'
            $.ajax({
                url: '{{ $form_url }}',
                type: 'post',
                data: response,
                datatype: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (msg) {

                    window.location.href = msg;
                }
            });
        },
        "prefill": {
            "name": "{{ $booking->first_name . ' ' . $booking->last_name }}",
            "email": "{{ $booking->email }}",
            "contact": ""
        },
        "notes": {
            "address": ""
        },
        "modal": {
            "ondismiss": function(){
                window.location.replace("{{ $cancelurl }}");
            }
        }
    };
    if($currency != 'INR')
    {
        options['display_amount'] = $amount;
        options['display_currency'] = $currency;
    }
    var rzp1 = new Razorpay(options);
    rzp1.open();
</script>
