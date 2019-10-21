$(document).ready(function(){
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