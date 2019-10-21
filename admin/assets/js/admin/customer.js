$(document).ready(function () {
    var site_root = $("#site_root").val();
    if ($("#admincustomerlisting").length > 0) {
        $('#admincustomerlisting').dataTable({
            "aaSorting": []
        });
    }
    $(".email_id").blur(function () {
        if ($(".email_id").val() != "")
        {
            var email = $(".email_id").val();
            var form_data = [{"name": "email", "value": email}];
            $.ajax({
                url: site_root + 'user/checkemail',
                type: "POST",
                data: form_data,
                success: function (data) {
                    if (data == 1)
                    {
                        alert("This email is already exist");
                        $(".email_id").reset();
                        return false;
                    }
                }
            });
        }
    });
    // $('.sa-warning').click(function(){
    $(document).on('click', ".sa-warning", function () {
        var delid = $(this).attr("data-id");
        var custid = $(this).attr("data-name");

        swal({
            title: "Are you sure you want to delete this Customer?",
            text: "You will not be able to recover this Customer!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": custid}];
            $.ajax({
                url: "deletecustomer",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Deleted!", "Customer has been deleted.", "success");
                    //window.location.href="services";
                }
            });
        });
    });
    // $('.sa-driver-warning').click(function(){
    $(document).on('click', ".sa-driver-warning", function () {
        var delid = $(this).attr("data-id");
        var custid = $(this).attr("data-name");

        swal({
            title: "Are you sure you want to delete this Driver?",
            text: "You will not be able to recover this Driver!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": custid}];
            $.ajax({
                url: "deletedriver",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Deleted!", "Driver has been deleted.", "success");
                    //window.location.href="services";
                }
            });
        });
    });

    $(document).on('click', ".sa-supplier-warning", function () {
        var delid = $(this).attr("data-id");
        var custid = $(this).attr("data-name");

        swal({
            title: "Are you sure you want to delete this Supplier?",
            text: "You will not be able to recover this Supplier!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": custid}];
            $.ajax({
                url: "deletesupplier",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Deleted!", "Supplier has been deleted.", "success");
                    //window.location.href="services";
                }
            });
        });
    });

    $(document).on('click', ".sa-salesperson-warning", function () {
        var delid = $(this).attr("data-id");
        var custid = $(this).attr("data-name");

        swal({
            title: "Are you sure you want to delete this Sales Person?",
            text: "You will not be able to recover this Sales Person!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": custid}];
            $.ajax({
                url: "deletesalesperson",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Deleted!", "Sales Person has been deleted.", "success");
                    //window.location.href="services";
                }
            });
        });
    });

    // $('.sa-dispatch-warning').click(function(){
    $(document).on('click', ".sa-dispatch-warning", function () {
        var delid = $(this).attr("data-id");
        var custid = $(this).attr("data-name");

        swal({
            title: "Are you sure you want to delete this Dispatch?",
            text: "You will not be able to recover this Dispatch!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": custid}];
            $.ajax({
                url: "deletedispatch",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Deleted!", "Dispatch has been deleted.", "success");
                    //window.location.href="services";
                }
            });
        });
    });




    $("#birthdate").datepicker({
//        autoclose: true,
//      minDate: new Date(1900,1-1,1),
//      defaultDate: '-18yr'
        minDate: new Date(1900, 1 - 1, 1), maxDate: '-18Y',
        dateFormat: 'dd/mm/yy',
        defaultDate: new Date(1999, 1 - 1, 1),
        changeMonth: true,
        changeYear: true,
        yearRange: '-110:-18'
    });
    $(function () {
        $('#meeting_date').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '-110:-18'
        });
    });
     $(function () {
        $('#from_date').datepicker({
            changeMonth: true,
            changeYear: true,
//            yearRange: '-110:-18'
//            yearRange: 'c-20:c+20',
        });
    });
     $(function () {
        $('#to_date').datepicker({
            changeMonth: true,
            changeYear: true,
//            yearRange: '-110:-18'
//            yearRange: 'c-20:c+20',

        });
    });
    $(".sales_person").change(function() {
//    alert("hii");
    var customer = $(this).val();
    $("#admincustomerlisting").html('');
//    alert(customer);
//    alert(cust);
    var form_data = [{"name": "customer", "value": customer}];
//    alert(form_data);
    $.ajax({
        url: site_root + "sales/customer_report",
        type: "POST",
        dataType:'html',
        data: form_data,
        success: function (data) {
//            var data=JSON.parse(data);
             console.log(data);
            if(data)
            {
                $("#admincustomerlisting").html(data);
            }
           else{
                alert('err');
           }
        }
    });
});

