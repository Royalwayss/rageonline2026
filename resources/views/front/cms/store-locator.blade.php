@extends('layouts.frontLayout.front-layout')
@section('content')
<style>.store-logo{ display: block;
    float: left;
    width: 100px;
    padding-top: 9px;
} </style>
<div class="site-main  main-container no-sidebar">
  <div class="section-037">
    <div class="container">
      <div class="rage-popupvideo style-01 mt-3 pt-2">
        <div class="row">
          <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">Store Locator</li>
          </ol>
        </div>
         <div class="store-list-container">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="store-list">
                  <div class="block-title">
                    <h3 class="title"><span>Store List</span></h3>
                  </div>
                  <div class="items">
                    <ul class="stores">
                    @if(isset($store))
                        @foreach($store as $key=>$storedata)
                          <li>
                            <div class="store-infor">
                              <div class="store-content"> <a class="store-logo" title="Organicdews" href="#"> <img class="img-responsive" src="{{ asset('images/store/'.$storedata->images)}}" alt="Organicdews"> </a>
                                <div class="description">
                                  <h4 class=""> <a href="#">&nbsp;&nbsp;{{ $storedata->store_name }}</a> </h4>
                                  <p> &nbsp;&nbsp;{{ $storedata->address }} </p>
                                  <p>{{ $storedata->city }}-{{ $storedata->pincode }} </p>
                                  <p>Ph : {{ $storedata->phone }}</p>
                                  <button class="action btn-xs btn btn-lightprim font12" title="View Map" type="button"> <span> View Map </span> </button>
                                </div>
                              </div>
                            </div>
                          </li>
                          @endforeach
					  @endif
                    </ul>
                  </div>
                </div>
                
              </div>
              <div class="col-md-8 col-sm-12 col-xs-12">
			  	<div class="map-responsive">

   <iframe src="https://www.google.com/maps/d/embed?mid=1yZUnTXBS_bAjmdv-owCzkvWKoPM&hl=en" width="100%" height="550" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
			  </div>
            </div>
          </div>
	  </div>
    </div>
  </div>
</div>

@stop
@section('javascript')
@parent

@stop