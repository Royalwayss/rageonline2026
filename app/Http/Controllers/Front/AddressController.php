<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use App\ShippingAddress;
use App\BillingAddress;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Indian states list, pulled from the states table.
     */
    private function states()
    {
        return State::orderby('name', 'ASC')->pluck('name')->toArray();
    }

    /**
     * AJAX: load the modal form body, for both Add (no id) and Edit (id given).
     * GET /address/form/{type}/{id?}   type = shipping|billing
     */
    public function form(Request $request, $type, $id = null)
    {
        $address = null;

        if ($type == 'shipping' && !empty($id)) {
            $address = ShippingAddress::where('user_id', Auth::id())->where('id', $id)->first();
        }

        // Billing address is always single - prefill the billing section
        // with the user's existing billing row, if any, regardless of
        // whether we're adding/editing a shipping address.
        $billing = BillingAddress::where('user_id', Auth::id())->first();

        $states = $this->states();

        return view('front.checkout.address-form', compact('address', 'billing', 'type', 'states'));
    }

    /**
     * POST /address/save
     */
    public function save(Request $request)
    {   
	
	    $post_data = $request->all();
        $rules = [
            'full_name' => 'required|regex:/^[a-zA-Z ]+$/u|max:255',
            'mobile'    => 'required|numeric|digits_between:7,15',
            'alternative_number' => 'required|numeric|digits_between:7,15',
            'address'   => 'bail|required',
            'postcode'  => 'required|numeric|digits:6',
            'city'      => 'required|regex:/^[a-zA-Z ]+$/u|max:255',
            'state'     => 'bail|required',
            'country'   => 'bail|required',
        ];

        $messages = [
            'full_name.required' => 'Enter the name.',
            'full_name.regex' => 'Enter the valid name.',
            'mobile.required' => 'Enter a valid mobile number (7 to 15 digits).',
            'mobile.numeric' => 'Enter a valid mobile number (7 to 15 digits).',
            'mobile.digits_between' => 'Enter a valid mobile number (7 to 15 digits).',
            'alternative_number.required' => 'Enter a valid alternative mobile number (7 to 15 digits).',
            'alternative_number.numeric' => 'Enter a valid alternative mobile number (7 to 15 digits).',
            'alternative_number.digits_between' => 'Enter a valid alternative mobile number (7 to 15 digits).',
            'address.required' => 'Enter the address.',
            'postcode.required' => 'Enter the postcode.',
            'postcode.numeric' => 'Enter the 6 digit valid postcode.',
            'postcode.digits' => 'Enter the 6 digit valid postcode.',
            'city.required' => 'Enter the city.',
            'city.regex' => 'Enter the valid city.',
            'state.required' => 'Please select state.',
            'country.required' => 'Please select country.',
        ];

        if ($request->input('billing_same') != '1' && isset($post_data['billing_same'])) {
            $rules['billing_full_name'] = 'required|regex:/^[a-zA-Z ]+$/u|max:255';
            $rules['billing_mobile']    = 'required|numeric|digits_between:7,15';
           // $rules['billing_alternative_number'] = 'numeric|digits_between:7,15';
            $rules['billing_address']   = 'bail|required';
            $rules['billing_postcode']  = 'required|numeric|digits:6';
            $rules['billing_city']      = 'required|regex:/^[a-zA-Z ]+$/u|max:255';
            $rules['billing_state']     = 'bail|required';
            $rules['billing_country']   = 'bail|required';

            $messages['billing_full_name.required'] = 'Enter the name.';
            $messages['billing_full_name.regex'] = 'Enter the valid name.';
            $messages['billing_mobile.required'] = 'Enter a valid mobile number (7 to 15 digits).';
            $messages['billing_mobile.numeric'] = 'Enter a valid mobile number (7 to 15 digits).';
            $messages['billing_mobile.digits_between'] = 'Enter a valid mobile number (7 to 15 digits).';
           
           // $messages['billing_alternative_number.numeric'] = 'Enter a valid alternative mobile number (7 to 15 digits).';
           // $messages['billing_alternative_number.digits_between'] = 'Enter a valid alternative mobile number (7 to 15 digits).';
            $messages['billing_address.required'] = 'Enter the address.';
            $messages['billing_postcode.required'] = 'Enter the postcode.';
            $messages['billing_postcode.numeric'] = 'Enter the 6 digit valid postcode.';
            $messages['billing_postcode.digits'] = 'Enter the 6 digit valid postcode.';
            $messages['billing_city.required'] = 'Enter the city.';
            $messages['billing_city.regex'] = 'Enter the valid city.';
            $messages['billing_state.required'] = 'Please select state.';
            $messages['billing_country.required'] = 'Please select country.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'type'   => 'validation',
                'errors' => $validator->errors(),
            ]);
        }

        // --- Shipping address (create or update) ---
        $nameParts = explode(' ', trim($request->input('full_name')), 2);
        $shippingData = [
            'user_id'             => Auth::id(),
            'name'                => $request->input('full_name'),
            'first_name'          => $nameParts[0],
            'last_name'           => $nameParts[1] ?? '',
            'mobile'              => $request->input('mobile'),
            'alternative_number'  => $request->input('alternative_number'),
            'country_code'        => $request->input('country_code'),
            'country_code2'       => $request->input('country_code2'),
            'country'             => $request->input('country'),
            'state'               => $request->input('state'),
            'city'                => $request->input('city'),
            'postcode'            => $request->input('postcode'),
            'address'             => $request->input('address'),
            'address2'            => '',
        ];

        if (!empty($request->input('id'))) {
            $shipping = ShippingAddress::where('user_id', Auth::id())->where('id', $request->input('id'))->first();
            if (!$shipping) {
                return response()->json(['status' => false, 'message' => 'Address not found.']);
            }
            $shipping->update($shippingData);
        } else {
            // First saved address for this user becomes default automatically.
            $existingCount = ShippingAddress::where('user_id', Auth::id())->count();
            $shippingData['is_default'] = $existingCount == 0 ? 'yes' : 'no';
            $shipping = ShippingAddress::create($shippingData);
        }

        // --- Billing address (always a single upserted row) ---
        if ($request->input('billing_same') == '1') {
            $billingSource = $shippingData;
			$billingSource['alternative_number'] = $request->input('alternative_number');
        } else {
            $billingNameParts = explode(' ', trim($request->input('billing_full_name')), 2);
            $billingSource = [
                'user_id'             => Auth::id(),
                'name'                => $request->input('billing_full_name'),
                'first_name'          => $billingNameParts[0],
                'last_name'           => $billingNameParts[1] ?? '',
                'mobile'              => $request->input('billing_mobile'),
                'alternative_number'  => $request->input('billing_alternative_number'),
                'country'             => $request->input('billing_country'),
				'country_code'        => $request->input('billing_country_code'),
                'country_code2'       => $request->input('billing_country_code2'),
                'state'               => $request->input('billing_state'),
                'city'                => $request->input('billing_city'),
                'postcode'            => $request->input('billing_postcode'),
                'address'             => $request->input('billing_address'),
                'address2'            => '',
            ];
        }

        $billingRow = BillingAddress::where('user_id', Auth::id())->first();
        if ($billingRow) {
            $billingRow->update($billingSource);
        } else {
            BillingAddress::create($billingSource);
        }

        $shippingAddresses = ShippingAddress::where('user_id', Auth::id())->orderBy('is_default', 'desc')->orderBy('id', 'desc')->get();

        return response()->json([
            'status'  => true,
            'message' => 'Address saved successfully.',
            'view'    => view('front.checkout.address-list', compact('shippingAddresses'))->render(),
        ]);
    }

    /**
     * POST /address/delete
     */
    public function delete(Request $request)
    {
        $address = ShippingAddress::where('user_id', Auth::id())->where('id', $request->input('id'))->first();

        if (!$address) {
            return response()->json(['status' => false, 'message' => 'Address not found.']);
        }

        $wasDefault = $address->is_default == 'yes';
        $address->delete();

        // If the deleted address was the default, promote another one (if any).
        if ($wasDefault) {
            $next = ShippingAddress::where('user_id', Auth::id())->orderBy('id', 'asc')->first();
            if ($next) {
                $next->is_default = 'yes';
                $next->save();
            }
        }

        $shippingAddresses = ShippingAddress::where('user_id', Auth::id())->orderBy('is_default', 'desc')->orderBy('id', 'desc')->get();

        return response()->json([
            'status'  => true,
            'message' => 'Address removed.',
            'view'    => view('front.checkout.address-list', compact('shippingAddresses'))->render(),
        ]);
    }

    /**
     * POST /address/set-default
     */
    public function setDefault(Request $request)
    {
        $address = ShippingAddress::where('user_id', Auth::id())->where('id', $request->input('id'))->first();

        if (!$address) {
            return response()->json(['status' => false, 'message' => 'Address not found.']);
        }

        ShippingAddress::where('user_id', Auth::id())->update(['is_default' => 'no']);
        $address->is_default = 'yes';
        $address->save();

        $shippingAddresses = ShippingAddress::where('user_id', Auth::id())->orderBy('is_default', 'desc')->orderBy('id', 'desc')->get();

        return response()->json([
            'status'  => true,
            'message' => 'Default address updated.',
            'view'    => view('front.checkout.address-list', compact('shippingAddresses'))->render(),
        ]);
    }
}