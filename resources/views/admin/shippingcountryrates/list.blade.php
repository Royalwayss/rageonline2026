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
                <h1> Shipping Country Rates Management</h1>
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
                            <span class="caption-subject font-green-sharp bold uppercase"> Shipping Country Rates </span>
                            <span class="caption-helper">weight-based shipping rates per country</span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="btn-group">
                                        <a href="{{ url('admin/shipping-country-rates/add') }}" class="btn btn-primary">Add Shipping Rate</a>
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
                                            Country
                                        </th>
                                        <th>
                                            0-500g Rate
                                        </th>
                                        <th>
                                            300000g+ Rate
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td></td>
                                        <td><input type="text" class="form-control form-filter input-sm" name="country_name" id="country_name" placeholder="Country Name"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
    document.getElementById('country_name')
      .addEventListener('keyup', function(event) {
        if (event.code === 'Enter') {
          event.preventDefault();
          document.getElementById("search").click();
        }
      });

    // Toggle Active/Inactive switch (event delegation since rows load via ajax)
    document.addEventListener('click', function(e) {
        var el = e.target.closest('.toogle_switch');
        if (!el) return;

        var id = el.getAttribute('id');

        fetch('{{ url("admin/shipping-country-rates/toggle-status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: 'id=' + encodeURIComponent(id)
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                el.classList.toggle('bootstrap-switch-on');
                el.classList.toggle('bootstrap-switch-off');
            } else {
                alert('Could not update status.');
            }
        })
        .catch(function() {
            alert('Status update failed. Check console/logs.');
        });
    });
</script>
@stop
