@extends('layouts.frontLayout.front-layout')
@section('content')
<style>
   .privacy-policy-content p{
   color: #333!important;
   font-size: 15px!important;
   font-family: inherit!important;
   font-weight: 400!important;
   }
   #cms_content ul  { margin-bottom:20px; }
   #cms_content ul li { margin-left:50px;list-style: disc; }
</style>
<div class="container policy-divs">
   <div class="row">
      <!-- <div class="col-lg-12 mb-3">
         <ol class="breadcrumb p-0">
         	<li><a href="{{ url('/') }}">Home&nbsp;/&nbsp;</a></li>
         	<li class="active">Return & Refund Policy</li>
         </ol>
         </div> -->
      <div class="col-lg-12 policy-padding privacy-policy-content" id="cms_content">
         <h3 class="">Return & Exchange Policy</h3>
         <hr>
         <p>At Rage, we want you to love every purchase. If something doesn’t feel right, you can initiate a <strong>Return or Exchange within 24–48 hours of delivery</strong> for eligible orders placed on <strong>regular (non-sale) days</strong>, for both Prepaid and COD purchases.</p>
         <p>This Exchange and Return policy applies exclusively to products purchased through our official website.</p>
		 <p><b>Important Notice – Sale Period Orders</b></p>
         <p>Orders placed during <strong>sale or promotional periods</strong> are <strong>not eligible for returns</strong>.
            However, <strong>exchanges are permitted</strong> during sale periods, subject to stock availability and successful quality checks.
         <p><b>Eligibility for Return & Exchange</b></p>
         <ul>
            <li> Request must be raised within <b>24–48 hours of delivery</b>.</li>
            <li> Product must be <b>unused, unwashed, and in original packaging with all tags intact</b>.</li>
            <li> <b>During sale periods, only exchanges are allowed</b>.</li>
            <li> Items marked as <b>Non-Returnable </b> are not eligible for return or exchange.</li>
            <li> If you receive a defective, damaged, or incorrect item, a <b>free replacement</b> will be arranged.</li>
            <li> If the requested exchange item is unavailable in stock, the <b>full amount will be refunded to the customer</b>.</li>
         </ul>
         <p><b>For Prepaid Orders</b></p>
         <ul>
            <li> On regular days, refunds will be processed to the <b>original payment method</b> after quality checks.</li>
            <li> During sale periods, <b>no returns are applicable; exchange only</b>.</li>
            <li> If an exchange cannot be fulfilled due to stock unavailability, the <b>refund will be processed to the original payment method</b>.</li>
         </ul>
         <p><b>For COD Orders</b></p>
         <ul>
            <li> On <b>regular days</b>, returns and exchanges are available.</li>
            <li> Refunds for COD orders will be <b>processed as per the original payment received</b> after quality checks.</li>
            <li> During sale periods, <b>returns are not applicable; exchange only</b>.</li>
            <li> If the exchange item is unavailable, the <b>refund will be processed as per applicable procedures</b>.</li>
         </ul>
         <p><b>Pickup & Processing</b></p>
         <ul>
            <li> A <b>reverse pickup</b> will be arranged once your request is approved.</li>
            <li> If pickup is unavailable in your area, you may be requested to <b>self-ship</b> the product.</li>
            <li> Items that fail quality checks will be shipped back to the customer.</li>
         </ul>
         <p><b>Need Assistance?</b></p>
         <p>For any enquiries, please mail us at <a href="mailto:rageindiaonline@gmail.com">rageindiaonline@gmail.com</a></p>
      </div>
   </div>
</div>
@stop