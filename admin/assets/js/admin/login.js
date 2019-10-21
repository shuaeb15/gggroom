$(document).ready(function () {
    var site_root = $("#hidden_root").val();


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

    // $('#single_cal3').daterangepicker({
    // singleDatePicker: true,
    // calender_style: "picker_3"
    // }, function(start, end, label) {
    // console.log(start.toISOString(), end.toISOString(), label);
    // });

    $('#frmadmin_login').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa',
            invalid: 'err',
            validating: 'fa'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Email'
                    },
                    emailAddress: {
                        message: 'Please enter valid Email'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Password'
                    },
                    stringLength: {
                        min: 6,
                        max: 16,
                        message: 'Password between 6 to 16 character long'
                    }
                }
            },
        },
        submitHandler: function (validator, form, submitButton) {

        }
    });
    // $("#email").focusout(function() {
    //     $('#frmadmin_reg').bootstrapValidator('revalidateField', 'email');
    // });
    $("#birthdate").datepicker({
        autoclose: true
    });
    $('#frmadmin_forgotpassword').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa',
            invalid: 'err',
            validating: 'fa'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Email'
                    },
                    emailAddress: {
                        message: 'Please enter valid Emailid'
                    }
                }
            },
        },
        submitHandler: function (validator, form, submitButton) {

        }
    });
//    $(document).ready(function () {
        $("#frmadmin_cust_reg").validate({
            focusInvalid: false,
            rules: {
                first_name: {required: true},
                last_name: {required: true},
                email: {required: true, email: true},
                phone_number: {required: true},
                address1: {required: true},
                country: {required: true},
                state: {valueNotEquals: ""},
                city: {required: true},
                zipcode: {required: true},
                password: {required: true, minlength: 5},
                confirm_pass: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                }
            },
            messages: {
                first_name: {required: "Please enter First Name"},
                last_name: {required: "Please enter Last Name"},
                email: {required: "Please enter Email", email: "Please enter valid Email"},
                phone_number: {required: "Please enter phone number"},
                address1: {required: "Please enter address line1"},
                country: {required: "Please enter country"},
                state: {required: "Please enter state"},
                city: {required: "Please enter city"},
                zipcode: {required: "Please enter PO Box"},
                password: {required: "Please enter password", minlength: "Password must be minimum 5 characters"},
                confirm_pass: {required: "Please enter confirm password", 
                    minlength: "Password must be minimum 5 characters", 
                    equalTo: "Password and confirm password doesnt match"}
            }
        });
//    });
//    $('#frmadmin_cust_reg').bootstrapValidator({
//        feedbackIcons: {
//            valid: 'fa',
//            invalid: 'err',
//            validating: 'fa'
//        },
//        fields: {
//            first_name: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter First Name'
//                    }
//                }
//            },
//            last_name: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Last Name'
//                    }
//                }
//            },
//            email: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Email'
//                    },
//                    emailAddress: {
//                        message: 'Please enter valid Emailid'
//                    }
//                }
//            },
//            password: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Password'
//                    },
//                    stringLength: {
//                        min: 6,
//                        max: 16,
//                        message: 'Password between 6 to 16 character long'
//                    }
//                }
//            },
//            confirm_pass: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Confirm Password'
//                    },
//                    identical: {
//                        field: 'password',
//                        message: 'The password and confirm password are not the same'
//                    }
//                }
//            },
//            phone_number: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Phone Number'
//                    }
//                }
//            },
//            address1: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Address'
//                    }
//                }
//            },
//            country: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please select Country'
//                    }
//                }
//            },
//            state: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter State'
//                    }
//                }
//            },
//            city: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter City'
//                    }
//                }
//            },
//            zipcode: {
//                validators: {
//                    notEmpty: {
//                        message: 'Please enter Zipcode'
//                    }
//                }
//            },
//        },
//        submitHandler: function (validator, form, submitButton) {
//
//        }
//    });
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
//                    alert("This email is already exist");
                        $("#email_error").html("Email address already exists, Please enter different email");
                        $("#email_error").css('cssText', 'text-align:left !important; color:#a94442 !important');
                        $(".email_id").val('');
                        $("#email_error").show();
                        interval = function () {
                            $("#email_error").css('cssText', 'display:none !important;');
                        }
                        setInterval(interval, 3000);
                        return true;
                    } else {
                        $("#email_success").html("Email address available");
                        $("#email_success").css('cssText', 'text-align:left !important; color:#3c763d !important');
                        $("#email_success").show();
                        interval = function () {
                            $("#email_success").css('cssText', 'display:none !important;');
                        }
                        setInterval(interval, 3000);
                    }
                }
            });
        }
    });
});