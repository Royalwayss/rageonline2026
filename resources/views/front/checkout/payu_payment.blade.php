@extends('layouts.frontLayout.front-layout')
@section('content')
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="myacc-panel mt-5 mb-5">
                    <div class="row" style="margin-top:80px">
                        <div class="col text-center">
                            <img src="{{ asset('images/loader.gif')}}" width="50%" class="img-fluid" alt="" title="" />
                            <h4 class="gateway">Please wait...<br />You are being redirected to Payment Gateway</h4>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>
<script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() 
    {
        if(hash == '') {
            return;
        }
        var payuForm = document.forms.payuForm;
        setTimeout(function(){
            payuForm.submit();
        }, 500);
    }
</script>
<form action="<?php echo $action; ?>" method="post" name="payuForm" id="payuForm">
    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
    <input type="hidden" name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" />
    <input type="hidden" name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" />
    <input type="hidden" name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" />
    <input type="hidden" name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" />
    <input type="hidden" name="productinfo" value="<?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?>" size="64" />
    <input type="hidden" name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" />
    <input type="hidden" name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" />
    <input type="hidden" name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" />
    <input type="hidden" name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" />
    <input type="hidden" name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" />
    
    <input type="hidden" name="surl" value="<?php echo (empty($posted['surl'])) ? '' : $posted['surl'] ?>" size="64" />
    <input type="hidden" name="curl" value="<?php echo (empty($posted['curl'])) ? '' : $posted['curl'] ?>" />
    <input type="hidden" name="furl" value="<?php echo (empty($posted['furl'])) ? '' : $posted['furl'] ?>" size="64" />
</form>
<script language="JavaScript" type="text/javascript">
    window.onload=submitPayuForm();
</script>
@stop