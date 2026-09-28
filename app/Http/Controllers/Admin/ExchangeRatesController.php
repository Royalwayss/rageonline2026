<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\ExchangeRate;
use App\GeoCountry;

class ExchangeRatesController extends Controller
{
    public function exchangeRates(Request $Request)
    {
        Session::put('active', 'exchange_rates');

        if ($Request->ajax()) {
            $conditions = array();
            $data = $Request->input();

            // Country names grouped per currency_code (a currency can map to many countries, e.g. EUR)
            $querys = ExchangeRate::leftJoin('geo_countries', function ($join) {
                    $join->on('geo_countries.currency_code', '=', 'exchange_rates.currency_code');
                        
                })
                ->select(
                    'exchange_rates.*',
                    'geo_countries.status as country_status',
                    'geo_countries.id as country_id',
                    DB::raw("GROUP_CONCAT(geo_countries.name ORDER BY geo_countries.name SEPARATOR ', ') as country_names")
                )
                ->groupBy(
                    'exchange_rates.id',
                    'exchange_rates.currency_code',
                    'exchange_rates.rate_from_inr',
                    'exchange_rates.last_synced_at',
                    'exchange_rates.created_at',
                    'exchange_rates.updated_at'
                );
			$querys = $querys->where('exchange_rates.status', 1);

            if (!empty($data['currency_code'])) {
                $querys = $querys->where('exchange_rates.currency_code', 'like', '%' . $data['currency_code'] . '%');
            }
            if (!empty($data['country_name'])) {
                $querys = $querys->where('geo_countries.name', 'like', '%' . $data['country_name'] . '%');
            }

            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);

            // ->count() on a grouped query only returns the count of the FIRST group (always 1 here,
            // since we group by exchange_rates.id which is unique per row). Clone + get()->count() instead
            // to get the real total number of groups/rows matching the filters.
            $iTotalRecords = (clone $querys)->get()->count();
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

            $querys = $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->orderBy('exchange_rates.currency_code', 'ASC')
                ->get();

            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array();
            $i = $iDisplayStart;
            $country_count =0;
            $querys = json_decode(json_encode($querys), true);
            foreach ($querys as $rate) { 
                $num = ++$i;

                $lastSynced = !empty($rate['last_synced_at'])
                    ? date('d M Y H:ia', strtotime($rate['last_synced_at']))
                    : '<span class="text-muted">Not synced yet</span>'; 
				$country_names_arr = [];
				$country_names_arr = explode(',',$rate['country_names']);
								

                  $countryNames = !empty($rate['country_names']) ? str_replace(', ', '<br>', $rate['country_names']) : '<span class="text-muted">-</span>';

                $inr100Converted = number_format(((float) $rate['rate_from_inr']) * 100, 2) . ' ' . $rate['currency_code'];

                if($rate['country_status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
				$country_status = '<div  id="'.$rate['currency_code'].'" rel="geo_countries" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>';  
                $records["data"][] = array(
                    $rate['id'],
                    $rate['currency_code'],
                    $countryNames,
                    number_format((float) $rate['rate_from_inr'], 6),
                    $inr100Converted,
                    $country_status,
                    $lastSynced,
                );
            } 
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }

        $lastSyncedAt = ExchangeRate::max('last_synced_at');
        $lastSyncedAt = !empty($lastSyncedAt) ? date('d M Y, h:i A', strtotime($lastSyncedAt)) : 'Not synced yet';

        $title = "Exchange Rates";
        return View::make('admin.exchangerates.list')->with(compact('title', 'lastSyncedAt'));
    }

    public function syncNow(Request $Request)
    {
        $key = config('services.exchangerate.key');
        $response = Http::timeout(15)->get("https://v6.exchangerate-api.com/v6/{$key}/latest/INR");

        if (!$response->successful()) {
            Log::error('Exchange rate manual sync failed', ['status' => $response->status()]);
            return redirect()->back()->with('flash_message_error', 'Sync failed: HTTP ' . $response->status());
        }

        $result = $response->json();
        if (($result['result'] ?? null) !== 'success') {
            Log::error('Exchange rate API error', $result);
            return redirect()->back()->with('flash_message_error', 'Sync failed: ' . ($result['error-type'] ?? 'Unknown API error'));
        }

        $now = now();
        $count = 0;  
        foreach ($result['conversion_rates'] as $code => $rate) {
            ExchangeRate::updateOrCreate(
                ['currency_code' => $code],
                ['rate_from_inr' => $rate, 'last_synced_at' => $now]
            );
            $count++;
        }

        return redirect()->back()->with('flash_message_success', $count . ' currency rates synced successfully.');
    }

    
}