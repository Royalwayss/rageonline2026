<?php

namespace App;
use DB;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class CustomFunction extends Model
{
    //
    public static  function formatAmt($amount){
        list ($number, $decimal) = explode('.', sprintf('%.2f', floatval($amount)));
        $sign = $number < 0 ? '-' : '';
        $number = abs($number);
        for ($i = 3; $i < strlen($number); $i += 3){
            $number = substr_replace($number, '', -$i, 0);
        }
        if($decimal==00){
            return  $sign . $number;
        }else{
            return  $sign . $number .".". $decimal;
        }
    }
	
	
	public static function CGST($productprice,$gstPercentage ){
		if($gstPercentage != '0' && $gstPercentage  != ''){
			
			$gst_percentage =  $gstPercentage /2 ;
			$gst_amount =  $productprice * ($gst_percentage / 100);
			return '('.$gst_percentage.'%) Rs.'.number_format($gst_amount,2).'';
			
		}else{
			return '(0%) Rs.0';
		}
		    
	}
	public static function SGST($productprice,$gstPercentage ){
		if($gstPercentage != '0' && $gstPercentage  != ''){
			
			$gst_percentage =  $gstPercentage /2 ;
			$gst_amount =  $productprice * ($gst_percentage / 100);
			return '('.$gst_percentage.'%) Rs.'.number_format($gst_amount,2).'';
			
		}else{
			return '(0%) Rs.0';
		}
		    
	}
	public static function IGST($productprice,$gstPercentage ){
		if($gstPercentage != '0' && $gstPercentage  != ''){
			$gst_amount =  $productprice * ($gstPercentage / 100);
			return '('.$gstPercentage.'%) Rs.'.number_format($gst_amount,2).'';
			
		}else{
			return '(0%) Rs.0';
		}
		    
	}
	
    public static function gstunitcalculate($price,$gst,$qty){
        
        $price = $price * $qty;
        
        $gst_with_hundred = 100 + $gst;
        
        $tot_price = $price/$gst_with_hundred * 100;
        
        return $tot_price;
        
    }	  

    public static function sgstcalculate($price,$gst,$qty){
        $tot_price = $igstamount = 0;
        
        $price = $price * $qty;
        
        $gst_with_hundred = 100 + $gst;
        
        $tot_price = $price/$gst_with_hundred * 100;
        
        $tot_final = $price - $tot_price;
        
        $tot_final = $tot_final /2;
        
        return $tot_final;
    }

    public static function igstcalculate($price,$gst,$qty){
        $tot_price = $igstamount = 0;
        
        $price = $price * $qty;
        
        $gst_with_hundred = 100 + $gst;
        
        $tot_price = $price/$gst_with_hundred * 100;
        
        $tot_final = $price - $tot_price;
        
        return $tot_final;
    }    
    public static function totalcalculate($price,$gst){
        $tot_price = $igstamount = 0;
        
        $tot_price = abs(($price * $gst / 100) - $price) ;        

        $igstamount = $price-$tot_price;

        return $igstamount;
    }

     public static function get_weight($id){ 
		 $sum_weight = Product::select(DB::raw("SUM(weight) as sumweight"))->where('id',$id)->first(); 
		 return $sum_weight->sumweight;
	 }
     public static function hsncode($id){ 
		 $hsn_code = Product::select('hsn_code')->where('id',$id)->first(); 
		 return $hsn_code;;
	 }
	 public static function statecode($state){
		$states = array(
			'28' => 'Andhra Pradesh',
			'18' => 'Assam',
			'12' => 'Arunachal Pradesh',
			'10' => 'Bihar',
			'24' => 'Gujrat',
			'06' => 'Haryana',
			'02' => ' Himachal Pradesh',
			'01' => 'Jammu & Kashmir',
			'29' => 'Karnataka',
			'32' => 'Kerala',
			'23' => 'Madhya Pradesh',
			'27' => 'Maharashtra',
			'14' => 'Manipur',
			'17' => 'Meghalaya',
			'15' => 'Mizoram',
			'13' => 'Nagaland',
			'21' => 'Odisha',
			'03' => 'Punjab',
			'08' => 'Rajasthan',
			'11' => 'Sikkim',
			'33' => 'Tamil Nadu',
			'16' => 'Tripura',
			'09' => 'Uttar Pradesh',
			'19' => 'West Bengal',
			'07' => 'Delhi',
			'30' => 'Goa',
			'34' => 'Puducherry',
			'31' => 'Lakshdweep',
			'25' => 'Daman & Diu',
			'26' => 'Dadra & Nagar',
			'04' => 'Chandigarh',
			'35' => 'Andaman & Nicobar',
			'05' => 'Uttarakhand',
			'20' => 'Jharkhand',
			'22' => 'Chattisgarh',
			'36' => 'Telangana',
			'38' => 'Ladakh',
		);		 
		foreach($states as $key=>$state_value){
			
			if($state_value==$state){
				return $key;
			}
		}
	 }
   public static function get_payment_method($method){
          if($method == 'cod'){
			   return 'Cash On Delivery ';
		  }else if($method == 'payu'){
			   return 'Payu';
		  }else if($method == 'bank_deposit'){
			   return 'Bank Deposit';
		  }else{
			   return $method;
		  }			  
   
   }   
   
   public static function charactersOnly($value){
	   if($value != ''){
	     $value = str_replace(' ', '',$value);
	 	 $value = str_replace('.', '',$value);
	   }
	   return $value; 
	   
   }
   
   
   public static function get_amt_format($amt=0){
	   $amt_explode = explode('.',$amt);
	   
	   $amount = $amt_explode[0];
	   
	   if(isset($amt_explode[1]) && !empty($amt_explode[1])){
		   
		   $twoDigits = substr($amt_explode[1], 0, $amt_explode[1] < 0 ? 3 : 2);
		   $amount .= '.'.$twoDigits;
	   }
	   
	   return $amount;
	   
   }
   
   
   
   
   
   
   
   
   
}
