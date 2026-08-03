@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
    .form-control-feedback {
    top: 9px !important;
    }
    .form-group select {
    float:left;
    display: inline-block;
    width:100%;
    padding: 6px 12px;
    }
</style>
<div class="page-content-wrapper">
    @if(Session::has('flash_message_error'))
    <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
    @endif
    @if(Session::has('flash_message_success'))
    <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
    @endif
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Stores Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('admin/stores') }}">Stores </a>
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
                        <form id="addEditStoreForm" role="form" class="form-horizontal" method="post" @if(!empty($storedata['id'])) action="{{ url('admin/add-edit-store/'.$storedata['id']) }}" @else action="{{ url('admin/add-edit-store') }}" @endif enctype="multipart/form-data"> 
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Store Name :</label>
                                <div class="col-md-5">
                                    <input type="text" placeholder="Store Name" name="store_name" style="color:gray" class="form-control" value="{{(!empty($storedata['store_name']))?$storedata['store_name']: '' }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Select State/City :</label>
                                <div class="col-md-5">
                                    <select name="city" class="form-control">
                                        <option value="">Please Select</option>
                                        @foreach($states as $state)
                                            <optgroup label="{{$state['name']}}">
                                                @foreach($state['cities'] as $city)
                                                    <option value="{{$state['name']}}-{{$city['city']}}" @if(!empty($storedata) && $storedata['city'] == $city['city']) selected @endif>{{$city['city']}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Phone:</label>
                                <div class="col-xs-5">
                                    <input type="text" placeholder="Phone" class="form-control placepicker" name="phone" value="{{(!empty($storedata['phone']))?$storedata['phone']: '' }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Email:</label>
                                <div class="col-xs-5">
                                    <input type="text" placeholder="Email" class="form-control placepicker" name="email" value="{{(!empty($storedata['email']))?$storedata['email']: '' }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Address:</label>
                                <div class="col-xs-5">
                                    <input type="text" placeholder="Address" class="form-control placepicker" name="address" value="{{(!empty($storedata['address']))?$storedata['address']: '' }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Pincode:</label>
                                <div class="col-xs-5">
                                    <input type="text" placeholder="Pincode" class="form-control placepicker" name="pincode" value="{{(!empty($storedata['pincode']))?$storedata['pincode']: '' }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Latitude:</label>
                                <div class="col-xs-5">
                                    <input type="text" placeholder="Latitude" class="form-control placepicker" name="latitude" value="{{(!empty($storedata['latitude']))?$storedata['latitude']: '' }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Longitude:</label>
                                <div class="col-xs-5">
                                    <input type="text" placeholder="Longitude" class="form-control placepicker" name="longitude" value="{{(!empty($storedata['longitude']))?$storedata['longitude']: '' }}"/>
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
@endsection