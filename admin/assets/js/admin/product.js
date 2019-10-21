$(document).ready(function () {
    site_root = $("#site_root").val();

    $(document).on('click', "#quickorder_product_btn", function () {
//        alert(brand); return false();
        var chkArray = [];
        var proprice = [];
        var brand = [];
        var custid = $("#custid_quick").val();
//        console.log(brand); return false;
        $(".chk:checked").each(function () {
            var brd = $('#brand' + $(this).attr('data-productid')).val();
            chkArray.push($(this).attr('data-productid'));
            proprice.push($(this).attr('data-productprice'));
            brand.push(brd);
        });
        var form_data = [{"name": "custid", "value": custid}, {"name": "productid", "value": chkArray},
            {"name": "productprice", "value": proprice}, {"name": "brand", "value": brand}];
        $.ajax({
            url: site_root + "user/AddQuickOrder",
            type: "POST",
            data: form_data,
            success: function (msg) {
                // alert(msg); return false;
                // $(".admin_msg_reply_area").val("");
                swal("Saved!", "Quick order placed.", "success");
                //window.location.href="services";
            }
        });
    });
    $('#frmadmin_importproduct').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa',
            invalid: 'err',
            validating: 'fa'
        },
        fields: {
            product_file: {
                validators: {
                    notEmpty: {
                        message: 'Please select file'
                    },
                    file: {
                        extension: 'csv',
                        //type: 'application/excel',
                        message: 'Please choose a CSV file'
                    }
                }
            },
        },
        submitHandler: function (validator, form, submitButton) {

        }
    });
    $(document).on('keyup mouseup', "#proprice", function () {
        dataid = $(this).attr('dataid');
        price = $(this).val();
        $("#chk_" + dataid).attr('data-productprice', price);
    });

    $(document).on('change', "#brand", function () {
        // alert("hi");
        dataid = $(this).attr('dataid');
        brand = $('#brand :selected').val();
        // alert(dataid);
        // alert(brand);
        var brand = $("#chk_" + dataid).attr('data-brand', brand);
        console.log(brand);
    });

    $(document).on('keyup', "#search_cust", function () {
        var custdata = $('#search_cust').val();
        $("#search_cust").autocomplete({
            source: site_root + 'user/GetCustData?customer=' + custdata,
            select: function (event, ui) {
                var table = $('#adminproductlisting').DataTable();
                var customerid = ui.item.id;
                $("#custid_quick").val(customerid);
                table.clear();
                table.draw();
                /* $.ajax({
                 url: site_root + "ajax/getCustomers",
                 type: "POST",
                 //                    data: form_data,
                 success: function (data) {
                 console.log(data);
                 table.rows.add(data);
                 // alert(msg); return false;
                 // $(".admin_msg_reply_area").val("");
                 //                        swal("Saved!", "Quick order saved.", "success");
                 //window.location.href="services";
                 }
                 });*/
                return true;
            }
        });
//        location.reload();
    });
    $(document).on('click', "#searchCustData", function () {
        var cust_id = $("#custid_quick").val();
        $("#quickorder_product").submit();


    });
    // $('#example').DataTable( {
    //     "processing": true,
    //     "serverSide": true,
    //     "ajax": "../server_side/scripts/server_processing.php"
    // } );
    // $('#datatable_cartview').dataTable( {
    //     "aaSorting": []
    // } );
    if ($("#datatable-buttons-adminorder").length > 0) {
        $('#datatable-buttons-adminorder').dataTable({
            "aaSorting": []
        });
    }
    if ($("#adminorderdetails").length > 0) {
        $('#adminorderdetails').dataTable({
            "aaSorting": [],
            "paging": false,
            "ordering": false,
            "info": false,
            searching: false
        });
    }
    if ($("#adminproductlisting").length > 0) {
        $('#adminproductlisting').dataTable({
            "aaSorting": []
        });
    }
    if ($("#adminproductlisting_ajax").length > 0) {
        $('#adminproductlisting_ajax').dataTable({
            "aaSorting": []
        });
    }

    if ($("#frontproductlisting").length > 0) {
        $('#frontproductlisting').dataTable({
            "aaSorting": []
        });
    }
    if ($("#frontyourorderlisting").length > 0) {
        $('#frontyourorderlisting').dataTable({
            "aaSorting": []
        });
    }
    if ($("#frontorderdetailslisting").length > 0) {
        $('#frontorderdetailslisting').dataTable({
            "aaSorting": []
        });
    }
    if ($("#adminvehiclelisting").length > 0) {
        $('#adminvehiclelisting').dataTable({
            "aaSorting": []
        });
    }
    var rowCount = $('.cart_cust_body tr').length;
    $(document).on('click', ".cart_send_betterprice", function () {
        if (rowCount > 0)
        {
            // if ($("#text_quotation").val() != "")
            // {
                $(".from").val(3);
                $("#cart_send_betterprice").attr("type", "submit");
            // }
            // else
            // {
            //     swal("Please enter comment in comment box");
            // }
        }
    });
    $(document).on('click', ".cartitem_submit", function () {
        if (rowCount > 1)
        {
            $(".from").val(2);
            $("#cartitem_submit").attr("type", "submit");
        }
    });

    $(document).on('click', ".admin_comment_send", function () {
        if ($(".admin_msg_reply_area").val() != "")
        {
            // $(".admin_comment_send").attr("type","submit");
            var order_id = $(this).attr("data-orderid");
            var comment_text = $(".admin_msg_reply_area").val();
            var cust_id = $("#custid").val();
            var form_data = [{"name": "orderid", "value": order_id}, {"name": "comment_text", "value": comment_text},{"name": "cust_id", "value": cust_id}];
            $.ajax({
                url: site_root + "customer/addcommentfromuser",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    // alert(msg); return false;
                    $(".admin_msg_reply_area").val("");
                    var user_name = $("#user_details").attr('data-username');
                    var user_profile = $("#user_details").attr('data-profile');
                    var comment = '<li class="media"> <div class="media-body"> <div class="media"> <a class="pull-left" href="#"> <img class="media-object img-circle" style="height: 64px;width: 64px;" src="'+user_profile+'"> </a> <div class="media-body"> <small class="text-muted">'+user_name+'</small> <br> '+comment_text+' <hr> </div> </div> </div> </li>';
                    $(".media-list").append(comment);
                    // swal("Send!", "Your orders has been send for approval to customer.", "success");
                    //window.location.href="services";
                }
            });
            $(".admin_msg_reply_area").val("");
        }
        else
        {
            swal("Please enter comment in comment box");
        }
    });

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

    $(document).on('change', "#product_image", function () {
        readURL(this);
        $('#prdt_img').val("");
    });
    $(document).on('click', ".remove_pict", function () {
        $('#prod_image').hide();
        $('#prod_image').attr('src', "");
        $('#product_image').val("");
        $('#prdt_img').val("");
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
//    $(document).on('keyup mouseup', "#productdetailqty", function () {
//        var proqty = $(this).attr('data-proqty');
//        var curqty = $(this).val();
//        if (curqty == 0)
//        {
//            $(this).val(1);
//            var proprice = $('.sa-cart').attr('data-price');
//            $('.sa-cart').attr('data-main-price', promainchangeprice);
//            $('.sa-order').attr('data-main-price', promainchangeprice);
//        }
//        if (parseInt(proqty) > parseInt(curqty))
//        {
//            $('#email_success').html('Quantity Avaliable');
//            $("#email_success").css('cssText', 'text-align:left !important; color:#3c763d !important');
//            $('#email_error').hide();
//            $('#email_success').show();
//            interval = function () {
//                $("#email_success").css('cssText', 'display:none !important;');
//            }
//            setInterval(interval, 4000);
//            var proprice = $('.sa-cart').attr('data-price');
//            var promainprice = $('.sa-cart').attr('data-main-price');
//            var prodis = $('.sa-cart').attr('data-discount');
//            var proqtyprice = proprice * curqty;
//            // alert(proqtyprice);
//            var disprice = proqtyprice * prodis / 100;
//            var promainchangeprice = proqtyprice - disprice;
//            $('.sa-cart').attr('data-main-price', promainchangeprice);
//            $('.sa-order').attr('data-main-price', promainchangeprice);
//            $('.sa-cart').attr('data-qty', curqty);
//            $('.sa-order').attr('data-qty', curqty);
//        }
//        else
//        {
//            $('#email_error').html('Quantity Not Avaliable');
//            $("#email_error").css('cssText', 'text-align:left !important; color:#a94442 !important');
//            $('#email_success').hide();
//            $('#email_error').show();
//            interval = function () {
//                $("#email_error").css('cssText', 'display:none !important;');
//            }
//            setInterval(interval, 4000);
//        }
//    });
    var json;
    var productidarray = $("#productidarray").val();
    if (productidarray != undefined)
    {
        json = $.parseJSON(productidarray);
    }
    var oldarray = new Array;
    var prid = new Array;
    if (json == null)
    {

    }
    else
    {
        var prid = $.merge(json, oldarray);
    }
    $('#createorder_table tbody').on('click', '.removeorder', function () {
        var proid = $(this).attr('data-id');
        var product_ttl = $("#total_" + proid).val();
        var main_total = $(".main_total").html();
        var alltotal = parseFloat(main_total) - parseFloat(product_ttl);
        $('.delete_' + proid).remove();
        $(".main_total").html(alltotal);
        var index = prid.indexOf(proid);

        if (index > -1) {
            prid.splice(index, 1);
        }
    });
    $('#createorder_table tbody').on('click', '.removequickorder', function () {
        var proid = $(this).attr('data-id');
        var cust_id = $(this).attr('data-custid');
        swal({
            title: "Are you sure you want to remove this Product?",
            text: "You will be able to reorder for this product!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Remove!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": proid}, {"name": "custid", "value": cust_id}];
            $.ajax({
                url: site_root + "user/checkquickorder",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    // alert(msg); return false;
                    if (msg == 1)
                    {
                        var product_ttl = $("#total_" + proid).val();
                        var main_total = $(".main_total").html();
                        var alltotal = parseFloat(main_total) - parseFloat(product_ttl);
                        $('.delete_' + proid).remove();
                        $(".main_total").html(alltotal);
                        var index = prid.indexOf(proid);

                        if (index > -1) {
                            prid.splice(index, 1);
                        }
                        // swal("Removed!", "Product has been remove.", "success");
                    }
                    else if (msg == 2)
                    {
                        var product_ttl = $("#total_" + proid).val();
                        var main_total = $(".main_total").html();
                        var alltotal = parseFloat(main_total) - parseFloat(product_ttl);
                        $('.delete_' + proid).remove();
                        $(".main_total").html(alltotal);
                        var index = prid.indexOf(proid);

                        if (index > -1) {
                            prid.splice(index, 1);
                        }
                        // swal("Removed!", "Product has been remove.", "success");
                    }
                    else if (msg == 0)
                    {
                        return false;
                    }
                }
            });
        });

        // var ordid = $(this).attr("data-id");
        // var proid = $(this).attr("data-name");
        // var proprice = $(this).attr("data-price");
    });

    $(document).on('keyup', "#search_items", function () {
        $("#search_items").autocomplete({
            source: site_root + 'customer/getitemsdata',
            select: function (event, ui) {
                var product_id = ui.item.id;
                if (product_id != undefined)
                {
                    console.log(prid);
                    if (jQuery.inArray(product_id, prid) == '-1')
                    {
                        if ($("#getorderval").val() == 'removequickorder')
                        {
                            var classval = 'removequickorder';
                        }
                        else if ($("#getorderval").val() == 'removeorder')
                        {
                            var classval = 'removeorder';
                        }
                        var form_data = [{"name": "product_id", "value": product_id}];
                        $.ajax({
                            url: site_root + 'customer/GetProductData',
                            type: "POST",
                            data: form_data,
                            success: function (data) {
                                var json_obj = $.parseJSON(data);
                                var rand = Math.floor(Math.random() * 90000) + 10000;
                                var discount_price = parseInt(json_obj.selling_price) * parseInt(json_obj.discount) / 100;
                                var total = json_obj.selling_price - discount_price;
                                var rowNode =
//                                        '<tr class="delete_' + json_obj.id + '"><td><input type="hidden" id="productid" name="productid[]" value="' + json_obj.id + '">' + json_obj.product_name + '</td><td><div class="highslide-gallery"><a href="' + site_root + "assets/uploads/product/" + json_obj.media_value + '" class="highslide" onclick="return hs.expand(this)"><img src="' + site_root + "assets/uploads/product/thumb/" + json_obj.media_value + '" alt="Highslide JS" title="Click to enlarge" /></a></div></td><td>' + json_obj.description.substring(0, 100) + '</td><td><input type="hidden" id="sellingprice_' + json_obj.id + '" name="sellingprice[]" value="' + json_obj.selling_price + '"><data class="pricedata_' + json_obj.id + '" data-name="' + json_obj.selling_price + '">AED ' + json_obj.selling_price + '</data></td><td><input type="number" min="1" id="qty" class="qty_' + json_obj.id + '" required="" data-id="' + json_obj.id + '" name="qty[]" value="1"></br><span class="email_error_' + json_obj.id + '" id="email_error_' + json_obj.id + '" style="display:none;"></span><span class="email_success_' + json_obj.id + '" id="email_success_' + json_obj.id + '" style="display:none;"></span></td><td><input type="hidden" id="discount" name="discount[]" value="' + json_obj.discount + '"><data class="discount_' + json_obj.id + '">' + json_obj.discount + '</data></td><td><input type="hidden" class="pro_ttal" data-main-total="' + total + '" id="total_' + json_obj.id + '" name="total[]" value="' + total + '"><data class="total_price_' + json_obj.id + '"><b>AED  ' + total + '</b></data></td><td><div align="center" style="font-size:30px;"><a href="javascript:void(0);" data-original-title="Delete" class="delete ' + classval + '" data-id="' + json_obj.id + '" data-toggle="tooltip"><i aria-hidden="true" class="fa fa-close"></i></a></div></td></tr>';
                                        '<tr class="delete_' + json_obj.id + '">\n\
                                        <td><input type="hidden" id="productid" name="productid[]" value="' + json_obj.id + '">' + json_obj.product_name + '</td>\n\
                                        <td><div class="highslide-gallery"><a href="' + site_root + "assets/uploads/product/" + json_obj.media_value + '" class="highslide" onclick="return hs.expand(this)"><img src="' + site_root + "assets/uploads/product/thumb/" + json_obj.media_value + '" alt="Highslide JS" title="Click to enlarge" /></a></div></td>\n\
                                        <td>' + json_obj.description.substring(0, 100) + '</td>\n\
                                        <td><input type="number" min="1" id="qty" class="qty_' + json_obj.id + '" required="" data-id="' + json_obj.id + '" name="qty[]" value="1"></br><span class="email_error_' + json_obj.id + '" id="email_error_' + json_obj.id + '" style="display:none;"></span><span class="email_success_' + json_obj.id + '" id="email_success_' + json_obj.id + '" style="display:none;"></span></td></b></data></td>\n\
                                        <td><div align="center" style="font-size:30px;"><a href="javascript:void(0);" data-original-title="Delete" class="delete ' + classval + '" data-id="' + json_obj.id + '" data-toggle="tooltip"><i aria-hidden="true" class="fa fa-close"></i></a></div></td>\n\
                                    </tr>';

                                $(".ordercreate").prepend(rowNode);
                                var product_ttl = $("#total_" + json_obj.id).val();
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
    $("#search_customer").keyup(function () {

        var customer = $('#search_customer').val();
        $("#search_customer").autocomplete({
            source: site_root + 'sales/GetCustomerData',
            select: function (event, ui) {
                var table = $('#adminproductlisting').DataTable();
                var customerid = ui.item.id;
                if (customerid != "")
                {
                    $("#custid_quotation").val(customerid);
                    // $('.send_for_quotation').data('target','.bs-example-modal-lg');
                    // $(".send_for_quotation").removeAttr( "data-target" );
                    $(".send_for_quotation").attr('data-target', '.bs-example-modal-lg');
                }
                else
                {
                    $("#custid_quotation").val("");
                }
                return true;
            }
        });
    });
    $(document).on('keyup blur mouseup', "#qty", function () {
        var proid = $(this).attr('data-id');
        var qty = $(this).val();
        var form_data = [{"name": "product_id", "value": proid}, {"name": "qty", "value": qty}];
        $.ajax({
            url: site_root + 'customer/CheckData',
            type: "POST",
            data: form_data,
            success: function (data) {
                if (data == 2)
                {
                    $('#email_error_' + proid).html('Quantity Not Allow zero or spaces');
                    $("#email_error_" + proid).css('cssText', 'text-align:left !important; color:#a94442 !important');
                    $('#email_success_' + proid).hide();
                    $('#email_error_' + proid).show();
                    $('#qty').val("1");
                    var sellprice = $("#sellingprice_" + proid).val();
                    $('.pricedata_' + proid).html('AED ' + sellprice);
                    var defaul_item_total = $(".pro_ttal").attr('data-main-total');
                    $('#total_' + proid).val(defaul_item_total);
                    $('.total_price_' + proid).html('<b>AED ' + defaul_item_total + '</b>');
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
                else if (data == 0)
                {

                    $('#email_error_' + proid).html('Quantity Not Avaliable');
                    $("#email_error_" + proid).css('cssText', 'text-align:left !important; color:#a94442 !important');
                    $('#email_success_' + proid).hide();
                    $('#email_error_' + proid).show();
                    $('#qty').val("1");
                    var sellprice = $("#sellingprice_" + proid).val();
                    $('.pricedata_' + proid).html('AED ' + sellprice);
                    var defaul_item_total = $(".pro_ttal").attr('data-main-total');
                    $('#total_' + proid).val(defaul_item_total);
                    $('.total_price_' + proid).html('<b>AED ' + defaul_item_total + '</b>');
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
                    $('#email_success_' + proid).html('Quantity Avaliable');
                    $("#email_success_" + proid).css('cssText', 'text-align:left !important; color:#3c763d !important');
                    $('#email_error_' + proid).hide();
                    $('#email_success_' + proid).show();
                    var curqty = $('.qty_' + proid).val();
                    var pricedataname = $('.pricedata_' + proid).attr('data-name');
                    var curprice = $('.pricedata_' + proid).html();
                    var curdis = $('.discount_' + proid).html();
                    var qtyprice = pricedataname * curqty;
                    $('#sellingprice' + proid).val(qtyprice);
                    $('.pricedata_' + proid).html('AED ' + qtyprice);
                    var disprice = qtyprice * curdis / 100;
                    var final_price = qtyprice - disprice;
                    // alert(final_price); return false;
                    $('#total_' + proid).val(final_price);
                    $('.total_price_' + proid).html('<b>AED ' + final_price + '</b>');
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
    // alert($('.quickordertbl tr').length);
    if ($('.quickordertbl tr').length > 0)
    {
        $('#createorder_submit').attr("type", "submit");
    }
    var calculated_total_sum = 0;
    $("#createorder_table .pro_ttal").each(function () {
        var get_textbox_value = $(this).val();

        if ($.isNumeric(get_textbox_value)) {
            calculated_total_sum += parseFloat(get_textbox_value);
        }

    });
    curmain = $('.main_total').html(calculated_total_sum);
    $(document).on('keyup blur mouseup', "#cart_qty", function () {
        var proid = $(this).attr('data-id');
        var qty = $(this).val();
        var form_data = [{"name": "product_id", "value": proid}, {"name": "qty", "value": qty}];
        $.ajax({
            url: site_root + 'Customer/CheckData',
            type: "POST",
            data: form_data,
            success: function (data) {
                if (data == 2)
                {
                    $('#email_error_' + proid).html('Quantity Not Allow zero or spaces');
                    $("#email_error_" + proid).css('cssText', 'text-align:left !important; color:#a94442 !important');
                    $('#email_success_' + proid).hide();
                    $('#email_error_' + proid).show();
                    interval = function () {
                        $('#email_error_' + proid).css('cssText', 'display:none !important;');
                    }
                    setInterval(interval, 4000);
                    $('#qty').val("1");
                    var sellprice = $("#sellingprice_" + proid).val();
                    $('.pricedata_' + proid).html('AED ' + sellprice);
                    var defaul_item_total = $(".pro_ttal").attr('data-main-total');
                    $('#total_' + proid).val(defaul_item_total);
                    $('.total_price_' + proid).html('<b>AED ' + defaul_item_total + '</b>');
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
                else if (data == 0)
                {

                    $('#email_error_' + proid).html('Quantity Not Avaliable');
                    $("#email_error_" + proid).css('cssText', 'text-align:left !important; color:#a94442 !important');
                    $('#email_success_' + proid).hide();
                    $('#email_error_' + proid).show();
                    interval = function () {
                        $('#email_error_' + proid).css('cssText', 'display:none !important;');
                    }
                    setInterval(interval, 4000);
                    $('#qty').val("1");
                    var sellprice = $("#sellingprice_" + proid).val();
                    $('.pricedata_' + proid).html('AED ' + sellprice);
                    var defaul_item_total = $(".pro_ttal").attr('data-main-total');
                    $('#total_' + proid).val(defaul_item_total);
                    $('.total_price_' + proid).html('<b>AED ' + defaul_item_total + '</b>');
                    var calculated_total_sum = 0;
                    $("#datatable_cartview .pro_ttal").each(function () {
                        var get_textbox_value = $(this).val();
                        if ($.isNumeric(get_textbox_value)) {
                            calculated_total_sum += parseFloat(get_textbox_value);
                        }

                    });
                    curmain = $('.main_total').html(calculated_total_sum);
                    ;
                    return true;
                }
                else
                {
                    $('#email_success_' + proid).html('Quantity Avaliable');
                    $("#email_success_" + proid).css('cssText', 'text-align:left !important; color:#3c763d !important');
                    $('#email_error_' + proid).hide();
                    $('#email_success_' + proid).show();
                    interval = function () {
                        $('#email_success_' + proid).css('cssText', 'display:none !important;');
                    }
                    setInterval(interval, 4000);
                    var curqty = $('.qty_' + proid).val();
                    var pricedataname = $('.pricedata_' + proid).attr('data-name');
                    var curprice = $('.pricedata_' + proid).html();
                    var curdis = $('.discount_' + proid).html();
                    var qtyprice = pricedataname * curqty;
                    $('#sellingprice' + proid).val(qtyprice);
                    // $('.pricedata_'+proid).html('AED '+qtyprice);
                    var disprice = qtyprice * curdis / 100;
                    var final_price = qtyprice - disprice;
                    $('#total_' + proid).val(final_price);
                    $('.total_price_' + proid).html('<b>AED ' + final_price + '</b>');

                    var calculated_total_sum = 0;
                    $("#datatable_cartview .pro_ttal").each(function () {
                        var get_textbox_value = $(this).val();
                        if ($.isNumeric(get_textbox_value)) {
                            calculated_total_sum += parseFloat(get_textbox_value);
                        }

                    });
                    // alert(calculated_total_sum);
                    curmain = $('.main_total').html(calculated_total_sum);
                    return true;
                }
            }
        });
    });
    var calculated_total_sum = 0;
    $("#datatable_cartview .pro_ttal").each(function () {
        var get_textbox_value = $(this).val();
        if ($.isNumeric(get_textbox_value)) {
            calculated_total_sum += parseFloat(get_textbox_value);
        }

    });
    // alert(calculated_total_sum);
    curmain = $('.main_total').html(calculated_total_sum);
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
//            serial_number: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Serial Number'
//                    },
//                    identical: {
//                        field: 'sku',
//                        message: 'The password and its confirm are not the same'
//                    }
//                }
//            },
//             serial_number: {
//                validators: {
//                    identical: {
//                        field: 'sku',
//                        message: 'The SKU Number and its Serial Number are not the same'
//                    }
//                }
//            },
            retail_price: {
                validators: {
                    notEmpty: {
                        message: 'Please select Retail Price'
                    },
                     regexp: {
                        regexp: /^[0-9]+([\,|\.][0-9]+)?/,
                        message: 'The Purchasing Price can consist of digit'
                    }
                }
            },
            selling_price: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Selling Price'
                    },
//                    integer: {
//                           message: 'The value is not an Number',
//                          }
                          regexp: {
                        regexp: /^[0-9]+([\,|\.][0-9]+)?/,
                        message: 'The Selling Price  can consist of digit'
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
        submitHandler: function (validator, form, submitButton) {

        }
    });

    $(document).on('click', ".sa-order", function () {
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
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": proid}, {"name": "price", "value": proprice}];
            $.ajax({
                url: site_root + "customer/makeorder",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    // swal("Success!", "Your Product is successfully orderd.", "success");
                    //window.location.href="services";
                }
            });
        });
    });
    $(document).on('click', ".sa-cart", function () {
        var ordid = $(this).attr("data-id");
        var proid = $(this).attr("data-name");
        // var proqty = $("#productdetailqty").val();
        var proprice = $(this).attr("data-price");
        var proqty = $(this).attr("data-qty");
        var promainprice = $(this).attr("data-main-price");
        // alert(promainprice); return false;
        var prodis = $(this).attr("data-discount");
        /*swal({
         title: "Are you sure you want to add this product to cart?",
         text: "You will be able to remove this order from cart items!",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Yes",
         closeOnConfirm: false
         }, function () {*/
        var form_data = [{"name": "id", "value": proid}, {"name": "price", "value": proprice}, {"name": "promainprice", "value": promainprice}, {"name": "prodis", "value": prodis}, {"name": "proqty", "value": proqty}];
        $.ajax({
            url: site_root + "customer/addtocart",
            type: "POST",
            data: form_data,
            success: function (msg) {
//                  alert(msg); return false;
                // location.reload();
                if (msg == 1)
                {
                    $('#alert_msg_pro_cart').css({"display": "block","width":"970px","position": "fixed", "z-index": "999"});
                    $("#alert_msg_pro_cart").html('Item added for request quotations');
                }
                else if (msg == 2)
                {
                    $('#alert_msg_pro_cart').css({"display": "block","width":"970px","position": "fixed", "z-index": "999"});
                    $("#alert_msg_pro_cart").html('Product alreday exist in quotations');
                }

                /*$('html, body').animate({
                    scrollTop: 0,
                }, 800);*/
                window.setTimeout(function () {
                    // $('#alert_msg_pro_cart').css('cssText', 'display:none !important;');
                    $("#alert_msg_pro_cart").fadeIn(3000, 0).slideUp(2000, function () {
                                       $('#alert_msg_pro_cart').hide();
//                                        $('#alert_msg_pro_cart').show();

                    });
                }, 1000);



//                              $('#alert_msg_pro_cart').on('click', function(){
//                                $('html,body').animate({scrollTop: $(this).offset().top}, 800);
//                            });
                //}
                //setInterval(interval, 4000);
//                     window.location.href=site_root + "customer/products";
//                     notify('','',);
//                    swal("Success!", "Your Product is successfully added to in request quotation.", "success");
//                    window.location.href = site_root + "customer/products";
            }
        });
        // });
    });

    $(document).on('click', ".sa-warning", function () {
        var delid = $(this).attr("data-id");
        var proid = $(this).attr("data-name");
        swal({
            title: "Are you sure you want to delete this Product?",
            text: "You will not be able to recover this Product!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": proid}];
            $.ajax({
                url: site_root + "product/deleteproduct",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Deleted!", "Product has been deleted.", "success");
                    //window.location.href="services";
                }
            });
        });
    });
    $(document).on('click', ".sa-cancel_order", function () {
        var delid = $(this).attr("data-id");
        var ordid = $(this).attr("data-name");
        var orderid = $(this).attr("data-orderid");
        var qty = $(this).attr("data-qty");
        var productid = $(this).attr("data-productid");
        var productqty = $(this).attr("data-productqty");
        var totalprice = $(this).attr("data-totalprice");
        var price = $(this).attr("data-price");

        swal({
            title: "Are you sure you want to cancel this order?",
            text: "You will not be able to order this Product!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Cancel!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": ordid}, {"name": "productid", "value": productid}, {"name": "qty", "value": qty}, {"name": "productqty", "value": productqty},{"name": "totalprice", "value": totalprice},{"name": "price", "value": price},{"name": "orderid", "value": orderid}];
            $.ajax({
                url: site_root + "customer/cancelorder",
                type: "POST",
                data: form_data,
                success: function (msg) {
//                  alert(msg);
                    if (msg = 'success') {
                        $("#dytr_" + delid).toggle();
                        // swal("Cancelled!", "Your order has been cancelled.", "success");
                        location.reload();
                        //window.location.href="services";
                    } else {
                        // swal("Error!", "Your order could not cancel.", "error");
                    }
                }
            });
        });
    });

    $(document).on('click', ".sa-vehicle_warning", function () {
        var delid = $(this).attr("data-id");
        var proid = $(this).attr("data-name");
        swal({
            title: "Are you sure you want to delete this Vehicle?",
            text: "You will not be able to recover this Vehicle!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": proid}];
            $.ajax({
                url: site_root + "user/deletevehicle",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Deleted!", "Vehicle has been deleted.", "success");
                    //window.location.href="services";
                }
            });
        });
    });

    $(document).on('click', ".sa-cancel_whole_order", function () {
        var delid = $(this).attr("data-id");
        var ordid = $(this).attr("data-name");
//            alert(ordid+', '+delid);
        swal({
            title: "Are you sure you want to cancel whole order?",
            text: "All the products in side the order will be deleted!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Cancel!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": ordid}];
            $.ajax({
                url: site_root + "customer/cancelwholeorder",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    if (msg = 'success') {
//                            $("#dytr_"+delid).toggle();
                        // swal("Cancelled!", "Your order has been cancelled.", "success");
                        location.reload();
                        //window.location.href="services";
                    } else {
                        // swal("Error!", "Your order could not cancel.", "error");
                    }
                }
            });
        });
    });


    $(document).on('click', ".sa-remove_cart", function () {
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
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": cartid}, {"name": "cartqty", "value": cartproductqty}, {"name": "product_id", "value": product_id}, {"name": "productqty", "value": productqty}];
            $.ajax({
                url: site_root + "customer/removefromcart",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Removed!", "Your Product has been remove from cart", "success");
                    location.reload();
                    //window.location.href="services";
                }
            });
        });
    });

    $(document).on('click', ".sa-remove_from_saved", function () {
        var delid = $(this).attr("data-id");
        var cartid = $(this).attr("data-name");
        var cartproductqty = $(this).attr("data-qty");
        var product_id = $(this).attr("data-proid");
        var productqty = $(this).attr("data-productqty");
        swal({
            title: "Are you sure you want to remove this product from saved items?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": cartid}, {"name": "cartqty", "value": cartproductqty}, {"name": "product_id", "value": product_id}, {"name": "productqty", "value": productqty}];
            $.ajax({
                url: site_root + "customer/removefromsaved",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Removed!", "Your Product has been remove from saved items", "success");
                    location.reload();
                    //window.location.href="services";
                }
            });
        });
    });

    $(document).on('click', ".sa-save_later", function () {
        var delid = $(this).attr("data-id");
        var cartid = $(this).attr("data-name");
        var cartproductqty = $(this).attr("data-qty");
        var product_id = $(this).attr("data-proid");
        var productqty = $(this).attr("data-productqty");
        swal({
            title: "Are you sure you want to save this product for later?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": cartid}, {"name": "cartqty", "value": cartproductqty}, {"name": "product_id", "value": product_id}, {"name": "productqty", "value": productqty}];
            $.ajax({
                url: site_root + "customer/saveforlater",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Removed!", "Your Product has been saved for later use", "success");
                    location.reload();
                    //window.location.href="services";
                }
            });
        });
    });

    $(document).on('click', "#cust_comment_send", function () {
        // alert("hi"); return false;
        if ($("#msg_reply_area").val() != "")
        {
            var order_id = $(this).attr("data-orderid");
            var comment_text = $("#msg_reply_area").val();
            var form_data = [{"name": "orderid", "value": order_id}, {"name": "comment_text", "value": comment_text}];
            $.ajax({
                url: site_root + "customer/addcommentfromuser",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    // alert(msg); return false;
                    $("#msg_reply_area").val("");
                    var user_name = $("#user_details").attr('data-username');
                    var user_profile = $("#user_details").attr('data-profile');
                    var comment = '<li class="media"> <div class="media-body"> <div class="media"> <a class="pull-left" href="#"> <img class="media-object img-circle" style="height: 64px;width: 64px;" src="'+user_profile+'"> </a> <div class="media-body"> <small class="text-muted">'+user_name+'</small> <br> '+comment_text+' <hr> </div> </div> </div> </li>';
                    $(".media-list").append(comment);
                    // swal("Send!", "Your orders has been send for approval to customer.", "success");
                    //window.location.href="services";
                }
            });
        }
        else
        {
            swal("Please enter comment in comment box");
        }
    });
    $(document).on('keyup mouseup', ".qty_details", function () {

        var ord_id = $(this).attr('data-id');
        var qty_details = $(this).val();
        var mainsellingprice = $("#mainsellprice_" + ord_id).val();
        var dis = (($("#discountdetails_" + ord_id).val() && $("#discountdetails_" + ord_id).val() != undefined) ? $("#discountdetails_" + ord_id).val() : 0);
        //$("#discountdetails_" + ord_id).val();
        var prc = $("#sellingprice_" + ord_id).val();
        var ttlprc = $("#ttlprice_details_" + ord_id).val();
        var qtyprc = prc * qty_details;
        var disprc = qtyprc * dis / 100;
        var fnlprc = qtyprc - disprc;
        $('#ordsend_' + ord_id).attr('data-orderdiscount_' + ord_id, dis);
        $('#ordsend_' + ord_id).attr('data-orderttlprice_' + ord_id, fnlprc);
        $('#ordsend_' + ord_id).attr('data-orderprice_' + ord_id, prc);
        $('#ordsend_' + ord_id).attr('data-orderqty_' + ord_id, qty_details);

        $("#ttlprice_details_" + ord_id).html(fnlprc);
        $("#ttlhdnprc_" + ord_id).val(fnlprc);
    });

    $(document).on('keyup', ".sellingprice", function () {
        var ord_id = $(this).attr('data-id');
        // alert(ord_id); return false;
        var qty_details = $('#qty_details_' + ord_id).val();
        var mainsellingprice = $("#mainsellprice_" + ord_id).val();
        var dis = (($("#discountdetails_" + ord_id).val() && $("#discountdetails_" + ord_id).val() != undefined) ? $("#discountdetails_" + ord_id).val() : 0);
        var prc = $(this).val();
        var ttlprc = $("#ttlprice_details_" + ord_id).val();
        var qtyprc = prc * qty_details;
        var disprc = qtyprc * dis / 100;
        var fnlprc = qtyprc - disprc;
        $('#ordsend_' + ord_id).attr('data-orderdiscount_' + ord_id, dis);
        $('#ordsend_' + ord_id).attr('data-orderttlprice_' + ord_id, fnlprc);
        $('#ordsend_' + ord_id).attr('data-orderprice_' + ord_id, prc);
        $('#ordsend_' + ord_id).attr('data-orderqty_' + ord_id, qty_details);

        $("#ttlprice_details_" + ord_id).html(fnlprc);
        $("#ttlhdnprc_" + ord_id).val(fnlprc);
    });

    $(document).on('keyup', ".discountdetails", function () {

        var ord_id = $(this).attr('data-id');
        // alert(ord_id); return false;
        var qty_details = $('#qty_details_' + ord_id).val();
        var mainsellingprice = $("#mainsellprice_" + ord_id).val();
        var dis = $(this).val();
        var prc = $("#sellingprice_" + ord_id).val();
        var ttlprc = $("#ttlprice_details_" + ord_id).val();
        var qtyprc = prc * qty_details;
        var disprc = qtyprc * dis / 100;
        var fnlprc = qtyprc - disprc;
        $('#ordsend_' + ord_id).attr('data-orderdiscount_' + ord_id, dis);
        $('#ordsend_' + ord_id).attr('data-orderttlprice_' + ord_id, fnlprc);
        $('#ordsend_' + ord_id).attr('data-orderprice_' + ord_id, prc);
        $('#ordsend_' + ord_id).attr('data-orderqty_' + ord_id, qty_details);

        $("#ttlprice_details_" + ord_id).html(fnlprc);
        $("#ttlhdnprc_" + ord_id).val(fnlprc);
    });

    $(document).on('change', ".orderdd_main", function () {
        // alert("hi"); return false;
        var ord_id = $(this).attr('data-id');
        var status = $(this).val();
        if(status == 2)
        {
            $("#rejection_model").modal('show');
            $("#rejectcomment_btn").click(function() {
                var reject_comment = $("#reject_comment").val();
                if(reject_comment != "")
                {
                    var reject_comment = $("#reject_comment").val();
                    var form_data = [{"name": "order_id", "value": ord_id}, {"name": "status", "value": status},{"name": "reject_comment", "value": reject_comment}];
                    $.ajax({
                        url: site_root + "customer/changeorderstatus",
                        type: "POST",
                        data: form_data,
                        success: function (msg) {
                            // alert(msg);return false;
                            swal({
                                title: "Changed",
                                text: "Your status has been Changed",
                                type: "success"
                            }, function () {
                                $('#cancle_rejection_model').fadeOut();
                                location.reload();
                            });
                            // swal("Changed!", "Your status has been Changed.", "success");
                            // location.reload();
                        }
                    });
                }
                else
                {
                    swal("Error!", "Please enter reason for reject", "error");
                }
            });
            $('#cancle_rejection_model').click(function() {
                // alert("hi");
                // $('.orderdd_main').val(0).trigger("change");
                 $('.orderdd_main').prop('selectedIndex',0);
                // $('#rejection_model').hide();
                $('#rejection_model').dialog("close");
                return false;
            });
        }
        else
        {
            swal({
                title: "Are you sure you want to order change staus?",
                text: "You will be able to change order again for this Product!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Confirm!",
                closeOnConfirm: true
           },
            function (isConfirm) {
                if(isConfirm)
                {
                    var form_data = [{"name": "order_id", "value": ord_id}, {"name": "status", "value": status}];
                    $.ajax({
                        url: site_root + "customer/changeorderstatus",
                        type: "POST",
                        data: form_data,
                        success: function (msg) {
                            // alert(msg);return false;
                              location.reload();
                            // swal({
                            //     title: "Changed",
                            //     text: "Your status has been Changed",
                            //     type: "success"
                            // }, function () {
                            //
                            // });
                            // swal("Changed!", "Your status has been Changed.", "success");
                            // location.reload();
                        }
                    });
                }
                else
                {
                    // $(this).prop('selectedIndex',0);
                    $('.orderdd_main').val(0).trigger("change");
                    return false;
                }
            });
        }
    });

    $(document).on('click', "#acceptquotations", function () {
        var ord_id = $(this).attr('data-id');
        var status = 1;
        var orderfrom = "quotations";
        swal({
            title: "Are you sure you want to accept this quotation?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Confirm!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "order_id", "value": ord_id}, {"name": "status", "value": status},{"name": "orderfrom", "value": orderfrom}];
            $.ajax({
                url: site_root + "customer/changeorderstatus",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    // alert(msg);return false;
                    // location.reload();
                    window.location.href = site_root + "customer/quotations";
                    // swal("Sended!", "Your status has been Changed.", "success");
                }
            });
        });
    });

    // $("#moveordertoquick").click(function() {
    $(document).on('click', "#moveordertoquick", function () {
        $(this).attr('data-id', '1');
        $('#sendforapprove').attr('data-id', '');
    });
    // $("#sendforapprove").click(function() {
    $(document).on('click', "#sendforapprove", function () {
//        alert('fgfd');
        $(this).attr('data-id', '2');
        $('#moveordertoquick').attr('data-id', '');
    });

    $("#frm_adminorderdetails").submit(function (e)
    {
        var postData = $(this).serializeArray();
        var order_id = $('.encrpt_id').val();
        var formURL = $(this).attr("action");
        var url = window.location.href;
//        alert(url);
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (data)
                    {
                       // alert(data);
                        // alert(data); return false;
//                        swal("Send5676!","<a href='#'>fgfg</a> Your orders has been send for approval to customer.", "success");
//                        var link_href = site_root + 'invoice/CreateOrderInvoice/' + order_id;
                        swal({
                            title: "Send!",
//                            text: "<a href='" + link_href + "'>Create Invoice</a><p>Your orders has been send for approval to customer.</p>",
                            type: "success",
                            html: true
                       },
                        function () {
                            //data: return data from server
                            if (url.indexOf('osm/user/orderdetails') > -1) {
                                window.location.href = site_root + 'order/vieworder';
                            }
                            else {
                                window.location.href = site_root + 'user/quotations';
                            }
                        });
                    }
                });
        e.preventDefault(); //STOP default action
    });


    $("#frm_adminorderdetails_sales").submit(function (e)
    {
//alert('fgdf');
        var postData = $(this).serializeArray();
        var order_id = $('.encrpt_id').val();
        var formURL = $(this).attr("action");
        var url = window.location.href;
//        alert(url);
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (data)
                    {
//                        alert(data);
                        // alert(data); return false;
//                        swal("Send5676!","<a href='#'>fgfg</a> Your orders has been send for approval to customer.", "success");
//                        var link_href = site_root + 'invoice/CreateOrderInvoice/' + order_id;
                        swal({
                            title: "Send!",
//                            text: "<a href='" + link_href + "'>Create Invoice</a><p>Your orders has been send for approval to customer.</p>",
                            type: "success",
                            html: true
                       },
                        function () {
                            //data: return data from server
                            if (url.indexOf('osm/sales/sales_orderdetails') > -1) {
                                window.location.href = site_root + 'sales/sales_orderview';
                            }
                            else {
                                window.location.href = site_root + 'user/quotations';
                            }
                        });
                    }
                });
        e.preventDefault(); //STOP default action
    });



    $("#frm_adminquotationdetails").submit(function (e)
    {

        var sendforapprove = $("#sendforapprove").attr('data-id');
//        alert(sendforapprove);
        var moveordertoquick = $("#moveordertoquick").attr('data-id');
        var postData = $(this).serializeArray();
        // alert(postData);return false;
        postData.push({name: "sendforapprove", value: sendforapprove}, {name: "moveordertoquick", value: moveordertoquick});
        var order_id = $('.encrpt_id').val();
        var formURL = $(this).attr("action");
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (data)
                    {
                        // alert(data); return false;
//                        swal("Send5676!","<a href='#'>fgfg</a> Your orders has been send for approval to customer.", "success");
//                        var link_href = site_root + 'invoice/CreateOrderInvoice/' + order_id;
                        swal({
                            title: "Sent!",
//                            text: "<a href='" + link_href + "'>Create Invoice</a><p>Your orders has been send for approval to customer.</p>",
                            type: "success",
                            html: true
                       },
                        function () {
                            //data: return data from server
                            window.location.href = site_root + 'user/quotations';
                        });
                    }
                });
        e.preventDefault();
    });

