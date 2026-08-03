<div class="col-md-12 col-12 billing mt-4 desc">
    <div class="row">
        <h4 class="orange">Shipping Address</h4>
        <div class="form-group">
            <span>Name :</span>
            <input type="text" class="input-style form-control" name="shipping_name" placeholder="Enter Name" value="{{(isset($getshippingAddress->name) ? $getshippingAddress->name : '')}}" />
            <p class="err text-center" id="Details-shipping_name" style="display: none;"></p>
        </div>
        <div class="form-group">
            <span>Mobile :</span>
            <input type="number" class="input-style form-control" name="shipping_mobile" placeholder="Enter Mobile" value="{{(isset($getshippingAddress->mobile) ? $getshippingAddress->mobile : '')}}"/>
            <p class="err text-center" id="Details-shipping_mobile" style="display: none;"></p>
        </div>
        <div class="form-group">
            <span>Country :</span>
            <select class="input-style form-control" name="shipping_country">
                <option value="India">India</option>
            </select>
        </div>
        <div class="form-group">
            <span>State :</span>
            <input type="text" class="input-style form-control" name="shipping_state" placeholder="Enter State" value="{{(isset($getshippingAddress->state) ? $getshippingAddress->state : '')}}" />
            <p class="err text-center" id="Details-shipping_state" style="display: none;"></p>
        </div>
        <div class="form-group">
            <span>City :</span>
            <input type="text" class="input-style form-control" name="shipping_city" placeholder="Enter City" value="{{(isset($getshippingAddress->city) ? $getshippingAddress->city : '')}}" />
            <p class="err text-center" id="Details-shipping_city" style="display: none;"></p>
        </div>
        <div class="form-group">
            <span>Postcode :</span>
            <input type="text" class="input-style form-control" name="shipping_postcode" placeholder="Enter Postcode" value="{{(isset($getshippingAddress->postcode) ? $getshippingAddress->postcode : '')}}"/>
            <p class="err text-center" id="Details-shipping_postcode" style="display: none;"></p>
        </div>
        <div class="form-group address">
            <span>Address Line 1:</span>
            <textarea class="input-style form-control" rows="1" name="shipping_address" placeholder="Enter Adresss line 1...">{{(isset($getshippingAddress->address) ? $getshippingAddress->address : '')}}</textarea>
            <p class="err text-center" id="Details-shipping_address" style="display: none;"></p>
        </div>
        <div class="form-group address">
            <span>Address Line 2:</span>
            <textarea class="input-style form-control" rows="1" name="shipping_address2" placeholder="Enter Adresss line 2...">{{(isset($getshippingAddress->address) ? $getshippingAddress->address2 : '')}}</textarea>
        </div>
    </div>
</div>