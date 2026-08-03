<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 100%;
            padding: 20px;
        }
        table {
            width: 100%;
        }
        .table th, .table td {
            text-align: center;
            cursor: pointer;
        }
        .pagination {
            justify-content: center;
        }
        .form-control {
            width: 120px;
            margin: 0 auto;
        }
        .btn {
            margin-top: 5px;
        }
        .sorted-asc::after {
            content: ' 🔼';
        }
        .sorted-desc::after {
            content: ' 🔽';
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mb-4">Product Attributes</h1>

    <table class="table table-bordered" id="product-table">
        <thead>
            <tr>
                <th id="sort-id" data-column="id" data-order="asc">#</th>
                <th id="sort-sku" data-column="sku" data-order="asc">SKU</th>
               
                <th id="sort-size" data-column="size" data-order="asc">Size</th>
                <th id="sort-color" data-column="color" data-order="asc">Color</th>
                <th id="sort-stock" data-column="stock" data-order="asc">Stock</th>
                
            </tr>
        </thead>
        <tbody id="update-pagination">
            @include('admin.products.table_rows')
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        {{ $productAttributes->appends(['sort' => $sortField, 'order' => $sortOrder])->links() }}
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Set initial column sorting (by default, the first column sorted)
    let currentSortColumn = 'id';
    let currentSortOrder = 'asc';

    // Handle header click to sort table
    $('th').click(function() {
        const column = $(this).data('column');
        const order = $(this).data('order');
        
        // Toggle the order (asc <-> desc)
        currentSortOrder = order === 'asc' ? 'desc' : 'asc';
        
        // Update the sort order on the clicked header
        $('th').data('order', 'asc'); // Reset all columns to 'asc'
        $(this).data('order', currentSortOrder); // Set the clicked column's order

        // Call the function to load the sorted data via AJAX
        loadSortedData(column, currentSortOrder);
    });

    // Function to load sorted data via AJAX
    function loadSortedData(sortColumn, sortOrder) {
        $.ajax({
            url: "{{ url('admin/stocks') }}", // Laravel url
            method: "GET",
            data: {
                sort: sortColumn,
                order: sortOrder
            },
            success: function(response) {
                // Replace table body with the new sorted data
                $('#update-pagination').html(response.html); 
                // Update pagination
                $('.pagination').html(response.pagination);
            }
        });
    }
});
</script>

</body>
</html>
