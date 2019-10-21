var site_url = $("#site_url").val();
$.validator.setDefaults({
    ignore: []
});
jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value !== param;
}, "Please choose a value!");
 jQuery.validator.addMethod("noSpace", function(value, element) {
  return value.indexOf(" ") < 0 && value != "";
}, "No space please and don't leave it empty");
 jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^\w+$/i.test(value);
}, "Letters, numbers, and underscores only please");
jQuery.validator.addMethod('regex', function(value, element, param) {
    return this.optional(element) ||
        value.match(typeof param == 'string' ? new RegExp(param) : param);
},
'Please enter a value in the correct format.');
/*jQuery.validator.addMethod(
      "regex",
      function(value, element, regexp) {
          var check = false;
          var re = new RegExp(regexp);
          return this.optional(element) || re.test(value);
      },"Please enter a value in the correct format."
);*/
jQuery.validator.addMethod("phoneno", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 9 &&
    phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
}, "<br />Please specify a valid phone number");
$("#register_user").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        fname: {
            required: true
        },
        lname: {
            required: true
        },
        mobile: {
            required: true
        },
        uname: {
          required: true,
          minlength: 6,
          noSpace: true,
          alphanumeric: true,
          remote: {
			         url: site_url + "Login/checkUniqueusername/user/username",
			         type: "post",
			         data: {
				           username: function(){ return $("#uname").val(); }
			          }
		       }
        },
        u_email: {
          required: true,
          email: true,
          remote: {
			         url: site_url + "Login/checkUnique/user/email",
			         type: "post",
			         data: {
				           email: function(){ return $("#u_email").val(); }
			          }
		       }
        },
        pwd: {
          required: true,
          minlength: 6
        },
        c_pwd: {
             required: true,
             minlength: 6,
             equalTo: "#pwd"
        },
        radio_gender: {
            required: true
        },
    },
    messages: {
        fname: "Please enter your firstname",
        lname: "Please enter your lastname",
        mobile: "Please enter your mobile no.",
        u_email: {
                required: "Please enter your email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
        uname: {
                required: "Please enter your username",
                minlength: "Your username must consist of at least 6 characters",
                remote: "Username already exist"
            },
            pwd: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"

            },
            c_pwd: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
            },
            radio_gender: "Please select gender",
    },
});

$("#login_user").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        uname: {
          required: true,
        },
        pwd: {
          required: true,
          minlength: 6
        },
    },
    messages: {
        uname: {
                required: "Please enter your username",
            },
            pwd: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"

            },
    },
});

$("#change_pwd_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
      current_pwd: {
        required: true,
        minlength: 6,
        remote: {
             url: site_url + "Login/check_old_password/user/password",
             type: "post",
             data: {
                 password: function(){ return $("#current_pwd").val(); }
              }
         }
      },
      pwd: {
        required: true,
        minlength: 6
      },
      c_pwd: {
           required: true,
           minlength: 6,
           equalTo: "#pwd"
      },
    },
    messages: {
      current_pwd: {
        required: "Please provide current password",
        minlength: "Your password must be at least 6 characters long",
        remote: "Entered password is not matching your Current password"
      },
      pwd: {
          required: "Please provide a password",
          minlength: "Your password must be at least 6 characters long"

      },
      c_pwd: {
          required: "Please provide confirm password",
          minlength: "Your password must be at least 6 characters long",
          equalTo: "Please enter the same password as above"
      },
    },
});

$("#forgot_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
      recovery_email: {
        required: true,
        email: true,
        remote: {
             url: site_url + "Login/check_recovery_email/user/email",
             type: "post",
             data: {
                 email: function(){ return $("#recovery_email").val(); }
              }
         }
      },
    },
    messages: {
      recovery_email: {
              required: "Please enter your email",
              email: "Please enter a valid email address",
              remote: "Email address does not exist in database, please sign up."
          },
    },
});

$("#reset_pwd_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
      pwd: {
        required: true,
        minlength: 6
      },
      c_pwd: {
           required: true,
           minlength: 6,
           equalTo: "#pwd"
      },
    },
    messages: {
      pwd: {
          required: "Please provide a password",
          minlength: "Your password must be at least 6 characters long"

      },
      c_pwd: {
          required: "Please provide confirm password",
          minlength: "Your password must be at least 6 characters long",
          equalTo: "Please enter the same password as above"
      },
    },
});

