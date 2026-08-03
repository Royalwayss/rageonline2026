<?php
	use App\Color; 
	use App\ProductAttribute;
	use App\Product;  
	use App\Category; 
	use App\Productcolor;
	$relatedcategory = Product::relatedcategory($catdetails['parent_id'],$catdetails['id'],$catdetails['seo_unique']);
	$getcategories = Category::getcategories();
	if (!isset($categories)) {
      $categories = Category::getcategories();
    }
?>



<div class="col-md-3 col-12 text-end d-flex justify-content-end gap-2 filter-bar">
    <div class="col-md-4 col-12 filter2">
        <div class="sorting">
            <select name="sort" class="classic getsort filterby  listing_dropdown">
                <option value="default">Sort by</option>
                <option value="lth">Price: low to high</option>
                <option value="htl">Price: high to low</option>
            </select>
        </div>
    </div>
    <div class="col-md-4 col-12 filter3">
        <div class="filter">
            <!-- <h6 class="d-inline-block filter-widget-toggle" id="filter-btn">Filter</h6> -->

            <button data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" class="filter-widget-toggle" id="filter-btn"
                aria-controls="filterOffcanvas" title="Filters">Filters
            </button>

            <!-- <div class="filter-popup" style="display: block;">
                <div class="row">
                    @if(!empty($getcategories))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12 position-static mb-3">
                        <div class="widget mb-20">
                            <h5 class="">Product Categories</h5>
                            <div class="category-list">
                                <ul>
                                    @foreach($categories as $category)
                                    <li><a href="{{url('/'.$category['seo_unique'])}}"
                                            class="mobile-filter-main-cat">{{ $category['name'] }}</a></li>
                                    @foreach($category['subcategories'] as $subcategory)
                                    <li class="mobile-listing sub-cat-mobile-listing"><a
                                            href="{{ url('/'.$subcategory['seo_unique']) }}"><span>&gt;
                                                {{ $subcategory['name'] }} </span></a></li>
                                    @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                    <?php 
                        if($catdetails['name'] == 'New Arrivals'){
                            $colors =  Product::GruopbyProductattribute($relatedcategory,'productcolor','New Arrivals'); 
                        }else{
                            $colors =  Product::GruopbyProductattribute($relatedcategory,'productcolor');
                        }
                        ?>
                    @if(count($colors)>0)
                    <div class="col-12 mb-3">
                        <div class="filter-popup-item">
                            <div class="widget mb-20">
                                <h5 class="">Filter By Color</h5>
                                <ul class="color-list">

                                    @foreach($colors as $ckey=> $color)
                                    @if($color->productcolor!='')
                                    <?php $get_color_code = Product::product_code($color->productcolor); ?>
                                    <li onclick="select_color({{$ckey}})"
                                        style="background-color: {{ $get_color_code }}"
                                        class="filter-color  filter-color-{{$ckey}}"></li>
                                    <input name="color" type="checkbox" value="{{ $color->productcolor }}"
                                        class="d-none filterAjax" id="color-{{ $ckey  }}">
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
                    <div class="col-12 mb-3">
                        <div class="widget mb-20">
                            <h5 class="">Filter By Size</h5>
                            <div class="size-link">
                                @foreach($sizes as $sizekey=> $size)
                                <a href="javascript:;" onclick="select_size({{ $sizekey }})"
                                    class="filter-size  filter-size-{{$sizekey}}">{{$size->size}}</a>
                                <input name="size" type="checkbox" value="{{$size->size}}" class="d-none filterAjax"
                                    id="size-{{  $sizekey  }}">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-12 mb-3">
                        <div id="rage_price_filter" class="widget rage widget_price_filter">
                            <h5 class="mb-4">Filter By Price</h5>
                            <div class="row">
                                <div class="col-sm-12" style="">
                                    <div id="slider-range-2"
                                        class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                        <div class="ui-slider-range ui-corner-all ui-widget-header"
                                            style="left: 12.5%; width: 62.5%;"></div><span tabindex="0"
                                            class="ui-slider-handle ui-corner-all ui-state-default"
                                            style="left: 12.5%;"></span><span tabindex="0"
                                            class="ui-slider-handle ui-corner-all ui-state-default"
                                            style="left: 75%;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row slider-labels d-flex justify-content-between">
                                <div class="col-md-6 col-6 caption mt-2">
                                    <strong class="filter_price">Min:</strong> <span
                                        id="slider-range-value-1">1000</span>
                                </div>
                                <div class="col-md-6 col-6 text-end caption mt-2">
                                    <strong class="filter_price">Max:</strong> <span
                                        id="slider-range-value-2">6000</span>
                                </div>
                                <input type="checkbox" style="display:none" class="filterAjax" id="price_sort"
                                    name="price" value="1000-6000">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                        <div class="widget mb-20">
                            <div class="filter-form-submit mt-20 mb-10">
                                <button type="submit" class="ApplyFilter">Apply
                                    Filter</button>
                                <button type="submit" class="ClearFilter">Clear
                                    Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
