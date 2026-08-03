@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
.table-scrollable table tbody tr td{
    vertical-align: middle;
}
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1> Products Management</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! url('admin/dashboard') !!}">Dashboard</a>
            </li>
        </ul>
         @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green-sharp bold uppercase"> Products </span>
                            <span class="caption-helper">manage records...</span>
                            <span class="caption-helper"><a href="{{url('admin/export-attribute')}}" class="btn btn-success" style="font-size: 9px;">Export Product Attributes</a></span>
                            <span class="caption-helper"><a href="{{url('admin/export-product')}}" class="btn btn-info" style="font-size: 9px;">Export Product</a></span>
                            <span class="caption-helper"><a href="{{url('admin/export-images')}}" class="btn btn-warning" style="font-size: 9px;">Export Product Image</a></span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="btn-group">
                                       <a href="{{action('App\Http\Controllers\Admin\ProductsController@addEditProduct')}}" class="btn btn-primary">Add Product</a>
                                    </div>
                                </div>
								 <div class="col-md-3">
                                    <div class="btn-group">
                                       <a  href="{{ route('product_attributes') }}" class="btn btn-primary">Stock Management</a>
                                    </div>
                                </div> 
                        <div class="actions">
                            <div class="btn-group" style="float: right;">
                                <a href="{{url('admin/export-stock')}}" class="btn btn-primary">Export Product Stock</a>
                            </div>
                        </div>
                            </div>
                        </div>
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Article Code    
                                        </th>
                                        <th>
                                            Image
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            SKU-QTY
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td><input type="text" class="form-control form-filter input-sm" name="id" id="id" placeholder="ID"></td>
                                        <td><input type="text" class="form-control form-filter input-sm" name="product_code" id="product_code" placeholder="Product Code"></td>
                                        <td></td>
                                        <td><input type="text" class="form-control form-filter input-sm" name="p_name" id="p_name" placeholder="Product Name"></td>
                                        <td></td>
                                        <!--<td><input type="text" class="form-control form-filter input-sm" name="sku" placeholder="Product Code"></td>-->
                                        <td><input type="text" class="form-control form-filter input-sm" name="cat_name" id="cat_name" placeholder="Category"></td>
                                        <td>
                                            
                                            <select class="form-control form-filter input-sm" name="status">
                                                 <option value="">All</option>
                                                 <option value="1">Active</option>
                                                  <option value="0">In Active</option>
                                            </select>
                                            
                                        </td>
                                        <td>
                                            <div class="margin-bottom-5">
                                                <button class="btn btn-sm yellow filter-submit margin-bottom" id="search"><i title="Search" class="fa fa-search"></i></button>
                                                <button class="btn btn-sm red filter-cancel"><i title="Reset" class="fa fa-refresh"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function ConfirmDelete() {
        if(confirm('Are you sure you want to delete this category')){
            e.preventDefault();
            return true;
        }
        return false;
    }
    document.getElementById('product_code')
      .addEventListener('keyup', function(event) {
        if (event.code === 'Enter') {
          event.preventDefault();
          document.getElementById("search").click(); 
        }
      }); 
      
    document.getElementById('p_name')
      .addEventListener('keyup', function(event) {
        if (event.code === 'Enter') {
          event.preventDefault();
          document.getElementById("search").click(); 
        }
      });
      
    document.getElementById('cat_name')
      .addEventListener('keyup', function(event) {
        if (event.code === 'Enter') {
          event.preventDefault();
          document.getElementById("search").click(); 
        }
      });
</script>
@stop





