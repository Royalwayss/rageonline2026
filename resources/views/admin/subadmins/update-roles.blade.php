@extends('layouts.adminLayout.backendLayout')
@section('content')
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
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet blue-hoki box ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>{{ $title }}
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="subadminForm" role="form" class="form-horizontal" method="post" action="{{ url('admin/update-role/'.$adminid) }}"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body">
                                @foreach($getModules as $key=> $module)
                                    @if(!empty($getRoleDetails))
                                        @foreach($getRoleDetails as $key => $roledetail)
                                            @if($roledetail['module_id'] == $module['id'])
                                                @if($roledetail['view_access'] ==1)
                                                    <?php $viewChecked ="checked"; ?>
                                                @else
                                                    <?php $viewChecked =""; ?>
                                                @endif
                                                @if($roledetail['edit_access'] ==1)
                                                    <?php $editChecked ="checked"; ?>
                                                @else
                                                    <?php $editChecked =""; ?>
                                                @endif
                                                @if($roledetail['delete_access'] ==1)
                                                    <?php $deleteChecked ="checked"; ?>
                                                @else
                                                    <?php $deleteChecked =""; ?>
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                    <?php   $viewChecked =""; 
                                            $editChecked =""; 
                                            $deleteChecked ="";?>
                                    @endif
                                    <input type="hidden" name="module_id[{{$module['id']}}]" value="{{$module['id']}}">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{$module['name']}}:</label>
                                        <div class="checkbox-list">
                                            <div class="col-md-9">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" rel="{{$module['id']}}" id="view-{{$module['id']}}" data-attr="View" class="getModuleid" name="module_id[{{$module['id']}}][view_access]" value="1"{{$viewChecked}}> View Only </label>
                                                <label class="checkbox-inline">
                                                @if($module['edit_route'] !="")
                                                <input type="checkbox" rel="{{$module['id']}}" data-attr="Edit"  id="edit-{{$module['id']}}" class="getModuleid" name="module_id[{{$module['id']}}][edit_access]" value="1" {{$editChecked}} > View/Edit </label>
                                                @endif
                                                @if($module['delete_route'] !="")
                                                    <label class="checkbox-inline">
                                                    <input type="checkbox" rel="{{$module['id']}}" data-attr="Delete" id="delete-{{$module['id']}}" class="getModuleid" name="module_id[{{$module['id']}}][delete_access]" value="1" {{$deleteChecked}}> View/Edit/Delete</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div> 
                                @endforeach               
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