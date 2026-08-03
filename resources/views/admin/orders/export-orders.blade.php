@extends('layouts.adminLayout.backendLayout')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Orders Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\OrdersController@orders') }}">Orders</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet blue-hoki box ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>{{ $title }}
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form  role="form"  class="form-horizontal" method="post" action="{{url('/admin/export-orders')}}"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select Status :</label>
                                    <div class="col-md-5">
                                        <select name="status[]" class="selectbox" multiple="" required>
                                            @foreach($orderstatuses as $ostatus)
                                                <option value="{{ $ostatus['name']}}">{{ $ostatus['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">From Date: </label>
                                    <div class="col-md-5">
                                        <input name="from_date" type="text" autocomplete="off" placeholder="From Date"  style="color:gray" class="form-control datePicker"/>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">To Date: </label>
                                    <div class="col-md-5">
                                        <input name="to_date" type="text" autocomplete="off" placeholder="To Date"  style="color:gray" class="form-control datePicker"/>
                                    </div>
                                </div>           
                            </div>
                            <div class="form-actions right1 text-center">
                                <button class="btn green" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop