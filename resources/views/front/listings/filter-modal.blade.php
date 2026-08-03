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
<!-- filter Offcanvas (Right Side) Start -->
  <div class="offcanvas offcanvas-end filter-canvas" tabindex="-1" id="filterOffcanvas">
      <div class="offcanvas-header">
        <h6>Filter By</h6>
          <button type="button" class="btn closeBtn" data-bs-dismiss="offcanvas" aria-label="Close">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                  viewBox="0 0 24 24">
                  <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" />
              </svg>
          </button>
      </div>
      <hr>
      <div class="offcanvas-body">
         <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12 mb-3 position-static">
                  <div class="widget mb-20">
                      <h5 class="">Product Categories</h5>
                      <div class="category-list">
                         @foreach($categories as $category)
                        <a href="{{url('/'.$category['seo_unique'])}}" class="mobile-filter-main-cat">{{ $category['name'] }}</a>
                         
                        <ul>
                               @foreach($category['subcategories'] as $subcategory)
                              <li class="mobile-listing sub-cat-mobile-listing"><a
                                      href="{{ url('/'.$subcategory['seo_unique']) }}">
                                          {{ $subcategory['name'] }}</a></li>
                              @endforeach
                          </ul>
                          @endforeach
                      </div>
                  </div>
              </div>
               <?php 
                        if($catdetails['name'] == 'New Arrivals'){
                            $colors =  Product::GruopbyProductattribute($relatedcategory,'productcolor','New Arrivals'); 
                        }else if($catdetails['name'] == 'Shop All'){ 
                            $colors =  Product::GruopbyProductattribute($relatedcategory,'productcolor','Shop All'); 
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
                                        class="d-none filterAjax" id="color-{{$ckey}}">
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
                            }else if($catdetails['name'] == 'Shop All'){ 
                                $sizes =  ProductAttribute::getproductsizes($relatedcategory,'Shop All'); 
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
                      <h5 class="range-selector">Filter By Price</h5>
                      <div class="row">
                          <div class="col-sm-12" style="">
                              <div id="slider-range-2"
                                  class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                  <div class="ui-slider-range ui-corner-all ui-widget-header"
                                      style="left: 12.5%; width: 62.5%;"></div><span
                                      tabindex="0"
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
                                  id="slider-range-value-1">500</span>
                          </div>
                          <div class="col-md-6 col-6 text-end caption mt-2">
                              <strong class="filter_price">Max:</strong> <span
                                  id="slider-range-value-2">10000</span>
                          </div>
                          <input type="checkbox" style="display:none" class="filterAjax" id="price_sort"
                                    name="price" value="500-10000">
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Add to Cart -->
      <div class="newBtns">
          <button class="btn-cart ApplyFilter">APPLY FILTER</button>
          <hr>
          <a href="javascript:;" class="detail-btn ClearFilter">CLEAR FILTER</a>
      </div>
  </div>
 <!-- filter Offcanvas (Right Side) End -->