$("#edit_user").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        fname: {
            required: true
        },
        lname: {
            required: true
        },
        u_email: {
          required: true,
          email: true,
          remote: {
			         url: site_url + "Profile/checkUnique/user/email",
			         type: "post",
			         data: {
				           email: function(){ return $("#u_email").val(); }
			          }
		       }
        },
        zipcode: {
            // required: true,
            zipcodeUS: true
        },
        radio_gender: {
            required: true
        },
    },
    messages: {
        fname: "Please enter your firstname",
        lname: "Please enter your lastname",
        u_email: {
                required: "Please enter your email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
        },
        zipcode: {
            // required: "Please enter zipcode",
            zipcodeUS: "Invalid zip code"
        },
        radio_gender: "Please select gender",
    },
});

$("#add_shop").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        shop_name: {
            required: true
        },
        shop_email: {
          required: true,
          email: true,
          remote: {
			         url: site_url + "Shop/checkUniqueadd_email/shop/shop_email",
			         type: "post",
			         data: {
				           email: function(){ return $("#shop_email").val(); },
			          }
		       }
        },
        mobile_no: {
            required: true,
            phoneno:true
        },
        // shop_title: {
        //     required: true
        // },
        address_1: {
            required: true
        },
        "city[]": {
            required: true
        },
        state: {
            required: true
        },
        zipcode: {
            required: true,
            zipcodeUS: true
        },
        discription: {
            required: true,
        },
    },
    messages: {
        shop_name: "Please enter shop name",
        shop_email: {
                required: "Please enter shop email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
        mobile_no: "Please enter valid mobile no",
        // shop_title: "Please enter shop title",
        address_1: "Please enter address",
        "city[]": "Please enter city",
        state: "Please select state",
        zipcode: {
                required: "Please enter zipcode",
                zipcodeUS: "Invalid zip code"
            },
        discription: "Please enter description",
    },
    errorPlacement: function(error, element) {
     if (element.attr("name") == "city[]") {
         error.insertAfter( $(".ui-multiselect") );
         // just another example
         // $("#yetAnotherPlace").html( error );
     } else {
         error.insertAfter(element);
     }
   }
});

$("#edit_shop").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        shop_name: {
            required: true
        },
        shop_email: {
          required: true,
          email: true,
          remote: {
			         url: site_url + "Shop/edit_checkUniqueadd_email/shop/shop_email",
			         type: "post",
			         data: {
				           email: function(){ return $("#shop_email").val(); },
                   id: function(){ return $("#shop_id").val(); }
			          }
		       }
        },
        mobile_no: {
            required: true,
            phoneno:true
        },
        // shop_title: {
        //     required: true
        // },
        address_1: {
            required: true
        },
        "city[]": {
            required: true
        },
        state: {
            required: true
        },
        zipcode: {
            required: true,
            zipcodeUS: true
        },
        discription: {
            required: true,
        },
    },
    messages: {
        shop_name: "Please enter shop name",
        shop_email: {
                required: "Please enter shop email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
        mobile_no: "Please enter valid mobile no",
        // shop_title: "Please enter shop title",
        address_1: "Please enter address",
        "city[]": "Please enter city",
        state: "Please select state",
        zipcode: {
                required: "Please enter zipcode",
                zipcodeUS: "Invalid zip code"
            },
        discription: "Please enter description",
    },
    errorPlacement: function(error, element) {
     if (element.attr("name") == "city[]") {
         error.insertAfter( $(".ui-multiselect") );
         // just another example
         // $("#yetAnotherPlace").html( error );
     } else {
         error.insertAfter(element);
     }
   }
});

$("#add_worker").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        worker_name: {
            required: true
        },
        worker_mobile: {
            required: true,
            // regex:"([0-9]{10})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})",
            phoneno:true
        },
        // all_time1: {
        //     required: true
        // },
        // all_time2: {
        //     required: true
        // },
        worker_email: {
          required: true,
          email: true,
          // remote: {
			    //      url: site_url + "Worker/checkUniqueadd_email/workers/email",
			    //      type: "post",
			    //      data: {
				  //          email: function(){ return $("#worker_email").val(); },
			    //       }
		      //  }
        },
        worker_percentage: {
          min: 0,
          max: 100,
      },
    },
    messages: {
        worker_name: "Please enter worker name",
        worker_mobile: "Please enter valid mobile no",
        // all_time1: "Please select from time",
        // all_time2: "Please select to time",
        worker_email: {
                required: "Please enter worker email",
                email: "Please enter a valid email address",
                // remote: "Email already exist"
            },
        worker_percentage: {
            min: "Please enter a value more than or equal to 0.",
            max: "Please enter a value less than or equal to 100.",
        },
    },
});

