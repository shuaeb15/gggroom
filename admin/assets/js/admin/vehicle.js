$('#frm_vehicle').bootstrapValidator({

    feedbackIcons: {
        valid: 'fa',
        invalid: 'err',
        validating: 'fa'
    },
    fields: {
        vehicle_number: {
            validators: {
                notEmpty: {
                    message: 'Please enter Vehicle Name'
                }
            }
        },
        vehicle_type: {
            validators: {
                notEmpty: {
                    message: 'Please enter Vehicle Type'
                }
            }
        },
        company_name: {
            validators: {
                notEmpty: {
                    message: 'Please enter Company Name'
                }
            }
        }
      
    },
    submitHandler: function (validator, form, submitButton) {

    }
});