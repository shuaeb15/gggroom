var site_url = $("#site_url").val();

jQuery.validator.addMethod("passwordCheck",
function(value, element, param) {
    if (this.optional(element)) {
        return true;
    } else if (!/[A-Z]/.test(value)) {
        return false;
    } else if (!/[0-9]/.test(value)) {
        return false;
    } else if (/^\w+$/.test(value)) {
        return false;
    }

    return true;
},
"Capital letter, numbers, symbols and minimum 8 characters");

$.validator.setDefaults({
    ignore: []
});

jQuery.validator.addMethod("phoneno", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 9 &&
    phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
}, "<br />Please specify a valid phone number");

$('#frm_changepassword').validate({
    rules: {
        n_password: {
            required: true,
        },
        c_password: {
            required: true,
            equalTo: '#n_password',
            minlength: 8,
            maxlength: 15
        }
    }
});
jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value !== param;
}, "Please choose a value!");
$("#frm_user").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        fname: {
            required: true,
            normalizer: function( value ) {
              return $.trim( value );
            }
        },
        lname: {
            required: true,
            normalizer: function( value ) {
              return $.trim( value );
            }
        },
        uname: {
          required: true,
          normalizer: function( value ) {
            return $.trim( value );
          },
          minlength: 6,
          remote: {
			         url: site_url + "User/checkUniqueusername/user/username",
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
			         url: site_url + "User/checkUnique/user/email",
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
        // u_chk: {
        //     required: true,
        //     notEqual:"0"
        // }
    },
    messages: {
        fname: "Please enter your firstname",
        lname: "Please enter your lastname",
        // u_chk: "Please choose any one option",
        u_email: {
                required: "Please enter your email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
        // u_email: "Please enter a valid email address",
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

$("#edit_frm_user").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        fname: {
            required: true,
            normalizer: function( value ) {
              return $.trim( value );
            }
        },
        lname: {
            required: true,
            normalizer: function( value ) {
              return $.trim( value );
            }
        },
        uname: {
          required: true,
          minlength: 6,
          normalizer: function( value ) {
              return $.trim( value );
            }
        },
        u_email: {
          required: true,
          email: true,
          remote: {
               url: site_url + "user/checkUniqueemail/user/email",
               type: "post",
               data: {
                  email: function(){ return $("#u_email").val(); },
                  id: function(){ return $("#user_id").val(); }
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
        // u_chk: {
        //     required: true,
        //     notEqual:"0"
        // }
    },
    messages: {
        fname: "Please enter your firstname",
        lname: "Please enter your lastname",
        // u_chk: "Please choose any one option",
        u_email: {
                required: "Please enter your email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
        // u_email: "Please enter a valid email address",
        uname: {
                required: "Please enter your username",
                minlength: "Your username must consist of at least 6 characters",
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

function UserConfirmDelete(id) {
  swal({
    title: "Are you sure?",
    text: "You want to delete this user",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
          url: site_url + 'User/Delete_user',
          method: "POST",
          data: {id: id},
          async: false,
          success: function (data) {
            // alert(data);
              var obj = JSON.parse(data);
              // alert(obj.success);
              if (obj.success == 'success') {
                // swal("", "User deleted", "success");
                  $('#row_' + obj.id).remove();
                  // $('.r_' + obj.id).remove();
                  $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>User deleted Successfully!</div>');

              }
              else if (obj.unsuccess == 'unsuccess') {
                // swal("Cancelled", "not deleted", "error");
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

              } else {
                // swal("Cancelled", "not deleted", "error");
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
              }
              window.location.href = site_url+"User";
          }
      });
    } else {
      // swal("Cancelled", "not deleted", "error");
    }
  });
}

$("#add_category").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        category_name: {
            required: true,
            normalizer: function( value ) {
              return $.trim( value );
            }
        },
    },
    messages: {
        category_name: "Please enter category name",
    },
});

function CategoryConfirmDelete(id) {
  swal({
    title: "Are you sure?",
    text: "You want to delete this category",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
          url: site_url + 'category/Delete_category',
          method: "POST",
          data: {id: id},
          async: false,
          success: function (data) {
              var obj = JSON.parse(data);
              if (obj.success == 'success') {
                  $('#row_' + obj.id).remove();
                  $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Category deleted Successfully!</div>');
              }
              else if (obj.unsuccess == 'unsuccess') {
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');
              } else if (obj.norecord == 'norecord') {
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Sorry you can not delete this category as it contains sub categories.</div>');
              } else {
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
              }
          }
      });
    } else {
      // swal("Cancelled", "not deleted", "error");
    }
  });
}

