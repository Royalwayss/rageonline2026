@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
    .form-control-feedback {
      top: 9px !important;
    }
</style>
<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/ckeditor.js')!!}"></script>
<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/adapters/jquery.js')!!}"></script>
<div class="page-content-wrapper">
    @if(Session::has('flash_message_error'))
        <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
    @endif
    @if(Session::has('flash_message_success'))
        <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
    @endif
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Coupon's Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\AdminController@dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\CouponController@coupons') }}">Coupons</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet blue-hoki box ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>{{ $title }}
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="addCouponForm" @if(!empty($couponData)) action="{{ url('/admin/add-edit-coupon/'.base64_encode(convert_uuencode($couponData['id']))) }}" @else action="{{ url('/admin/add-edit-coupon') }}"  @endif role="form" class="form-horizontal" method="post"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body">
                                @if(!empty($couponData))
                                    <div  class="form-group">
                                    <label class="col-md-3 control-label">Coupon Code:</label>
                                    <div class="col-md-5" style="margin-top: 8px;">
                                        <span><b>{{ $couponData['code'] }}</b></span>
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Coupon Code :</label>
                                    <div  class="col-md-5" style="margin-top:8px;">
                                        <label>
                                            <input id="Automatic" type="radio" value="Automatic" name="codeoption" checked />Automatic &nbsp;
                                        </label>
                                        <label>
                                            <input id="Manual" type="radio" value="Manual" name="codeoption" />Manual
                                        </label>
                                    </div>
                                </div>
                                <div id="textField" class="form-group" style="display: none;">
                                    <label class="col-md-3 control-label">Enter Code:</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Enter code" name="code" style="color:gray" class="form-control"/>
                                    </div>
                                </div>
								
                                @endif 
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Type :</label>
                                    <div class="col-md-5" style="margin-top:8px;">
                                        @if(!empty($couponData))    
                                            @if($couponData['type']=="staff")
                                                <?php  $staffchecked = "checked";
                                                        $customerchecked  ="";?>
                                            @else
                                                <?php $customerchecked="checked";
                                                      $staffchecked =""; ?>
                                            @endif
                                        @else
                                            <?php $customerchecked="checked"; 
                                                  $staffchecked="";?>
                                        @endif
                                        <label>
                                            <input type="radio" name="type" value="customer" {{ $customerchecked }}/>&nbsp;Customer &nbsp;
                                        </label>
                                        <label>
                                            <input type="radio" name="type" value="staff" {{ $staffchecked }} />&nbsp;Staff
                                        </label>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Coupon Type :</label>
                                    <div class="col-md-5" style="margin-top:8px;">
                                        @if(!empty($couponData))    
                                            @if($couponData['coupon_type']=="Multiple Times")
                                                <?php  $Mchecked = "checked";
                                                        $Schecked  ="";?>
                                            @else
                                                <?php $Schecked="checked";
                                                      $Mchecked =""; ?>
                                            @endif
                                        @else
                                            <?php $Schecked=""; 
                                                  $Mchecked="checked";?>
                                        @endif
                                        <label>
                                            <input type="radio" name="coupon_type" value="Multiple Times" {{ $Mchecked }}/>Multiple Times &nbsp; 
                                        </label>
                                        <label>
                                            <input type="radio" name="coupon_type" value="Single Time" {{ $Schecked }} />Single Time
                                        </label>
                                    </div>
                                </div>
								  <div class="form-group">
                                    <label class="col-md-3 control-label">Select Categories :</label>
                                    <div class="col-md-4">
                                        <select name="categories[]" class="selectpicker" data-live-search="true" data-width="100%" data-actions-box="true" multiple> 
                                            <?php foreach ($getCategories as $key => $category) {?>
                                            <option value="{{$category['id']}}" @if(in_array($category['id'],$Selcats)) selected @endif>&#9679;&nbsp;{{$category['name']}}</option>
                                            <?php if(!empty($category['subcategories'])){
                                                foreach ($category['subcategories'] as $key => $subcat) { ?>
                                                    <option value="{{$subcat['id']}}" @if(in_array($subcat['id'],$Selcats)) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subcat['name']}}</option>
                                                    <?php foreach ($subcat['subcategories'] as $key => $subsubcat) { ?>
                                                    <option value="{{$subsubcat['id']}}" @if(in_array($subsubcat['id'],$Selcats)) selected @endif>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&raquo; &raquo; &nbsp;{{$subsubcat['name']}}</option>
                                                <?php } 
                                                }
                                            }
                                        } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select Users :</label>
                                    <div class="col-md-9">
                                        @if(!empty($couponData['user_emails1111']))
                                            <span class="form-control">{{$couponData['user_emails']}}</span>
                                        @else
                                            <select name="user_emails[]" class="selectpicker" class="selectpicker" data-live-search="true" data-width="100%" data-actions-box="true" multiple> 
                                                <?php 
													if(isset($couponData['user_emails'])){
														$select_user_emails = explode(",",$couponData['user_emails']); 
													}else{
														$select_user_emails = array();
													}
													
													?>
												@foreach($users as $user)
                                                    <option value="{{$user->email}}"  @if(in_array($user->email,$select_user_emails)) selected @endif>{{$user->email}}</option>
                                                @endforeach
                                            </select>
                                            <b><span  style="display:none">Don't select user in case of coupon for all users</span></b>
                                        @endif
                                    </div>
                                </div>
                                <?php //echo "<pre>"; print_r($couponData); exit;?>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select Product (sku) :</label>
                                    <div class="col-md-4">
										<?php 
										if(isset($couponData['product_sku'])){
											$skuCat = explode(",",$couponData['product_sku']); 
										}else{
											$skuCat = array();
										}
										
										?>
                                            <select name="product_sku[]" class="selectpicker" data-live-search="true"  data-actions-box="true"  data-width="100%" multiple="">
                                                @foreach($getattributes as $getattribute)
												    @if($getattribute->sku != '')
                                                    <option value="<?php echo $getattribute->sku ?>" @if(in_array($getattribute->sku,$skuCat)) selected @endif> {{$getattribute->sku}} </option>
                                                   @endif
                                                @endforeach
                                            </select>
                                            <b><span style="display:none">Don't select user in case of coupon for all users</span></b>
                                    </div>
                                </div>
								
								 <div class="form-group">
                                    <label class="col-md-3 control-label">Coupon for Only New User:</label>
                                    <div class="col-md-1">
                                        <input type="checkbox" style="margin-top: 10px; width: 40px; height: 30px;" name="coupon_for_new_user" value="1" <?php  if(!empty($couponData['coupon_for_new_user']) && $couponData['coupon_for_new_user']=="1") { echo "checked"; } ?> />
                                    </div>
                                </div>
								
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Amount Type :</label>
                                    <div class="col-md-5" style="margin-top:8px;">
                                        @if(!empty($couponData))    
                                            @if($couponData['amount_type']=="Percentage")
                                                <?php  $Perchecked = "checked";
                                                        $Rschecked  ="";?>
                                            @else
                                                <?php $Rschecked="checked";
                                                      $Perchecked =""; ?>
                                            @endif
                                        @else
                                            <?php $Rschecked="checked"; 
                                                  $Perchecked="";?>
                                        @endif
                                        <label>
                                            <input type="radio" name="amount_type" value="Rupees" {{ $Rschecked }}/>Rs. &nbsp;
                                        </label>
                                        <label>
                                            <input type="radio" name="amount_type" value="Percentage" {{ $Perchecked }} />%
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Amount :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Amount" name="amount" style="color:gray" autocomplete="off"  class="form-control" value="{{(!empty($couponData['amount']))?$couponData['amount']: '' }}"/>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Select Quantity :</label>
                                    <div class="col-md-2">
                                        <select name="min_qty" style="color:gray" class="form-control">
                                            <option value="">Select Min Qty</option>
                                            <?php for($i=1;$i<=10;$i++) { ?>
                                            <option value="{{$i}}" <?php  if(!empty($couponData['min_qty']) && $couponData['min_qty']==$i) { echo "selected"; } ?>>{{ $i }}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="max_qty" style="color:gray" class="form-control">
                                            <option value="">Select Max Qty</option>
                                            <?php for($j=1;$j<=500;$j++) { ?>
                                            <option value="{{$j}}" <?php  if(!empty($couponData['max_qty']) && $couponData['max_qty']==$j) { echo "selected"; } ?>>{{ $j }}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Enter Price Range :</label>
                                    <div class="col-md-2">
                                        <input type="text" placeholder="Enter Min Amount" name="min_amount" style="color:gray" autocomplete="off"  class="form-control" value="{{(!empty($couponData['min_amount']))?$couponData['min_amount']: '1499' }}"/>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" placeholder="Enter Max Amount" name="max_amount" style="color:gray" autocomplete="off"  class="form-control" value="{{(!empty($couponData['max_amount']))?$couponData['max_amount']: '3999' }}"/>
                                    </div>
                                </div>
								<div class="form-group" style="display:none">
                                    <label class="col-md-3 control-label">Coupon Usage :</label>
                                    <div class="col-md-4">
                                        <input type="number" placeholder="Coupon Usage" name="coupon_usage" style="color:gray" class="form-control" autocomplete="off" value="{{(!empty($couponData))?$couponData['coupon_usage']: '' }}" />
                                    </div>
                                </div>
								<?php /*
								    <div class="form-group ">
                                    <label class="col-md-3 control-label">Terms and conditions :</label>
                                    <div class="col-md-9">
                                        
                                                
                                        <textarea name="terms_and_conditions">@if(!empty($couponData['terms_and_conditions'])) {{$couponData['terms_and_conditions']}} @endif</textarea>
                                        <script>
                                                CKEDITOR.replace( 'terms_and_conditions' );
                                        </script>                            
                                    </div>
                                </div>  */ ?>
								
								
								<div class="form-group">
                                    <label class="col-md-3 control-label">Terms and conditions :</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Terms and conditions" name="terms_and_conditions" style="color:gray" autocomplete="off"  class="form-control" value="{{(!empty($couponData['terms_and_conditions']))?$couponData['terms_and_conditions']: '' }}"/>
                                    </div>
                                </div>
								
								
								
								
								  <div class="form-group">
                                    <label class="col-md-3 control-label">Start Date :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Start Date" name="start_date" style="color:gray" class="form-control datePicker" autocomplete="off" value="{{(!empty($couponData['start_date']))?$couponData['start_date']: '' }}" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Expiry Date :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Expiry Date" name="expiry_date" style="color:gray" class="form-control datePicker" autocomplete="off" value="{{(!empty($couponData['expiry_date']))?$couponData['expiry_date']: '' }}" required />
                                    </div>
                                </div>
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Remarks :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Remarks" name="remarks" style="color:gray" autocomplete="off"  class="form-control" value="{{(!empty($couponData['remarks']))?$couponData['remarks']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Enable:</label>
                                    <div class="col-md-1">
                                        <input type="checkbox" style="margin-top: 10px; width: 40px; height: 30px;" name="status" value="1" <?php  if(!empty($couponData['status']) && $couponData['status']=="1") { echo "checked"; } ?> />
                                    </div>
                                </div>
							    <div class="form-group">
                                    <label class="col-md-3 control-label"> Visible in Cart::</label>
                                    <div class="col-md-1">
                                        <input type="checkbox" style="margin-top: 10px; width: 40px; height: 30px;" name="visible" value="1" <?php  if(!empty($couponData['visible']) && $couponData['visible']=="1") { echo "checked"; } ?> />
                                    </div>
                                </div>
                               
                            </div>
                            <div class="form-actions right1 text-center">
                                <button class="btn green" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.form-control-feedback{
    top:8px! important;
}
.form-horizontal .form-group {
    margin-left: 0px !important;
}
</style>
@endsection