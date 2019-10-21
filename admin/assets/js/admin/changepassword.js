$(document).ready(function(){
    $('#frmadmin_change_pass').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa',
            invalid: 'err',
            validating: 'fa'
        },
        fields: {
            password: {
                validators: {
                    notEmpty: {
                        message: 'Please enter New Password'
                    }
                }
            },
            password2: {
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
        },
        submitHandler:function(validator, form, submitButton){

        }
    });
});