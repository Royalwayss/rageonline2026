<?php
use App\ProductAttribute; 
 $all_sizes = [];

      if(count($pro_attrs)>0){
         foreach($pro_attrs as $key=> $pro_attr){  
            $all_sizes[] = $pro_attr['size'];
         }
      }
   
?>

      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Notify Me</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
         </div>
         <div class="modal-body">
            <div id="notify_msg"></div>
            <form action="javascript:;" method="post" id="notify">
               @csrf
               <div class="form-group">
                  <label for="name">Size:</label>
                  <select name="notifysize" id="notifysize" class="form-control">
                     @foreach($all_sizes as $attrkey=> $attribute)
                     <?php  $stock = ProductAttribute::stock($product['id'],$attribute); ?>
                     @if(!$stock) 
                     <option value="{{ $attribute }}">
                        {{ $attribute }}
                     </option>
                     @endif
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="hidden" name="notifycode"  id="notifycode" value="{{ $product['product_code'] }}">
                  <input type="text" class="form-control" id="name" name="name" required>
               </div>
               <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email" name="email" required="">
               </div>
               <div class="form-group">
                  <label for="email">Mobile:</label>
                  <input type="text" class="form-control" id="mobile" name="mobile">
               </div>
               <button type="submit" class="btn btn-default size-chart-close-btn mt-3">Submit</button>
            </form>
         </div>
      </div>
   