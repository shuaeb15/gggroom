$(document).ready(function () {
//    var site_root = $("#site_root").val();
//    $(function () {
        $('#report_from').datepicker({
            changeMonth: true,
            changeYear: true
        });
//    });
    
    $("#report_to").datepicker({
        changeMonth: true,
        changeYear: true
    });

    $('#frmadmin_cust_register').bootstrapValidator({

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

$('#frmadmin_dispatch_team').bootstrapValidator({
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
if ($("#misreportstable").length > 0) {
        $('#misreportstable').dataTable({
    searching: false,
    paging: false,
    ordering: false,
    dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
});

    }
/*$("#frmadmin_sales_reports").submit(function (e)
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
                    if(data != "")
                    {
                        $(".reportsdata").html(data);
                        var calculated_total_sum = 0;
                        $(".reportsdata .revenue_hidden").each(function () {
                            var get_textbox_value = $(this).val();
                            // alert(get_textbox_value);
                            if ($.isNumeric(get_textbox_value)) {
                                calculated_total_sum += parseFloat(get_textbox_value);
                            }

                        });
                        curmain = $('.revenue_total').html('<b> AED '+calculated_total_sum+'</b>');
                        return false;
                    }
                    else
                    {
                        $(".reportsdata").html("");
                        swal("Error!", "Please select sales person.", "error");
                    }
                }
            });
    e.preventDefault(); //STOP default action
});*/
var calculated_total_sum = 0;
$(".reportsdata .revenue_hidden").each(function () {
    var get_textbox_value = $(this).val();
    // alert(get_textbox_value);
    if ($.isNumeric(get_textbox_value)) {
        calculated_total_sum += parseFloat(get_textbox_value);
    }

});
curmain = $('.revenue_total').html('<b> AED '+calculated_total_sum+'</b>');
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



     