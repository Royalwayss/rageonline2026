@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page">
    <section class="account-page">
        <div class="container-fluid">

            <?php
                $active_tab_map = [
                    'dashboard' => 'profile',
                    'address'   => 'address',
                    'orders'    => 'orders',
                    'wishlists' => 'wishlist',
                    'settings'  => 'settings',
                ];
                $active_tab = $active_tab_map[$slug] ?? 'profile';
            ?>

            @include('front.account.account-header')
             
            <div class="row mt-3">
                <div class="col-12">
                    @if($slug=="dashboard")
                        @include('front.account.dashboard')
                    @elseif($slug=="settings")
                        @include('front.account.change-password')
                    @elseif($slug=="address")
                        @include('front.account.my-address')
                    @elseif($slug=="orders")
                        @include('front.account.orders')
                    @elseif($slug=="wishlists")
                        @include('front.account.wishlists')
					@elseif($slug=="order-view")
                        @include('front.account.order-view')
                    @endif
                </div>
            </div>

        </div>
    </section>
</main>
@stop