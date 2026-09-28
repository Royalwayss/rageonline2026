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
                <h1> Exchange Rates Management</h1>
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
                            <span class="caption-subject font-green-sharp bold uppercase"> Exchange Rates </span>
                           
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-12" style="display:flex; align-items:center; flex-wrap:wrap; gap:12px;">
                                    <div class="btn-group">
                                        <a href="{{ url('admin/exchange-rates/sync-now') }}" class="btn btn-success" onclick="return confirm('Are you sure you want to sync exchange rates now?')">
                                            <i class="fa fa-refresh"></i> Sync Now
                                        </a>
                                    </div>
                                    <div style="background:#f4f4f4; border-radius:4px; padding:6px 12px; font-size:12px; color:#555;">
                                        <span id="last-synced-text">Last synced: {{ $lastSyncedAt }}</span>
                                        &nbsp;|&nbsp;
                                        Rates auto-sync automatically every day at 12:00 AM.
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
                                            Currency Code
                                        </th>
                                        <th>
                                            Country Name
                                        </th>
                                        <th>
                                            Rate (1 INR =)
                                        </th>
                                        <th>
                                            100 INR =
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Last Synced
                                        </th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td></td>
                                        <td><input type="text" class="form-control form-filter input-sm" name="currency_code" id="currency_code" placeholder="Currency Code"></td>
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
    document.getElementById('currency_code')
      .addEventListener('keyup', function(event) {
        if (event.code === 'Enter') {
          event.preventDefault();
          document.getElementById("search").click();
        }
      });

    document.getElementById('country_name')
      .addEventListener('keyup', function(event) {
        if (event.code === 'Enter') {
          event.preventDefault();
          document.getElementById("search").click();
        }
      });

 
</script>
@stop