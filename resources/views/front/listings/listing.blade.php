@extends('layouts.frontLayout.front-layout')
@section('content')
<?php
 use App\CustomFunction;
 use App\Wishlist;
 use App\Category;
 $getcategories = Category::getcategories();
 $page_link = url($catdetails['seo_unique']);
 ?>
<style>
.color-active {
    border: 2px solid #8e313c !important;
}
</style>
<main>
    <div class="container-fluid listing">
        <div class="row" data-aos="fade-right">
            <div class="col-md-12 listing-h3 listing-img">
                <h3>{{ $catdetails['name'] }}</h3>
            </div>

			<div class="row align-items-center m-auto">
				<div class="col-xl-12">
					<div class="filter-heading py-2 px-3 bg-light border">
						<div class="row align-items-center">
							<div class="col-md-3 col-6">
								<!-- Left: Grid Toggle -->
								<div class="view-toggle">
									<button class="btn btn-light active" id="grid-3" title="3 per row">
										<!-- 3-column icon -->
										<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
											<rect x="3" y="3" width="7" height="7"></rect>
											<rect x="14" y="3" width="7" height="7"></rect>
											<rect x="3" y="14" width="7" height="7"></rect>
											<rect x="14" y="14" width="7" height="7"></rect>
										</svg>

									</button>
									<button class="btn btn-light" id="grid-4" title="4 per row">
										<!-- 4-column icon -->
										<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
											<rect x="3" y="3" width="4" height="4"></rect>
											<rect x="10" y="3" width="4" height="4"></rect>
											<rect x="17" y="3" width="4" height="4"></rect>
											<rect x="3" y="10" width="4" height="4"></rect>
											<rect x="10" y="10" width="4" height="4"></rect>
											<rect x="17" y="10" width="4" height="4"></rect>
											<rect x="3" y="17" width="4" height="4"></rect>
											<rect x="10" y="17" width="4" height="4"></rect>
											<rect x="17" y="17" width="4" height="4"></rect>
										</svg>

									</button>
								</div>
							</div>
							<!-- Center: Product Count -->
							<div class="col-md-6 col-12 filter1 text-center">
								<div class="filter-shown-item">
									<p class="mb-0" id="no_of_products">{{ $no_of_products }}</p>
								</div>
							</div>
								@include('front.listings.filters') 
								@include('front.listings.filter-modal') 
						</div>
					</div>
					<!-- /. filter heading -->

					<!-- /. filter content -->
				</div>
				<!-- /. shop products -->
			</div>

			<div id="appnedProductListing">
            @include('front.listings.product-listing')
            </div>
        </div>
    </div>
