						
								  <table style="width:100%">
								  
								   <thead>
		
										<th style="width:80%" colspan="2">Top Sale Categories</th>
										<th style="width:20%">Units Sold</th>
								   </thead>
								   <tbody>
										@if(!empty($sales))
										@foreach($sales as $key => $sale)
										<?php 
											if($key != 0){
												if(!empty($sale['total_quantity_sold'])){
													$width = round(($sale['total_quantity_sold']/$total_quantity_sold)*100);
												}else{
													$width = 0;
												}
											}else{
												$width = 100;
											}
										?>
										<tr>
											<td style="padding:5px;width:10%" >
											     @if(!empty($sale['image']))
												     <img width="30px" src="{{ asset('images/CategoryImages/'.$sale['image']) }}">
												 @else
													 <img width="67px" src="{{ asset('images/default.png') }}"> 
												 @endif
											</td>
											<td  style="width:70%">
											  <div class="process-bar-content top-conversions-links">
												 <span @if($key == 0) style="width:{{ $width }}%;background:green!important;" @else style="width:{{ $width }}%;background:#90EE90!important;" @endif ></span>
												 
												
												 <a title="{{ $sale['category_name'] }}" target="_block" href="{{ url('admin/add-edit-category/'.$sale['category_id']) }}">{{ $sale['category_name'] }}</a>
											   </div>
											</td>
											<td>
												<div class="col-3 span-right color-27272A" >{{ $sale['total_quantity_sold'] }}</div>
											</td>
										</tr>
										@endforeach
										@else
										<tr>
											<td colspan="2" style="text-align:center">No sales found</td>
										</tr>
										@endif
										
								   </tbody>
								   
							   </table>
							  
							 