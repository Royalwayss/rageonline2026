@extends('layouts.frontLayout.front-layout')
@section('content')

<style>

.pointer {cursor: pointer;}
.accTabs {
    width: 100%;
    display: inline-block;
    margin-top: 1em;
}
.error{
    color:red;
}
.accTabs ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    gap: 25px;
}

.accTabs ul li {
    display: inline-block;
    background: #fff;
    margin-bottom: 5px;
    border: transparent;
    width: auto;
    text-align: center;
    border-radius: 0;
}

.accTabs ul li a.active {
    color: #8e313c;
    border-bottom: 3px solid #8e313c;
}

.accTabs ul li a {
    color: #7f7f7f;
    display: block;
    font-size: 15px;
    padding: 0 15px;
    line-height: 40px;
    text-decoration: none;
    border-bottom: 3px solid #cdcdcd;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
}
.accTabs ul li {
    display: inline-block;
    margin-bottom: 5px;
    width: auto;
    text-align: center;
    border-radius:0;
}
.accound_btn-style {
    border: none;
    background: #000;
    margin-top: 0;
    color: #fff;
    text-align: center;
    font-size: 14px;
    text-transform: uppercase;
    display: inline-block;
    padding: 10px 35px;
    cursor: pointer;
    letter-spacing: 2px;
}
.form-control {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 13px;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    border-radius: 0;
}

 .form-group {
    width: 50%;
    float: left;
    padding-right: 15px;
    padding-left: 0px;
	margin-bottom: 1rem;
}
</style>

<!-- <div class="container">
	<div class="row" >
		<div class="col-12 p-0">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
				    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
				    <li class="breadcrumb-item active" aria-current="page">My Account</li>
			  	</ol>
			</nav>
		</div>
	</div>
</div> 
 -->
<main>
    <div class="container settings-tab">
    	<div class="row prf-tabs-row">
    		<div class="col-md-9 col-12">
    			<div class="accTabs prf-tabs">
    				<ul>
    					<li class="nav-item"><a @if($slug=="dashboard") href="javascript:;" @else href="{{url('account/dashboard')}}" @endif @if($slug=="dashboard") class="active" @endif >My Profile</a></li>
    					<li class="nav-item"><a @if($slug=="address") href="javascript:;" @else href="{{url('account/address')}}" @endif @if($slug=="address") class="active" @endif >My Address</a></li>
    					<li class="nav-item"><a @if($slug=="orders") href="javascript:;" @else href="{{url('account/orders')}}" @endif @if($slug=="orders") class="active" @endif>Orders</a></li>
    					<li class="nav-item"><a @if($slug=="wishlists") href="javascript:;" @else href="{{url('account/wishlists')}}" @endif @if($slug=="wishlists") class="active" @endif>Wishlist</a></li>
    					<!--<li class="nav-item"><a @if($slug=="address") href="javascript:;" @else href="{{url('account/address')}}" @endif @if($slug=="address") class="active" @endif>My Address</a></li> -->
    					<li class="nav-item"><a @if($slug=="settings") href="javascript:;" @else href="{{url('account/settings')}}" @endif @if($slug=="settings") class="active" @endif>Settings</a></li>
    				</ul>
    			</div>
    		</div>
    		
    		<div class="col-md-3 d-none d-md-block col-12 text-end align-self-center"><a href="{{url('/logout')}}" class="account-logout logout-btn"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a></div>
    	</div>
        <div class="row mt-3">
    		<div class="col-12">
    			@if($slug=="dashboard")
    				@include('front.account.dashboard')
    			@elseif($slug=="settings")
    				@include('front.account.change-password')
    			@elseif($slug=="address")
    				@include('front.address.my-address')
    			@elseif($slug=="orders")
    				@include('front.account.orders')
    			@elseif($slug=="wishlists")
    				@include('front.account.wishlists')
    			@endif
    		</div>
        </div>
    </div>
</main>
@stop