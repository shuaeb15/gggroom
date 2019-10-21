$(document).ready(function(){
    var site_root = $("#site_root").val();
    $(".email_id").blur(function() {
        if($(".email_id").val() != "")
        {
            var email = $(".email_id").val();
            var form_data = [{"name":"email","value":email}];
            $.ajax({
                url: site_root+'user/checkemail',
                type: "POST",
                data: form_data,
                success: function(data) {
                  if(data == 1)
                  {
                    alert("This email is already exist");
                    $(".email_id").val("");
                    return false;
                  }
                }
            });
        }
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
        submitHandler:function(validator, form, submitButton){

        }
    });
});