$('#send').click(function(){
 var customer = $('#customer').val();
// alert(customer);
 var from_date=$("#from_date").val();
// alert(from_date);
 var to_date=$("#to_date").val();
// alert(to_date);
    $("#admincustomerlisting").html('');
//    alert(customer);
//    alert(cust);
    var form_data = [{"name": "customer", "value": customer},{"name": "from_date", "value": from_date},{"name": "to_date", "value": to_date}];
//    alert(form_data);
    $.ajax({
        url: site_root + "sales/customer_date_report",
        type: "POST",
        dataType:'html',
        data: form_data,
        success: function (data) {
//            var data=JSON.parse(data);
             console.log(data);
            if(data)
            {
                $("#admincustomerlisting").html(data);
            }
           else{
                alert('err');
           }
        }
    });
});

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#pro_image').attr('src', e.target.result);
                $('#pro_image').show();
                $('.remove_pict').show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#profile_picture").change(function () {
        readURL(this);
    });
    $(".remove_pict").click(function () {
        $('#pro_image').hide();
        $('#pro_image').attr('src', "");
        $('#profile_picture').val("");
        $('.remove_pict').hide();
    });


    $('#frmadmin_cust_register').bootstrapValidator({

        feedbackIcons: {
            valid: 'fa',
            invalid: 'err',
            validating: 'fa'
        },
//        feedbackIcons: {
//            valid: 'glyphicon glyphicon-ok',
//            invalid: 'glyphicon glyphicon-remove',
//            validating: 'glyphicon glyphicon-refresh'
//        },
        fields: {
            first_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter First Name'
                    },
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'The First Name can consist of alphabetical characters and spaces only'
                    }
                }
            },
            last_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Last Name'
                    },
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'The Last Name can consist of alphabetical characters and spaces only'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Email'
                    }
                }
            },
            profile_picture: {
                validators: {
                    notEmpty: {
                        message: 'Please select an image'

                    },
                    file: {
                        extension: 'jpeg,jpg,png,gif',
                        type: 'image/jpeg,image/png,image/gif',
                        maxSize: 2097152, // 2048 * 1024
                        message: 'The selected file is not valid .Please Select Only Images'
                    }
                }
            },
            phone_number: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Phone Number'
                    },
                    stringLength: {
                        min: 10,
                        max: 12,
                        message: 'The Phone Number has to be 10 or 12 digits'
                    }
                }
            },
//            date: {
//                validators: {
//                    date: {
//                        format: 'DD/MM/YYYY',
//                        message: 'The format is dd/mm/yyyy'
//                    },
//                    notEmpty: {
//                        message: 'The field can not be empty'
//                    }
//                }
//            },

//             date: {
//                 validators: {
//                     notEmpty: {
//                         message: 'Please select Birthdate'
//                     }
//                 }
//             },
            address1: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Address1'
                    }
                }
            },
            shop: {
                validators: {
                    notEmpty: {
                        message: 'Please enter shop'
                    }
                }
            },
            address2: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Address2'
                    }
                }
            },
            country: {
                validators: {
                    notEmpty: {
                        message: 'Please select Country'
                    }
                }
            },
            state: {
                validators: {
                    notEmpty: {
                        message: 'Please enter State'
                    }
                }
            },
            city: {
                validators: {
                    notEmpty: {
                        message: 'Please enter City'
                    },
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: 'The City Name can consist of alphabetical characters and spaces only'
                    }
                }
            },
            zipcode: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Zipcode'
                    }
                }
            },
        },
        submitHandler: function (validator, form, submitButton) {

        }
    });
});
var countrydata = $("#countrydata").val();
var statedata = $("#statedata").val();
putAllCountryOptions("country", countrydata, "state", statedata);

