<div class="account-content-grid">
    <div class="luxury-card address-manager-card">

        <div class="luxury-card-head d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="head-icon">
                    <i class="fa-regular fa-address-book"></i>
                </div>
                <div>
                    <h2>My Addresses</h2>
                    <p>Manage your saved delivery destinations</p>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{-- Real saved shipping addresses. The controller rendering this
                 page must pass $shippingAddresses - see note below. --}}
            @include('front.checkout.address-list')

            <button type="button" class="add-address-btn mt-3" onclick="loadAddressForm('shipping', 0)">
                <i class="fa-solid fa-plus"></i>
                Add Address
            </button>
        </div>

    </div>
</div>

{{-- Modal shell - body is loaded via AJAX by loadAddressForm() --}}
<div class="modal fade" id="addressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="addressModalContent">
            <!-- AJAX-loaded content goes here -->
        </div>
    </div>
</div>

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>
    $(document).on('click', '.saved-address-card', function() {
        $('.saved-address-card').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type=radio]').prop('checked', true);
    });

    function loadAddressForm(type, id) {
        $('.PleaseWaitDiv').show();
        $.ajax({
            url: '/address/form/' + type + '/' + id,
            type: 'GET',
            success: function(html) {
                $('.PleaseWaitDiv').hide();
                $('#addressModalContent').html(html);
                var modal = new bootstrap.Modal(document.getElementById('addressModal'));
                modal.show();
            }
        });
    }

    $(document).on('change', '#billingSame', function() {
        if ($(this).is(':checked')) {
            $('#billingForm').hide();
        } else {
            $('#billingForm').show();
        }
    });

    $(document).on('submit', '#addressForm', function(e) {
        e.preventDefault();
        $('.PleaseWaitDiv').show();
        var formdata = $('#addressForm').serialize();
        $.ajax({
            url: '/address/save',
            type: 'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                $('.err').html('');
                if (!data.status) {
                    if (data.type == 'validation') {
                        $.each(data.errors, function(i, error) {
                            $('#Address-' + i).html(error);
                        });
                    } else {
                        alert(data.message);
                    }
                } else {
                    $('#addressListWrap').replaceWith(data.view);
                    var modalEl = document.getElementById('addressModal');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    if (typeof RageToast !== 'undefined') {
                        RageToast.show(data.message, 'fa-location-dot');
                    }
                }
            }
        });
    });

    function deleteAddress(id) {
        if (!confirm('Remove this address?')) {
            return;
        }
        $('.PleaseWaitDiv').show();
        $.ajax({
            url: '/address/delete',
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", id: id },
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if (data.status) {
                    $('#addressListWrap').replaceWith(data.view);
                } else {
                    alert(data.message);
                }
            }
        });
    }

    function setDefaultAddress(id) {
        $('.PleaseWaitDiv').show();
        $.ajax({
            url: '/address/set-default',
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", id: id },
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if (data.status) {
                    $('#addressListWrap').replaceWith(data.view);
                } else {
                    alert(data.message);
                }
            }
        });
    }
</script>
@stop