<?php /*
	  <style>
	  .noUi-horizontal .noUi-handle {
		width: 15px;
		height: 15px;
		border-radius: 50%;
		left: -7px;
		top: -5px;
		background-color: rgb(250, 143, 71)!important;
		cursor: pointer;
	  }
   </style>
	 <div id="rage_price_filter" class="widget rage widget_price_filter">
           <h5 class="mb-20">Filter By Price</h5>
            <div class="row">
               <div class="col-sm-12" style="">
                 <div id="slider-range"></div>
               </div>
             </div>
             <div class="row slider-labels d-flex justify-content-between" style="margin-top: 10px;">
               <div class="col-xs-6 caption">
                 <strong class="filter_price">Min:</strong> <span id="slider-range-value1">1000</span>
               </div>
               <div class="col-xs-6 text-right caption">
                 <strong class="filter_price">Max:</strong> <span id="slider-range-value2">6000</span>
               </div>
             </div>
             <div class="filter-form-submit mt-35">
					<button type="submit" class="price_slider_amount mb-3">Filter</button>
					
					<input type="checkbox" style="display:none" class="filterAjax" id="price_sort" name="price" value="1000-6000">
				</div>

          </div>
	
	<?php 
						 if($catdetails['name'] == 'New Arrivals'){
							 $colors =  Product::GruopbyProductattribute($relatedcategory,'productcolor','New Arrivals'); 
						 }else{
							$colors =  Product::GruopbyProductattribute($relatedcategory,'productcolor');
						 }
         
						?> @if(count($colors)>0)
<div class="widget mt-30">
    <h5 class="mb-20">Filter By Color</h5>
    <ul class="color-list"> @foreach($colors as $ckey=> $color) @if($color->productcolor!='')
        <?php $get_color_code = Product::product_code($color->productcolor); ?>
        <li onclick="select_color({{ $ckey }})" style="background-color: {{ $get_color_code }}"
            class="filter-color  filter-color-{{$ckey}}"></li>
        <input name="color" type="checkbox" value="{{ $color->productcolor }}" class="filterAjax d-none"
            id="color-{{ $ckey  }}"> @endif @endforeach
    </ul>
</div> @endif
<?php 
						 if($catdetails['name'] == 'New Arrivals'){
						 $sizes =  ProductAttribute::getproductsizes($relatedcategory,'New Arrivals');
						 }else{
						 $sizes =  ProductAttribute::getproductsizes($relatedcategory);
						 }
         
						?> @if(count($sizes)>0)
<div class="widget mt-35">
    <h5 class="mb-20">Filter By Size</h5>
    <div class="size-link"> @foreach($sizes as $sizekey=> $size) <a href="javascript:;"
            onclick="select_size({{ $sizekey }})" class="filter-size  filter-size-{{$sizekey}}">{{$size->size}}</a>
        <input name="size" type="checkbox" value="{{$size->size}}" class="filterAjax d-none "
            id="size-{{  $sizekey  }}"> @endforeach
    </div>
</div> @endif */ ?>


