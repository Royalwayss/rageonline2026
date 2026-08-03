<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Product Attributes</title>
      <!-- Bootstrap CSS -->
      
      
      <link href="{{ asset('css/backend_css/bootstrap-5-3-2.min.css') }}" rel="stylesheet" />
      <link href="{{ asset('css/backend_css/select2.min.css') }}" rel="stylesheet" />
      <link href="{{ asset('css/backend_css/stock-management.css') }}?v=2.5" rel="stylesheet" />
      <style>
		.qty-red {
			background: red;
			color:#fff;
			min-width:50px;
		}

		/* Green color class */
		.qty-green {
			background: green;
			color:#fff;
			min-width:50px;
		}

		.btn {
			border-width: 0;
			padding: 7px 14px;
			font-size: 14px;
			outline: none !important;
			background-image: none !important;
			filter: none;
			-webkit-box-shadow: none;
			-moz-box-shadow: none;
			box-shadow: none;
			text-shadow: none;
		}
      </style>
   </head>
   <body>
      <div class="container mt-4">
         <div class="row ">
            <div class="col-6">
				<h3 class="text-right">Stock Management</h3>
			</div>
			<div class="col-6 mt7">
				<a class="backtobtn text-right" href="{{ url('admin/products') }}">Back to Products</a>
			</div>
			
         </div>
         <div class="row">
            <form class="filter-form" id="filterForm" action="javascript:;">
               @csrf
               <?php
                  $productCats = [];
                  $stock_from = '';
                  $stock_to = '';
                  $keyword = '';
                  if(Session::has('stock_filter')){
                  
                  if(isset(Session::get('stock_filter')['cats'])){
                  $productCats = Session::get('stock_filter')['cats'];
                  }
                  
                  if(isset(Session::get('stock_filter')['stock_from'])){
                  $stock_from = Session::get('stock_filter')['stock_from'];
                  } 
                  if(isset(Session::get('stock_filter')['stock_to'])){
                  $stock_to = Session::get('stock_filter')['stock_to'];
                  } 
                  if(isset(Session::get('stock_filter')['keyword'])){
                  $keyword = Session::get('stock_filter')['keyword'];
                  }  
                  
                  
                  
                  }
                  
                  ?>
               <!-- Category Field -->
               <div class="row">
               <div class="col-4">
                  <label for="category">Category:</label>
                  <select name="cats[]" id="cats" class="selectbox MultipleSelect"  multiple  >
					  <?php foreach ($categories as $key => $category) {?>
					  <option value="{{$category['id']}}" @if(in_array($category['id'],$productCats)) selected @endif>&#9679;&nbsp;{{$category['name']}}</option>
						  <?php if(!empty($category['subcategories'])){
							 foreach ($category['subcategories'] as $key => $subcat) { ?>
							 <option value="{{$subcat['id']}}" @if(in_array($subcat['id'],$productCats)) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subcat['name']}}</option>
							  <?php foreach ($subcat['subcategories'] as $key => $subsubcat) { ?>
									<option value="{{$subsubcat['id']}}" @if(in_array($subsubcat['id'],$productCats)) selected @endif>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&raquo; &raquo; &nbsp;{{$subsubcat['name']}}</option>
							  <?php 
							   } 
							 }
						 }
                     } ?>
                  </select>
               </div>
               <!-- Stock From and To -->
               <div class="col-2">
                  <label for="stock-from">Stock From:</label>
                  <input type="number" id="stock-from" name="stock_from" min="0"  value="{{ $stock_from }}" placeholder="stock from">
               </div>
               <div class="col-1">
                  <label for="stock-to">Stock To:</label>
                  <input type="number" id="stock-to" name="stock_to" min="0" value="{{ $stock_to }}" placeholder="stock to">
               </div>
               <!-- Search Keyword -->
               <div class="col-3">
                  <label for="search-keyword">Search Keyword:</label>
                  <input type="text" id="search-keyword" name="keyword" value="{{ $keyword }}" placeholder="product name,category name,sku,size ....">
               </div>
               <div class="col-2">
                  <!-- Submit Button -->
                  <button type="submit" >Apply Filters</button>
               </div>
			   
            </form>
         </div>
         </div>
		 
		 <div class="">
            <p id="product_count">
                
            </p>
        </div>
		 
		 
		 
		 
         <table class="table table-bordered table-hover table-striped w-100">
            <thead class="attr-table-head">
               <tr>
                  <th data-column="products.product_code">Product <span class="sort-icon">↕</span></th>
                  <th data-column="categories.name">Category<span class="sort-icon">↕</span></th>
                  <th data-column="product_attributes.sku">SKU <span class="sort-icon">↕</span></th>
                  <th data-column="product_attributes.size">Size <span class="sort-icon">↕</span></th>
                  <th data-column="product_attributes.price">Price <span class="sort-icon">↕</span></th>
                  <th data-column="product_attributes.stock">Stock <span class="sort-icon">↕</span></th>
                  <th data-column="product_attributes.id" >Action</th>
               </tr>
            </thead>
            <tbody id="table-data"></tbody>
         </table>
      </div>
      <div id="loader">
         <div class="loader-spinner"></div>
      </div>
	  
	  <!-- Modal -->
        <!-- Modal -->
