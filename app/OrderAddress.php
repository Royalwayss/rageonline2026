<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    //
    protected $fillable = ['id','order_id','billing_name','billing_first_name','billing_last_name','billing_mobile','billing_alternative_number','billing_country_code1','billing_country_code2','billing_postcode','billing_address','billing_address2','billing_country','billing_state','billing_city','shipping_name','shipping_first_name','shipping_last_name','shipping_mobile','shipping_alternative_number','shipping_country_code1','shipping_country_code2','shipping_postcode','shipping_address','shipping_address2','shipping_country','shipping_state','shipping_city','company_name','gstin','created_at','updated_at'];

    public function getBillingMobileAttribute($value)
    {
        if (empty($this->attributes['billing_country_code1']) || empty($value)) {
            return $value;
        }
        return $this->attributes['billing_country_code1'] . ' ' . $value;
    }

    public function getBillingAlternativeNumberAttribute($value)
    {
        if (empty($this->attributes['billing_country_code2']) || empty($value)) {
            return $value;
        }
        return $this->attributes['billing_country_code2'] . ' ' . $value;
    }

    public function getShippingMobileAttribute($value)
    {
        if (empty($this->attributes['shipping_country_code1']) || empty($value)) {
            return $value;
        }
        return $this->attributes['shipping_country_code1'] . ' ' . $value;
    }

    public function getShippingAlternativeNumberAttribute($value)
    {
        if (empty($this->attributes['shipping_country_code2']) || empty($value)) {
            return $value;
        }
        return $this->attributes['shipping_country_code2'] . ' ' . $value;
    }
}