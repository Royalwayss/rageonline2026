<!-- The Modal -->
<div class="modal fade popup-options" id="shipAdd" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Shipping Address</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<form id="addressModalForm" action="javascript:;" method="post">@csrf
				<div class="modal-body">
					<div class="col-sm-12 col-12">
						<div class="row">
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control" name="first_name" id="first_name"  placeholder="First Name" />
								<p class="err text-center" id="DeliveryAddress-first_name" style="display: none;"></p>
							</div>
							<input type="hidden" name="shipping_id">
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control" name="last_name" id="last_name"  placeholder="Last Name" />
								<p class="err text-center" id="DeliveryAddress-last_name" style="display: none;"></p>
							</div>
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control" name="mobile" id="mobile" placeholder="Mobile"  />
								<p class="err text-center" id="DeliveryAddress-mobile" style="display: none;"></p>
							</div>
							@if(isset($states))
							<div class="col-sm-6 col-12 form-group">
								<select  class="form-control" name="state">
									<option value="">Please Select</option>
									@foreach($states as $state)
										<option value="{{$state}}">{{$state}}</option>
									@endforeach
								</select>
								<p class="err text-center" id="DeliveryAddress-state" style="display: none;"></p>
							</div>
							@endif
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control" name="city" id="ship_city" placeholder="City"  />
								<p class="err text-center" id="DeliveryAddress-city" style="display: none;"></p>
							</div>
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control" name="postcode" id="ship_pincode" placeholder="Postcode"  />
								<p class="err text-center" id="DeliveryAddress-postcode" style="display: none;"></p>
							</div>
							<div class="col-sm-6 col-12 form-group">
								<textarea class="input-style form-control" name="address" id="ship_address" placeholder="Address Line 1" ></textarea>
								<p class="err text-center" id="DeliveryAddress-address" style="display: none;"></p>
							</div>
							<div class="col-sm-6 col-12 form-group">
								<textarea class="input-style form-control" name="address2" id="ship_address" placeholder="Address Line 2" ></textarea>
							</div>
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control company" name="company_name" id="company_name" placeholder="Company Name"  />
								<p class="err text-center" id="DeliveryAddress-company_name" style="display: none;"></p>
							</div>
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control" name="gstin" id="gstin" placeholder="GSTIN"  />
								<p class="err text-center" id="DeliveryAddress-gstin" style="display: none;">Please enter the GSTIN value</p>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" id="btnShipping" class="btn-style save-btn">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>