$("#country").change(function () {
    putAllStateOptions("state", $(this).prop("selectedIndex"));
});



//$(document).ready(function() {
//    $('#datePicker')
//        .datepicker({
//            autoclose: true,
//            format: 'mm/dd/yyyy'
//        })
//        .on('changeDate', function(e) {
//            // Revalidate the date field
//            $('#frmadmin_dispatch_team').formValidation('revalidateField', 'date');
//        });
//    });

$('#frmadmin_dispatch_team').bootstrapValidator({
//    framework: 'bootstrap',
//        icon: {
//            valid: 'glyphicon glyphicon-ok',
//            invalid: 'glyphicon glyphicon-remove',
//            validating: 'glyphicon glyphicon-refresh'
//        },
    feedbackIcons: {
        valid: 'fa',
        invalid: 'err',
        validating: 'fa'
    },
    fields: {
        first_name: {
            validators: {
                notEmpty: {
                    message: 'Please enter First Name'
                },
                regexp: {
                    regexp: /^[a-z\s]+$/i,
                    message: 'The First Name can consist of alphabetical characters and spaces only'
                }
            }
        },
        last_name: {
            validators: {
                notEmpty: {
                    message: 'Please enter Last Name'
                },
                regexp: {
                    regexp: /^[a-z\s]+$/i,
                    message: 'The Last Name can consist of alphabetical characters and spaces only'
                }
            }
        },
        email: {
            validators: {
                notEmpty: {
                    message: 'Please enter Email'
                }
            }
        },
        profile_picture: {
            validators: {
                notEmpty: {
                    message: 'Please select an image'

                },
                file: {
                    extension: 'jpeg,jpg,png,gif',
                    type: 'image/jpeg,image/png,image/gif',
                    maxSize: 2097152, // 2048 * 1024
                    message: 'The selected file is not valid'
                }
            }
        },
        phone_number: {
            validators: {
                notEmpty: {
                    message: 'Please enter Phone Number',
                },
                stringLength: {
                    min: 10,
                    max: 12,
                    message: 'The Phone Number has to be 10 or 12 digits'
                }

            }
        },
//            date: {
//                validators: {
//                    notEmpty: {
//                        message: 'The date is required'
//                    },
//                    date: {
//                        format: 'MM/DD/YYYY',
//                        min: '01/01/2010',
//                        max: '12/30/2020',
//                        message: 'The date is not a valid'
//                    }
//                }
//            },
//             date: {
//                 validators: {
//                     notEmpty: {
//                         message: 'Please select Birthdate'
//                     }
//                 }
//             },

        shop: {
            validators: {
                notEmpty: {
                    message: 'Please enter shop'
                }
            }
        },
        address1: {
            validators: {
                notEmpty: {
                    message: 'Please enter Address1'
                }
            }
        },
        address2: {
            validators: {
                notEmpty: {
                    message: 'Please enter Address2'
                }
            }
        },
        country: {
            validators: {
                notEmpty: {
                    message: 'Please select Country'
                }
            }
        },
        state: {
            validators: {
                notEmpty: {
                    message: 'Please enter State'
                }
            }
        },
        city: {
            validators: {
                notEmpty: {
                    message: 'Please enter City'
                },
                regexp: {
                    regexp: /^[a-z\s]+$/i,
                    message: 'The City Name can consist of alphabetical characters and spaces only'
                }
            }
        },
        zipcode: {
            validators: {
                notEmpty: {
                    message: 'Please enter Zipcode'
                }
            }
        },
    },
    submitHandler: function (validator, form, submitButton) {

    }
});

jQuery("#profile_picture").change(function () {

    var val = jQuery(this).val();

    switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
        case 'gif':
        case 'jpg':
        case 'png':
            jQuery('.err').val('');
//            alert("an image");
            break;
        default:
            jQuery(this).val('');
            jQuery('.err').html('<p style="color:red;margin: 41px 0px 0 260px;">not an image</p>');
            myFunction();

            break;
    }
});
function myFunction() {
    setTimeout(function () {
        jQuery('.err').html('');
        ;
    }, 15000);
}
