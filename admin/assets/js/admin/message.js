$('#mt').dataTable();

$(document).ready(function () {
    $("#sendMessageForm").validate({
        rules: {
            iReceiverID: {
                required: true
            },
            subject: {
                required: true
            },
            message_text: {
                required: true
            }
        }
    });
});
//if(document.getElementById('mt_length')) {
////    $('#mt_length').html('<h3 class="createnew  btn btn-success" data-toggle="modal" data-target="#myModal">Create new message</h3>');
//$('#mt_length').css('display','none');
//}
    
$("#r_id").autocomplete({
    source: '/phpprojects/osm/Message/Users',
    select: function (event, ui) {
        $("#r_id").val(ui.item.label);
        $("#receiver_id").val(ui.item.key_a);

    },
    change: function (event, ui) {
        if (ui.item) {
            $("#r_id").val(ui.item.label);
            $("#receiver_id").val(ui.item.key_a);

        } else {
            $(".receiver_error").html("<p style='color:red'>Please select a autosuggestion</p>");
            this.value = '';
        }
    },
    focus: function (event, ui) {
        $("#r_id").val(ui.item.label);

    }
});

$(function () {
    setTimeout(function () {
        $('#receiver_error').fadeOut('fast');
    }, 30000);
});
$(".deleteMsg").click(function () {
    if (confirm('Are you sure you want to delete?')) {
        var iParentID = $(this).attr("data-val");
        var msgID = this.id;
        $.post(CI.base_url + "Message/Delete", {iParentID: iParentID}, function (data) {
            if (typeof (data.err) != undefined && $.trim(data.err) == 'Not Delete') {
                $("#msgDiv").html(data.msg);
                return false;
            } else if (typeof (data.succ) != undefined && $.trim(data.succ) == "Valid") {
                $("#msgDiv").html(data.msg);
                $("#msg" + msgID).fadeOut();
            }
        }, 'json');
    }
});
var v =   $("#reply_msg").validate({
                        rules: {
                            message_text:{
                               required: true
                            }
                        }
         });

$('#btn_send_msg').on('click', function (e) {
    e.preventDefault();
    if(!v.form()){ return false;}
    var subject = $('#re_subject').val();
    var parent_id = $('#re_parent_id').val();
    var message_text = $('#message_text').val();
    var senday = $('#senday').val();
    $.ajax({
     type: "POST",
     url: CI.base_url + "Message/reply_msg/"+subject+'/'+parent_id,  
     data: $('#reply_msg').serialize(),
                                        
                                      //  cache: false,
     success: function(data){
//         alert(data);
         if(data == 'success'){
             if(senday != 'Today'){
                  $('.faqboxmid').append('<div class="sysmessagediv" data-value="Today"><span>Today</span></div>');
                  $('#senday').val('Today');
             }
         $('.faqboxmid').append('<div class="wr_right messagediv" data-id="36">\n\
<a href="" class="avatar" target="_blank">\n\
<img src="https://www.liveperk.com/images/avatar_male_light_on_gray_200x200.png" alt="https://www.liveperk.com/images/avatar_male_light_on_gray_200x200.png">\n\
</a>\n\
<div class="bubble">\n\
<p>'+message_text+' </p>\n\
<span class="timespan"> '+time+' </span>\n\
</div><div class="clear">\n\
</div>\n\
</div>');
             $("#reply_msg")[0].reset();
     }
     else{
         $("#reply_msg")[0].reset();
     }
     }
 });

});