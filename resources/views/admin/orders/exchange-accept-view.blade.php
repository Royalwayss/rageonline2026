@extends('layouts.adminLayout.backendLayout')

@section('content')

<?php use App\ProductAttribute; ?>

<div class="page-content-wrapper">

    <div class="page-content">

        <div class="page-head">

            <div class="page-title">

                <h1>Order's Management</h1>

            </div>

        </div>

        <ul class="page-breadcrumb breadcrumb">

            <li>

                <a href="{!! url('admin/dashboard') !!}">Dashboard</a>

                <i class="fa fa-circle"></i>

            </li>

            <li>

                <a href="{!! url('admin/orders') !!}">Orders</a>

            </li>

        </ul>

        @if(Session::has('flash_message_error'))

        <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>

        @endif

        @if(Session::has('flash_message_success'))

        <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>

        @endif

        <div class="row">

            <div class="col-md-12">

                <div class="portlet light">

                    <div class="portlet-title">

                        <div class="caption">

                            <i class="icon-basket font-green-sharp"></i>

                            <span class="caption-subject font-green-sharp bold uppercase">

                            Order #{{$orderDetails['id']}} </span>

                            <span class="caption-helper">{{ date('d F Y h:ia',strtotime($orderDetails['created_at'])) }}</span>

                        </div>

                    </div>

                    <div class="portlet-body">

                        <div class="row">

                            <div class="col-md-6 col-sm-12">

                                <div class="portlet blue-hoki box">

                                    <div class="portlet-title">

                                        <div class="caption">

                                            <i class="fa fa-cogs"></i>Exchange Form

                                        </div>
                                    </div>
                                <div class="portlet-body">
                                    <form action="{{ url('admin/exchange-accept-status') }}" name="exchange-form" id="exchange-form"  method="post">@csrf
                                        
                                        <input type="hidden" name="exchange_id" value=<?php echo $exchangerequest_id; ?>>
                                            <?php 
                                            
                                                $get_sku = ProductAttribute::getSku($orderDetails['product_id'],$orderDetails['product_sku']);  
                                                
                                            ?>
                                            
                                             <div class="form-group">
                                                @if(isset($get_sku))
                                                    <select id="OrderStatus" name="search" class="form-control input-sm" required>
    
                                                        <option value="">Please Select</option>
    
                                                        @foreach($get_sku as $get_skuvalue)
    
                                                        <option value="{{$get_skuvalue->sku}}" <?php if($exchangerequest->exchange_sku==$get_skuvalue->sku){ echo "selected"; } ?>>{{$get_skuvalue->sku}}</option>
    
                                                        @endforeach
    
                                                    </select>
                                                @else    
                                                    <h4>Out of stock!</h4>
                                                @endif

                                            </div>   									    

    										<div class="form-group">
    
    											<label  class="col-form-label">Qty:</label>
    
    											<input type="text" name="qty" class="form-control" value="{{$orderDetails['product_qty']}}" required>
    
    										</div>
    										<div class="form-group">
    
    											<label  class="col-form-label">Comments:</label>
    
    											<textarea type="text" name="comments" class="form-control" value=""><?php if(isset($exchangerequest->reply_comment)){ echo $exchangerequest->reply_comment; } ?></textarea>
    
    										</div>
    										<div class="form-group">
    
    											<label  class="col-form-label"><input type="checkbox" name="send_order"  value=""></label>
                                                <label  class="col-form-label">Send Order Placed Email to customer</label>
    											
    
    										</div>
    										<div class="modal-footer">
    
    											<button type="submit" class="btn btn-primary">Update</button>
    
    										</div>
    									
									</form>
									</div>
                                </div>

                            </div>

                            <div class="col-md-6 col-sm-12">

                                <div class="portlet blue-hoki box">

                                    <div class="portlet-title">

                                        <div class="caption">

                                            <i class="fa fa-cogs"></i>Order Product History

                                        </div>

                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">


                                            <div class="col-md-7 value">

                                                <img src="{{ asset('images/ProductImages/small/'.$productAttribute['image'])}}" class="img-fluid" alt="" title="" />

                                            </div>

                                        </div>
                                        <div class="row static-info">

                                            <div class="col-md-5 name">

                                                OrderId:

                                            </div>

                                            <div class="col-md-7 value">

                                                {{$orderDetails['id']}}

                                            </div>

                                        </div>

                                        <div class="row static-info">

                                            <div class="col-md-5 name">

                                                Product Name

                                            </div>

                                            <div class="col-md-7 value">

                                                {{ $orderDetails['product_name'] }}

                                            </div>

                                        </div>

                                        <div class="row static-info">

                                            <div class="col-md-5 name">

                                                Product Code:

                                            </div>

                                            <div class="col-md-7 value">

                                                {{ $orderDetails['product_code'] }}

                                            </div>

                                        </div>

                                        <div class="row static-info">

                                            <div class="col-md-5 name">

                                                Product SKU:

                                            </div>

                                            <div class="col-md-7 value">

                                                {{$orderDetails['product_sku']}}

                                            </div>

                                        </div>

                                        <div class="row static-info">

                                            <div class="col-md-5 name">

                                                Product Qty:

                                            </div>

                                            <div class="col-md-7 value">

                                                {{$orderDetails['product_qty']}}

                                            </div>

                                        </div>
                                        <div class="row static-info">

                                            <div class="col-md-5 name">

                                                MRP:

                                            </div>

                                            <div class="col-md-7 value">

                                                {{$orderDetails['product_price']}}

                                            </div>

                                        </div>
                                        <div class="row static-info">

                                            <div class="col-md-5 name">

                                                Price:

                                            </div>

                                            <div class="col-md-7 value">

                                                {{$orderDetails['product_price']}}

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<script>
    
     $('#exchange-form').validate({ // initialize the plugin
        rules: {
            search: {
                required: true
            },
            qty: {
                required: true
            }
        }   
    });   
    
    
</script>
@stop