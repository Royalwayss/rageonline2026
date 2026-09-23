<?php use App\CustomFunction;   use App\Product; ?>

 
                            <div class="product-grid"  >
                                
								<div class="row">
                                    @foreach($getproducts as $key=> $product)
									<?php 
										$product_image = '';
										if(!empty($product['product_image'])){
											$product_image= $product['product_image']['image'];
										}
										$product_link = url('/product/'.$product['seo_url']);
									?>
									<div class="col-lg-4 col-md-4 col-6">
                                        <div class="prod-card">
                                            <div class="prod-img">
                                                <a href="{{ $product_link }}">
                                                    
													@if(!empty($product_image))
														<img src="{{ asset('images/ProductImages/large/'.$product_image)}}?v=1.0"  alt="{{ $product['product_name'] }}" title="{{ $product['product_name'] }}" />
													@else
														<img src="{{asset('images/no-image-found.jpg')}}"  alt="{{ $product['product_name'] }}" title="{{ $product['product_name'] }}" width="600" height="778" style="height: 364px;" />
													@endif
                                                </a>
                                                <a href="javascript:void(0)" class="addWishList WishList-{{ $product['id'] }}" data-productid="{{ $product['id'] }}">
                                                    @if($product['is_wishlisted'] == '1')
														<i class="fa-heart fa-solid" style="color: rgb(147, 47, 47);"></i>
													@else
														<i class="fa-regular fa-heart"></i>
													@endif	
												</a>
                                                <div class="cart-btn">
                                                    <a href="{{ $product_link }}" class="link-btn black">Add to Cart</a>
                                                    <a href="{{ $product_link }}" class="link-btn brown">Buy Now</a>
                                                </div>
												
												
												@if($product['new_arrival'] == 'Yes')
                                                <span class="prod-badge">New</span>
												@endif
												
												@if($product['best_seller'] == 'Yes')
                                                <span class="prod-badge">Exclusive</span>
												@endif
												
                                            </div>
                                            <div class="prod-info">
                                                <div class="name-wrap">
                                                    <h4><a href="{{ $product_link }}">Abeer Velvet Kurta</a></h4>
                                                </div>
                                                <div class="detail-price card-box">
                                                    {!! productPriceHtml($product) !!}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                  @endforeach 
							
							</div>
                            <div class="listing-load-more product-count" >
                                <span>{{ @$no_of_products }}</span>
                             <?php /*   <div class="load-line">
                                    <span></span>
                                </div>
                                <button type="button">
                                    Load More
                                </button> */ ?>
                            </div>
							
							
							
							@empty(count($getproducts)) 
							<div class="listing-empty-state">
								<i class="fa-solid fa-magnifying-glass"></i>
								<h3>No Products Found</h3>
								@if(!empty($search))
								<p>We couldn't find any pieces matching your current filters. Try adjusting or clearing them to see more results.</p>
								<button type="button" class="primary-btn filter-all-clear">
									Clear All Filters
								</button>
								@endif
							</div>
							@endempty
							
							
							
							
							
                        </div>
                   
                