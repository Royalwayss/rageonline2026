<?php
    use App\ShippingAddress;
    // NOTE: Order and Wishlist model/table names below are my best guess based
    // on the tab names already in account.blade.php (front.account.orders,
    // front.account.wishlists). I don't have those model files - confirm the
    // class names and user-scoping column match your actual models.
    $orders_count = 0;
    $wishlist_count = 0;
    if (class_exists(\App\Order::class)) {
        $orders_count = \App\Order::where('user_id', Auth::id())->count();
    }
    if (class_exists(\App\Wishlist::class)) {
        $wishlist_count = \App\Wishlist::where('user_id', Auth::id())->count();
    }

    $address_count = ShippingAddress::where('user_id', Auth::id())->count();

    if (!isset($active_tab)) {
        $active_tab = 'profile';
    }

    $nameInitials = '';
    $nameParts = explode(' ', trim(Auth::user()->name));
    foreach (array_slice($nameParts, 0, 2) as $part) {
        $nameInitials .= strtoupper(substr($part, 0, 1));
    }
?>

<!-- ACCOUNT DOSSIER HEADER -->
<div class="account-hero-dossier">
    <div class="dossier-inner">
        <div class="dossier-profile">
            <div class="dossier-avatar-wrap">
                <div class="dossier-avatar">
                    <span>{{ $nameInitials }}</span>
                </div>
                {{-- NOTE: no avatar-upload backend confirmed - this button/modal
                     is UI only, does not actually save an uploaded photo yet. --}}
               <?php /* <button type="button" class="dossier-avatar-edit" title="Change Avatar" data-bs-toggle="modal" data-bs-target="#avatarModal">
                    <i class="fa-solid fa-camera"></i>
                </button> */ ?>
            </div>
            <div class="dossier-details">
                <h1 class="dossier-name">{{ Auth::user()->name }}</h1>
                <p class="dossier-meta">
                    <span><i class="fa-regular fa-envelope"></i> {{ Auth::user()->email }}</span>
                    <span class="dot-sep">•</span>
                    <span><i class="fa-solid fa-phone"></i> +91 {{ Auth::user()->mobile }}</span>
                    @if(!empty(Auth::user()->created_at))
                    <span class="dot-sep">•</span>
                    <span>Member since {{ Auth::user()->created_at->format('M Y') }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="dossier-stats">
            <a href="{{ url('account/orders') }}" class="stat-pill {{ ($active_tab === 'orders') ? 'active' : '' }}">
                <div class="stat-num">{{ $orders_count }}</div>
                <div class="stat-lbl">Orders Placed</div>
            </a>
            <a href="{{ url('account/address') }}" class="stat-pill {{ ($active_tab === 'address') ? 'active' : '' }}">
                <div class="stat-num">{{ $address_count }}</div>
                <div class="stat-lbl">Saved Addresses</div>
            </a>
            <a href="{{ url('account/wishlists') }}" class="stat-pill {{ ($active_tab === 'wishlist') ? 'active' : '' }}">
                <div class="stat-num">{{ $wishlist_count }}</div>
                <div class="stat-lbl">Wishlist Items</div>
            </a>
            @if(!empty(Auth::user()->loyalty_points))
            <div class="stat-pill privilege-points">
                <div class="stat-num">{{ Auth::user()->loyalty_points }}</div>
                <div class="stat-lbl">Rage Luxe Pts</div>
            </div>
            @endif
        </div>
    </div>

    <!-- ACCOUNT NAVIGATION TABS -->
    <div class="account-nav-bar">
        <div class="account-nav-tabs">
            <a href="{{ url('account/dashboard') }}" class="acc-tab {{ ($active_tab === 'profile') ? 'active' : '' }}">
                <i class="fa-regular fa-user"></i>
                <span>My Profile</span>
            </a>
            <a href="{{ url('account/address') }}" class="acc-tab {{ ($active_tab === 'address') ? 'active' : '' }}">
                <i class="fa-regular fa-address-book"></i>
                <span>Saved Addresses</span>
            </a>
            <a href="{{ url('account/orders') }}" class="acc-tab {{ ($active_tab === 'orders') ? 'active' : '' }}">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Order History</span>
                @if($orders_count > 0)
                <span class="tab-badge">{{ $orders_count }}</span>
                @endif
            </a>
            <a href="{{ url('account/wishlists') }}" class="acc-tab {{ ($active_tab === 'wishlist') ? 'active' : '' }}">
                <i class="fa-regular fa-heart"></i>
                <span>Wishlist</span>
                @if($wishlist_count > 0)
                <span class="tab-badge">{{ $wishlist_count }}</span>
                @endif
            </a>
            <a href="{{ url('account/settings') }}" class="acc-tab {{ ($active_tab === 'settings') ? 'active' : '' }}">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Security & Settings</span>
            </a>
        </div>

        <a href="{{ url('/logout') }}" class="acc-logout-btn" title="Sign out of your account">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

{{-- Avatar upload modal - UI only, not wired to a real upload endpoint yet --}}
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content luxury-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">Update Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="avatar-upload-preview mb-3">
                    <div class="dossier-avatar mx-auto" style="width: 100px; height: 100px; font-size: 36px; display:flex; align-items:center; justify-content:center;">
                        <span>{{ $nameInitials }}</span>
                    </div>
                </div>
                <p class="text-muted small">Choose an image from your device (JPG, PNG, max 2MB).</p>
                <input type="file" class="form-control" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="primary-btn" data-bs-dismiss="modal">Save Photo</button>
            </div>
        </div>
    </div>
</div>