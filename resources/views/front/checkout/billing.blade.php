@extends('layouts.frontLayout.front-layout')
@section('content')
<div class="container-fluid grey-back inner-pages">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-12 p-0">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/cart')}}">Cart</a></li>
                        <li class="breadcrumb-item active">Billing Shipping</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4 cart">
    @if(Session::has('flash_message_error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong> {!! session('flash_message_error') !!}
        </div>
    @endif
    <form id="billingShippingform" method="post" autocomplete="off" action="javascript:;">@csrf
        <div class="row">
            <div class="col-md-12 col-12 billing">
                <div class="row">
                    <div class="col-12">
                        <h4 class="orange">Billing Address</h4>
                        <br />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <span>Name :</span>
                        <input type="text" name="billing_name" class="input-style form-control" placeholder="Enter Name" value="{{Auth::user()->name}}" />
                        <p class="err text-center" id="Details-billing_name" style="display: none;"></p>
                    </div>
                    <div class="form-group">
                        <span>Mobile :</span>
                        <input type="number" name="billing_mobile" class="input-style form-control" placeholder="Enter Mobile" value="{{Auth::user()->mobile}}"/>
                        <p class="err text-center" id="Details-billing_mobile" style="display: none;"></p>
                    </div>
                    <div class="form-group">
                        <span>Country :</span>
                        <select class="input-style form-control" name="billing_country">
                            <option value="India">India</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <span>State :</span>
                        <input type="text" class="input-style form-control" name="billing_state" placeholder="Enter State" value="{{Auth::user()->state}}"/>
                        <p class="err text-center" id="Details-billing_state" style="display: none;"></p>
                    </div>
                    <div class="form-group">
                        <span>City :</span>
                        <input type="text" class="input-style form-control" name="billing_city" placeholder="Enter City" value="{{Auth::user()->city}}" />
                        <p class="err text-center" id="Details-billing_city" style="display: none;"></p>
                    </div>
                    <div class="form-group">
                        <span>Postcode :</span>
                        <input type="text" class="input-style form-control" name="billing_postcode" placeholder="Enter Postcode" value="{{Auth::user()->postcode}}"/>
                        <p class="err text-center" id="Details-billing_postcode" style="display: none;"></p>
                    </div>
                    <div class="form-group address">
                        <span>Address Line 1:</span>
                        <textarea class="input-style form-control" name="billing_address" rows="1" placeholder="Enter Adresss line 1...">{{Auth::user()->address}}</textarea>
                        <p class="err text-center" id="Details-billing_address" style="display: none;"></p>
                    </div>
                    <div class="form-group address">
                        <span>Address Line 2:</span>
                        <textarea class="input-style form-control" name="billing_address2" rows="1" placeholder="Enter Adresss line 2...">{{Auth::user()->address2}}</textarea>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <ul class="filter listeeTarget radio">
                            <li>
                                <input type="radio" name="action" value="billing" id="add1" checked>
                                <label for="add1">Use Shipping Address same as Billing Address &nbsp; &nbsp;</label>
                            </li>
                            <li>
                                <input type="radio" value="shipping" name="action" id="add2">
                                <label for="add2">Enter Different Shipping Address</label>
                            </li>
                        </ul>
                        <p class="err text-center" id="Details-action" style="display: none;"></p>
                    </div>
                </div>
            </div>
            <div id="showShipping" style="display: none">
                @include('front.checkout.shipping')
            </div>
            <div class="offset-md-2 col-md-8 col-12 text-center mt-3">
                <div class="alert alert-danger print-error-msg text-center" style="display:none">
                    <ul></ul>
                </div>
                <button type="submit" class="btn-style">Proceed to Checkout</button>
            </div>
        </div>
    </form>
</div>
@stop
@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $(document).on('change','[name=action]',function(){
            var value = $(this).val();
            if(value=="shipping"){
                $('#showShipping').show();
            }else{
                $('#showShipping').hide();
                /*$('#showShipping').find('input:text').val('');  
                $('#showShipping').find('textarea').val('');  */
            }
        });

        $('#billingShippingform').submit(function(e){
            e.preventDefault();
            //$('.PleaseWaitDiv').show();
            var formdata = $("#billingShippingform").serialize();
            $.ajax({
                url: '/save-billing-shipping',
                type:'POST',
                data: formdata,
                success: function(data) {
                    $('.PleaseWaitDiv').hide();
                    if(!data.status){
                        if(data.type=="validation"){
                            $.each(data.errors, function (i, error) {
                                $('#Details-'+i).attr('style', '');
                                $('#Details-'+i).html(error);
                                $('#Details-'+i).addClass('error-triggered');
                                setTimeout(function () {
                                    $('#Details-'+i).css({
                                        'display': 'none'
                                    });
                                }, 3000);
                                $('#Details-'+i).removeClass('error-triggered');
                            });
                            $('html,body').animate({
                                scrollTop: $('.error-triggered').first().stop().offset().top - 200
                            }, 1000);
                        }else{
                            var msg = [];
                            msg[0] = data.errors;
                            printErrorMsg(msg);
                            $('.print-error-msg').delay(3000).fadeOut('slow');
                        }
                    }else{
                        window.location.href="/order-checkout";
                    }
                },
                error:function(){
                    window.location.reload();
                }
            });
        });
    })
</script>
@stop