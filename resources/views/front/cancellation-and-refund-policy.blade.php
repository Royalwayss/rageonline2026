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
         <h3 class="">Cancellation & Refund Policy</h3>
         <hr>
         <p>At <strong>Rage</strong>, we strive to offer a smooth and transparent shopping experience. Please review our Cancellation & Refund Policy below:</p>
         <p><b>Order Cancellation</b></p>
         <ul>
            <li>Orders can be <strong>cancelled within 24 hours</strong> of purchase.</li>
            <li>After 24 hours, cancellation requests cannot be accepted as the order may already be processed or dispatched. </li>
         </ul>
         <p><b>Refund & Voucher Terms</b></p>
         <ul>
            <li>
               <strong>All orders cancelled with a value below or equal to ₹2000</strong> will be either:
               <ul>
                  <li>Refunded to the <strong>user’s original account of transaction, or </strong></li>
                  <li>Issued as a Rage Discount Voucher of equivalent value within <strong>7 working days</strong> via email.
                     All voucher terms & conditions will remain valid and applicable at all times. 
                  </li>
               </ul>
            </li>
            <li><strong>All orders cancelled with a value above ₹2000 will be refunded directly to the user’s original account of transaction.</strong></li>
         </ul>
         <p><b>Platform Safety & Verification</b></p>
         <ul>
            <li>Rage reserves the right to <strong>cancel any order</strong> placed using a <strong>Credit Card with an International Billing Address</strong>, or any order that appears <strong>dubious, suspicious, or invalid</strong> in probity.</li>
         </ul>
         <p><b>Need Assistance?</b></p>
         <p>For any enquiries please mail us at <a href="mailto:rageindiaonline@gmail.com">rageindiaonline@gmail.com</a></p>
      </div>
   </div>
</div>
@stop