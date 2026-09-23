<div id="addressListWrap">

    @if($shippingAddresses->count() > 0)
    <div class="saved-address-list">
        @foreach($shippingAddresses as $addr)
        <label class="saved-address-card {{ $addr->is_default == 'yes' ? 'active' : '' }}">
            <input type="radio" name="saved_address" value="{{ $addr->id }}" {{ $addr->is_default == 'yes' ? 'checked' : '' }}>
            <span class="address-radio"></span>

            <div class="saved-address-content">

                <div class="saved-address-top">
                    <strong>{{ $addr->name }}</strong>
                    @if($addr->is_default == 'yes')
                    <span class="default-badge">Default</span>
                    @endif
                </div>

                <p>
                    {{ $addr->address }}, {{ $addr->city }},
                    {{ $addr->state }} - {{ $addr->postcode }}, {{ $addr->country }}
                </p>
                <p>+91 {{ $addr->mobile }}</p>

                <div class="saved-address-actions">
                    <button type="button" class="address-action-btn" onclick="loadAddressForm('shipping', {{ $addr->id }})">
                        <i class="fa-regular fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="address-action-btn address-action-danger" onclick="deleteAddress({{ $addr->id }})">
                        <i class="fa-regular fa-trash-can"></i> Delete
                    </button>
                    @if($addr->is_default != 'yes')
                    <button type="button" class="address-action-btn" onclick="setDefaultAddress({{ $addr->id }})">
                        <i class="fa-regular fa-star"></i> Set as Default
                    </button>
                    @endif
                </div>

            </div>
        </label>
        @endforeach
    </div>
    @else
    <p class="no-address-msg">No saved addresses yet. Add one to continue.</p>
    @endif

</div>

<style>
.saved-address-top {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
}
.default-badge {
    background: #8e313c;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 2px 10px;
    border-radius: 20px;
}
.saved-address-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}
.address-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff;
    border: 1px solid #d8d0c5;
    color: #4a4038;
    font-size: 13px;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.address-action-btn i {
    font-size: 12px;
}
.address-action-btn:hover {
    background: #8e313c;
    border-color: #8e313c;
    color: #fff;
}
.address-action-btn.address-action-danger:hover {
    background: #b3261e;
    border-color: #b3261e;
    color: #fff;
}
</style>