@extends('layouts.frontLayout.front-layout')
@section('content')

<style>
.track-page { padding: 40px 0 70px; }
.track-wrap { max-width: 720px; margin: 0 auto; }
.track-card { border: 1px solid #e4ded3; background: #fff; padding: 28px; margin-bottom: 24px; }
.track-card h2 { font-size: 22px; margin: 0 0 6px; }
.track-card p.sub { color: #777; margin: 0 0 20px; font-size: 14px; }
.track-field { margin-bottom: 16px; }
.track-field label { display: block; font-size: 13px; margin-bottom: 6px; color: #333; }
.track-field input { width: 100%; height: 44px; padding: 0 12px; border: 1px solid #cfc8bb; background: #fff; font-size: 15px; outline: none; }
.track-field input:focus { border-color: #a58355; }
.track-field input.has-error { border-color: #c0392b; }
.track-error { color: #c0392b; font-size: 12.5px; margin-top: 5px; min-height: 16px; }
.track-btn { width: 100%; height: 46px; border: 0; background: #111; color: #fff; font-size: 14px; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; }
.track-btn[disabled] { opacity: .6; cursor: not-allowed; }
.track-head { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; border-bottom: 1px solid #eee; padding-bottom: 14px; margin-bottom: 14px; }
.track-head h3 { margin: 0; font-size: 20px; }
.track-badge { display: inline-block; padding: 4px 12px; background: #f3ede2; color: #7a5d2f; font-size: 13px; }
.track-meta { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-bottom: 18px; }
.track-meta div span { display: block; font-size: 12px; color: #888; }
.track-meta div strong { font-size: 15px; }
.track-items { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
.track-items th, .track-items td { text-align: left; padding: 9px 6px; border-bottom: 1px solid #f0ece4; font-size: 14px; }
.track-items th { font-size: 12px; color: #888; font-weight: 500; text-transform: uppercase; }
.track-link { display: inline-block; margin: 6px 0 18px; padding: 11px 20px; background: #a58355; color: #fff; text-decoration: none; font-size: 14px; }
.track-link:hover { color: #fff; opacity: .9; }
.track-timeline { list-style: none; margin: 0; padding: 0 0 0 18px; border-left: 2px solid #e4ded3; }
.track-timeline li { position: relative; padding: 0 0 16px 16px; font-size: 14px; }
.track-timeline li:before { content: ''; position: absolute; left: -25px; top: 5px; width: 10px; height: 10px; border-radius: 50%; background: #a58355; }
.track-timeline li small { display: block; color: #888; }
.track-note { color: #777; font-size: 14px; }
</style>

<main class="inner-page">
    <div class="container track-page">
        <div class="track-wrap">

            <div class="detail-breadcrumb" style="margin-bottom:18px;">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <span>Track Your Order</span>
            </div>

            <div class="track-card" id="trackFormCard">
                <h2>Track Your Order</h2>
                <p class="sub">Enter the email used for the order and your order ID to see your order status. No login needed.</p>

                <form id="trackForm" novalidate>
                    <div class="track-field">
                        <label for="trackEmail">Order Email</label>
                        <input type="email" id="trackEmail" name="email" placeholder="Email given while placing the order" autocomplete="email">
                        <div class="track-error" id="err-email"></div>
                    </div>
                    <div class="track-field">
                        <label for="trackOrderId">Order ID</label>
                        <input type="text" id="trackOrderId" name="order_id" placeholder="e.g. 1234" inputmode="numeric">
                        <div class="track-error" id="err-order_id"></div>
                    </div>
                    <button type="submit" class="track-btn" id="trackBtn">Track Order</button>
                </form>
            </div>

            <div class="track-card" id="trackResult" style="display:none;"></div>

        </div>
    </div>
</main>
@stop

@section('javascript')
@parent
<script>
(function () {
    var form     = document.getElementById('trackForm');
    var btn      = document.getElementById('trackBtn');
    var result   = document.getElementById('trackResult');
    var formCard = document.getElementById('trackFormCard');
    var emailEl  = document.getElementById('trackEmail');
    var orderEl  = document.getElementById('trackOrderId');
    var csrf     = '{{ csrf_token() }}';

    function esc(v) {
        var d = document.createElement('div');
        d.textContent = (v === null || v === undefined) ? '' : v;
        return d.innerHTML;
    }

    function setError(field, msg) {
        document.getElementById('err-' + field).textContent = msg || '';
        var input = field === 'email' ? emailEl : orderEl;
        input.classList.toggle('has-error', !!msg);
    }

    function clearErrors() { setError('email', ''); setError('order_id', ''); }

    // quick browser-side check before calling the server
    function validateLocal() {
        var ok = true;
        var email = emailEl.value.trim();
        var oid   = orderEl.value.trim();
        if (!email) { setError('email', 'Please enter your order email.'); ok = false; }
        else if (!/^[^\s]+@[^\s]+\.[^\s]+$/.test(email)) { setError('email', 'Please enter a valid email address.'); ok = false; }
        if (!oid) { setError('order_id', 'Please enter your order ID.'); ok = false; }
        else if (!/^\d+$/.test(oid)) { setError('order_id', 'Order ID must be a number.'); ok = false; }
        return ok;
    }

    emailEl.addEventListener('input', function () { setError('email', ''); });
    orderEl.addEventListener('input', function () { setError('order_id', ''); });

    function render(o) {
        var html = '';
        html += '<div class="track-head"><h3>Order #' + esc(o.id) + '</h3><span class="track-badge">' + esc(o.order_status) + '</span></div>';
        html += '<div class="track-meta">'
              + '<div><span>Order Date</span><strong>' + esc(o.date) + '</strong></div>'
              + '<div><span>Payment</span><strong>' + esc(o.payment_method) + ' (' + esc(o.payment_status) + ')</strong></div>'
              + '<div><span>Order Total</span><strong>INR ' + esc(o.total) + '</strong></div>'
              + '</div>';

        html += '<table class="track-items"><thead><tr><th>Item</th><th>Size</th><th>Qty</th><th>Price</th></tr></thead><tbody>';
        (o.items || []).forEach(function (it) {
            html += '<tr><td>' + esc(it.name) + '<br><small style="color:#888">' + esc(it.code) + '</small></td><td>' + esc(it.size) + '</td><td>' + esc(it.qty) + '</td><td>INR ' + esc(it.price) + '</td></tr>';
        });
        html += '</tbody></table>';

        if (o.is_cancelled) {
            html += '<p class="track-note">This order has been cancelled.</p>';
        } else if (o.tracking_url) {
            html += '<p style="margin:0;"><strong>Shipment (AWB ' + esc(o.waybill) + ')</strong>';
            if (o.tracking && o.tracking.status) { html += ' &mdash; ' + esc(o.tracking.status); }
            html += '</p>';
            html += '<a class="track-link" href="' + esc(o.tracking_url) + '" target="_blank" rel="noopener">Track on Delhivery</a>';

            if (o.tracking && o.tracking.scans && o.tracking.scans.length) {
                html += '<ul class="track-timeline">';
                o.tracking.scans.forEach(function (s) {
                    html += '<li><strong>' + esc(s.status) + '</strong>'
                          + '<small>' + esc(s.location) + (s.date ? ' &middot; ' + esc(s.date) : '') + '</small>'
                          + (s.remarks ? '<small>' + esc(s.remarks) + '</small>' : '')
                          + '</li>';
                });
                html += '</ul>';
            }
        } else {
            html += '<p class="track-note">Your order has not been shipped yet. A tracking link will appear here once it is dispatched.</p>';
        }

        html += '<button type="button" class="track-btn" id="trackAnotherBtn" style="margin-top:8px;">Track Another Order</button>';

        result.innerHTML = html;
        formCard.style.display = 'none';
        result.style.display = 'block';

        document.getElementById('trackAnotherBtn').addEventListener('click', function () {
            result.style.display = 'none';
            result.innerHTML = '';
            emailEl.value = '';
            orderEl.value = '';
            clearErrors();
            formCard.style.display = 'block';
            emailEl.focus();
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        result.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();
        result.style.display = 'none';
        if (!validateLocal()) { return; }

        btn.disabled = true;
        btn.textContent = 'Checking...';

        fetch('{{ url('track-your-order/check') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ email: emailEl.value.trim(), order_id: orderEl.value.trim() })
        })
        .then(function (res) { return res.json().then(function (data) { return { code: res.status, data: data }; }); })
        .then(function (r) {
            if (r.data && r.data.status) {
                render(r.data.order);
            } else if (r.code === 429) {
                setError('order_id', 'Too many attempts. Please wait a minute and try again.');
            } else if (r.data && r.data.errors) {
                Object.keys(r.data.errors).forEach(function (f) { setError(f, r.data.errors[f][0]); });
            } else {
                setError('order_id', 'Something went wrong. Please try again.');
            }
        })
        .catch(function () { setError('order_id', 'Something went wrong. Please try again.'); })
        .then(function () { btn.disabled = false; btn.textContent = 'Track Order'; });
    });
})();
</script>
@stop