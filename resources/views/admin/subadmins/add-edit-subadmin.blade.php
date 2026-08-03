@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
    .form-control-feedback {
      top: 9px !important;
    }
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>SubAdmin's Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! action('App\Http\Controllers\Admin\AdminController@dashboard') !!}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\AdminController@subadmins') }}">SubAdmins</a>
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
                        <form  role="form"  id="addEditSubadmin" class="form-horizontal" method="post" @if(empty($admindata)) action="{{ url('admin/add-edit-subadmin') }}" @else  action="{{ url('admin/add-edit-subadmin/'.$admindata['id']) }}" @endif> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name :</label>
                                    <div class="col-md-5">
                                        <input type="text" placeholder="Full Name" name="name" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($admindata['name']))?$admindata['name']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Email: </label>
                                    <div class="col-md-5">
                                        <input type="text" autocomplete="off" placeholder="Email" name="email" style="color:gray" class="form-control"    value="{{(!empty($admindata['email']))?$admindata['email']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Mobile: </label>
                                    <div class="col-md-5">
                                        <input type="text" autocomplete="off" placeholder="Mobile" name="mobile"  style="color:gray" class="form-control" value="{{(!empty($admindata['mobile']))?$admindata['mobile']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status :</label>
                                    <div class="col-md-5">
                                        <select name="status" class="selectbox"> 
                                            <?php $statusArr = array('1'=>'Active','0'=>'Inactive'); ?>
                                            @foreach($statusArr as $key => $status)
                                                <option value="{{$key}}" @if(!empty($admindata['status']) && $admindata['status'] == $key) selected @endif>{{$status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if(empty($admindata))
                                    <div class="form-group ">
                                        <label class="col-md-3 control-label">Password: </label>
                                        <div class="col-md-5">
                                            <input type="password" placeholder="Password" name="password"  style="color:gray" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                    <label class="col-md-7 control-label"><p>Note : Minimum 8 alphanumeric characters.</p> </label>
                                    </div>
                                @endif           
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