<?php use App\Color; use App\ProductAttribute;  use\App\Product;  use App\Category; use App\Productcolor;
   $relatedcategory = Product::relatedcategory($catdetails['parent_id'],$catdetails['id'],$catdetails['seo_unique']);
   $getcategories = Category::getcategories();
   if($catdetails['name'] == 'New Arrivals'){
   $colors =  Product::GruopbyProductattribute($relatedcategory,'productcolor','New Arrivals'); 
   }else{
   $colors =  Product::GruopbyProductattribute($relatedcategory,'productcolor');
   } 
   ?>
<div class="filter">
   <h6 class="d-inline-block filter-widget-toggle" id="filter-btn">Filter</h6>
   <div class="filter-popup" style="display:none">
      <div class="row">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12 position-static">
            <div class="widget mb-20">
               <h5 class="">Product Categories</h5>
               <div class="category-list">
                  <ul>
                     @foreach($getcategories  as $key=> $categories)
                     <li><a href="{{ url($categories['seo_unique']) }}" class="mobile-filter-main-cat">{{ $categories['name'] }}</a></li>
                     @if(!empty($categories['subcategories']))
                     @foreach($categories['subcategories'] as $subcategory)
                     <li class="mobile-listing sub-cat-mobile-listing"><a href="{{url('/'.$subcategory['seo_unique'])}}"><span>&gt; {{$subcategory['name']}} </span></a></li>
                     @endforeach
                     @endif
                     @endforeach   
                  </ul>
               </div>
            </div>
         </div>
         @if(count($colors)>0)
         <div class="col-12">
            <div class="filter-popup-item">
               <div class="widget mb-20">
                  <h5 class="">Filter By Color</h5>
                  <ul class="color-list">
                     @foreach($colors as $ckey=> $color)
                     @if($color->productcolor!='')
                     <?php $get_color_code = Product::product_code($color->productcolor); ?>
                     <li onclick="select_color2({{ $ckey }})" style="background-color: {{ $get_color_code }}" class="filter-color  filter-color-{{$ckey}}"></li>
                     <input name="color" type="checkbox" value="{{ $color->productcolor }}" class="d-none filterAjaxMobile" id="pro-color-{{ $ckey  }}"  >
                     @endif
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
         @endif
         <?php 
            if($catdetails['name'] == 'New Arrivals'){
            $sizes =  ProductAttribute::getproductsizes($relatedcategory,'New Arrivals');
            }else{
            $sizes =  ProductAttribute::getproductsizes($relatedcategory);
            }
            
            ?>
         @if(count($sizes)>0) 
         <div class="col-12">
            <div class="widget mb-20">
               <h5 class="">Filter By Size</h5>
               <div class="size-link">
                  @foreach($sizes as $sizekey=> $size)
                  <a href="javascript:;" onclick="select_size2({{ $sizekey }})" class="filter-size  filter-size-{{$sizekey}}">{{$size->size}}</a>
                  <input name="size" type="checkbox" value="{{$size->size}}" class="d-none filterAjaxMobile" id="pro-size-{{  $sizekey  }}" >
                  @endforeach
               </div>
            </div>
         </div>
         @endif
         <div class="col-12">
            <div id="rage_price_filter" class="widget rage widget_price_filter">
               <h5 class="mb-20">Filter By Price</h5>
               <div class="row">
                  <div class="col-sm-12" style="">
                     <div id="slider-range-2"></div>
                  </div>
               </div>
               <div class="row slider-labels d-flex justify-content-between" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
                  <div class="col-xs-6 caption">
                     <strong class="filter_price">Min:</strong> <span id="slider-range-value-1">1000</span>
                  </div>
                  <div class="col-xs-6 text-right caption">
                     <strong class="filter_price">Max:</strong> <span id="slider-range-value-2">6000</span>
                  </div>
				  <input type="checkbox" style="display:none" class="filterAjax" id="price_sort" name="price" value="1000-6000">
               </div>
            </div>
         </div>
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
            <div class="widget mb-20">
               <div class="filter-form-submit mt-20 mb-10">
                  <button type="submit" class="ApplyFilter">Apply Filter</button>
                  <button type="submit" class="ClearFilter">Clear Filter</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>