function SubcategoryConfirmDelete(id) {
  swal({
    title: "Are you sure?",
    text: "You want to delete this category",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
          url: site_url + 'category/Delete_sub_category',
          method: "POST",
          data: {id: id},
          async: false,
          success: function (data) {
              var obj = JSON.parse(data);
              if (obj.success == 'success') {
                  $('#row_' + obj.id).remove();
                  $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Category deleted Successfully!</div>');
              }
              else if (obj.unsuccess == 'unsuccess') {
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');
              } else if (obj.norecord == 'norecord') {
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Sorry you can not delete this sub category as it contains child category.</div>');
              } else {
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
              }
          }
      });
    } else {
      // swal("Cancelled", "not deleted", "error");
    }
  });
}

function ChildcategoryConfirmDelete(id) {
  swal({
    title: "Are you sure?",
    text: "You want to delete this category",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
          url: site_url + 'category/Delete_child_category',
          method: "POST",
          data: {id: id},
          async: false,
          success: function (data) {
              var obj = JSON.parse(data);
              if (obj.success == 'success') {
                  $('#row_' + obj.id).remove();
                  $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Category deleted Successfully!</div>');
              }
              else if (obj.unsuccess == 'unsuccess') {
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');
              } else {
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
              }
          }
      });
    } else {
      // swal("Cancelled", "not deleted", "error");
    }
  });
}

$("#edit_shop1").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        shop_name: {
            required: true
        },
        shop_email: {
          required: true,
          email: true,
          // remote: {
			    //      url: site_url + "Shop/checkUniqueadd_email/shop/shop_email",
			    //      type: "post",
			    //      data: {
				  //          email: function(){ return $("#shop_email").val(); },
          //          id: function(){ return $("#shop_id").val(); }
			    //       }
		      //  }
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
            required: true
        },
        discription: {
            required: true
        },
    },
    messages: {
        shop_name: "Please enter shop name",
        shop_email: {
                required: "Please enter shop email",
                email: "Please enter a valid email address",
                // remote: "Email already exist"
            },
        mobile_no: "Please enter valid mobile no",
        // shop_title: "Please enter shop title",
        address_1: "Please enter address",
        "city[]": "Please enter city",
        state: "Please select state",
        zipcode: "Please enter zipcode",
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
      percentage: {
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
      percentage: {
          min: "Please enter a value more than or equal to 0.",
          max: "Please enter a value less than or equal to 100.",
      },
  },
});

$("#changepassword_frm").validate({
    rules: {
        password: {
            required: true
        },
        c_password: {
            required: true,
            equalTo: '#password'
        }
    }
});

$("#settings_frm").validate({
    rules: {
        username: {
            required: true
        },
        email: {
            required: true
        }
    }
});

$("#insert_page").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        name: {
            required: true
        },
        title: {
            required: true
        },
        description: {
            required: true
        },
        footer_page:{
            required: true
        },
        page_url: {
          noSpace: true,
          remote: {
			         url: site_url + "page/checkUnique/page/page_url",
			         type: "post",
			         data: {
				           page_url: function(){ return $("#page_url").val(); }
			          }
		       }
        },
    },
    messages: {
        name: "Please enter page name",
        title: "Please enter page title",
        description: "Please enter description",
        footer_page: "Please select footer page option",
        page_url: {
                noSpace: "No space allowed, Please use underscore",
                remote: "Page url already exist",
            },
    },
});

