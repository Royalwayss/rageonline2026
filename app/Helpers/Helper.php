<?php 
use Illuminate\Support\Facades\DB;
 use App\Product; 

    function formatAmt($amount){
        list ($number, $decimal) = explode('.', sprintf('%.2f', floatval($amount)));
        $sign = $number < 0 ? '-' : '';
        $number = abs($number);
        for ($i = 3; $i < strlen($number); $i += 3){
            $number = substr_replace($number, ',', -$i, 0);
        }
        if($decimal==00){
            return  $sign . $number;
        }else{
            return  $sign . $number;
        }
    }
	
	 function AmountFormat($amount){ 
		$formatted_number = number_format($amount, 2, '.', ''); // Format to 2 decimal places
		
		
		$explode = explode(".",$formatted_number);
		
		if($explode['1'] != '00'){
			return $formatted_number;
		}else{
			return $explode['0'];
		}
		
		
		
		
        
	 }


    function convert_number_to_words($number) {
        $hyphen      = ' ';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' ';
        $dictionary  = array(
            0                   => 'Zero',
            1                   => 'One',
            2                   => 'Two',
            3                   => 'Three',
            4                   => 'Four',
            5                   => 'Five',
            6                   => 'Six',
            7                   => 'Seven',
            8                   => 'Eight',
            9                   => 'Nine',
            10                  => 'Ten',
            11                  => 'Eleven',
            12                  => 'Twelve',
            13                  => 'Thirteen',
            14                  => 'Fourteen',
            15                  => 'Fifteen',
            16                  => 'Sixteen',
            17                  => 'Seventeen',
            18                  => 'Eighteen',
            19                  => 'Nineteen',
            20                  => 'Twenty',
            30                  => 'Thirty',
            40                  => 'Fourty',
            50                  => 'Fifty',
            60                  => 'Sixty',
            70                  => 'Seventy',
            80                  => 'Eighty',
            90                  => 'Ninety',
            100                 => 'Hundred',
            1000                => 'Thousand',
            1000000             => 'Million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );
        
        if (!is_numeric($number)) {
            return false;
        }
        
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }
        
        $string = $fraction = null;
        
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
    
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }
    
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        return $string;
    }

    function sendSms($smsdetails=null,$otp=null){
            $r = 0;
            /*Code for SMS Script Starts*/
            $request ="";
            $param['username']="gloryknitwears";
            $param['pass'] = 'C@Z7v_t1';
            $param['message']=$smsdetails['message'];
            $param['dest_mobileno']=$smsdetails['mobile'];
            $param['senderid']="DEERCL";
            $param['response']="Y";
            
            foreach($param as $key=>$val) {
                $request.= $key."=".urlencode($val);
                $request.= "&";
            }
            $request = substr($request, 0, strlen($request)-1);
    
            $url ="http://www.smsjust.com/sms/user/urlsms.php?".$request;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curl_scraped_page = curl_exec($ch);
            if($curl_scraped_page){
                $r = 1;
            }
            curl_close($ch);
            return $r;
            /*Code for SMS Script Ends*/
    }
	function getinvoiceNumber($input){
		$position = $input - 100000;
		return $position; 		
	}   

    function get_gst_amount($price,$own_state,$product_gst){ 
		
		$cgst = '';  //own state
		$sgst = '';  //own state
		$igst = ''; //other state
		$cgst_percentage = '';
		$sgst_percentage = '';
		$igst_percentage = '';
		if($price < 1000){
			//$product_gst = '5';
		}else{
			//$product_gst = '12';
		}
		$total_gst = igstcalculate($price,$product_gst);
        if($own_state == 'yes'){ 
		  
		   $cgst = abs(formatAmt($total_gst/2));
		   $sgst = abs(formatAmt($total_gst/2));
		   $cgst_percentage = $product_gst/2;
		   $sgst_percentage = $product_gst/2;
		}else{
			$igst = $total_gst;
			$igst_percentage = $product_gst;
		}
		
		
		$result['total_gst'] = $total_gst;
		$result['cgst'] = $cgst;
		$result['sgst'] = $sgst;
		$result['igst'] = $igst;
		$result['cgst_percentage'] = $cgst_percentage;
		$result['sgst_percentage'] = $sgst_percentage;
		$result['igst_percentage'] = $igst_percentage;
		$result['product_gst'] = $product_gst;
		$result['price'] = $price;
		
		return $result;
	} 
    
	function igstcalculate($price,$gst){
        $tot_price = $igstamount = 0;
        
        $price = $price;
        
        $gst_with_hundred = 100 + $gst;
        
        $tot_price = $price/$gst_with_hundred * 100;
        
        $tot_final = $price - $tot_price;
		
		$tot_final = round($tot_final); 
        
        return $tot_final;
    } 
	
	
	
	function months() {
		return [
		    '01'=>'January',
		    '02'=>'February',
		    '03'=>'March',
		    '04'=>'April',
		    '05'=>'May',
		    '06'=>'June',
		    '07'=>'July',
		    '08'=>'August',
		    '09'=>'September',
		    '10'=>'October',
		    '11'=>'November',
		    '12'=>'December'
		];
	}
	function get_month($month_no) {
		$months = months();
		return @$months[$month_no];
	}
	
	function years() {
		$years =[];
		for($y=date('Y'); $y > 2020; $y--){
			$years[] = $y;
		}
		return $years;
	}
	
	
    function chart_types(){
		return  [
			'bar' =>'Bar',
			'line' =>'Line',
			'pie' => 'Pie',
			'doughnut' =>'Doughnut',
			'radar' =>'Radar',
			'polarArea' =>'Polar Area'
		];
		
	}
		
		
    function pd($data=array()){
		echo "<pre>"; print_r($data); exit;	
	} 
	
	
	
	function update_order_product_gst($order_id){
		$orderDetails =  new \App\Order; 
		$orderDetails = $orderDetails->with('order_products')->where('id',$order_id)->first();
		$orderDetails = json_decode(json_encode($orderDetails),true);
		foreach($orderDetails['order_products'] as $key=>$order_product){
			$mrp = $order_product['mrp'];
			$product_qty = $order_product['product_qty'];
			$product_discount = ($orderDetails['order_discount']/$orderDetails['subtotal']) * ($mrp*$product_qty);
			$product_discount = round($product_discount/$product_qty);
			$unit_price = ($order_product['subtotal']/$order_product['product_qty']- ($product_discount));
			if($unit_price > 2625){
					$product_gst = 18;
			}else{
					$product_gst = 5;
			}
			$OrderProduct =  new \App\OrderProduct;
			$OrderProduct::where('id',$order_product['id'])->update(['product_gst'=>$product_gst]);
			
		}
	}
	
	
	function order_products_summery($orderDetails){
		
		if($orderDetails['id'] > 7883){ 
			return order_products_summery_new($orderDetails);
		}else{
			return order_products_summery_old($orderDetails);
		}
	}
	
	function order_products_summery_new($orderDetails){
	    
		
		if($orderDetails['order_address']['shipping_state'] =='Punjab'){
			$own_state = 'yes';
		}else{
			$own_state = 'no';
		}
		
		
		
		$order_total_product_gst_amount = 0;
		$orderDetails = json_decode(json_encode($orderDetails),true);
		$order_discount_percentage = $orderDetails['order_discount_percentage'];
		$order_discount = $orderDetails['order_discount']+($orderDetails['coupon_discount']-$orderDetails['prepaid_discount']); 
		
		$order_product_summery = [];
		$order_products = $orderDetails['order_products'];
	    foreach($order_products as $key=>$order_product){
			$product_gst = $order_product['product_gst'];
			$mrp = $order_product['mrp'];
			$product_qty = $order_product['product_qty'];
			$product_price = $order_product['mrp'] - $order_product['discount'];
			
			
			//$product_discount = ($order_discount/$orderDetails['subtotal']) * ($orderDetails['subtotal']*$product_qty);
			//$product_discount = round($product_discount/$product_qty);
			$product_discount = ( $order_product['discount'] + (($orderDetails['total_order_discount']/$orderDetails['subtotal'] * $product_price )));
			
			$unit_price = ($order_product['mrp']-$product_discount); 
			$product_gst_amount = igstcalculate($unit_price,$product_gst);
			$total_product_gst_amount = $product_gst_amount*$order_product['product_qty'];
			$order_total_product_gst_amount += $product_gst_amount*$order_product['product_qty'];
			
			
			if($own_state == 'no'){
				$IGST = $product_gst_amount;
				$CGST = '';
				$SGST = '';
			}else{
				$IGST = '';
				$CGST = $product_gst_amount/2;
				$SGST = $product_gst_amount/2;
			}
			
			
			$product_summery['IGST'] = $IGST;
			$product_summery['CGST'] = $CGST;
			$product_summery['SGST'] = $SGST;
			
			$image ='';
			if($order_product['productdetail']['product_image']){
				$image = $order_product['productdetail']['product_image']['image'];
			}
			
			$product_summery['id'] = $order_product['id'];
			$product_summery['mrp'] = $order_product['mrp'];
			$product_summery['subtotal'] = $order_product['subtotal']*$order_product['product_qty']; 
			$product_summery['product_gst'] = $order_product['product_gst'];
			$product_summery['product_gst_amount'] = $product_gst_amount;
			$product_summery['total_product_gst_amount'] = $total_product_gst_amount;
			$product_summery['product_qty'] = $order_product['product_qty'];
			$product_summery['order_discount_percentage'] = $order_discount_percentage;
			$product_summery['product_discount'] = $product_discount;
			$product_summery['unit_price'] = $unit_price;
			$product_summery['taxable_value'] = $unit_price - $product_gst_amount;
			$product_summery['sub_total'] = $unit_price * $product_qty;
			$product_summery['grand_total'] = $product_summery['unit_price'];
			$product_summery['product_name'] = $order_product['productdetail']['product_name'];
			$product_summery['seo_url'] = $order_product['productdetail']['seo_url'];
			$product_summery['product_size'] = $order_product['product_size'];
			$product_summery['product_link'] = url('product/'.$order_product['productdetail']['seo_url']);
			$product_summery['product_code'] = $order_product['product_code'];
			$product_summery['productcolor'] = $order_product['productdetail']['productcolor'];
			$product_summery['product_sku'] = $order_product['product_sku'];
			$product_summery['category_name'] = $order_product['category_name']; 
			$product_summery['image'] = $image;
			$products_summery[] = $product_summery;
			
			
			
		}  
		$order_product_summery['products'] =  $products_summery; 
		
		
		
		$order_discount = $orderDetails['total_order_discount']; 
		
		
		$order_product_summery['total_amount'] =  $orderDetails['subtotal'];
		
		$order_product_summery['discount'] =   $order_discount;
		$order_product_summery['subtotal'] =   $orderDetails['subtotal']- $order_discount;
		//$order_product_summery['taxable_value'] =   ($orderDetails['grand_total']+$orderDetails['prepaid_discount'])-$order_total_product_gst_amount;
		$order_product_summery['taxable_value'] =   ($orderDetails['subtotal'] - $order_discount - $orderDetails['shipping_charges'] )-$order_total_product_gst_amount;
		
		$order_product_summery['total_product_gst_amount'] =  $order_total_product_gst_amount;
		
		
		if($orderDetails['round_of'] != '0.00' && $orderDetails['round_of'] != '0'){
			if (!str_contains($orderDetails['round_of'], '-')) {  
				$round_of = '+'.$orderDetails['round_of']; 
			}else{
				$round_of = $orderDetails['round_of']; 
			}
			
		}else{
			$round_of = '';
		}
		
		
		$order_product_summery['round_of'] =  $round_of; 
		$order_product_summery['grand_total_without_round_of'] =  $orderDetails['grand_total_without_round_of']; 
		$order_product_summery['grand_total'] =  $orderDetails['grand_total']; 
		
	    //pd($order_product_summery);
		
		return $order_product_summery;
	}
	
	function order_products_summery_old($orderDetails){
	    
		
		if($orderDetails['order_address']['shipping_state'] =='Punjab'){
			$own_state = 'yes';
		}else{
			$own_state = 'no';
		}
		
		
		
		$order_total_product_gst_amount = 0;
		$orderDetails = json_decode(json_encode($orderDetails),true);
		$order_discount_percentage = $orderDetails['order_discount_percentage'];
		$order_discount = $orderDetails['order_discount']+($orderDetails['coupon_discount']-$orderDetails['prepaid_discount']); 
		
		$order_product_summery = [];
		$order_products = $orderDetails['order_products'];
	    foreach($order_products as $key=>$order_product){
			$product_gst = $order_product['product_gst'];
			$mrp = $order_product['mrp'];
			$product_qty = $order_product['product_qty'];
			$product_discount = ($order_discount/$orderDetails['subtotal']) * ($orderDetails['subtotal']*$product_qty);
			$product_discount = round($product_discount/$product_qty);
			$unit_price = ($order_product['subtotal']/$order_product['product_qty']- ($product_discount));
			$product_gst_amount = igstcalculate($unit_price,$product_gst);
			$total_product_gst_amount = $product_gst_amount*$order_product['product_qty'];
			$order_total_product_gst_amount += $product_gst_amount*$order_product['product_qty'];
			
			
			if($own_state == 'no'){
				$IGST = $product_gst_amount;
				$CGST = '';
				$SGST = '';
			}else{
				$IGST = '';
				$CGST = $product_gst_amount/2;
				$SGST = $product_gst_amount/2;
			}
			
			
			$product_summery['IGST'] = $IGST;
			$product_summery['CGST'] = $CGST;
			$product_summery['SGST'] = $SGST;
			
			$image ='';
			if($order_product['productdetail']['product_image']){
				$image = $order_product['productdetail']['product_image']['image'];
			}
			
			$product_summery['id'] = $order_product['id'];
			$product_summery['mrp'] = $order_product['mrp'];
			$product_summery['subtotal'] = $order_product['subtotal'];
			$product_summery['product_gst'] = $order_product['product_gst'];
			$product_summery['product_gst_amount'] = $product_gst_amount;
			$product_summery['total_product_gst_amount'] = $total_product_gst_amount;
			$product_summery['product_qty'] = $order_product['product_qty'];
			$product_summery['order_discount_percentage'] = $order_discount_percentage;
			$product_summery['product_discount'] = $product_discount;
			$product_summery['unit_price'] = $unit_price;
			$product_summery['taxable_value'] = $unit_price - $product_gst_amount;
			$product_summery['sub_total'] = $unit_price * $product_qty;
			$product_summery['grand_total'] = $product_summery['unit_price'];
			$product_summery['product_name'] = $order_product['productdetail']['product_name'];
			$product_summery['seo_url'] = $order_product['productdetail']['seo_url'];
			$product_summery['product_size'] = $order_product['product_size'];
			$product_summery['product_link'] = url('product/'.$order_product['productdetail']['seo_url']);
			$product_summery['product_code'] = $order_product['product_code'];
			$product_summery['productcolor'] = $order_product['productdetail']['productcolor'];
			$product_summery['product_sku'] = $order_product['product_sku'];
			$product_summery['category_name'] = $order_product['category_name']; 
			$product_summery['image'] = $image;
			$products_summery[] = $product_summery;
			
			
			
		}
		$order_product_summery['products'] =  $products_summery; 
		
		
		
		$order_discount = $orderDetails['order_discount']+($orderDetails['coupon_discount']-$orderDetails['prepaid_discount']); 
		
		
		$order_product_summery['total_amount'] =  $orderDetails['subtotal'];
		
		$order_product_summery['discount'] =   $order_discount;
		$order_product_summery['subtotal'] =   $orderDetails['subtotal']- $order_discount;
		//$order_product_summery['taxable_value'] =   ($orderDetails['grand_total']+$orderDetails['prepaid_discount'])-$order_total_product_gst_amount;
		$order_product_summery['taxable_value'] =   ($orderDetails['subtotal'] - $order_discount - $orderDetails['shipping_charges'] )-$order_total_product_gst_amount;
		
		$order_product_summery['total_product_gst_amount'] =  $order_total_product_gst_amount;
		$order_product_summery['grand_total'] =  $orderDetails['grand_total'];
		
	    
		
		return $order_product_summery;
	}
	
	
	function round_of($round_of){ 
			    if($round_of != '0.00' && $round_of != '0'){
					if (!str_contains($round_of, '-')) {  
						$roundof = '+'.$round_of; 
					}else{
						$roundof = $round_of; 
					}
					
				}else{
					$roundof = '';
				} 
			return $roundof;
	}
	
	function ensureJson($data): string
{
    // If already a valid JSON string, return as-is
    if (is_string($data)) {
        json_decode($data);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $data;
        }
    }

    // If array or object, convert to JSON
    if (is_array($data) || is_object($data)) {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    // Fallback: convert scalar values
    return json_encode($data);
}




