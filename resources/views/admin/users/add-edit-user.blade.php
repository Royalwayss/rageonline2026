@extends('layouts.adminLayout.backendLayout')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>User Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\UsersController@users') }}">Users</a>
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
                        <form  role="form"  id="addEditUser" class="form-horizontal" method="post" @if(empty($userdata)) action="{{ url('admin/add-edit-user') }}" @else  action="{{ url('admin/add-edit-user/'.$userdata['id']) }}" @endif> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Name :</label>
                                    <div class="col-md-5">
                                        <input type="text" placeholder="Name" name="name" style="color:gray" autocomplete="off" class="form-control" pattern="[A-Za-z]"  value="{{(!empty($userdata['name']))?$userdata['name']: '' }}"/>
                                    </div>
                                </div>
                               
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Email: </label>
                                    <div class="col-md-5">
                                        <input type="text" autocomplete="off" placeholder="Email"  style="color:gray" class="form-control" @if(!empty($userdata['email']))   value="{{(!empty($userdata['email']))?$userdata['email']: '' }}" readonly @else name="email" @endif/>
                                    </div>
                                </div>
                                <div class="form-group" style="display:none">
                                    <label class="col-md-3 control-label">Select Gender :</label>
                                    <div class="col-md-5">
                                        <select name="gender" class="selectbox"> <?php $genderArray = array('Male','Female','Other'); ?>
                                            <option value="">Select</option>
                                            @foreach($genderArray as $gender)
                                                @if(!empty($userdata['gender']) && $userdata['gender'] == $gender)
                                                    <?php $gselected = "selected";?>
                                                @else
                                                    <?php $gselected = "";?>
                                                @endif
                                                <option value="{{ $gender}}" {{$gselected}}>{{ $gender }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Mobile: </label>
                                    <div class="col-md-5">
                                        <input type="text" autocomplete="off" placeholder="Mobile" name="mobile"  style="color:gray" class="form-control" value="{{(!empty($userdata['mobile']))?$userdata['mobile']: '' }}"/>
                                    </div>
                                </div>
								
								 <div class="form-group ">
                                    <label class="col-md-3 control-label">Date of Birth: </label>
                                    <div class="col-md-5">
                                        <input type="date" autocomplete="off"  name="dob"  style="color:gray" class="form-control" value="{{(!empty($userdata['dob']))?$userdata['dob']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Address: </label>
                                    <div class="col-md-5">
                                        <input type="text" autocomplete="off" placeholder="Address" name="address"  style="color:gray" class="form-control" value="{{(!empty($userdata['address']))?$userdata['address']: '' }}"/>
                                    </div>
                                </div>
								 <div class="form-group ">
                                    <label class="col-md-3 control-label">Address2: </label>
                                    <div class="col-md-5">
                                        <input type="text" autocomplete="off" placeholder="Address2" name="address2"  style="color:gray" class="form-control" value="{{(!empty($userdata['address2']))?$userdata['address2']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Postcode: </label>
                                    <div class="col-md-5">
                                        <input type="text" autocomplete="off" placeholder="Postcode" name="postcode"  style="color:gray" class="form-control user_pincode" maxlength="6" value="{{(!empty($userdata['postcode']))?$userdata['postcode']: '' }}"/>
                                    </div>
                                </div>
                               
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">State: </label>
                                   
									<div class="col-md-5">
									 <select class="form-control user_state" name="state" id="state">
									   <option value="">Select the state </option>
									   @foreach($states as $state)
									      <option value="{{ $state  }}"
                                         <?php

												if(!empty($userdata['state'])) { if($state  == $userdata['state'] ){ echo 'selected'; }   }
                                          ?>										 
										  
										  > {{ $state  }}</option>
									   @endforeach
									 </select>
									</div>
									
									
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">City: </label>
                                    <div class="col-md-5">
                                        <input type="text" autocomplete="off" placeholder="City" name="city" pattern="[A-Za-z]"   style="color:gray" class="form-control user_city" value="{{(!empty($userdata['city']))?$userdata['city']: '' }}"/>
                                    </div>
                                </div>
								
								
								
								 <div class="form-group">
                                    <label class="col-md-3 control-label">Select Country :</label>
                                    <div class="col-md-5">
                                        <select name="country" class="selectbox"> 
                                            <option value="">Select</option>
                                            <option value="India" selected>India</option>
                                        </select>
                                    </div>
                                </div>
								
								
								
								
								
                                <?php /*<div class="form-group">
                                    <label class="col-md-3 control-label">Select State :</label>
                                    <div class="col-md-5">
                                        <select name="state" class="selectbox getState" id="AppendStates"> 
                                            <option value="">Select</option>
                                            @if(!empty($getstates))
                                                @foreach($getstates as $state)
                                                    @if($userdata['state'] == $state['id'])
                                                        <?php $stateselected = "selected";?>
                                                    @else
                                                        <?php $stateselected = "";?>
                                                    @endif
                                                    <option value="{{ $state['id'] }}" {{$stateselected}}>{{ $state['name']  }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select City :</label>
                                    <div class="col-md-5">
                                        <select name="city" class="selectbox" id="AppendCities"> 
                                            <option value="">Select</option>
                                            @if(!empty($getcities))
                                                @foreach($getcities as $city)
                                                    @if($userdata['city'] == $city['id'])
                                                        <?php $cityselected = "selected";?>
                                                    @else
                                                        <?php $cityselected = "";?>
                                                    @endif
                                                    <option value="{{ $city['id'] }}" {{$cityselected}}>{{ $city['name']  }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> */?>
                                @if(empty($userdata))
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
<script>
$(document).on('keyup', '.user_pincode', function() {
        var pincode = $(this).val();
        if($(this).val().length == 6){
		  $('.PleaseWaitDiv').show();
		  $.ajax({
            url: '/get-state',
            type:'POST',
            data: {_token: "{{ csrf_token() }}",  pincode: pincode},
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if(data.status){
					if(data.state == 'Jammu And  kashmir'){
					    $('.user_state').val('Jammu And  Kashmir');
					}else{
						$('.user_state').val(data.state);
					}
					
        			$('.user_city').val(data.city);
            	}else{
					alert('Invalid pincode!');
            	}
            }
         });
	    }
	});
</script>
@stop