$(document).ready(function () {
    var site_root = $("#hidden_root").val();
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
                        return false;
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
    $('#frmadmin_reg').bootstrapValidator({
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
                    }
                }
            },
            last_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Last Name'
                    }
                }
            },
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
            phone_number: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Phone Number'
                    }
                }
            },
            date: {
                validators: {
                    notEmpty: {
                        message: 'Please select Birthdate'
                    }
                }
            },
            address1: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Address'
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
    $('#frmadmin_cust_reg').bootstrapValidator({
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
                    }
                }
            },
            last_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Last Name'
                    }
                }
            },
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
            password: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Password'
                    }
                }
            },
            confirm_pass: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Confirm Password'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and confirm password are not the same'
                    }
                }
            },
            phone_number: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Phone Number'
                    }
                }
            },
            date: {
                validators: {
                    notEmpty: {
                        message: 'Please select Birthdate'
                    }
                }
            },
            address1: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Address'
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