<div class="modal fade" id="stockLogModal" tabindex="-1" aria-labelledby="stockLogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="stockLogModalLabel">Product Stock Logs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal Body with Table -->
      <div class="modal-body" id="attribute_logs">
        
	  </div>
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

   

	  
      <!-- jQuery -->
      <script type="text/javascript" src="{!! asset('js/backend_js/jquery.min.js') !!}" ></script>
      <script type="text/javascript" src="{!! asset('js/backend_js/select2.full.min.js') !!}" type="text/javascript"></script>
      <script type="text/javascript" src="{!! asset('js/backend_js/bootstrap.bundle.min.js') !!}" type="text/javascript"></script>
     
	 
	 <script>
    $(document).ready(function() {
        // Initialize Select2 for the category dropdown
        $('#cats').select2({
            placeholder: 'select category',
            allowClear: true
        });

        // Filter form submission
        $('#filterForm').submit(function(event) {
            event.preventDefault();  // Prevent default form submission

            // Serialize the form data
            var formData = $(this).serialize();

            
			
			// Send data using AJAX
            $.ajax({
                url: "{{ route('product.attributes.filterStock') }}",  // Your server-side URL for processing
                type: 'POST',
                data: formData,
                success: function(response) {
                    loadData();
                },
                error: function(xhr, status, error) {
                    // Display error message
                    
                }
            });
        });
		
		
		$(document).on('click', '.stock_logs', function() {
           var id =$(this).attr('data-id'); 
          
		   
		   var csrfToken = $('meta[name="csrf-token"]').attr('content');
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': csrfToken
				}
			});
		   
		   $.ajax({
                url: "{{ route('product.attributes.logs') }}", // The route defined for AJAX
                type: 'POST',
                data: {id:id},
                success: function(response) {
                    
                     $('#attribute_logs').html(response.html);
                     $("#stockLogModal").modal('show');
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error); // Handle error
                }
            });
		   
		   
		   
		   
		   
		   
        })
		
		
		

        let sortColumn = 'id';
        let sortOrder = 'desc';

        // Load data via AJAX
        function loadData(page = 1) {
            $('#loader').show();
            $.get("{{ route('product.attributes.fetch') }}", {
                page: page,
                sortColumn: sortColumn,
                sortOrder: sortOrder
            }, function(data) {
                $('#table-data').html(data.html);
                $('#product_count').html(data.product_count);
                $('#loader').hide();
            });
        }

        loadData();

        // Column sorting
        $('th').click(function() {
            let column = $(this).data('column');
            if (sortColumn === column) {
                sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                sortColumn = column;
                sortOrder = 'asc';
            }

            // Reset all icons
            $('.sort-icon').css('transform', 'rotate(0deg)');

            // Rotate clicked icon
            $(this).find('.sort-icon').css('transform', sortOrder === 'asc' ? 'rotate(180deg)' : 'rotate(0deg)');

            loadData();
        });

        // Pagination click
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault(); // prevent full page reload
            var page = $(this).attr('href').split('page=')[1];
            if (page) loadData(page);
        });

        // AJAX update stock
        function updateStock(id, stock, inputEl) {
            $.post("{{ route('product.attributes.updateStock') }}", {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                stock: stock
            }, function(res) {
                if (res.success) {
                    // Flash effect
                    inputEl.addClass('updated');
                    setTimeout(() => inputEl.removeClass('updated'), 500);

                    // Low stock highlight
                    if (stock < 5) inputEl.addClass('low-stock');
                    else inputEl.removeClass('low-stock');
                }
            });
        }

        // Increase / Decrease buttons
        $(document).on('click', '.increase-stock, .decrease-stock', function() {
            let group = $(this).closest('.stock-group');
            let input = group.find('.stock-input');
            let current = parseInt(input.val()) || 0;

            if ($(this).hasClass('increase-stock')) current += 1;
            else current = Math.max(0, current - 1);

            input.val(current);
            updateStock(group.data('id'), current, input);
        });

        // Manual input change
        $(document).on('change', '.stock-input', function() {
            let id = $(this).closest('.stock-group').data('id');
            let val = parseInt($(this).val()) || 0;
            $(this).val(val); // Sanitize negative values

            // Call AJAX update
            updateStock(id, val, $(this));
        });
    });
</script>

   </body>
</html>