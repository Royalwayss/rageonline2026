@extends('layouts.adminLayout.backendLayout')
@section('content')
<link rel="stylesheet" href="{!!asset('css/backend_css/select2.min.css')!!}">
<link rel="stylesheet" href="{!!asset('css/backend_css/bootstrap/css/select2-bootstrap4.min.css')!!}">
<style>
    #sortTags { list-style: none; margin: 0; padding: 14px; border: 1px solid #cfd8e6; border-radius: 8px; min-height: 60px; background: #f6f8fc; }
#sortTags li { display: inline-block; margin: 4px; padding: 6px 12px 6px 6px; background: #fff; color: #1e2a4a; border: 1.5px solid #b9c6dc; border-left: 4px solid #3b6fb6; border-radius: 8px !important; cursor: move; font-size: 13px; user-select: none; box-shadow: 0 1px 3px rgba(30,42,74,.10); transition: box-shadow .15s, border-color .15s, transform .15s; }
#sortTags li:hover { border-color: #3b6fb6; box-shadow: 0 4px 10px rgba(59,111,182,.22); transform: translateY(-1px); }
#sortTags li.inactive-product { background: #f3f4f7; color: #7a8499; border-color: #cfd4de; border-left-color: #9aa3b5; border-style: solid; }
#sortTags li .tag-no { display: inline-block; min-width: 24px; margin-right: 6px; padding: 1px 6px; background: #1e2a4a; color: #fff; border-radius: 4px !important; text-align: center; font-size: 12px; }
#sortTags li.inactive-product .tag-no { background: #9aa3b5; }
#sortTags li .tag-code { display: inline-block; margin-right: 6px; padding: 1px 7px; background: #e3f6ee; color: #0b7a55; font-weight: 600; border-radius: 4px !important; }
#sortTags li.inactive-product .tag-code { background: #e8eaef; color: #6b7487; }
#sortTags li.sortable-ghost { opacity: .4; }
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1> Products Sort</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li><a href="{!! url('admin/dashboard') !!}">Dashboard</a></li>
            <li><a href="{!! url('admin/products') !!}">Products</a></li>
        </ul>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green-sharp bold uppercase"> Products Sort </span>
                            <span class="caption-helper">drag and drop to change the order...</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="sortMessage"></div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Category <span class="red">*</span></label>
                                <select id="category_id" class="form-control select2">
                                    <option value="">Select Category</option>
                                    <?php foreach ($getCategories as $key => $category) {?>
                                    <option value="{{$category['id']}}">&#9679;&nbsp;{{$category['name']}}</option>
                                    <?php if(!empty($category['subcategories'])){
                                        foreach ($category['subcategories'] as $subcat) { ?>
                                            <option value="{{$subcat['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subcat['name']}}</option>
                                            <?php if(!empty($subcat['subcategories'])){ foreach ($subcat['subcategories'] as $subsubcat) { ?>
                                            <option value="{{$subsubcat['id']}}">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&raquo; &raquo; &nbsp;{{$subsubcat['name']}}</option>
                                    <?php } }
                                        }
                                    }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Default Sort Type <span class="red">*</span></label>
                                <select id="sort_type" class="form-control">
                                    <option value="">Select Sort Type</option>
                                    <option value="current" selected>Current Sort</option>
                                    <option value="highest_sale">Highest Sale</option>
                                    <option value="new_to_old">New to Old</option>
                                    <option value="old_to_new">Old to New</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Status <span class="red">*</span></label>
                                <select id="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="active" selected>Active</option>
                                    <option value="deactive">Deactive</option>
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:15px;">
                            <div class="col-md-12">
                                <button type="button" id="searchSort" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                <button type="button" id="clearSort" class="btn btn-default"><i class="fa fa-refresh"></i> Clear</button>
                            </div>
                        </div>

                        <div id="sortArea" style="display:none;">
                            <p class="text-muted">
                                <span id="sortCount"></span> Drag the tags to change the order, then click Submit.
                                <span style="margin-left:10px;"><span class="label label-info">Active</span> <span class="label label-default">Deactive</span></span>
                            </p>
                            <ul id="sortTags"></ul>
                            <div style="margin-top:15px;">
                                <button type="button" id="submitSort" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <div id="sortEmpty" class="alert alert-warning" style="display:none;">No products found for the selected filters.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{!!asset('js/backend_js/select2.full.min.js')!!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
$(function () {
    var csrf = '{{ csrf_token() }}';
    var sortUrl  = '{{ url("admin/products-sort/fetch") }}';
    var saveUrl  = '{{ url("admin/products-sort/save") }}';

    $('#category_id').select2({ placeholder: 'Select Category', allowClear: false });

    function showMessage(type, text) {
        $('#sortMessage').html('<div role="alert" class="alert alert-' + type + ' alert-dismissible fade in"><button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button>' + $('<div>').text(text).html() + '</div>');
    }

    function renumber() {
        $('#sortTags li').each(function (i) { $(this).find('.tag-no').text(i + 1); });
    }

    var sortable = Sortable.create(document.getElementById('sortTags'), {
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: renumber
    });

    function loadProducts() {
        var category = $('#category_id').val(), sortType = $('#sort_type').val(), status = $('#status').val();
        $('#sortMessage').empty();
        if (!category || !sortType || !status) { $('#sortArea, #sortEmpty').hide(); showMessage('danger', 'Please select Category, Default Sort Type and Status, then click Search.'); return; }

        $.ajax({
            url: sortUrl, type: 'POST', dataType: 'json',
            data: { _token: csrf, category_id: category, sort_type: sortType, status: status },
            success: function (res) {
                $('#sortTags').empty();
                if (!res.status) { showMessage('danger', res.message); $('#sortArea, #sortEmpty').hide(); return; }
                if (!res.products.length) { $('#sortArea').hide(); $('#sortEmpty').show(); return; }
                $('#sortEmpty').hide();
                $.each(res.products, function (i, p) {
                    var li = $('<li>').attr('data-id', p.id).toggleClass('inactive-product', p.status != 1);
                    li.append($('<span class="tag-no">').text(i + 1));
                    if (p.code) { li.append($('<span class="tag-code">').text(p.code)); }
                    li.append(document.createTextNode(p.name));
                    var tip = '';
                    if (p.sold !== null) { tip = 'Sold: ' + p.sold; }
                    li.attr('title', tip);
                    $('#sortTags').append(li);
                });
                $('#sortCount').text(res.products.length + ' product(s).');
                $('#sortArea').show();
            },
            error: function () { showMessage('danger', 'Something went wrong. Please try again.'); }
        });
    }

    $('#searchSort').on('click', loadProducts);
    $('#clearSort').on('click', function () {
        $('#category_id').val('').trigger('change');
        $('#sort_type, #status').val('');
        $('#sortTags').empty();
        $('#sortArea, #sortEmpty').hide();
        $('#sortMessage').empty();
    });
    // changing a filter hides the old list until Search is clicked again
    $('#category_id, #sort_type, #status').on('change', function () { $('#sortArea, #sortEmpty').hide(); $('#sortMessage').empty(); });

    $('#submitSort').on('click', function () {
        var ids = $('#sortTags li').map(function () { return $(this).data('id'); }).get();
        if (!ids.length) { return; }
        var btn = $(this).prop('disabled', true);
        $.ajax({
            url: saveUrl, type: 'POST', dataType: 'json',
            data: { _token: csrf, product_ids: ids },
            success: function (res) { showMessage(res.status ? 'success' : 'danger', res.message); },
            error: function () { showMessage('danger', 'Could not save the order. Please try again.'); },
            complete: function () { btn.prop('disabled', false); $('html,body').animate({scrollTop: 0}, 200); }
        });
    });
});
</script>
@stop