</main>

   
@stop
@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
			if($('.filtertrue').length > 0) {
	        $(".filterAjax").each( function () {
	            var name = $(this).attr('name');
	            queryStringObject[name] = [];
	            $.each($("input[name='"+$(this).attr('name')+"']:checked"), function(){
	                queryStringObject[name].push($(this).val());
	            });
	            if(queryStringObject[name].length == 0){
	                delete queryStringObject[name];
	            }
	        });
	        var value = $('.getsort option:selected').val();
	        var name= $('.getsort').attr('name');
	        queryStringObject[name] = [value];
	        if(value==""){
	            delete queryStringObject[name];
	        }
	    }
            var page = $(this).attr('href').split('page=')[1];
			var query = {};
			queryStringObject['page'] = page;
            filterproducts(queryStringObject);
        });
		//Add to Wishlist
		$(document).on('click','.addWishList1',function(){
			$('.PleaseWaitDiv').show();
			var proid = $(this).data('productid');
			$.ajax({
				data : {
					"_token": "{{ csrf_token() }}",
					"proid":proid
				},
				type : 'post',
				url : '/add-to-wishlist',
				success:function(resp){	
					if(resp.status){
						if(resp.message ==='set'){
							$('a[data-productid='+proid+']').children().removeClass('fa-heart-o');
							$('a[data-productid='+proid+']').children().addClass('fa-heart');
						}else if(resp.message ==='unset'){
							$('a[data-productid='+proid+']').children().removeClass('fa-heart');
							$('a[data-productid='+proid+']').children().addClass('fa-heart-o');
						}
					}else{
						alert(resp.message);
						if(resp.login == false){
						   window.location.href=resp.url;
						}
					}
					$('.PleaseWaitDiv').hide();
				},
				error:function(){
					//Nothing to do
				}
			});	
		});

		//Filter Products
		var queryStringObject = {};
	    if($('.filtertrue').length > 0) {
	        $(".filterAjax").each( function () {
	            var name = $(this).attr('name'); 
	            queryStringObject[name] = [];
	            $.each($("input[name='"+$(this).attr('name')+"']:checked"), function(){
	                queryStringObject[name].push($(this).val());
	            });
	            if(queryStringObject[name].length == 0){
	                delete queryStringObject[name];
	            }
	        });
	        var value = $('.getsort option:selected').val();
	        var name= $('.getsort').attr('name');
	        queryStringObject[name] = [value];
	        if(value==""){
	            delete queryStringObject[name];
	        }
			
	    }
		 $(".price_slider_amount").click(function(event){ 
				event.preventDefault();		 
		       var filter_price = $("#price_sort").val();
				$("#price_sort").val($.trim(filter_price));
			    $("#price_sort").prop("checked", true); 
				
                var name = 'price';
				queryStringObject[name] = [];
				$.each($("input[name='price']:checked"), function(){
					queryStringObject[name].push($(this).val());
				});
				if(queryStringObject[name].length == 0){
					delete queryStringObject[name];
				}
				
				delete queryStringObject['page']; 
				
				filterproducts(queryStringObject);  
					 setTimeout(function () {
                     $(".PleaseWaitDiv").hide();
                 }, 3000);

			return false;
		 });  
		 
		 $(".ApplyFilter").click(function(){
			 $("#filter-btn").trigger("click")
             var filter_price = $("#price_sort").val();
			$("#price_sort").val($.trim(filter_price));
			$("#price_sort").prop("checked", true); 
			
			var name = 'price';
			queryStringObject[name] = [];
			$.each($("input[name='price']:checked"), function(){
				queryStringObject[name].push($(this).val());
			});
			if(queryStringObject[name].length == 0){
				delete queryStringObject[name];
			}
				
			delete queryStringObject['page'];			 
			 filterproducts(queryStringObject,'1');
			 
		 });
		 
		 $(".ClearFilter").click(function(){
			 window.location.href='<?php echo $page_link; ?>';
		 });
		 
		 $(".filterAjaxMobile").click(function(){
	        var name = $(this).attr('name'); 
	        queryStringObject[name] = [];
	        $.each($("input[name='"+$(this).attr('name')+"']:checked"), function(){
	            queryStringObject[name].push($(this).val());
	        });
	        if(queryStringObject[name].length == 0){
	            delete queryStringObject[name];
	        }
			
			delete queryStringObject['page']; 
			
		   
			
			
			
		
	    });
		 
	    $(".filterAjax").click(function(){
	        $(".PleaseWaitDiv").show();
			
	        var name = $(this).attr('name'); 
	        queryStringObject[name] = [];
	        $.each($("input[name='"+$(this).attr('name')+"']:checked"), function(){
	            queryStringObject[name].push($(this).val());
	        });
	        if(queryStringObject[name].length == 0){
	            delete queryStringObject[name];
	        }
			
			delete queryStringObject['page']; 
			
	        filterproducts(queryStringObject);  
                 setTimeout(function () {
                     $(".PleaseWaitDiv").hide();
                 }, 3000);
	        
	    });
	    
	    $(document).on('change','.getsort',function(){
	        var value = $(this).val();
	        var name= $(this).attr('name');
	        queryStringObject[name] = [value];
	        if(value==""){
	            delete queryStringObject[name];
	        }
			delete queryStringObject['page'];
	        filterproducts(queryStringObject);
	    });
	});
  
    function filterproducts(queryStringObject,reload=0){
       $(".PleaseWaitDiv").show();
        var queryString = "";
        for (var key in queryStringObject) {
            if(queryString==''){
                queryString +="?"+key+"=";
            }else{
                queryString +="&"+key+"=";
            }
            var queryValue = "";
            for (var i in queryStringObject[key]) {
                if(queryValue==''){
                    queryValue += queryStringObject[key][i];
                } else {
                    queryValue += "~"+queryStringObject[key][i];
                }
            }
            queryString += queryValue;
        } 
        if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + queryString;
            window.history.pushState({path:newurl},'',newurl);
        }
        if (newurl.indexOf("?") >= 0) {
            newurl = newurl+"&json=";
        }else{
            newurl = newurl+"?json=";
        } 
		if(reload == 1){
		window.location.reload();
		}
		
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '<?= csrf_token() ?>'
            }
        });
        $.ajax({
            url : newurl,
            type : 'get',
            dataType:'json',
            success:function(resp){
                $("#appnedProductListing").html(resp.view); 
			    $('#no_of_products').html(resp.no_of_products);
			    $("#divindex").focus();
                $("#UpdateProCount").text(resp.countproducts+ " styles");
                $(".PleaseWaitDiv").hide();
            },
            error:function(){}
        });
    }
function changes_categories(url){ 
  window.location.href=url;
}
function select_size(id){ 
		var size_id = '#size-'+id;
        $(size_id).trigger("click");
		
		if($(size_id).is(':checked')){ 
		   $(".filter-size-"+id).addClass('size-active');
		}else{
			$(".filter-size-"+id).removeClass('size-active');
		}
		
}
function select_size2(id){ 
		var size_id = '#pro-size-'+id;
        $(size_id).trigger("click");
		
		if($(size_id).is(':checked')){ 
		   $(".filter-size-"+id).addClass('size-active');
		}else{
			$(".filter-size-"+id).removeClass('size-active');
		}
		
}
function select_color(id){ 
		var color_id = '#color-'+id;
        $(color_id).trigger("click");
		
		if($(color_id).is(':checked')){ 
		   $(".filter-color-"+id).addClass('color-active');
		}else{ 
			$(".filter-color-"+id).removeClass('color-active');
		}
		
}

function select_color2(id){ 
		var color_id = '#pro-color-'+id;
        $(color_id).trigger("click");
		
		if($(color_id).is(':checked')){ 
		   $(".filter-color-"+id).addClass('color-active');
		}else{ 
			$(".filter-color-"+id).removeClass('color-active');
		}
		
}
 
$(document).ready(function(){
          $(".device-filter").click(function(){ 
            $(".sidebar").removeClass('d-none').addClass('d-sm-block').addClass('mobile-filter');
          });
          $(".m-filter-close").click(function(){
            $('.sidebar').addClass('d-none').removeClass('d-sm-block').removeClass('mobile-filter');
          });

        });		
</script>

@stop