$("#edit_worker").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        worker_name: {
            required: true
        },
        worker_mobile: {
            required: true,
            phoneno:true
        },
        // all_time1: {
        //     required: true
        // },
        // all_time2: {
        //     required: true
        // },
        worker_email: {
          required: true,
          email: true,
          remote: {
			         url: site_url + "Worker/checkUniqueemail/workers/email",
			         type: "post",
			         data: {
				           email: function(){ return $("#worker_email").val(); },
                   id: function(){ return $("#worker_id").val(); }
			          }
		       }
        },
        worker_percentage: {
          min: 0,
          max: 100,
      },
    },
    messages: {
        worker_name: "Please enter worker name",
        worker_mobile: "Please enter valid mobile no",
        // all_time1: "Please select from time",
        // all_time2: "Please select to time",
        worker_email: {
            required: "Please enter worker email",
            email: "Please enter a valid email address",
            remote: "Email already exist"
        },
        worker_percentage: {
            min: "Please enter a value more than or equal to 0.",
            max: "Please enter a value less than or equal to 100.",
        },
    },
});

$("#default_card_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        card_number: {
            required: true
        },
        card_name: {
            required: true
        },
        exp_date: {
            required: true
        },
        card_cvv: {
            required: true
        },
    },
    messages: {
        card_number: "Please enter valid card number",
        card_name: "Please enter cardholder's name",
        exp_date: "Please select expiry date",
        card_cvv: "Please enter valid cvv",
    },
});

$("#change_email_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
      u_email: {
        required: true,
        email: true,
        remote: {
             url: site_url + "Profile/checkUnique/user/email",
             type: "post",
             data: {
                 email: function(){ return $("#u_email").val(); }
              }
         }
      },
    },
    messages: {
      u_email: {
          required: "Please enter your email",
          email: "Please enter a valid email address",
          remote: "Email already exist"
      },
    },
});

$("#add_s_cat").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        add_parent_category: {
          remote: {
			         url: site_url + "Category/check_cat_name/category/cat_name",
			         type: "post",
			         data: {
				           cat_name: function(){ return $("#add_parent_category").val(); },
			          }
		       }
        },
        add_sub_category: {
          remote: {
			         url: site_url + "Category/check_cat_name/category/cat_name",
			         type: "post",
			         data: {
				           cat_name: function(){ return $("#add_sub_category").val(); },
			          }
		       }
        },
        add_child_category: {
          remote: {
			         url: site_url + "Category/check_cat_name/category/cat_name",
			         type: "post",
			         data: {
				           cat_name: function(){ return $("#add_child_category").val(); },
			          }
		       }
        },
    },
    messages: {
        add_parent_category: {
                remote: "Category name already exist"
          },
        add_sub_category: {
                remote: "Category name already exist"
          },
        add_child_category: {
                remote: "Category name already exist"
          },
    },
});

$("#add_offer_view").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        offer_code: {
            required: true,
            noSpace1:true,
            accept: true
        },
        discount_type: {
            required: true
        },
        price: {
            required: true
        },
        // service_name: {
        //     required: true
        // },
    },
    messages: {
        offer_code:{
            required: "Please enter offer code",
            noSpace1: "No space allowed",
            accept: "Please enter only letters or numbers"
        },
        discount_type: "Please select discount type",
        price: "Please enter price",
        // service_name: "Please select service",
    },
});

$("#add_document").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        doc_caption: {
            required: true
        },
        doc_type: {
            required: true
        },
    },
    messages: {
        doc_caption: "Please enter caption",
        doc_type: "Please select document type",
    },
});

$("#shop_varification").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
      recovery_email: {
        required: true,
        email: true,
      },
    },
    messages: {
      recovery_email: {
          required: "Please enter your email",
          email: "Please enter a valid email address",
      },
    },
});

$.validator.addMethod("accept", function(value, element) {
        return this.optional(element) || /^[a-z0-9]+$/i.test(value);
    }, "Please enter only letters or numbers.");

jQuery.validator.addMethod("noSpace1", function(value, element) {
      return value.indexOf(" ") < 0 && value != "";
}, "No space allowed, Please use underscore");

jQuery.validator.addMethod("zipcodeUS", function(value, element) {
    return this.optional(element) || /(^\d{5}$)|(^\d{5}-\d{4}$)/.test(value)
}, "Invalid zip code");
