@extends('layouts.adminLayout.backendLayout')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Subscribers Management</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! url('/admin/dashboard') !!}">Dashboard</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-green-sharp bold uppercase">Subscribers</span>
                        <span class="caption-helper">manage records...</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a href="{{url('admin/export-subscribers')}}" class="btn btn-primary">Click to Export Data</a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                            <thead>
                                <tr role="row" class="heading">
                                    <th>
                                        No.
                                    </th>
                                    <th>
                                     Email
                                    </th>
                                    <th>
                                     Actions
                                    </th>
                                </tr>
                                <tr role="row" class="filter">
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control form-filter input-sm" name="email" placeholder="Email">
                                    </td>
                                    <td>
                                        <div class="margin-bottom-5">
                                            <button class="btn btn-sm yellow filter-submit margin-bottom"><i title="Search" class="fa fa-search"></i></button>

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
@endsection
