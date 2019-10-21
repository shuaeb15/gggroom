$(document).ready(function(){
  $('.cls_delete_profile').click(function() {
    var id = $('#user_id').val();
    swal({
      title: "Are you sure?",
      text: "You want to delete this Profile",
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
            url: site_url + "setting/delete_profile",
            type: 'post',
            data: {id:id},
            success: function (data) {
              window.location.href = site_url;
              // swal({
              //       title: "Deleted!",
              //       text: "Your profile has been deleted.",
              //       confirmButtonText: "ok",
              //       allowOutsideClick: "true"
              //   }, function () {
              //
              //
              //   })
            },
            error: function () {
            }
        });
      } else {
        swal("Cancelled", "Profile not deleted", "error");
      }
    });
  });

  $('#messages_alert').click(function() {
    if ($('#messages_alert').hasClass("messages_notification")) {
    var id = $('#user_id').val();
    var add_alert = '0';
    swal({
      title: "Are you sure?",
      text: "You want to disable messages notification",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, disable",
      cancelButtonText: "No, cancel",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {

        $.ajax({
            url: site_url + "setting/update_message_alert",
            type: 'post',
            data: {id:id, add_alert:add_alert},
            success: function (data) {
              $('#messages_alert').removeClass("messages_notification");
              $('#messages_alert').prop('checked', false);
              // swal("Disable!", "Message notifications are disable.", "success");
            },
            error: function () {
            }
        });
      } else {
        $('#messages_alert').addClass("messages_notification");
        $('#messages_alert').prop('checked', true);
        // swal("Cancelled", "Message notifications are not disable", "error");
      }
    });
  }else{

    var id = $('#user_id').val();
    var add_alert = '1';
    swal({
      title: "Are you sure?",
      text: "You want to enable messages notification",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Yes, enable",
      cancelButtonText: "No, cancel",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {

        $.ajax({
            url: site_url + "setting/update_message_alert",
            type: 'post',
            data: {id:id, add_alert:add_alert},
            success: function (data) {
              $('#messages_alert').prop('checked', true);
              $('#messages_alert').addClass("messages_notification");
              // swal("Enable!", "Message notifications are enable.", "success");
            },
            error: function () {
            }
        });
      } else {
        $('#messages_alert').removeClass("messages_notification");
        $('#messages_alert').prop('checked', false);
        // swal("Cancelled", "Message notifications are not enable", "error");
      }
    });
  }
  });

  $('#reminder_alert').click(function() {

    if ($('#reminder_alert').hasClass("reminder_notification")) {

    var id = $('#user_id').val();
    var add_alert = '0';
    swal({
      title: "Are you sure?",
      text: "You want to disable reminder notification",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, disable",
      cancelButtonText: "No, cancel",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + "setting/update_reminder_alert",
            type: 'post',
            data: {id:id, add_alert:add_alert},
            success: function (data) {
              $('#reminder_alert').removeClass("reminder_notification");
              $('#reminder_alert').prop('checked', false);
              // swal("Disable!", "reminder notifications are disable.", "success");
            },
            error: function () {
            }
        });
      } else {
        $('#reminder_alert').prop('checked', true);
        $('#reminder_alert').addClass("reminder_notification");
        // swal("Cancelled", "reminder notifications are not disable", "error");
      }
    });
  }else{

    var id = $('#user_id').val();
    var add_alert = '1';
    swal({
      title: "Are you sure?",
      text: "You want to enable reminder notification",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Yes, enable",
      cancelButtonText: "No, cancel",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + "setting/update_reminder_alert",
            type: 'post',
            data: {id:id, add_alert:add_alert},
            success: function (data) {
              $('#reminder_alert').addClass("reminder_notification");
              $('#reminder_alert').prop('checked', true);
              // swal("Enable!", "reminder notifications are enable.", "success");
            },
            error: function () {
            }
        });
      } else {
        $('#reminder_alert').removeClass("reminder_notification");
        $('#reminder_alert').prop('checked', false);
        // swal("Cancelled", "reminder notifications are not enable", "error");
      }
    });
  }
  });

  $('#tips_alert').click(function() {

    if ($('#tips_alert').hasClass("tips_notification")) {

    var id = $('#user_id').val();
    var add_alert = '0';
    swal({
      title: "Are you sure?",
      text: "You want to disable promotion & tips notification",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, disable",
      cancelButtonText: "No, cancel",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + "setting/update_tips_alert",
            type: 'post',
            data: {id:id, add_alert:add_alert},
            success: function (data) {
              $('#tips_alert').removeClass("tips_notification");
              $('#tips_alert').prop('checked', false);
              // swal("Disable!", "promotion & tips notifications are disable.", "success");
            },
            error: function () {
            }
        });
      } else {
        $('#tips_alert').addClass("tips_notification");
        $('#tips_alert').prop('checked', true);
        // swal("Cancelled", "promotion & tips notifications are not disable", "error");
      }
    });
  }else{

    var id = $('#user_id').val();
    var add_alert = '1';
    swal({
      title: "Are you sure?",
      text: "You want to enable promotion & tips notification",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Yes, enable",
      cancelButtonText: "No, cancel",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + "setting/update_tips_alert",
            type: 'post',
            data: {id:id, add_alert:add_alert},
            success: function (data) {
              $('#tips_alert').addClass("tips_notification");
              $('#tips_alert').prop('checked', true);
              // swal("Enable!", "promotion & tips notifications are enable.", "success");
            },
            error: function () {
            }
        });
      } else {
        $('#tips_alert').removeClass("tips_notification");
        $('#tips_alert').prop('checked', false);
        // swal("Cancelled", "promotion & tips notifications are not enable", "error");
      }
    });
  }
  });

$('.cls_default_card').click(function() {
  $('#myModal').modal('show');
});

$("#card_number").mask("9999 9999 9999 9999", {
  placeholder: " "
});
$("#exp_date").mask("99/9999", {
  placeholder: " "
});
$("#card_cvv").mask("999", {
  placeholder: " "
});

});