// change the model of total consumption in changes message.
    $("#frm_cart_placeorder").submit(function (e)
    {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (data)
                    {
                        // alert(data); return false;
                        $('#consumption_model').modal('hide');
                        $('#comment_model_cmt').modal('hide');
                        $(".cart_cust_body").html("");
                        $("#text_quotation").val("");
                        $("#search_customer").val("");
                        swal("Success!", "Your request is sent to admin", "success");

                        //data: return data from server
                    }
                });
        e.preventDefault(); //STOP default action
    });

    $("#frmadmin_addpurchaseorder").submit(function (e)
    {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (data)
                    {
                        if (data = 1)
                        {
                            $('#frmadmin_addpurchaseorder')[0].reset();
                            swal("Success!", "Your order sent successfully", "success");
                        }
                    }
                });
        e.preventDefault(); //STOP default action
    });

// old model in customer for total consumption
//      $("#frm_cart_placeorder").submit(function (e)
//    {
//        var postData = $(this).serializeArray();
//        var formURL = $(this).attr("action");
//        $.ajax(
//                {
//                    url: formURL,
//                    type: "POST",
//                    data: postData,
//                    success: function (data)
//                    {
//                        // alert(data); return false;
//                        $('#consumption_model').modal('hide');
//                        $(".cart_cust_body").html("");
//                        $("#text_quotation").val("");
//                        swal("Success!", "Your cart has been placed", "success");
//
//                        //data: return data from server
//                    }
//                });
//        e.preventDefault(); //STOP default action
//    });
//
    hs.graphicsDir = site_root + 'assets/js/plugin/highslide/graphics/';
    hs.align = 'center';
    hs.transitions = ['expand', 'crossfade'];
    hs.outlineType = 'rounded-white';
    hs.wrapperClassName = 'controls-in-heading';
    hs.fadeInOut = true;
    //hs.dimmingOpacity = 0.75;

    // Add the controlbar
    if (hs.addSlideshow)
        hs.addSlideshow({
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
    // $("#checkedAll").change(function () {
    $(document).on('change', "#checkedAll", function () {
        if (this.checked) {
            $(".checkSingle").each(function () {
                $("tbody").css('background-color', '#ffeb8c');
                this.checked = true;
            })
        } else {
            $(".checkSingle").each(function () {
                $("tbody").css('background-color', '');
                this.checked = false;
            })
        }
    });

    // $(".checkSingle").click(function () {
    $(document).on('click', ".checkSingle", function () {
        if ($(this).is(":checked")) {
            dataid = $(this).attr('data-id');
            $("#dytr_"+dataid).css('background-color', '#ffeb8c');
            var isAllChecked = 0;
            $(".checkSingle").each(function () {
                if (!this.checked)
                    isAllChecked = 1;
            })
            if (isAllChecked == 0) {
                $("#checkedAll").prop("checked", true);
            }
        }
        else {
            $("#dytr_"+dataid).css("background-color", "");
            $("#checkedAll").prop("checked", false);
        }
    });
    $(document).on('keyup mouseup', "#quickcustqty", function () {
       // alert('hii');
        var product_id = $(this).attr("data-id");

        var price = $(this).attr("data-price");
        var item_qty = $(this).val();
        // if (item_qty <= 0)
        // {
        //     $(this).val("1");
        //     item_qty = 1;
        // }
        var discount = $(this).attr("data-discount");
        //var total = $("#total").val();
        var total = price * item_qty;
        var disprc = total * discount / 100;
        var fnlprc = total - disprc;
        $("#total_" + product_id).html('AED ' + parseFloat(fnlprc, 2));
        $("#checkbox_" + product_id).attr('data-total', fnlprc);
        $("#checkbox_" + product_id).attr('data-qty', item_qty);
    });
    // $("#cust_quickorder_product_btn").click(function () {
    /*$(document).on('click', "#cust_quickorder_product_btn", function () {
        var productid = [];
        var price = [];
        var qty = [];
        var defaultqty = [];
        var discount = [];
        var total = [];
        if ($(".checkSingle").is(":checked") == true) {
            $(".checkSingle:checked").each(function () {
                productid.push($(this).attr('data-productid'));
                price.push($(this).attr('data-price'));
                qty.push($(this).attr('data-qty'));
                defaultqty.push($(this).attr('data-defaultqty'));
                discount.push($(this).attr('data-disc'));
                total.push($(this).attr('data-total'));
            });
            var custid = $("#custid_quick").val();
            swal({
            title: "Are you sure you want to make this order?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Confirm!",
            closeOnConfirm: true
            }, function () {
                var form_data = [{"name": "proid", "value": productid}, {"name": "price", "value": price}, {"name": "qty", "value": qty}, {"name": "defaultqty", "value": defaultqty}, {"name": "discount", "value": discount}, {"name": "total", "value": total}];
                $.ajax({
                    url: site_root + "customer/AddOrderFromQuickOrder",
                    type: "POST",
                    data: form_data,
                    success: function (msg) {
                        alert(msg); return false;
                        // $(".admin_msg_reply_area").val("");
                        $(".checkSingle").each(function () {
                            $("tbody").css('background-color', '');
                            this.checked = false;
                        })
                        swal("Saved!", "Order Placed.", "success");
                        //window.location.href="services";
                    }
                });
            });

        } else if ($(".checkSingle").prop("checked") == false) {
            swal("Error!", "Please select at least one checkbox", "error");
        }
        return false;

    });*/

    $(document).on('click', "#cust_quickorder_product_btn", function () {
        var productid = [];
        var price = [];
        var qty = [];
        var defaultqty = [];
        var discount = [];
        var total = [];
        if ($(".checkSingle").is(":checked") == true) {
            $(".checkSingle:checked").each(function () {
                var id = $(this).attr('data-id');
                var unit_drop = $("#unit_dropdown_"+id).val();
                if(unit_drop == 1)
                {
                    var ttl = parseFloat($(this).attr('data-package')) * parseFloat($(this).attr('data-qty'));
                    var final_prc = ttl * parseFloat($(this).attr('data-price'));
                    $(this).attr('data-total',parseFloat(final_prc));
                    // alert(final_prc);
                }
                else
                {
                    final_prc = parseFloat($(this).attr('data-price')) * parseFloat($(this).attr('data-qty'));
                    $(this).attr('data-total',parseFloat(final_prc));
                    // alert(final_prc);
                }
                // alert(ttl);return false;
                productid.push($(this).attr('data-productid'));
                price.push($(this).attr('data-price'));
                qty.push($(this).attr('data-qty'));
                defaultqty.push($(this).attr('data-defaultqty'));
                discount.push($(this).attr('data-disc'));
                total.push($(this).attr('data-total'));
            });
            // return false;
            var custid = $("#custid_quick").val();
            swal({
            title: "Are you sure you want to make this order?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Confirm!",
            closeOnConfirm: true
            }, function () {
                var form_data = [{"name": "proid", "value": productid}, {"name": "price", "value": price}, {"name": "qty", "value": qty}, {"name": "defaultqty", "value": defaultqty}, {"name": "discount", "value": discount}, {"name": "total", "value": total}];
                $.ajax({
                    url: site_root + "customer/AddOrderFromQuickOrder",
                    type: "POST",
                    data: form_data,
                    success: function (msg) {
                        // alert(msg); return false;
                        // $(".admin_msg_reply_area").val("");
                        $(".checkSingle").each(function () {
                            $("tbody").css('background-color', '');
                            this.checked = false;
                        })
                        // swal("Saved!", "Order Placed.", "success");
                        //window.location.href="services";
                    }
                });
            });

        } else if ($(".checkSingle").prop("checked") == false) {
            swal("Error!", "Please select at least one checkbox", "error");
        }
        return false;

    });

    $(document).on('click', "#mailsendquotation", function () {
        var email = $("#search_customer").val();
        var form_data = [{"name": "email", "value": email}];
        $.ajax({
            url: site_root + "sales/quotationmailsend",
            type: "POST",
            data: form_data,
            success: function (msg) {
                // alert(msg); return false;\
                if (msg = 1)
                {
                    $('.send_mail').modal('hide');
                    $(".cart_cust_body").html("");
                    $("#search_customer").val("");
                    swal("Send!", "Quotation send.", "success");
                }
                else if (msg = 2)
                {
                    $("#search_customer").val("");
                    $('.send_mail').modal('hide');
                    swal("Error!", "There is some problem in send qoutation", "error");
                }
            }
        });
    });

    // function notify(title,text,type)
    // {
    //     // alert("hi");
    //     new PNotify({
    //           title: 'Regular Success',
    //           text: 'That thing that you were trying to do worked!',
    //           type: 'success',
    //           styling: 'bootstrap3'
    //       });
    // }
    // $('#adminproductlisting input').val("producttest");

//
     jQuery(document).ready(function () {
           jQuery('#adminproductlisting_ajax_form').DataTable({
                                    "processing": true,
                                    "serverSide": true,

                         "ajax":{
                              url: site_root + "product/viewproduct_page",
                             type: "post",
//                             datatype: "JSON",// method  , by default get
                             error: function(){  // error handling
                                            $("#adminproductlisting_ajax_form").append('<tbody class="pro_list"><tr><th colspan="3">No data found in the server</th></tr></tbody>');

                                    }
                                    }
            });
        });

    var customer_productview = $('#frontproductlisting').DataTable();
    var table = $('#adminproductlisting_ajax').DataTable();
    var customer_quickorder = $('#frontyourorderlisting').DataTable();
    $("#category").change(function () {
        var category = $('select#category option:selected').text();
        if(category == '- Choose Category -')
        {
            category = "";
        }
        else
        {
            category = category;
        }
        table.search(category).draw();
        var customer_quickorder_category = $('select#category option:selected').val();
        customer_quickorder.search(customer_quickorder_category).draw();
        var customer_productview_category = $('select#category option:selected').val();
        customer_productview.search(customer_productview_category).draw();
    });
    $("#sc1").change(function () {
        var customer_quickorder_category = $('select#category option:selected').text();

//        alert(customer_quickorder_category);
        var cat1 = $('select#sc1 option:selected').text();
        if(cat1 == '- Choose Sub Category -')
        {
            cat1 = "";
        }
        else
        {
            cat1 = cat1;
        }
        var subcategory1 = customer_quickorder_category + ' ' + cat1;
        table.search(subcategory1).draw();

        var customer_quickorder_category1 = customer_quickorder_category + ' ' + $('select#sc1 option:selected').val();
        customer_quickorder.search(customer_quickorder_category1).draw();

        var customer_productview_category1 = customer_quickorder_category + ' ' + $('select#sc1 option:selected').val();
        customer_productview.search(customer_productview_category1).draw();
    });
    $("#sc2").change(function () {
        var cat = $('select#category option:selected').text();
        var cat1 = $('select#sc1 option:selected').text();
        var cat2 = $('select#sc2 option:selected').text();
        if(cat == '- Choose Category -')
        {
            cat = "";
        }
        else
        {
            cat = cat;
        }
        if(cat1 == '- Choose Sub Category -')
        {
            cat1 = "";
        }
        else
        {
            cat1 = cat1;
        }
        if(cat2 == '- Choose Sub Category -')
        {
            cat2 = "";
        }
        else
        {
            cat2 = cat2;
        }
        var subcategory2 = cat + ' ' + cat1 + ' ' + cat2;
        table.search(subcategory2).draw();

        var customer_quickorder_category2 = $('select#category option:selected').val() + ' ' + $('select#sc1 option:selected').val() + ' ' + $('select#sc2 option:selected').val();
        customer_quickorder.search(customer_quickorder_category2).draw();

        var customer_productview_category2 = $('select#category option:selected').val() + ' ' + $('select#sc1 option:selected').val() + ' ' + $('select#sc2 option:selected').val();
        customer_productview.search(customer_productview_category2).draw();
    });
    var category = new Array("Paper", "Plastic", "Foam", "Wooden", "Hygiene", "Aluminium");
    var subcategory1 = new Array("Cup", "Bowl", "Tissue", "Box", "Doilies", "Container", "Bottle", "Lid", "Cutlery", "Bag", "Straw", "Plate", "Tray", "Cleaning", "Gloves", "Cap", "Apron", "Wrap", "Platter");
    var subcat1 = new Array();
    subcat1[0] = "";
    subcat1[1] = "Cup|Bowl|Tissue|Box|Doilies";
    subcat1[2] = "Container|Bottle|Lid|Cutlery|Bag|Straw";
    subcat1[3] = "Plate|Tray|Bowl";
    subcat1[4] = "Cutlery";
    subcat1[5] = "Cleaning|Gloves|Cap|Apron";
    subcat1[6] = "Wrap|Platter|Container";
    var subcat2 = new Array();
    subcat2[0] = "";
    subcat2[1] = "Ripple cup";
    subcat2[2] = "Soup bowl";
    subcat2[3] = "Facial Tissue|Embossed";
    subcat2[4] = "";
    subcat2[5] = "Round";
    subcat2[6] = "Rectangular|Deep|Square|Shallow|Round";
    subcat2[7] = "Clear";
    subcat2[8] = "Flat";
    subcat2[9] = "Spoon|Fork|Knife|Toothpick";
    subcat2[10] = "Clear";
    subcat2[11] = "Flexible";
    subcat2[12] = "";
    subcat2[13] = "";
    subcat2[14] = "Liquid";
    subcat2[15] = "Powdered";
    subcat2[16] = "";
    subcat2[17] = "";
    subcat2[18] = "";
    subcat2[19] = "";
    // putAllCategoryOptions("category", '', 'sc1', '');
    // $("#category").change(function () {
    //     putAllCat1Options("sc1", $(this).prop("selectedIndex"), "", subcat1);
    // });
    // $("#sc1").change(function () {
    //     putAllCat2Options("sc2", $(this).prop("selectedIndex"), $(this).val(), subcat2);
    // });
    // function putAllCategoryOptions(Category_id, SelectedCategory, catoneid, selectedcatone)
    // {
    //     // given the id of the <select> tag as function argument, it inserts <option> tags
    //     var option_str = document.getElementById(Category_id);
    //     var current_selected_index = '';
    //     option_str.length = '0';
    //     option_str.options[0] = new Option('Select Category', '');
    //     option_str.selectedIndex = 0;
    //     for (var i = 0; i < category.length; i++) {
    //         option_str.options[option_str.length] = new Option(category[i], category[i]);
    //         if (category[i] == SelectedCategory)
    //         {
    //             current_selected_index = i + 1;

    //             option_str.selectedIndex = current_selected_index;
    //         }
    //     }
    //     if (current_selected_index != '')
    //         putAllCat1Options(catoneid, current_selected_index, selectedcatone);
    // }
    // function putAllCat1Options(catoneid, catone_index, selectedcatone, array_data) {
    //     var option_str = document.getElementById(catoneid);
    //     option_str.length = 0;    // Fixed by Julian Woods
    //     option_str.options[0] = new Option('Select Sub Category 1', '');
    //     option_str.selectedIndex = 0;
    //     var state_arr = array_data[catone_index].split("|");
    //     for (var i = 0; i < state_arr.length; i++) {
    //         option_str.options[option_str.length] = new Option(state_arr[i], state_arr[i]);
    //         if (state_arr[i] == selectedcatone)
    //             option_str.selectedIndex = i + 1;
    //     }
    //     // $("#vState").selectBox('destroy');
    //     // $("#vState").selectBox();
    // }
    // function putAllCat2Options(catoneid, catone_index, selectedcatone, array_data) {
    //     for (var j = 0; j < subcategory1.length; j++) {
    //         if (selectedcatone == subcategory1[j]) {
    //             var pickedIndex = j + 1;
    //         }
    //     }
    //    // if(subcategory1 == array_data)
    //     var option_str = document.getElementById(catoneid);
    //    // console.log(catone_index);
    //     option_str.length = 0;    // Fixed by Julian Woods
    //     option_str.options[0] = new Option('Select Sub Category 1', '');
    //     option_str.selectedIndex = 0;
    //     var state_arr = array_data[pickedIndex].split("|");
    //     for (var i = 0; i < state_arr.length; i++) {
    //         option_str.options[option_str.length] = new Option(state_arr[i], state_arr[i]);
    //         if (state_arr[i] == selectedcatone)
    //             option_str.selectedIndex = i + 1;
    //     }
    //     // $("#vState").selectBox('destroy');
    //     // $("#vState").selectBox();
    // }
});