$("#edit_page").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        name: {
            required: true
        },
        title: {
            required: true
        },
        description: {
            required: true
        },
        footer_page:{
            required: true
        },
        page_url: {
          noSpace: true,
          remote: {
			         url: site_url + "page/checkUnique_id/page/page_url",
			         type: "post",
			         data: {
				           page_url: function(){ return $("#page_url").val(); },
                   id: function(){ return $("#page_id").val(); }
			          }
		       }
        },
    },
    messages: {
        name: "Please enter page name",
        title: "Please enter page title",
        description: "Please enter description",
        footer_page: "Please select footer page option",
        page_url: {
                noSpace: "No space allowed, Please use underscore",
                remote: "Page url already exist",
            },
        },
});

$("#add_state_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        state_name: {
            required: true
        },
    },
    messages: {
        state_name: "Please enter state name",
    },
});
$("#edit_state_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        state_name: {
            required: true
        },
    },
    messages: {
        state_name: "Please enter state name",
    },
});

$("#add_city_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        city_name: {
            required: true
        },
    },
    messages: {
        state_name: "Please enter city name",
    },
});
$("#edit_city_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        city_name: {
            required: true
        },
    },
    messages: {
        state_name: "Please enter city name",
    },
});

$("#add_offer_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        offer_code: {
            required: true,
            noSpace:true,
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
            noSpace: "No space allowed",
            accept: "Please enter only letters or numbers"
        },
        discount_type: "Please select discount type",
        price: "Please enter price",
        // service_name: "Please select service",
    },
});

$("#edit_offer_form").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        offer_code: {
            required: true,
            noSpace:true,
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
            noSpace: "No space allowed",
            accept: "Please enter only letters or numbers"
        },
        discount_type: "Please select discount type",
        price: "Please enter price",
        // service_name: "Please select service",
    },
});

$("#add_admin_user").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        fname: {
            required: true,
            normalizer: function( value ) {
              return $.trim( value );
            }
        },
        lname: {
            required: true,
            normalizer: function( value ) {
              return $.trim( value );
            }
        },
        // uname: {
        //   required: true,
        //   normalizer: function( value ) {
        //     return $.trim( value );
        //   },
        //   minlength: 6,
        //   remote: {
			  //        url: site_url + "admin/checkUniqueusername/user/username",
			  //        type: "post",
			  //        data: {
				//            username: function(){ return $("#uname").val(); }
			  //         }
		    //    }
        // },
        u_email: {
          required: true,
          email: true,
          remote: {
			         url: site_url + "admin/checkUnique/admin/email",
			         type: "post",
			         data: {
				           email: function(){ return $("#u_email").val(); }
			          }
		       }
        },
        // pwd: {
        //   required: true,
        //   minlength: 6
        // },
        // c_pwd: {
        //      required: true,
        //      minlength: 6,
        //      equalTo: "#pwd"
        // },
        user_role: {
          required: true,
        },
    },
    messages: {
        fname: "Please enter your firstname",
        lname: "Please enter your lastname",
        // u_chk: "Please choose any one option",
        u_email: {
                required: "Please enter email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
        // u_email: "Please enter a valid email address",
        // uname: {
        //         required: "Please enter username",
        //         minlength: "Your username must consist of at least 6 characters",
        //         remote: "Username already exist"
        //     },
            // pwd: {
            //     required: "Please provide a password",
            //     minlength: "Your password must be at least 6 characters long"
            //
            // },
            // c_pwd: {
            //     required: "Please provide a password",
            //     minlength: "Your password must be at least 6 characters long",
            //     equalTo: "Please enter the same password as above"
            // },
            user_role: "Please select role",
    },
});
$("#edit_admin_user").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        fname: {
            required: true,
            normalizer: function( value ) {
              return $.trim( value );
            }
        },
        lname: {
            required: true,
            normalizer: function( value ) {
              return $.trim( value );
            }
        },
        // uname: {
        //   required: true,
        //   normalizer: function( value ) {
        //     return $.trim( value );
        //   },
        //   minlength: 6,
        //   remote: {
			  //        url: site_url + "admin/checkUniqueusername/user/username",
			  //        type: "post",
			  //        data: {
				//            username: function(){ return $("#uname").val(); }
			  //         }
		    //    }
        // },
        u_email: {
          required: true,
          email: true,
          remote: {
			         url: site_url + "admin/checkUniqueemail/admin/email",
			         type: "post",
			         data: {
				           email: function(){ return $("#u_email").val(); },
                   id: function(){ return $("#user_id").val(); }
			          }
		       }
        },
        // pwd: {
        //   required: true,
        //   minlength: 6
        // },
        // c_pwd: {
        //      required: true,
        //      minlength: 6,
        //      equalTo: "#pwd"
        // },
        user_role: {
          required: true,
        },
    },
    messages: {
        fname: "Please enter your firstname",
        lname: "Please enter your lastname",
        // u_chk: "Please choose any one option",
        u_email: {
                required: "Please enter email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
        // u_email: "Please enter a valid email address",
        // uname: {
        //         required: "Please enter username",
        //         minlength: "Your username must consist of at least 6 characters",
        //         remote: "Username already exist"
        //     },
            // pwd: {
            //     required: "Please provide a password",
            //     minlength: "Your password must be at least 6 characters long"
            //
            // },
            // c_pwd: {
            //     required: "Please provide a password",
            //     minlength: "Your password must be at least 6 characters long",
            //     equalTo: "Please enter the same password as above"
            // },
            user_role: "Please select role",
    },
});

