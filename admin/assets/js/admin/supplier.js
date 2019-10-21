function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

site_root = $("#site_root").val();

$("#purchase_order").change(function() {
        product_id = $(this).val();
        var form_data = [{"name":"product_id","value":product_id}];
        $.ajax({
            url: site_root+"supplier/getpurchaseorderdata",
            type: "POST",
            data: form_data,
            success: function (msg) {
                var product = jQuery.parseJSON(msg);
                $("#product_name").val(product.product_name);
                $("#description").val(product.description);
                $("#quantity").val(product.po_qty);
                //window.location.href="services";
            }
        });
});

$("#convert_qty").click(function() {
        var product_id = $("#purchase_order").val();
        var po_qty = $("#quantity").val();
        var form_data = [{"name":"product_id","value":product_id},{"name":"po_qty","value":po_qty}];
        $.ajax({
            url: site_root+"supplier/ConvertQty",
            type: "POST",
            data: form_data,
            success: function (msg) {
                // alert(msg);return false;
                if(msg = 1)
                {
                    swal({
                        title: "Complete!",
                        text: "Quantity Converted",
                        type: "success",
                        html: true
                        }, 
                   
                     function(){
                    //data: return data from server
                     window.location.href = site_root + 'product/viewproduct'; 
                    });
                    return false;
                }
                else if(msg = 2)
                {
                    swal("Error!", "There is some problem in convert qty", "error");
                    return false;
                }

            }
        });
});

// $('#create-form').bootstrapValidator({
//        
//        feedbackIcons: {
//            valid: 'fa',
//            invalid: 'err',
//            validating: 'fa'
//        },
////        feedbackIcons: {
////            valid: 'glyphicon glyphicon-ok',
////            invalid: 'glyphicon glyphicon-remove',
////            validating: 'glyphicon glyphicon-refresh'
////        },
//        fields: {
//             purchase_id: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Purchase ID'
//                    }
//                }
//            },
//            item: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Item'
//                    }
//                }
//            },
//            product_description: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Product Description'
//                    }
//                }
//            },
//            price: {
//               validators: {
//                   notEmpty: {
//                       message: 'Please enter Product Description'
//
//                   }
//               }
//               },
//            qty: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Phone Qty'
//                    }
//                }
//            }
//
//           
//        },
//        submitHandler: function (validator, form, submitButton) {
//
//        }
//    });
