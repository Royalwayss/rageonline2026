<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'currency_code',
        'rate_from_inr',
        'last_synced_at',
    ];
	
	
	public function countries()
	{
		return $this->hasMany(GeoCountry::class, 'currency_code', 'currency_code');
	}
	
	
	
	
}