$("#frm_document_type").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        d_name: {
          required: true,
          normalizer: function( value ) {
            return $.trim( value );
          },
          remote: {
			         url: site_url + "document/checkUnique_name/document_type/name",
			         type: "post",
			         data: {
				           d_name: function(){ return $("#d_name").val(); }
			          }
		       }
        },
    },
    messages: {
        d_name: {
                required: "Please enter document type name",
                remote: "This name already exist"
            },
    },
});

$("#edit_frm_document_type").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        d_name: {
          required: true,
          normalizer: function( value ) {
            return $.trim( value );
          },
          remote: {
			         url: site_url + "document/edit_frm_checkUnique_name/document_type/name",
			         type: "post",
			         data: {
				           d_name: function(){ return $("#d_name").val(); },
                   document_id: function(){ return $("#document_id").val(); }
			          }
		       }
        },
    },
    messages: {
        d_name: {
                required: "Please enter document type name",
                remote: "This name already exist"
            },
    },
});

$("#add_shop").validate({
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        shop_name: {
            required: true,
        },
        mobile_no: {
            required: true,
        },
        address_1: {
            required: true,
        },
        "city[]": {
            required: true,
        },
        state: {
            required: true,
        },
        zipcode: {
            required: true,
        },
        discription: {
            required: true,
        },
        shop_email: {
          required: true,
          email: true,
          remote: {
			         url: site_url + "shop/checkUnique_email/shop/shop_email",
			         type: "post",
			         data: {
				           email: function(){ return $("#shop_email").val(); },
			          }
		       }
        },
    },
    messages: {
        shop_name: "Please enter shopname",
        mobile_no: "Please enter mobile no.",
        address_1: "Please enter address.",
        "city[]": "Please select city.",
        state: "Please select state.",
        zipcode: "Please enter zipcode.",
        discription: "Please enter description.",

        shop_email: {
                required: "Please enter email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
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

$.validator.addMethod("accept", function(value, element) {
        return this.optional(element) || /^[a-z0-9]+$/i.test(value);
    }, "Please enter only letters or numbers.");

jQuery.validator.addMethod("noSpace", function(value, element) {
  return value.indexOf(" ") < 0 && value != "";
}, "No space allowed, Please use underscore");
