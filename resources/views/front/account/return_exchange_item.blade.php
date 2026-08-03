@extends('layouts.frontLayout.front-layout')
@section('content')
<?php 
   $sizeArr=[]; ?>
<main>
   <div class="container">
      <div class="row">
         <div class="col-12">
            <?php 
               use App\ExchangeRequest;
               use App\Order;
               use App\Product;
               use App\OrderProduct;
               use App\CustomFunction;
               use App\ReturnRequest;
               ?>
            <!-- Order Detail Page Html Starts -->
            @if(Session::has('flash_message_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <strong>Error! </strong> {!! session('flash_message_error') !!}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @endif
            @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>Success! </strong> {!! session('flash_message_success') !!}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @endif
            @if(isset($_GET['order_id']) && !empty($_GET['order_id']))
            @else
            <div class="row accTabsInfo OrderView">
               <div class="col-12">
                  <a class="View-BackBtn" href="{{ url('account/orders') }}"> Back </a>
               </div>
               <div class="col-12">
			       <h4 class="booster-font">Exchange Item</h4>
                  
               </div>
               <div class="col-sm-12 col-12 mt-1">
                  <?php 
                     if($order->payment_method == 'bank_deposit') { $payment_method = 'Bank deposit'; }  else { $payment_method = $order->payment_method;  }
                     
                     
                     if(@$order->order_address->shipping_state =='Punjab'){
                     $own_state = 'yes';
                     }else{
                     $own_state = 'no';
                     }
                     $total_gst_ = 0;
                     
                     ?>
                  <div class="row">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pd">
                        <div id="no-more-tables">
                          <p><strong>Order ID:</strong> {{ $order->id }} </p>
						    <p><strong>Payment Method: </strong>{{
                              CustomFunction::get_payment_method($order->payment_method) }}
                           <p>
                           <p><strong>Order Date: </strong>{{date('d M Y',strtotime($order->created_at))}}
                           </p>
                           <div class="">
                               <form action="{{ url('exchange_item/'.$order->id) }}" method="post" enctype="multipart/form-data">@csrf
							  <table class="table-bordered cf no-pd table table-bordered">
                                 <thead class="cf">
                                    <tr>
                                       <th>Select Item</th>
                                       <th>Product Details</th>
                                    </tr>
                                 </thead>
                                 <?php 
                                    $product_gst_array = $priceArr = array();
                                                        $total_gst_ = 0;					 
                                    ?>
                                 @foreach($order->order_products as $order_product)
                                 <tr>
                                    <td>
									       <input type="radio" name="order_product_id" value="{{ $order_product->id }}" required>
									</td>
                                    <td data-title="Product Image ">
                                       <a
                                          href="{{ url('product/'.$order_product->productdetail->seo_url) }}">
                                       @if(isset($order_product['productdetail']['product_image']['image']))
                                       <img style="border:0px;"
                                          src="{{asset('images/ProductImages/medium/'.$order_product['productdetail']['product_image']['image'])}}"
                                          height="50px" width="50px">
                                       @else
                                       <img style="border:0px;"
                                          src="{{asset('images/no-image-found.jpg')}}" height="50px"
                                          width="50px">
                                       @endif
                                       </a>
                                       <a target="_block" style="color:#9d3d49"
                                          href="{{ url('product/'.$order_product->productdetail->seo_url) }}">{{
                                       $order_product->product_name }}</a>
                                       <b><br>Size</b>: {{ $order_product->product_size }}
                                       <b><br>Category</b>: {{ $order_product->category_name }}
                                       <b><br>Sku</b>: {{ $order_product->product_sku }}
                                    </td>
                                 </tr>
                                 @endforeach
                              </table>
							  
							 
							  
							   <div class="row" style="display:none">
							       <?php /* <label for="message-text" class="col-2 col-form-label">Action:</label>
									<div class="col-2  col-form-label"> 
									    <input type="radio" for="item-return" name="action" value="Return"> <label for="item-return">Return</label><br>
									 </div> */ ?>
									 <div class="col-2  col-form-label"> 
									    <input type="radio" for="item-exchange" name="action" value="Exchange" checked> <label for="item-exchange">Exchange</label><br>
									 </div>
							   </div>
							  
							   <div class="row" id="action_reason" >
                                 <div class="col">
                                    <label for="return_reason" class="col-form-label" id="reason_field">Reason for
                                    Exchange:</label>
                                    <select name="return_reason" class="form-control return_items" required>
                                       <option value="">Please Select</option>
                                       <option value="Incorrect product received">Incorrect product
                                          received
                                       </option>
                                       <option value="Received product is defective">Received product is
                                          defective
                                       </option>
                                       <option value="A Part of the product is missing">A Part of the
                                          product is missing
                                       </option>
                                       <option value="Wrong size received">Wrong size received</option>
                                       <option value="Size Issue">Size Issue</option>
                                       <option value="Others">Others</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="row" id="required_size_field" >
                                 <div class="col">
                                    <label for="message-text" class="col-form-label">Required Size:</label>
                                    <input name="required_size" id="required_size" placeholder="Size" class="form-control"
                                       required>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col">
                                    <label for="message-text" class="col-form-label">Comments:</label>
                                    <textarea name="reason" placeholder="Comments"
                                       class="form-control return_items" id="message-text"
                                       required></textarea>
                                 </div>
                              </div>
                            
							  <div class="col-md-6">
									<label class="form-label">Pictures</label>
									<div class="upload-box">
									<input type="file" name="file[]" id="fileUpload" accept="image/*" multiple onchange="previewImages(event)">
									<label for="fileUpload" class="d-block">Click to Upload Multiple</label>
									<div id="previewContainer" class="preview-container"></div>
									</div>
								</div> 
							  
							   <br> <br> <br>
							    <div class=" mt-3">
								 
											<button type="submit" class="btn-cart2 ">Submit</button>
								</div>
							  </form>
							  
                           </div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
            @endif
         
		 </div>
         @section('javascript')
         @parent
         <script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
         <script type="text/javascript">
            $(document).ready(function() {
               $(document).on('change','[name=action]',function(){ 
                     var action = $(this).val(); 
                     $("#action_reason").show();
                     
					 if(action == 'Exchange'){
						 $("#reason_field").html('Reason for Exchange');  
                         $("#required_size_field").show();						 
                         $('#required_size').attr('required', true);
					 
					 }else{
						 $("#reason_field").html('Reason for Return');
						 $("#required_size_field").hide();
						 $('#required_size').attr('required', false);
					 }
					 
                })
            })
            
            
            $(document).on('click', '.close', function() {
                $("#returnItem").modal('hide');
            });
            
            
            $(document).on('click', '.triggerOrderDetails', function() {
            
                $(".collapse").css("display", "block");
            });
            $(document).ready(function() {
            
                /*$.validator.addMethod('filesize', function (value, element, arg) {
                    var minsize=1000; // min 1kb
                    if(element.files[0].size<=arg){
                        return true;
                    }else{
                        return false;
                    }
                });  */
                $('#return-form').validate({ // initialize the plugin
                    rules: {
                        return_reason: {
                            required: true
                        }
            
                    }
                });
            
            });
         </script>
         @stop
      </div>
   </div>
</main>
@stop
<style>
</style>