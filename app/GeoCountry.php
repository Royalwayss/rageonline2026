<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeoCountry extends Model
{
    protected $table = 'geo_countries';

    protected $fillable = [
        'name',
        'currency_code',
        'phone_code',
        'status',
    ];

   public static function getcountries()
	{
		$data = self::where('status', 1)->orderBy('name', 'asc')->get(['name', 'phone_code']);
		$return = json_decode(json_encode($data), true);
		return $return;
	}

    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class, 'currency_code', 'currency_code');
    }
}