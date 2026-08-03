<div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="<?php echo $address_type; ?>_first_name">First Name</label>
                                                            <input type="text" class="form-control" id="<?php echo $address_type; ?>_first_name" name="<?php echo $address_type; ?>_first_name" id="<?php echo $address_type; ?>_first_name" value="{{(!empty($address[$address_type]))?$address[$address_type]['first_name']: '' }}">
                                                            <span class="err address-err" id="Address-<?php echo $address_type; ?>_first_name"></span>
														</div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="<?php echo $address_type; ?>_mobile">Mobile</label>
                                                            <input type="text" class="form-control" id="<?php echo $address_type; ?>_mobile" name="<?php echo $address_type; ?>_mobile" id="<?php echo $address_type; ?>_mobile" value="{{(!empty($address[$address_type]))?$address[$address_type]['mobile']: '' }}">
                                                            <span class="err address-err" id="Address-<?php echo $address_type; ?>_mobile"></span>
														</div>
                                                    </div>
													<div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="<?php echo $address_type; ?>_alternative_number">Alternative Mobile Number </label>
                                                            <input type="text" class="form-control" id="<?php echo $address_type; ?>_alternative_number" name="<?php echo $address_type; ?>_alternative_number" id="<?php echo $address_type; ?>_alternative_number" value="{{(!empty($address[$address_type]))?$address[$address_type]['alternative_number']: '' }}">
                                                            <span class="err address-err" id="Address-<?php echo $address_type; ?>_alternative_number"></span>
														</div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="<?php echo $address_type; ?>_address">Address</label>
                                                            <input type="text" class="form-control" id="<?php echo $address_type; ?>_address" name="<?php echo $address_type; ?>_address" id="<?php echo $address_type; ?>_address" value="{{(!empty($address[$address_type]))?$address[$address_type]['address']: '' }}">
                                                            <span class="err address-err" id="Address-<?php echo $address_type; ?>_address"></span>
														</div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="<?php echo $address_type; ?>_postcode">Zip Code</label>
                                                            <input type="text" class="form-control user_pincode" id="<?php echo $address_type; ?>_postcode" name="<?php echo $address_type; ?>_postcode" id="<?php echo $address_type; ?>_postcode" value="{{(!empty($address[$address_type]))?$address[$address_type]['postcode']: '' }}">
                                                            <span class="err address-err" id="Address-<?php echo $address_type; ?>_postcode"></span>
														</div>
                                                    </div>
													
                                                    <div class="col-lg-6">
                                                        <div class="mb-4 mb-lg-0">
                                                            <label class="form-label">State</label>
                                                            <select class="form-control form-select user_state" name="<?php echo $address_type; ?>_state" id="<?php echo $address_type; ?>_state" >
                                                                <option value="">Select state</option>
                                                                @foreach($states as $state)
																	<option value="{{$state}}" <?php if(!empty($address[$address_type])){ if($address[$address_type]['state'] == $state){ echo "selected"; } }?>>{{$state}}</option>
															    @endforeach                              
                                                            </select>
															<span class="err address-err" id="Address-<?php echo $address_type; ?>_state"></span>
                                                        </div>
                                                    </div>
													<div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="<?php echo $address_type; ?>_city">City</label>
                                                            <input type="text" class="form-control user_city" id="<?php echo $address_type; ?>_city" name="<?php echo $address_type; ?>_city" id="<?php echo $address_type; ?>_postcode" value="{{(!empty($address[$address_type]))?$address[$address_type]['city']: '' }}">
                                                            <span class="err address-err" id="Address-<?php echo $address_type; ?>_city"></span>
														</div>
                                                    </div>
													
													<div class="col-lg-6">
                                                        <div class="mb-4 mb-lg-0">
                                                            <label class="form-label">Country</label>
                                                            <select class="form-control form-select" name="<?php echo $address_type; ?>_country" id="<?php echo $address_type; ?>_country" >
                                                               <option value="India" <?php if(!empty($address[$address_type])) { if($address[$address_type]['country']  == 'India'){ echo 'selected';    } } ?> >INDIA</option>                             
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
													
                                                </div>

                                               
											</div>

