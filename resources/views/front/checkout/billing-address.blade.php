<div id="billingAddressWrap">

    <div class="checkout-title mt-4">
        <span>02</span>
        <h3>Billing Address</h3>
    </div>

    @if(!empty($billing))
    <div class="saved-address-card active billing-card">
        <div class="saved-address-content">
            <strong>{{ $billing->name }}</strong>
            <p>
                {{ $billing->address }}, {{ $billing->city }},
                {{ $billing->state }} - {{ $billing->postcode }}, {{ $billing->country }}
            </p>
            <p>+91 {{ $billing->mobile }}</p>

            <div class="saved-address-actions">
                <a href="javascript:;" onclick="loadAddressForm('billing', 0)">Edit</a>
            </div>
        </div>
    </div>
    @else
    <p class="no-address-msg">No billing address on file yet.</p>
    <button type="button" class="add-address-btn" onclick="loadAddressForm('billing', 0)">
        <i class="fa-solid fa-plus"></i>
        Add Billing Address
    </button>
    @endif

</div>