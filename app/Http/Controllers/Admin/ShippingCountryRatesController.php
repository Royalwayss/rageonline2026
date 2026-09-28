<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\ShippingCountryRate;
use App\GeoCountry;

class ShippingCountryRatesController extends Controller
{
    // Fixed weight brackets (grams) -> matches actual gm..._... column names
    private $weightBrackets = [
        [0, 500], [500, 1000], [1000, 1500], [1500, 2000], [2000, 2500], [2500, 3000],
        [3000, 3500], [3500, 4000], [4000, 4500], [4500, 5000], [5000, 5500], [5500, 6000],
        [6000, 6500], [6500, 7000], [7000, 7500], [7500, 8000], [8000, 8500], [8500, 9000],
        [9000, 9500], [9500, 10000], [10000, 10500], [10500, 11000], [11000, 11500], [11500, 12000],
        [12500, 13000], [13000, 13500], [13500, 14000], [14000, 14500], [14500, 15000], [15000, 15500],
        [15500, 16000], [16000, 16500], [16500, 17000], [17000, 17500], [17500, 18000], [18000, 18500],
        [18500, 19000], [19000, 19500], [19500, 20000], [20000, 20500], [20500, 21000], [21000, 21500],
        [21500, 22000], [22000, 22500], [22500, 23000], [23000, 23500], [23500, 24000], [24000, 24500],
        [24500, 25000], [25000, 25500], [25500, 26000], [26000, 26500], [26500, 27000], [27000, 27500],
        [27500, 28000], [28000, 28500], [28500, 29000], [29000, 29500], [29500, 30000], [30000, 30500],
        [30500, 31000], [31000, 70000], [70000, 300000], [300000, 9999000],
    ];

    private function weightColumns()
    {
        $cols = [];
        foreach ($this->weightBrackets as $b) {
            $cols[] = 'gm' . $b[0] . '_' . $b[1];
        }
        return $cols;
    }

    public function shippingCountryRates(Request $Request)
    {
        Session::put('active', 'shipping_country_rates');

        if ($Request->ajax()) {
            $conditions = array();
            $data = $Request->input();

            $querys = ShippingCountryRate::leftJoin('geo_countries', 'geo_countries.id', '=', 'shipping_country_rates.country_id')
                ->select('shipping_country_rates.*', 'geo_countries.name as country_name', 'geo_countries.iso2');

            if (!empty($data['country_name'])) {
                $querys = $querys->where('geo_countries.name', 'like', '%' . $data['country_name'] . '%');
            }

            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iTotalRecords = (clone $querys)->get()->count();
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

            $querys = $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->orderBy('geo_countries.name', 'ASC')
                ->get();

            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array();

            $querys = json_decode(json_encode($querys), true);
            foreach ($querys as $rate) {
                if ($rate['status'] == 1) {
                    $checked = 'on';
                } else {
                    $checked = 'off';
                }
                $status = '<div id="' . $rate['id'] . '" rel="shipping_country_rates" class="bootstrap-switch bootstrap-switch-' . $checked . ' bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container"><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>';

                $actions = '<a href="' . url('admin/shipping-country-rates/edit/' . $rate['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>';

                $records["data"][] = array(
                    $rate['id'],
                    $rate['country_name'] . ' (' . $rate['iso2'] . ')',
                    number_format((float) $rate['gm0_500'], 2),
                    number_format((float) $rate['gm300000_9999000'], 2),
                    $status,
                    $actions,
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }

        $title = "Shipping Country Rates";
        return View::make('admin.shippingcountryrates.list')->with(compact('title'));
    }

    // Same view used for BOTH Add and Edit. $id is null for add.
    public function form($id = null)
    {
        Session::put('active', 'shipping_country_rates');

        $rate = null;
        $title = "Add Shipping Country Rate";

        if ($id) {
            $rate = ShippingCountryRate::findOrFail($id);
            $title = "Edit Shipping Country Rate";
        }

        // Countries already configured (excluding current record when editing)
        $configuredCountryIds = ShippingCountryRate::when($id, function ($q) use ($id) {
                return $q->where('id', '!=', $id);
            })
            ->pluck('country_id')->toArray();

        $availableCountries = GeoCountry::where('status', 1)
            ->whereNotIn('id', $configuredCountryIds)
            ->orderBy('name', 'ASC')
            ->get();

        // For the quick-jump dropdown on Edit: every country that already has a rate record
        $allConfiguredRates = ShippingCountryRate::leftJoin('geo_countries', 'geo_countries.id', '=', 'shipping_country_rates.country_id')
            ->select('shipping_country_rates.id', 'geo_countries.name', 'geo_countries.iso2')
            ->orderBy('geo_countries.name', 'ASC')
            ->get();

        $weightBrackets = $this->weightBrackets;

        return View::make('admin.shippingcountryrates.form')->with(compact('title', 'rate', 'availableCountries', 'weightBrackets', 'allConfiguredRates'));
    }

    // Single save handler - creates or updates depending on whether id is present
    public function save(Request $Request)
    {
        $id = $Request->input('id');

        $Request->validate([
            'country_id' => 'required|integer|exists:geo_countries,id|unique:shipping_country_rates,country_id,' . ($id ?: 'NULL') . ',id',
        ]);

        $weightCols = $this->weightColumns();
        $rateInput = $Request->input('rate', []);

        $payload = [
            'country_id' => $Request->input('country_id'),
            'status' => $Request->has('status') ? 1 : 0,
        ];

        foreach ($weightCols as $col) {
            $payload[$col] = isset($rateInput[$col]) ? $rateInput[$col] : 0;
        }

        if ($id) {
            $rate = ShippingCountryRate::findOrFail($id);
            $rate->update($payload);
            $message = 'Shipping country rate updated successfully.';
        } else {
            ShippingCountryRate::create($payload);
            $message = 'Shipping country rate added successfully.';
        }

        return redirect('admin/shipping-country-rates')->with('flash_message_success', $message);
    }

    public function toggleStatus(Request $Request)
    {
        $id = $Request->input('id');
        $rate = ShippingCountryRate::find($id);
        if ($rate) {
            $rate->status = $rate->status == 1 ? 0 : 1;
            $rate->save();
            return response()->json(['status' => 'success', 'is_status' => $rate->status]);
        }
        return response()->json(['status' => 'error', 'message' => 'Record not found']);
    }
}