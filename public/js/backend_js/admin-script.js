jQuery(document).ready(function() { 
    $.ajaxSetup({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });    
    TableAjax.init();
    $(document).on('click','.toogle_switch',function(){
        if($(this).hasClass('bootstrap-switch-on')){
            $(this).removeClass('bootstrap-switch-on');
            $(this).addClass('bootstrap-switch-off');
            var status=0;
            var id_sent=$(this).attr('id');
        }
        else{
            $(this).removeClass('bootstrap-switch-off');
            $(this).addClass('bootstrap-switch-on');
            var status=1;
            var id_sent=$(this).attr('id');
        }
        var table = $(this).attr('rel');
        var ajax_url='status';
        $.ajax({
            url:ajax_url,
            type:'POST',
            data:{
                'id':id_sent,'status':status, 'table':table
            },
            success:function(msg) {
            }
        })
    });
    
    
    $(".form-filter").keypress(function(event) {
        if (event.keyCode === 13) {
            $(".filter-submit").click();
        }
    });

    $(".select").change(function(event) {
        $(".filter-submit").click();
    });

    
    
    
    

    $('#change_pass').formValidation({
        framework: 'bootstrap',
        message: 'This value is not valid',
        icon:{
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        err:{
            container: 'popover'
        },
        fields:{
            "password":{
                validators:{
                    notEmpty:{
                        message: 'Current password is required'
                    },
                    remote:{
                        message: 'Current password is incorrect',
                        url: '/admin/checkAdminPassword',
                        type: 'POST',
                        delay: 1000     // Send Ajax request every 2 seconds
                    }
                }
            },
            "new_password":{
                validators:{
                    notEmpty:{
                        message: 'New password is required'
                    }
                }
            },
            "re_password":{
                validators:{
                    notEmpty:{
                        message: 'Confirm Password  is required'
                    },
                    identical:{
                        field: "new_password",
                        message: 'Confirm Password is not match with New Password'
                    }
                }
            }
        }
    });

    $('#addEditUser').formValidation({
        framework: 'bootstrap',
        message: 'This value is not valid',
        icon:{
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err:{
            container: 'popover'
        }, //match('^[a-zA-Z]{3,16}$') 
        fields:{
            "name":{
                validators:{
                    notEmpty:{
                        message: 'Name is required'
                    },
                },
				
            },
            "gender":{
                validators:{
                    notEmpty:{
                        message: 'Gender is required'
                    },
                }
            },
            "country":{
                validators:{
                    notEmpty:{
                        message: 'Country is required'
                    },
                }
            },
            "state":{
                validators:{
                    notEmpty:{
                        message: 'Select the State'
                    },
                }
            },
            "city":{
                validators:{
                    notEmpty:{
                        message: 'City is required'
                    },
                }
            },
            "address":{
                validators:{
                    notEmpty:{
                        message: 'Address is required'
                    },
                }
            },
            "postcode":{
                validators:{
                    notEmpty:{
                        message: 'Postcode is required'
                    },
                }
            },
			 "postcode":{
                validators:{   
                    notEmpty:{
                        message: 'Postcode is required.'
                    },
                    regexp: {
                        regexp: /^[1-9]\d*(\.\d+)?$/,
                        message: 'Postcode can only accept integer'
                    }
                }
            },
            "email":{
                validators:{
                    notEmpty:{
                        message: 'Email is required.'
                    },
                    emailAddress:{
                        message: 'This Email is not a valid email address'
                    },
                    remote:{
                        message: 'This email already exists.',
                        url: '/admin/CheckUserEmail',
                        type: 'POST',
                        delay: 2000     // Send Ajax request every 2 seconds
                    }
                }
            },
            "mobile":{
                validators:{   
                    notEmpty:{
                        message: 'Mobile Number is required.'
                    },
                    regexp: {
                        regexp: /^[789]\d{9}$/,
                        message: 'Mobile number must be in digists and 10 in length'
                    }
                }
            },
            "password":{
                validators:{
                    notEmpty:{
                        message: 'Password  is required'
                    },
                    stringLength:{
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 5 letters.'
                    },
                }
            }
        }
    });

    $(document).on('change','.getCountry',function(){
        var countryid = $(this).val(); 
        $("#AppendCities").html('<option value="">Select</option');
        $.ajax({
            url : '/get-states',
            data : {countryid: countryid},
            type : 'post',
            success:function(resp){
                $("#AppendStates").html(resp);
            },
            error:function(){}
        })
    });

    $(document).on('change','.getState',function(){
        var stateid = $(this).val(); 
        $.ajax({
            url : '/get-cities',
            data : {stateid: stateid},
            type : 'post',
            success:function(resp){
                $("#AppendCities").html(resp);
            },
            error:function(){}
        })
    });

    if($("#CatSeoUnique").length > 0){
        var catseo = $("#CatSeoUnique").html();
        var catseourl = "?catseo="+catseo;
    }else{
        var catseourl ="";
    }
    //Catgeory Validation Starts
    $('#addEditCategoryForm').formValidation({
        framework: 'bootstrap',
        excluded: [':disabled'],
        message: 'This value is not valid',
        icon: 
        {
         /*   valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err: 
        {
            container: 'popover'
        },
        fields:
        {
            "name": 
            {
                validators: 
                {   
                    notEmpty: 
                    {
                        message: 'This field is required.'
                    }
                }
            },
            "seo_unique": 
            {
                validators: 
                {   
                    notEmpty: 
                    {
                        message: 'This field is required.'
                    },
                    remote:{
                        message: 'This unique phrase already exists.',
                        url: '/admin/CheckSeoUnique'+catseourl,
                        type: 'POST',
                        delay: 2000     // Send Ajax request every 2 seconds
                    }
                }
            },
            "parent_id": 
            {
                validators: 
                {   
                    notEmpty: 
                    {
                        message: 'This field is required.'
                    }
                }
            },
            "category_discount":{
                validators:{   
                    regexp: {
                        regexp: /^[1-9]\d*(\.\d+)?$/,
                        message: 'Category Discount can only accept decimal and numeric values'
                    }
                }
            },
            "description": 
            {
                validators: 
                {   
                    notEmpty: 
                    {
                        message: 'This field is required.'
                    }
                }
            },
        }
    });
    if($("#getSeoUrl").length > 0){
        var seourl = $("#getSeoUrl").html();
        var geturl = "?seo="+seourl;
    }else{
        var geturl ="";
    }
    //Product Validation Starts
    $('#addEditProduct').formValidation({
        framework: 'bootstrap',
        excluded: [':disabled'],
        message: 'This value is not valid',
        icon:{
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err:{
            container: 'popover'
        },
        fields:{
            "product_name":{
                validators:{   
                    notEmpty:{
                        message: 'This field is required.'
                    }
                }
            },
            "category_id":{
                validators: {   
                    notEmpty:{
                        message: 'This field is required.'
                    }
                }
            },
            /*"wheel_size":{
                validators: {   
                    notEmpty:{
                        message: 'This field is required.'
                    }
                }
            },*/
            /*"suspension":{
                validators: {   
                    notEmpty:{
                        message: 'This field is required.'
                    }
                }
            },*/
            /*"brake":{
                validators: {   
                    notEmpty:{
                        message: 'This field is required.'
                    }
                }
            },*/
            "color":{
                validators: {   
                    notEmpty:{
                        message: 'This field is required.'
                    }
                }
            },
            "sleeve":{
                validators: {   
                    notEmpty:{
                        message: 'This field is required.'
                    }
                }
            },
            /*"pattern":{
                validators: {   
                    notEmpty:{
                        message: 'This field is required.'
                    }
                }
            },*/
            "neck":{
                validators: {   
                    notEmpty:{
                        message: 'This field is required.'
                    }
                }
            },
         /*   "seo_url":{
                validators: {   
                    notEmpty:{
                        message: 'This field is required.'
                    },
                    remote: {
                        message: 'This SEO Unique Phrase already exists.',
                        url: '/admin/checkProductDetails'+geturl,
                        type: 'POST',
                        delay: 1000     // Send Ajax request every 2 seconds
                    }
                }
            }, */
            "product_code":{
                validators:{   
                    notEmpty:{
                        message: 'This field is required.'
                    },
                   /* remote: {
                        message: 'This product code already exists.',
                        url: '/admin/checkProductDetails',
                        type: 'POST',
                        delay: 1000     // Send Ajax request every 2 seconds
                    } */
                }
            },
           
            "product_sort":{
                validators:{   
                    notEmpty: {
                        message: 'This fields is required.'
                    },
                    regexp: {
                        regexp: /^\d+$/,
                        message: 'Sort only contains digits only'
                    }
                }
            },
            "product_price":{
                validators:{   
                    notEmpty: {
                        message: 'This fields is required.'
                    },
                    regexp: {
                        regexp: /^[1-9]\d*(\.\d+)?$/,
                        message: 'Price can only accept decimal and numeric values'
                    }
                }
            },
            "shipping_cost":{
                validators:{ 
                    regexp: {
                        regexp: /^[1-9]\d*(\.\d+)?$/,
                        message: 'Shipping Cost can only accept decimal and numeric values'
                    }
                }
            },
            "product_stock":{
                validators:{   
                    regexp: {
                        regexp: /^[1-9]\d*(\.\d+)?$/,
                        message: 'Product Stock can only accept decimal and numeric values'
                    }
                }
            },
            "product_discount":{
                validators:{   
                    regexp: {
                        regexp: /^[1-9]\d*(\.\d+)?$/,
                        message: 'Product Discount can only accept decimal and numeric values'
                    }
                }
            },
            "product_gst":{
                validators:{ 
                   			
                    regexp: {
                        regexp: /^[1-9]\d*(\.\d+)?$/,
                        message: 'Product GST can only accept decimal and numeric values'
                    }
                }
            },
            "stock": {
                validators:{   
                    notEmpty:{
                        message: 'This fields is required.'
                    },
                    regexp: {
                        regexp: /^\d+$/,
                        message: 'Stock can only accept numeric digits'
                    }
                }
            },
            "qty": {
                validators:{   
                    notEmpty:{
                        message: 'This fields is required.'
                    },
                    regexp: {
                        regexp: /^\d+$/,
                        message: 'Qty can only accept numeric digits'
                    }
                }
            },
            "qty_type": {
                validators:{   
                    notEmpty:{
                        message: 'This fields is required.'
                    }
                }
            },
        }
    })
    .on('err.field.fv', function(e, data) {
        data.fv.disableSubmitButtons(false);
    })
    .on('success.field.fv', function(e, data) {
        data.fv.disableSubmitButtons(false);
    })/*
    .find('[name="product_description"]')
    .each(function() {
        $(this).ckeditor().editor
    });*/

    //Product Image delete Code
    $(document).on('click','.pImage',function(){
        if(confirm('Are you sure?')){
            $(".loadingDiv").show();
            var ProductImageId = $(this).attr('id');
            $.ajax({
                type: "post",
                url: "/admin/delete-product-image",
                data : {id : ProductImageId},
                success:function(resp){
                    if(resp == "success"){
                        $(".loadingDiv").hide();
                        $("#delete-"+ProductImageId).remove();
                        alert('Image deleted successfully');
                        $(".SuccessFader").slideDown();
                        setTimeout(function(){
                          $(".SuccessFader").slideUp();      
                        }, 1500);
                    }
                },
                error:function(resp){
                }
            });
        }
        return false;
    });

    // Coupon Validation Starts
    $('#addCouponForm').formValidation({
        framework: 'bootstrap',
        excluded: [':disabled'],
        message: 'This value is not valid',
        icon: 
        {
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err: 
        {
            container: 'popover'
        },
        fields:
        {
            "code": 
            {
                validators: 
                {   
                    remote: 
                    {
                        message: 'This coupon code already exists.',
                        url: '/admin/checkCouponCode',
                        type: 'POST',
                        delay: 2000     // Send Ajax request every 2 seconds
                    }
                }
            },
            "expiry_date": 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'Expiry date is required.'
                    }, 
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The date is not a valid'
                    }
                }
            },
            "amount": 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'Coupon Discount is required.'
                    },
                    regexp: {
                        regexp: /^\d+$/,
                        message: 'Coupon Discount can only consist of digits'
                    }
                }
            },
        }
    });

    $("#Manual").click(function(){
        $("#textField").show();
    });

    $("#Automatic").click(function(){
        $("#textField").hide();
        $('#addCouponForm').formValidation('removeField','code');
    });

    /*SubAdmin Roles Scripts starts*/
    $(document).on('change','.getModuleid',function(){
        var roleType = $(this).attr('data-attr');
        var id = $(this).attr('rel');
        if(roleType === "View"){
            $('#edit-'+id).prop('checked',false);
            $('#delete-'+id).prop('checked',false);
        }else if(roleType==="Edit"){
            $('#view-'+id).prop('checked',true);
            $('#delete-'+id).prop('checked',false);
        }else if(roleType==="Delete"){
            $('#view-'+id).prop('checked',true);
            $('#edit-'+id).prop('checked',true);
        }
    });
    /*SubAdmin Roles Scripts ends*/
    
    //SubAdmin Validations
    $('#addEditSubadmin').formValidation({
        framework: 'bootstrap',
        excluded: [':disabled'],
        message: 'This value is not valid',
        icon:{
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err:{
            container: 'popover'
        },
        fields:{
            "name":{
                validators:{
                    notEmpty:{
                        message: 'This field is required'
                    },
                }
            },
            "username":{
                validators:{
                    notEmpty:{
                        message: 'This field is required'
                    },
                    remote:{
                        message: 'This username already exists.',
                        url: '/admin/checkAdminUsername',
                        type: 'POST',
                        delay: 2000     // Send Ajax request every 2 seconds
                    }
                }
            },
            "email":{
                validators:{
                    notEmpty:{
                        message: 'This field is required'
                    },
                    emailAddress:{
                        message: 'This Email is not a valid email address'
                    },
                }
            },
            "password":{
                validators:{
                    notEmpty:{
                        message: 'This field is required'
                    },
                    stringLength:{
                        min: 6,
                        max: 10,
                        message: 'The password must be more than 5 letters.'
                    },
                }
            },
        }
    })
    .on('err.field.fv', function(e, data) {
        data.fv.disableSubmitButtons(false);
    })
    .on('success.field.fv', function(e, data) {
        data.fv.disableSubmitButtons(false);
    });

    $('#addEditGift').formValidation({
        framework: 'bootstrap',
        excluded: [':disabled'],
        message: 'This value is not valid',
        icon: 
        {
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err: 
        {
            container: 'popover'
        },
        fields:
        {
            "gift_name": 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'Gift Name is required.'
                    }
                }
            },
            "mrp": 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'MRP is required.'
                    },
                    regexp: {
                        regexp: /^\d+$/,
                        message: 'Shopping Amount From can only consist of digits'
                    }
                }
            },
            "shopping_amount_from": 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'Shopping Amount From is required.'
                    },
                    regexp: {
                        regexp: /^\d+$/,
                        message: 'Shopping Amount From can only consist of digits'
                    }
                }
            },
            "shopping_amount_to": 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'Shopping Amount To is required.'
                    },
                    regexp: {
                        regexp: /^\d+$/,
                        message: 'Shopping Amount To can only consist of digits'
                    }
                }
            }
        }
    });
    
    
    $(document).on('click','.delete_order',function(){
		if(confirm('Are you sure you want to delete the order?')){
		   var id=$(this).attr('data-order-id');
		   var ajax_url = 'order-delete';
			$.ajax({
				url:ajax_url,
				type:'POST',
				data:{
					'id':id,
				},
				success:function(msg) {
					  $('.fa-refresh').click();
				}
			})
		}
			
    });

    

    $('.datePicker')
        .datepicker({
        format: 'yyyy-mm-dd'/*,
        startDate: new Date()*/
    }).on('changeDate', function(e) {
        $(this).datepicker('hide');
    });

});