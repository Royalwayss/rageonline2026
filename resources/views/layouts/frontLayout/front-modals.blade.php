
  
  <!-- Guest Checkout Modal Starts-->
<div class="modal fade" id="GuestCheckoutModal" tabindex="-1" role="dialog" aria-labelledby="GuestCheckoutModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="GuestCheckoutModalLabel">Guest Checkout</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="GuestCheckoutForm" autocomplete="off" method="post" action="javascript:;">@csrf
			<div class="modal-body">
			        <div class="form-group col-6">
						<label for="Guest-Mobile" class="col-form-label">Email:</label>
						<input type="text" name="email_address" placeholder="Enter email" class="form-control" id="Guest-email_address">
						<p class="err text-center" id="guestCheckout-email_address" style="display: none;"></p>
					</div>
					<div class="form-group">
						<label for="Guest-Mobile" class="col-form-label">Mobile:</label>
						<input type="text" name="mobile" placeholder="Enter Mobile" class="form-control" id="Guest-Mobile">
						<p class="err text-center" id="guestCheckout-mobile" style="display: none;"></p>
					</div>
					<button type="submit" class="guest-btn btn-style pointer">Submit</button>
				</div>
				<br />
			</form>
		</div>
	</div>
</div>
<!-- Guest Checkout Modal Ends-->


