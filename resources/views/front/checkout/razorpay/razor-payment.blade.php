@extends('layouts.frontLayout.front-layout')
@section('content')
<!-- <p>Please wait...</p> -->


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    $('.PleaseWaitDiv').show();
    function demoSuccessHandler(transaction) {
        // You can write success code here. If you want to store some data in database.
        $.ajax({
            method: 'post',
            url: "{!!route('dopayment')!!}",
            data: {
                "_token": "{{ csrf_token() }}",
                "razorpay_payment_id": transaction.razorpay_payment_id,
                "data" :transaction
            },
            complete: function (r) {
                $('.PleaseWaitDiv').hide();
                if(r.status){ 
                    window.location.href = "{{url('/thanks')}}";
                }else{
                    window.location.href = "{{url('/')}}";
                }
            }
        })
    }
</script>
<script>
    var options = {
        key: "{{ $RAZORPAY_KEY }}",
        name: 'RageOnline',
        description: 'RageOnline Order Payment',
        order_id: "<?php echo $orderid;?>",
        capture:1,
		"image": "{{ asset('images/logo.png') }}",
        handler: demoSuccessHandler,
        prefill: {
            "name": "{{Auth::user()->name}}",
            "email": "{{Auth::user()->email}}",
            "contact": "{{Auth::user()->mobile}}"
        },
        modal: {
            "ondismiss": function(){
                window.location.href = "{{url('/cancel')}}";
            }
        }
    }
</script>
<script>
    window.r = new Razorpay(options);
   r.open();
</script>
@stop