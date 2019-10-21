$(document).ready(function(){

    site_root = $("#site_root").val();
    // $('#datatable_cartview').dataTable( {
    //     "aaSorting": []
    // } );
    if($("#datatable-buttons-adminorder").length > 0){
        $('#datatable-buttons-adminorder').dataTable( {
            "aaSorting": []
        } );
    }   
    if($("#adminorderdetails").length > 0){
        $('#adminorderdetails').dataTable( {
            "aaSorting": []
        } );
    }
    if($("#adminproductlisting").length > 0){
        $('#adminproductlisting').dataTable( {
            "aaSorting": []
        } );
    }
    if($("#frontproductlisting").length > 0){
        $('#frontproductlisting').dataTable( {
            "aaSorting": []
        } );
    }
    if($("#frontyourorderlisting").length > 0){
        $('#frontyourorderlisting').dataTable( {
            "aaSorting": []
        } );
    }
    if($("#frontorderdetailslisting").length > 0){
        $('#frontorderdetailslisting').dataTable( {
            "aaSorting": []
        } );
    }

    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#prod_image').attr('src', e.target.result);
            $('#prod_image').show();
            $('.remove_pict').show();
        }

        reader.readAsDataURL(input.files[0]);
        }
    }

    $("#product_image").change(function(){
        readURL(this);
    });
    $(document).on('click', ".remove_pict",function () {
        $('#prod_image').hide();
        $('#prod_image').attr('src', "");
        $('#product_image').val("");
        $('.remove_pict').hide();
    });
    var calculated_total_sum = 0;
    $("#datatable_cartview .pro_ttal").each(function () {
       var get_textbox_value = $(this).val();
       
       if ($.isNumeric(get_textbox_value)) {
          calculated_total_sum += parseFloat(get_textbox_value);
          }          

        });
    curmain = $('.main_total').html(calculated_total_sum);
    $(document).on('keyup mouseup', "#productdetailqty",function () {
        var proqty = $(this).attr('data-proqty');
        var curqty = $(this).val();
        if(curqty == 0)
        {
            $(this).val(1);
            var proprice = $('.sa-cart').attr('data-price');
            $('.sa-cart').attr('data-main-price',promainchangeprice);
            $('.sa-order').attr('data-main-price',promainchangeprice);
        }
        if(parseInt(proqty) > parseInt(curqty))
        {
            $('#email_success').html('Quantity Avaliable');
            $("#email_success").css('cssText', 'text-align:left !important; color:#3c763d !important');
            $('#email_error').hide();
            $('#email_success').show();
            interval = function () {
            $("#email_success").css('cssText', 'display:none !important;');
            }
            setInterval(interval, 4000);
            var proprice = $('.sa-cart').attr('data-price');
            var promainprice = $('.sa-cart').attr('data-main-price');
            var prodis = $('.sa-cart').attr('data-discount');
            var proqtyprice = proprice * curqty;
            // alert(proqtyprice);
            var disprice = proqtyprice * prodis / 100;
            var promainchangeprice = proqtyprice - disprice;
            $('.sa-cart').attr('data-main-price',promainchangeprice);
            $('.sa-order').attr('data-main-price',promainchangeprice);
            $('.sa-cart').attr('data-qty',curqty);
            $('.sa-order').attr('data-qty',curqty);
        }
        else
        {
            $('#email_error').html('Quantity Not Avaliable');
            $("#email_error").css('cssText', 'text-align:left !important; color:#a94442 !important');
            $('#email_success').hide();
            $('#email_error').show();
            interval = function () {
            $("#email_error").css('cssText', 'display:none !important;');
            }
            setInterval(interval, 4000);
        }
    });
    var prid = new Array;
   $('#createorder_table tbody').on( 'click', '.removeorder', function () {
        var proid = $(this).attr('data-id');
        var product_ttl = $("#total_"+proid).val();
        var main_total = $(".main_total").html();
        var alltotal = parseFloat(main_total) - parseFloat(product_ttl);
        $('.delete_'+proid).remove();
        $(".main_total").html(alltotal);
         var index = prid.indexOf(proid);

        if (index > -1) {
           prid.splice(index, 1);
        }
    } );
   
    $( "#search_items" ).keyup(function() {
        
      $( "#search_items" ).autocomplete({
        source: site_root+'customer/getitemsdata',
        select: function (event, ui) {
            var product_id = ui.item.id;
            if(product_id != undefined)
            {         
                if (jQuery.inArray(product_id, prid)=='-1') 
                {
                    var form_data = [{"name":"product_id","value":product_id}];
                    $.ajax({
                        url: site_root+'customer/GetProductData',
                        type: "POST",
                        data: form_data,
                        success: function(data) {
                             var json_obj = $.parseJSON(data);
                             var rand = Math.floor(Math.random()*90000) + 10000;
                             var discount_price = parseInt(json_obj.selling_price) * parseInt(json_obj.discount) / 100;
                             var total = json_obj.selling_price - discount_price;
                                var rowNode = 
                                '<tr class="delete_'+json_obj.id+'"><td><input type="hidden" id="productid" name="productid[]" value="'+json_obj.id+'">'+json_obj.product_name+'</td><td><div class="highslide-gallery"><a href="'+site_root+"assets/uploads/product/"+json_obj.media_value+'" class="highslide" onclick="return hs.expand(this)"><img src="'+site_root+"assets/uploads/product/thumb/"+json_obj.media_value+'" alt="Highslide JS" title="Click to enlarge" /></a></div></td><td>'+json_obj.description.substring(0, 100)+'</td><td><input type="hidden" id="sellingprice_'+json_obj.id+'" name="sellingprice[]" value="'+json_obj.selling_price+'"><data class="pricedata_'+json_obj.id+'" data-name="'+json_obj.selling_price+'">US<i class="fa fa-usd"></i> '+json_obj.selling_price+'</data></td><td><input type="number" min="1" id="qty" class="qty_'+json_obj.id+'" required="" data-id="'+json_obj.id+'" name="qty[]" value="1"></br><span class="email_error_'+json_obj.id+'" id="email_error_'+json_obj.id+'" style="display:none;"></span><span class="email_success_'+json_obj.id+'" id="email_success_'+json_obj.id+'" style="display:none;"></span></td><td><input type="hidden" id="discount" name="discount[]" value="'+json_obj.discount+'"><data class="discount_'+json_obj.id+'">'+json_obj.discount+'</data></td><td><input type="hidden" class="pro_ttal" data-main-total="'+total+'" id="total_'+json_obj.id+'" name="total[]" value="'+total+'"><data class="total_price_'+json_obj.id+'"><b>US<i class="fa fa-usd"></i>  '+total+'</b></data></td><td><div align="center" style="font-size:30px;"><a href="javascript:void(0);" data-original-title="Delete" class="delete removeorder" data-id="'+json_obj.id+'" data-toggle="tooltip"><i aria-hidden="true" class="fa fa-close"></i></a></div></td></tr>';
                            $(".ordercreate").prepend(rowNode); 
                            var product_ttl = $("#total_"+json_obj.id).val();
                            var main_total = $(".main_total").html();
                            var alltotal = parseFloat(product_ttl) + parseFloat(main_total);
                            $(".main_total").html(alltotal);
                            $('#search_items').val("");
                            $('#createorder_submit').attr("type", "submit");
                            return false;
                        }
                    });
                    prid.push(product_id);
                }
                else
                {
                    $('#search_items').val("");
                    alert("Product Already Selected");
                    return false;
                }
            }
            else
            {
                $('#search_items').val("");
                return false;
            }
            
        }
      });
    });
    $(document).on('keyup blur mouseup', "#qty",function () {
        var proid = $(this).attr('data-id');
        var qty = $(this).val();
        var form_data = [{"name":"product_id","value":proid},{"name":"qty","value":qty}];
            $.ajax({
                url: site_root+'customer/CheckData',
                type: "POST",
                data: form_data,
                success: function(data) {                   
                    if(data == 2)
                    {
                        $('#email_error_'+proid).html('Quantity Not Allow zero or spaces');
                        $("#email_error_"+proid).css('cssText', 'text-align:left !important; color:#a94442 !important');
                        $('#email_success_'+proid).hide();
                        $('#email_error_'+proid).show();
                        $('#qty').val("1");
                        var sellprice = $("#sellingprice_"+proid).val();
                        $('.pricedata_'+proid).html('US<i class="fa fa-usd"></i> '+sellprice);
                        var defaul_item_total = $(".pro_ttal").attr('data-main-total');
                        $('#total_'+proid).val(defaul_item_total);
                        $('.total_price_'+proid).html('<b>US<i class="fa fa-usd"></i> '+defaul_item_total+'</b>');
                        var calculated_total_sum = 0;
                        $("#createorder_table .pro_ttal").each(function () {
                           var get_textbox_value = $(this).val();
                           
                           if ($.isNumeric(get_textbox_value)) {
                              calculated_total_sum += parseFloat(get_textbox_value);
                              }          

                            });
                        curmain = $('.main_total').html(calculated_total_sum);
                        return true;
                    }
                    else if(data == 0)
                    {
                        
                        $('#email_error_'+proid).html('Quantity Not Avaliable');
                        $("#email_error_"+proid).css('cssText', 'text-align:left !important; color:#a94442 !important');
                        $('#email_success_'+proid).hide();
                        $('#email_error_'+proid).show();
                        $('#qty').val("1");
                        var sellprice = $("#sellingprice_"+proid).val();
                        $('.pricedata_'+proid).html('US<i class="fa fa-usd"></i> '+sellprice);
                        var defaul_item_total = $(".pro_ttal").attr('data-main-total');
                        $('#total_'+proid).val(defaul_item_total);
                        $('.total_price_'+proid).html('<b>US<i class="fa fa-usd"></i> '+defaul_item_total+'</b>');
                        var calculated_total_sum = 0;
                        $("#createorder_table .pro_ttal").each(function () {
                           var get_textbox_value = $(this).val();
                           
                           if ($.isNumeric(get_textbox_value)) {
                              calculated_total_sum += parseFloat(get_textbox_value);
                              }          

                            });
                        curmain = $('.main_total').html(calculated_total_sum);
                        return true;
                    }
                    else
                    {
                        $('#email_success_'+proid).html('Quantity Avaliable');
                        $("#email_success_"+proid).css('cssText', 'text-align:left !important; color:#3c763d !important');
                        $('#email_error_'+proid).hide();
                        $('#email_success_'+proid).show();
                        var curqty = $('.qty_'+proid).val();
                        var pricedataname = $('.pricedata_'+proid).attr('data-name');
                        var curprice = $('.pricedata_'+proid).html();
                        var curdis = $('.discount_'+proid).html();
                        var qtyprice = pricedataname * curqty;
                        $('#sellingprice'+proid).val(qtyprice);
                        $('.pricedata_'+proid).html('US<i class="fa fa-usd"></i> '+qtyprice);
                        var disprice = qtyprice * curdis / 100;
                        var final_price = qtyprice - disprice;
                        $('#total_'+proid).val(final_price);
                        $('.total_price_'+proid).html('<b>US<i class="fa fa-usd"></i> '+final_price+'</b>');
                        var calculated_total_sum = 0;
                        $("#createorder_table .pro_ttal").each(function () {
                           var get_textbox_value = $(this).val();
                           
                           if ($.isNumeric(get_textbox_value)) {
                              calculated_total_sum += parseFloat(get_textbox_value);
                              }          

                            });
                        curmain = $('.main_total').html(calculated_total_sum);
                    }
                }
            });
    });

    $(document).on('keyup blur mouseup', "#cart_qty",function () {
        var proid = $(this).attr('data-id');
        var qty = $(this).val();
        var form_data = [{"name":"product_id","value":proid},{"name":"qty","value":qty}];
            $.ajax({
                url: site_root+'customer/CheckData',
                type: "POST",
                data: form_data,
                success: function(data) {                
                    if(data == 2)
                    {
                        $('#email_error_'+proid).html('Quantity Not Allow zero or spaces');
                        $("#email_error_"+proid).css('cssText', 'text-align:left !important; color:#a94442 !important');
                        $('#email_success_'+proid).hide();
                        $('#email_error_'+proid).show();
                        interval = function () {
                        $('#email_error_'+proid).css('cssText', 'display:none !important;');
                        }
                        setInterval(interval, 4000);
                        $('#qty').val("1");
                        var sellprice = $("#sellingprice_"+proid).val();
                        $('.pricedata_'+proid).html('US<i class="fa fa-usd"></i> '+sellprice);
                        var defaul_item_total = $(".pro_ttal").attr('data-main-total');
                        $('#total_'+proid).val(defaul_item_total);
                        $('.total_price_'+proid).html('<b>US<i class="fa fa-usd"></i> '+defaul_item_total+'</b>');
                        var calculated_total_sum = 0;
                        $("#datatable_cartview .pro_ttal").each(function () {
                           var get_textbox_value = $(this).val();
                           if ($.isNumeric(get_textbox_value)) {
                              calculated_total_sum += parseFloat(get_textbox_value);
                              }          

                            });
                        curmain = $('.main_total').html(calculated_total_sum);
                        return true;
                    }
                    else if(data == 0)
                    {
                        
                        $('#email_error_'+proid).html('Quantity Not Avaliable');
                        $("#email_error_"+proid).css('cssText', 'text-align:left !important; color:#a94442 !important');
                        $('#email_success_'+proid).hide();
                        $('#email_error_'+proid).show();
                        interval = function () {
                        $('#email_error_'+proid).css('cssText', 'display:none !important;');
                        }
                        setInterval(interval, 4000);
                        $('#qty').val("1");
                        var sellprice = $("#sellingprice_"+proid).val();
                        $('.pricedata_'+proid).html('US<i class="fa fa-usd"></i> '+sellprice);
                        var defaul_item_total = $(".pro_ttal").attr('data-main-total');
                        $('#total_'+proid).val(defaul_item_total);
                        $('.total_price_'+proid).html('<b>US<i class="fa fa-usd"></i> '+defaul_item_total+'</b>');
                        var calculated_total_sum = 0;
                        $("#datatable_cartview .pro_ttal").each(function () {
                           var get_textbox_value = $(this).val();
                           if ($.isNumeric(get_textbox_value)) {
                              calculated_total_sum += parseFloat(get_textbox_value);
                              }          

                            });
                        curmain = $('.main_total').html(calculated_total_sum);;
                        return true;
                    }
                    else
                    {
                        $('#email_success_'+proid).html('Quantity Avaliable');
                        $("#email_success_"+proid).css('cssText', 'text-align:left !important; color:#3c763d !important');
                        $('#email_error_'+proid).hide();
                        $('#email_success_'+proid).show();
                        interval = function () {
                        $('#email_success_'+proid).css('cssText', 'display:none !important;');
                        }
                        setInterval(interval, 4000);
                        var curqty = $('.qty_'+proid).val();
                        var pricedataname = $('.pricedata_'+proid).attr('data-name');
                        var curprice = $('.pricedata_'+proid).html();
                        var curdis = $('.discount_'+proid).html();
                        var qtyprice = pricedataname * curqty;
                        $('#sellingprice'+proid).val(qtyprice);
                        // $('.pricedata_'+proid).html('US<i class="fa fa-usd"></i> '+qtyprice);
                        var disprice = qtyprice * curdis / 100;
                        var final_price = qtyprice - disprice;
                        $('#total_'+proid).val(final_price);
                        $('.total_price_'+proid).html('<b>US<i class="fa fa-usd"></i> '+final_price+'</b>');

                        var calculated_total_sum = 0;
                        $("#datatable_cartview .pro_ttal").each(function () {
                           var get_textbox_value = $(this).val();
                           if ($.isNumeric(get_textbox_value)) {
                              calculated_total_sum += parseFloat(get_textbox_value);
                              }          

                            });
                        // alert(calculated_total_sum);
                        curmain = $('.main_total').html(calculated_total_sum);;
                        return true;
                    }
                }
            });
    });
    $('#frmadmin_addproduct').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa',
            invalid: 'err',
            validating: 'fa'
        },
        fields: {
            sku: {
                validators: {
                    notEmpty: {
                        message: 'Please enter SKU'
                    }
                }
            },
            product_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Product Name'
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Description'
                    }
                }
            },
            serial_number: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Serial Number'
                    }
                }
            },
            retail_price: {
                validators: {
                    notEmpty: {
                        message: 'Please select Retail Price'
                    }
                }
            },
            selling_price: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Selling Price'
                    }
                }
            },
            qty: {
                validators: {
                    integer: {
                        message: 'Allow only digits'
                    },
                    notEmpty: {
                        message: 'Please enter Quntity'
                    }
                }
            },
        },
        submitHandler:function(validator, form, submitButton){

        }
    });

    $('.sa-order').click(function(){

            var ordid = $(this).attr("data-id");
            var proid = $(this).attr("data-name"); 
            var proprice = $(this).attr("data-price"); 
            swal({   
                title: "Are you sure you want to buy this Product?",   
                text: "You will be able to cancel this order!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, Buy!",   
                closeOnConfirm: false 
            }, function(){
                var form_data = [{"name":"id","value":proid},{"name":"price","value":proprice}];
                $.ajax({
                    url: site_root+"customer/makeorder",
                    type: "POST",
                    data: form_data,
                    success: function (msg) {
                        swal("Success!", "Your Product is successfully orderd.", "success");
                        //window.location.href="services";
                    }
                });
        });
    });

    $('.sa-cart').click(function(){
            var ordid = $(this).attr("data-id");
            var proid = $(this).attr("data-name");
            // var proqty = $("#productdetailqty").val();
            var proprice = $(this).attr("data-price"); 
            var proqty = $(this).attr("data-qty"); 
            var promainprice = $(this).attr("data-main-price"); 
            // alert(promainprice); return false;
            var prodis = $(this).attr("data-discount"); 
            swal({   
                title: "Are you sure you want to add to cart this Product?",   
                text: "You will be able to remove this order from cart items!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes",   
                closeOnConfirm: false 
            }, function(){
                var form_data = [{"name":"id","value":proid},{"name":"price","value":proprice},{"name":"promainprice","value":promainprice},{"name":"prodis","value":prodis},{"name":"proqty","value":proqty}];
                $.ajax({
                    url: site_root+"customer/addtocart",
                    type: "POST",
                    data: form_data,
                    success: function (msg) {
                        swal("Success!", "Your Product is successfully added in cart items.", "success");
                        //window.location.href="services";
                    }
                });
        });
    });

    $('.sa-warning').click(function(){

            var delid = $(this).attr("data-id");
            var proid = $(this).attr("data-name"); 
            swal({   
                title: "Are you sure you want to delete this Product?",   
                text: "You will not be able to recover this Product!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, Delete!",   
                closeOnConfirm: false 
            }, function(){
                var form_data = [{"name":"id","value":proid}];
                $.ajax({
                    url: site_root+"product/deleteproduct",
                    type: "POST",
                    data: form_data,
                    success: function (msg) {
                        $("#dytr_"+delid).toggle();
                        swal("Deleted!", "Product has been deleted.", "success");
                        //window.location.href="services";
                    }
                });
        });
    });
    $('.sa-cancel_order').click(function(){

            var delid = $(this).attr("data-id");
            var ordid = $(this).attr("data-name"); 
            var qty = $(this).attr("data-qty"); 
            var productid = $(this).attr("data-productid");
            var productqty = $(this).attr("data-productqty"); 
            swal({   
                title: "Are you sure you want to cancel this order?",   
                text: "You will not be able to order this Product!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, Cancel!",   
                closeOnConfirm: false 
            }, function(){
                var form_data = [{"name":"id","value":ordid},{"name":"productid","value":productid},{"name":"qty","value":qty},{"name":"productqty","value":productqty}];
                $.ajax({
                    url: site_root+"customer/cancelorder",
                    type: "POST",
                    data: form_data,
                    success: function (msg) {
                        $("#dytr_"+delid).toggle();
                        swal("Cancelled!", "Your order has been cancelled.", "success");
                        //window.location.href="services";
                    }
                });
        });
    });
    

    $('.sa-remove_cart').click(function(){

            var delid = $(this).attr("data-id");
            var cartid = $(this).attr("data-name");
            var cartproductqty = $(this).attr("data-qty"); 
            var product_id = $(this).attr("data-proid"); 
            var productqty = $(this).attr("data-productqty");            
            swal({   
                title: "Are you sure you want to remove this product from cart?",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes!",   
                closeOnConfirm: false 
            }, function(){
                var form_data = [{"name":"id","value":cartid},{"name":"cartqty","value":cartproductqty},{"name":"product_id","value":product_id},{"name":"productqty","value":productqty}];
                $.ajax({
                    url: site_root+"customer/removefromcart",
                    type: "POST",
                    data: form_data,
                    success: function (msg) {
                        $("#dytr_"+delid).toggle();
                        swal("Removed!", "Your Product has been remove from cart", "success");
                        //window.location.href="services";
                    }
                });
        });
    });

    $(document).on('keyup mouseup', ".qty_details",function () {
        
        var ord_id = $(this).attr('data-id');
        var qty_details = $(this).val();
        var mainsellingprice = $("#mainsellprice_"+ord_id).val();
        var dis = $("#discountdetails_"+ord_id).val();
        var prc = $("#sellingprice_"+ord_id).val();
        var ttlprc = $("#ttlprice_details_"+ord_id).val();
        var qtyprc = prc * qty_details;
        var disprc = qtyprc * dis / 100;
        var fnlprc = qtyprc - disprc;
        $('#ordsend_'+ord_id).attr('data-orderdiscount_'+ord_id,dis);
        $('#ordsend_'+ord_id).attr('data-orderttlprice_'+ord_id,fnlprc);
        $('#ordsend_'+ord_id).attr('data-orderprice_'+ord_id,prc);
        $('#ordsend_'+ord_id).attr('data-orderqty_'+ord_id,qty_details);
        
        $("#ttlprice_details_"+ord_id).html(fnlprc);
        $("#ttlhdnprc_"+ord_id).val(fnlprc);
    });

    $(document).on('keyup', ".sellingprice",function () {
        
        var ord_id = $(this).attr('data-id');
        // alert(ord_id); return false;
        var qty_details = $('#qty_details_'+ord_id).val();
        var mainsellingprice = $("#mainsellprice_"+ord_id).val();
        var dis = $("#discountdetails_"+ord_id).val();
        var prc = $(this).val();
        var ttlprc = $("#ttlprice_details_"+ord_id).val();
        var qtyprc = prc * qty_details;
        var disprc = qtyprc * dis / 100;
        var fnlprc = qtyprc - disprc;
        $('#ordsend_'+ord_id).attr('data-orderdiscount_'+ord_id,dis);
        $('#ordsend_'+ord_id).attr('data-orderttlprice_'+ord_id,fnlprc);
        $('#ordsend_'+ord_id).attr('data-orderprice_'+ord_id,prc);
        $('#ordsend_'+ord_id).attr('data-orderqty_'+ord_id,qty_details);
        
        $("#ttlprice_details_"+ord_id).html(fnlprc);
        $("#ttlhdnprc_"+ord_id).val(fnlprc);
    });

    $(document).on('keyup', ".discountdetails",function () {
        
        var ord_id = $(this).attr('data-id');
        // alert(ord_id); return false;
        var qty_details = $('#qty_details_'+ord_id).val();
        var mainsellingprice = $("#mainsellprice_"+ord_id).val();
        var dis = $(this).val();
        var prc = $("#sellingprice_"+ord_id).val();
        var ttlprc = $("#ttlprice_details_"+ord_id).val();
        var qtyprc = prc * qty_details;
        var disprc = qtyprc * dis / 100;
        var fnlprc = qtyprc - disprc;
        $('#ordsend_'+ord_id).attr('data-orderdiscount_'+ord_id,dis);
        $('#ordsend_'+ord_id).attr('data-orderttlprice_'+ord_id,fnlprc);
        $('#ordsend_'+ord_id).attr('data-orderprice_'+ord_id,prc);
        $('#ordsend_'+ord_id).attr('data-orderqty_'+ord_id,qty_details);
        
        $("#ttlprice_details_"+ord_id).html(fnlprc);
        $("#ttlhdnprc_"+ord_id).val(fnlprc);
    });

    $("#orderdd_main").change(function(){
        var ord_id = $(this).attr('data-id');
        var status = $(this).val();
        swal({   
                title: "Are you sure you want to order change staus?",
                text: "You will be able to change order agin for this Product!",
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, Confirm!",   
                closeOnConfirm: false 
            }, function(){
                var form_data = [{"name":"order_id","value":ord_id},{"name":"status","value":status}];
                $.ajax({
                    url: site_root+"customer/changeorderstatus",
                    type: "POST",
                    data: form_data,
                    success: function (msg) {
                        // alert(msg);return false;
                        swal("Sended!", "Your status has been Changed.", "success");
                    }
                });
        });
    });
    $("#frm_adminorderdetails").submit(function(e)
    {
        
                var postData = $(this).serializeArray();
                var formURL = $(this).attr("action");
                $.ajax(
                {
                    url : formURL,
                    type: "POST",
                    data : postData,
                    success:function(data) 
                    {
                        // alert(data); return false;
                        swal("Send!", "Your orders has been send for approval to customer.", "success");
                        //data: return data from server
                    }
                });
                e.preventDefault(); //STOP default action
    });

    $(".cart_send_betterprice").click(function() {
        $(".from").val(3);
    });
    $(".cartitem_submit").click(function() {
        $(".from").val(2);
    });
    $("#frm_cart_placeorder").submit(function(e)
    {
                var postData = $(this).serializeArray();
                var formURL = $(this).attr("action");
                $.ajax(
                {
                    url : formURL,
                    type: "POST",
                    data : postData,
                    success:function(data) 
                    {
                        $(".cart_cust_body").html("");
                        $("#text_quotation").val("");
                        swal("Success!", "Your cart has been placed", "success");
                        //data: return data from server
                    }
                });
                e.preventDefault(); //STOP default action
    });
hs.graphicsDir = site_root+'assets/js/plugin/highslide/graphics/';
        hs.align = 'center';
        hs.transitions = ['expand', 'crossfade'];
        hs.outlineType = 'rounded-white';
        hs.wrapperClassName = 'controls-in-heading';
        hs.fadeInOut = true;
        //hs.dimmingOpacity = 0.75;

        // Add the controlbar
        if (hs.addSlideshow) hs.addSlideshow({
            //slideshowGroup: 'group1',
            interval: 5000,
            repeat: false,
            useControls: true,
            fixedControls: false,
            overlayOptions: {
                opacity: 1,
                position: 'top right',
                hideOnMouseOut: false
            }
        });

});