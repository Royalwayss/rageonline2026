@extends('layouts.adminLayout.backendLayout')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Gifts Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\GiftController@gifts') }}">Gifts</a>
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
                        <form  role="form"  id="addEditGift" class="form-horizontal" method="post" @if(empty($giftdata)) action="{{ url('admin/add-edit-gift') }}" @else  action="{{ url('admin/add-edit-gift/'.$giftdata['id']) }}" @endif enctype="multipart/form-data"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Gift Name :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Gift Name" name="gift_name" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($giftdata['gift_name']))?$giftdata['gift_name']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Invoice Gift Name :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Invoice Gift Name" name="invoice_gift_name" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($giftdata['invoice_gift_name']))?$giftdata['invoice_gift_name']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Gift Image: </label>
                                    <div class="col-md-5">
                                        <div data-provides="fileinput" class="fileinput fileinput-new">
                                            <div style="" class="fileinput-new thumbnail">
                                            <?php if(!empty($giftdata['gift_image'])){
                                                $path = "images/GiftImages/".$giftdata['gift_image']; 
                                            if(file_exists($path)) { ?>
                                                <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/GiftImages/'.$giftdata['gift_image'])}}">
                                            <?php }else{?>
                                                    <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/default.png') }}">
                                            <?php } } else { ?>
                                            <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/default.png') }}">
                                            <?php } ?>
                                        </div>
                                            <div style="max-width: 200px; max-height: 150px; line-height: 10px;" class="fileinput-preview fileinput-exists thumbnail">
                                            </div>
                                            <div>
                                                <div class="form-group">
                                                    <span class="btn default btn-file">
                                                    <span class="fileinput-new">
                                                    Select Image </span>
                                                    <span class="fileinput-exists">
                                                    Select Image </span>
                                                    <input type="file" id="Image" name="gift_image">
                                                    </span>
                                                    <a data-dismiss="fileinput" class="btn default fileinput-exists" href="#">
                                                    Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">MRP :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="MRP" name="mrp" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($giftdata['mrp']))?$giftdata['mrp']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Bar Code :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Bar Code" name="bar_code" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($giftdata['bar_code']))?$giftdata['bar_code']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Shopping Amount :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Enter Min Amount" name="shopping_amount_from" style="color:gray" autocomplete="off"  class="form-control" value="{{(!empty($giftdata['shopping_amount_from']))?$giftdata['shopping_amount_from']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Stock :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Stock" name="stock" style="color:gray" autocomplete="off"  class="form-control" value="{{(!empty($giftdata['stock']))?$giftdata['stock']: '' }}"/>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Gift Terms & Conditions :</label>
                                    <div class="col-md-4">
                                        <textarea placeholder="Gift Terms & Conditions" name="gift_terms" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($giftdata['gift_terms']))?$giftdata['gift_terms']: '' }}"></textarea>
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
@stop