$('#consumption_model').on('show.bs.modal', function () {
    var rowCount = $('.cart_cust_body tr').length;
    if (rowCount > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
});
$('.send_mail').on('show.bs.modal', function () {
    // alert("hi");return false;
    var rowCount = $('.cart_cust_body tr').length;
    if (rowCount > 0)
    {
        if ($("#search_customer").val() != "")
        {
            return true;
        }
        else
        {
            swal("Error!", "Please enter email in search box", "error");
            return false;
        }
    }
    else
    {
        swal("Error!", "Please select at least one product", "error");
        return false;
    }
});
$('#comment_model_cmt').on('show.bs.modal', function () {
//  alert("hi");return false;
    var rowCount = $('.cart_cust_body tr').length;
    if (rowCount > 0)
    {
        if ($("#search_customer").val() != "")
        {
            return true;
        }
        else
        {
            swal("Error!", "Please enter email in search box", "error");
            return false;
        }
    }
    else
    {
        swal("Error!", "Please select at least one product", "error");
        $("#search_customer").val("");
        return false;
    }
});
/*$('#status_order').on('change', function(){
 if($(this).val() == 7)
 {
 $(".payment_status").show();
 }
 else
 {
 $(".payment_status").hide();
 }
 }) ;*/
// consumption_model
$(".bank_name").hide();
$(".check_number").hide();
$(".received_amount").hide();
$("#payment_type").change(function () {
    // alert($(this).val());
    if ($(this).val() == 1)
    {
        $(".received_amount").show();
        $(".bank_name").hide();
        $(".check_number").hide();
        $("#bank_name").val("");
        $("#check_number").val("");
    }
    else if ($(this).val() == 2)
    {
        $(".bank_name").show();
        $(".check_number").show();
        $(".received_amount").show();
    }
    else if ($(this).val() == "")
    {
        $(".bank_name").hide();
        $(".check_number").hide();
        $(".received_amount").hide();
        $("#bank_name").val("");
        $("#check_number").val("");
        $("#received_amount").val("");
    }
});

$(document).on('change', ".pmt_type", function () {
    var paymentid = $(this).attr('paymentid');
    if($(this).val() == 2)
    {
        $(".payment_model_"+paymentid).modal('show');
    }
});

$(".due_amount").click(function() {
        var payment_id = $(this).attr('paymentid-data');
        var payment_amount = $('#due_amount_'+payment_id).val();
        var paymenttype = $("#payment_type_"+payment_id).val();
        if(paymenttype != "")
        {
            if(paymenttype == 1)
            {
                var payment_type = 'CASH';
                var bank_name = "";
                var check_no = "";
                if(payment_amount != "")
                {
                    var custid = $(this).attr('custid');
                    var form_data = [{"name": "payment_id", "value": payment_id}, {"name": "payment_amount", "value": payment_amount}, {"name": "payment_type", "value": payment_type}, {"name": "bank_name", "value": bank_name}, {"name": "check_no", "value": check_no}];
                        $.ajax({
                            url: site_root + "customer/DueAmountPaid",
                            type: "POST",
                            data: form_data,
                            success: function (msg) {
                                // alert(msg); return false;
                                if(msg == 1)
                                {
                                    var rcvamt = $("#rcv_amt_"+payment_id).val();
                                    var rstamt = $("#rst_amt_"+payment_id).val();
                                    var rcvplus = parseFloat(rcvamt) + parseFloat(payment_amount);
                                    var rstminus = parseFloat(rstamt) - parseFloat(payment_amount);
                                    var cur_type = $("#cur_type").val();
                                    $('#due_amount_'+payment_id).val("");
                                    $(".receive_amount_"+payment_id).html(cur_type+' '+rcvplus);
                                    $(".rest_amount_"+payment_id).html(cur_type+' '+rstminus);
                                    $('.payment_success').show();
                                    $('.pmt_type').prop('selectedIndex',0);
                                    $(".msgsuccess").html('Payment updated successfully');
                                }
                                else if(msg == 0)
                                {
                                    $('.payment_error').show();
                                    $(".msgerror").html('There is some problem in update payment');
                                    interval = function () {
                                       $(".payment_error").css('cssText', 'display:none !important;');
                                    }
                                    setInterval(interval, 4000);
                                    $('html, body').animate({
                                        scrollTop: 0,
                                    }, 800);
                                }
                            }
                        });
                }
                else
                {
                    // swal("Error!", "Please enter due amount", "error");
                    $('.payment_error').show();
                    $(".msgerror").html('Please enter due amount');
                    interval = function () {
                       $(".payment_error").css('cssText', 'display:none !important;');
                    }
                    setInterval(interval, 4000);
                    $('html, body').animate({
                        scrollTop: 0,
                    }, 800);
                    return false;
                }
            }
            else if(paymenttype == 2)
            {
                var payment_type = 'CHECK';
                var bank_name =  $("#bank_name_popup_"+payment_id).val();
                var check_no =  $("#check_number_popup_"+payment_id).val();
                if(check_no != "" && bank_name != "")
                {
                    if(payment_amount != "")
                    {
                        var custid = $(this).attr('custid');
                        var form_data = [{"name": "payment_id", "value": payment_id}, {"name": "payment_amount", "value": payment_amount}, {"name": "payment_type", "value": payment_type}, {"name": "bank_name", "value": bank_name}, {"name": "check_no", "value": check_no}];
                            $.ajax({
                                url: site_root + "customer/DueAmountPaid",
                                type: "POST",
                                data: form_data,
                                success: function (msg) {
                                    // alert(msg); return false;
                                    if(msg == 1)
                                    {
                                        var rcvamt = $("#rcv_amt_"+payment_id).val();
                                        var rstamt = $("#rst_amt_"+payment_id).val();
                                        var rcvplus = parseFloat(rcvamt) + parseFloat(payment_amount);
                                        var rstminus = parseFloat(rstamt) - parseFloat(payment_amount);
                                        var cur_type = $("#cur_type").val();
                                        $('#due_amount_'+payment_id).val("");
                                        $(".receive_amount_"+payment_id).html(cur_type+' '+rcvplus);
                                        $(".rest_amount_"+payment_id).html(cur_type+' '+rstminus);
                                        $('.payment_success').show();
                                        $('.pmt_type').prop('selectedIndex',0);
                                        $(".msgsuccess").html('Payment updated successfully');
                                    }
                                    else if(msg == 0)
                                    {
                                        $('.payment_error').show();
                                        $(".msgerror").html('There is some problem in update payment');
                                        interval = function () {
                                           $(".payment_error").css('cssText', 'display:none !important;');
                                        }
                                        $('html, body').animate({
                                            scrollTop: 0,
                                        }, 800);
                                        setInterval(interval, 4000);
                                    }
                                }
                            });
                    }
                    else
                    {
                        swal("Error!", "Please enter due amount", "error");
                        interval = function () {
                           $(".payment_error").css('cssText', 'display:none !important;');
                        }
                        setInterval(interval, 4000);
                        $('html, body').animate({
                            scrollTop: 0,
                        }, 800);
                        return false;
                    }
                }
                else
                {
                    $('.payment_error').show();
                    $(".msgerror").html('Please enter check details');
                    interval = function () {
                       $(".payment_error").css('cssText', 'display:none !important;');
                    }
                    setInterval(interval, 3000);
                    $('html, body').animate({
                        scrollTop: 0,
                    }, 800);
                    // $(".payment_model_"+payment_id).modal('show').delay(5000);
                    setTimeout(function() {
                        $(".payment_model_"+payment_id).modal('show');
                    }, 3000);
                    return false;
                }
            }
        }
        else
        {
            $('.payment_error').show();
            $(".msgerror").html('Please select payment type');
            interval = function () {
               $(".payment_error").css('cssText', 'display:none !important;');
           }
           setInterval(interval, 4000);
           $('html, body').animate({
                    scrollTop: 0,
                }, 800);
            return false;
        }
        // alert(payment_amount); return false;
});
$(".product_category").change(function() {
    var catid = $(this).val();
    // alert(catid);
    var form_data = [{"name": "catid", "value": catid}];
    $.ajax({
        url: site_root + "product/changecategory",
        type: "POST",
        data: form_data,
        success: function (msg) {
            // alert(msg); return false;
            if(msg != "")
            {
                $(".sub_category1").html(msg);
            }
            else
            {
                $(".sub_category1").html("");
                $(".sub_category2").html("");
            }
        }
    });
});
$(".sub_category1").change(function() {
    var catid = $(this).val();
    // alert(catid);
    var form_data = [{"name": "catid", "value": catid}];
    $.ajax({
        url: site_root + "product/changecategory",
        type: "POST",
        data: form_data,
        success: function (msg) {
            // alert(msg); return false;
            if(msg != "")
            {
                $(".sub_category2").html(msg);
            }
            else
            {
                $(".sub_category2").html("");
            }
        }
    });
});
