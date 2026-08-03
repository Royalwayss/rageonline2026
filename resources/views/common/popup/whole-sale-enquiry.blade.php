<!-- The Modal -->
<div class="modal fade popup-options" id="Wholesale_Enquiry" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">

	<div class="modal-dialog modal-lg">
	
		<div class="modal-content">
			<!-- Modal Header -->
			
			<div class="modal-header">
				<h4 class="modal-title">Wholesale Enquiry</h4>
				
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				
			</div>
			<div id="WholesaleEnquiry_result" class="text-center"> </div>
			<!-- Modal body -->
			
			<form id="WholesaleEnquiryForm" action="javascript:;" method="post">@csrf
				<div class="modal-body">
					<div class="col-sm-12 col-12">
						<div class="row">
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control" name="Name" id="Name"  placeholder="Name" />
								<p class="err text-center" id="WholesaleEnquiry-Name" style="display: none;"></p>
							</div>
							
							<div class="col-sm-6 col-12 form-group">
								<input type="email" class="input-style form-control" name="Email" id="Email"  placeholder="Email" />
								<p class="err text-center" id="WholesaleEnquiry-Email" style="display: none;"></p>
							</div>
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control" name="Mobile" id="Mobile" placeholder="Mobile"  />
								<p class="err text-center" id="WholesaleEnquiry-Mobile" style="display: none;"></p>
							</div>
							
							<div class="col-sm-6 col-12 form-group">
								<input type="text" class="input-style form-control" name="City" id="City" placeholder="City"  />
								<p class="err text-center" id="WholesaleEnquiry-City" style="display: none;"></p>
							</div>
							
							<div class="col-sm-12 col-12 form-group">
								<textarea class="input-style form-control" name="Message" id="Message" placeholder="Message" ></textarea>
								<p class="err text-center" id="WholesaleEnquiry-Message" style="display: none;"></p>
							</div>
							
						</div>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" id="Submit_Enquiry" class="btn-style save-btn">Submit Enquiry
</button>
				</div>
			</form>
		</div>
	</div>
</div>