function get_counties() {
	$counties = [];
	
	$sql = 'select id,name as country from `countries` group by name order by `countries`.`name` asc';
	$counties = DB::select($sql); 
	$counties = json_decode(json_encode($counties),true);
    return $counties;	
}



function get_state_options($country_id=101) {
	$state_options = '<option value="" disabled selected>Select your state</option>';
	$sql = 'select * from `all_states` where `country_id` = '.$country_id.' group by name order by name asc';
	DB::select($sql);
	$result = DB::select($sql); 
	$result = json_decode(json_encode($result),true);

    $state_options = '<option value="" disabled selected>Select your state</option>';
    
        foreach($result as $row){
        
		  $state_options .= '<option value="'.$row['name'].'"  data-id="'.$row['id'].'">'.$row['name'].'</option>';
			  
        }
    

    return $state_options;	
}


function get_city_options($state_id) {
	$city_options = '<option value="" disabled selected>Select your city</option>';
	$sql = 'select * from `cities` where `state_id` = '.$state_id.' group by name order by name asc';
	DB::select($sql);
	$result = DB::select($sql); 
	$result = json_decode(json_encode($result),true);
    
	foreach($result as $row){ 
	  $city_options .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';	  
	}
    

    return $city_options;	
}



if (!function_exists('productPriceHtml')) {
    /**
     * Renders the price + discount markup for a product card.
     * Usage in Blade: {!! productPriceHtml($product) !!}
     */
    function productPriceHtml($product)
    {
        $price = Product::ProductPrice($product['category_id'], $product);

        if ($product['current_discount'] == 'product' || $product['current_discount'] == 'category') {

            if ($product['current_discount'] == 'product') {
                $discount_percentage = $product['product_discount'];
            } else {
                $discount_percentage = $product['category']['category_discount'];
            }

            $original_price = round((float) str_replace(',', '', formatAmt($product['product_price'])));

            return '<span class="sale-price">INR '.$price.'</span>'
                 . '<del>INR '.$original_price.'</del>'
                 . '<span class="discount">'.$discount_percentage.'% OFF</span>';

        }

        return '<span class="sale-price">INR '.$price.'</span>';
    }
}





