@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
.rate-table-scroll { max-height: 500px; overflow-y: auto; border: 1px solid #ddd; }
.rate-table-scroll table { margin-bottom: 0; }
.rate-table-scroll thead th { position: sticky; top: 0; background: #f4f4f4; z-index: 2; }
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1> {{ $title }}</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! url('admin/dashboard') !!}">Dashboard</a>
            </li>
            <li>
                <a href="{!! url('admin/shipping-country-rates') !!}">Shipping Country Rates</a>
            </li>
        </ul>
        @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if($errors->any())
            <div role="alert" class="alert alert-danger alert-dismissible fade in">
                <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button>
                <ul style="margin-bottom:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green-sharp bold uppercase"> {{ $title }} </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form action="{{ url('admin/shipping-country-rates/save') }}" method="POST">
                            @csrf

                            @if($rate)
                                <input type="hidden" name="id" value="{{ $rate->id }}">
                            @endif

                            @if($rate)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jump to Another Country</label>
                                            <select id="quick-jump-country" class="form-control">
                                                @foreach($allConfiguredRates as $r)
                                                    <option value="{{ $r->id }}" {{ $r->id == $rate->id ? 'selected' : '' }}>
                                                        {{ $r->name }} ({{ $r->iso2 }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="hint" style="font-size:12px;color:#888;margin-top:4px;">Selecting a different country takes you to that country's edit page. Unsaved changes here will be lost.</div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        @if($rate)
                                            <input type="text" class="form-control" value="{{ $rate->country->name ?? '' }} ({{ $rate->country->iso2 ?? '' }})" readonly>
                                            <input type="hidden" name="country_id" value="{{ $rate->country_id }}">
                                        @else
                                            <select name="country_id" class="form-control" required>
                                                <option value="">Select Country</option>
                                                @foreach($availableCountries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }} ({{ $country->iso2 }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="checkbox-list">
                                            <label>
                                                <input type="checkbox" name="status" value="1"
                                                    {{ old('status', $rate->status ?? 1) == 1 ? 'checked' : '' }}> Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <h4>Weight-based Rates (INR)</h4>
                            <div class="rate-table-scroll">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Weight From (g)</th>
                                            <th>Weight To (g)</th>
                                            <th>Rate (INR)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($weightBrackets as $bracket)
                                            @php
                                                $col = 'gm' . $bracket[0] . '_' . $bracket[1];
                                                $existingValue = $rate->{$col} ?? 0;
                                            @endphp
                                            <tr>
                                                <td>{{ $bracket[0] }}</td>
                                                <td>{{ $bracket[1] }}</td>
                                                <td>
                                                    <input type="number" step="0.01" name="rate[{{ $col }}]" class="form-control" value="{{ old('rate.' . $col, $existingValue) }}" required>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <br>
                            <button type="submit" class="btn btn-primary">{{ $rate ? 'Update' : 'Save' }} Shipping Rate</button>
                            <a href="{{ url('admin/shipping-country-rates') }}" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var quickJump = document.getElementById('quick-jump-country');
    if (quickJump) {
        quickJump.addEventListener('change', function() {
            var newId = this.value;
            var proceed = confirm('Switch to this country? Any unsaved changes on this page will be lost.');
            if (proceed) {
                window.location.href = '{{ url("admin/shipping-country-rates/edit") }}/' + newId;
            } else {
                // revert selection back to current country
                this.value = '{{ $rate->id ?? '' }}';
            }
        });
    }
</script>
@stop