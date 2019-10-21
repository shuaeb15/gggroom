$(document).ready(function($) {

  $('#OpenImgUpload').click(function() { $('#imgupload').trigger('click'); });
  var site_url = $("#site_url").val();
  /* Chat Page */
  $(window).on("load",function(){

    $(".right-header-contentChat").mCustomScrollbar();
    $(".left-chat").mCustomScrollbar();

    // scrolled bottom by default
     $(".right-header-contentChat").mCustomScrollbar("scrollTo","bottom");

  });


  var height = $(window).height();
    $('.left-chat').css('height', (height - 92) + 'px');
    $('.right-header-contentChat').css('height', (height - 163) + 'px');

    $(document).on('keypress', function(event) {
      var keycode = (event.keyCode ? event.keyCode : event.which);
      if(keycode == '13'){
          // alert($("#messageText").val());
          var senderId = $("#senderId").val();
          var receiverId = $("#receiverId").val();
          // alert(receiverId); return false;
          var msg = $("#messageText").val();
          if($.trim(msg))
          {
            var url = site_url+'chat/SendMessage';
            $.post(url, {submit:1,senderId:senderId,receiverId:receiverId,userMsg:msg}, function(data){
              $("#messageText").val("");
            });

            setTimeout(function () {
              $(".right-header-contentChat").mCustomScrollbar("scrollTo","bottom",{
                  scrollInertia:10
                });
              }, 1000);
          }
          else
          {
            $("#messageText").val("");
          }
      }
    });

    $(document).on('click', "#send", function (event) {
      // alert(keycode);return false;
      var senderId = $("#senderId").val();
      var receiverId = $("#receiverId").val();
      // alert(receiverId); return false;
      var msg = $("#messageText").val();
      if($.trim(msg))
      {
        var url = site_url+'chat/SendMessage';
        $.post(url, {submit:1,senderId:senderId,receiverId:receiverId,userMsg:msg}, function(data){
          $("#messageText").val("");
        });
        // $(".right-header-contentChat").mCustomScrollbar("scrollTo","bottom");
        setTimeout(function () {
          $(".right-header-contentChat").mCustomScrollbar("scrollTo","bottom",{
              scrollInertia:10
            });
          }, 1000);
      }
      else
      {
        $("#messageText").val("");
      }
    });

    setInterval(function () {
        $('.chatsMain').load(site_url+'chat/LoadMessage/'+$("#senderId").val()+'/'+$("#receiverId").val());
    }, 1000);
    if($("#receiverId").val() != "")
    {
      $(".messagebar").show();
    }
    setTimeout(function(){ $(".right-header-contentChat").mCustomScrollbar("scrollTo","bottom"); }, 2000);
    $(document).on('click', "#chatChange", function () {
        var senderId = $(this).attr('data-sender');
        var receiverId = $(this).attr('data-receiver');
        $("#senderId").val(senderId);
        $("#receiverId").val(receiverId);
        var rowCount = $('.left-chat-ul li').length;
        for (var i = 0; i < rowCount; i++) {
           $('.left-chat-ul li').attr('class','');
        }
        $(this).attr('class','active');
        setTimeout(function () {
            $(".right-header-contentChat").mCustomScrollbar("scrollTo","bottom");
        }, 1000);
        $(".noConversation").hide();
        $(".messagebar").show();
    });
    /* Chat Page end*/


    $(document).on('change', "#imgupload", function (e) {

        var files = e.target.files[0];
        var senderId = $("#senderId").val();
        var receiverId = $("#receiverId").val();
        var fd = new FormData();
        fd.append( 'file', files );
        fd.append( 'senderId', senderId );
        fd.append( 'receiverId', receiverId );

        var files1 = $('#imgupload')[0].files;
        var error = '';
        var name = files1[0].name;
        var imageSize = files1[0].size;
        var extension = name.split('.').pop().toLowerCase();

        if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
        {
           error += "Please select only gif, png, jpg or jpeg file"
        }
        if (imageSize > 2097152) {
          error += "Please select image size less than 2 MB"
        }

        if(error == ''){
          $("#overlay").show();
          $.ajax({
              url: site_url + 'chat/uploadChatImage',
              type: "POST",
              data: fd,
              processData: false,
              contentType: false,
              success: function(data) {
                // console.log(data);
                if(data == '1')
                {
                  $("#overlay").hide();
                  setTimeout(function () {
                      $(".right-header-contentChat").mCustomScrollbar("scrollTo","bottom");
                  }, 1000);
                }
                else
                {
                  $("#overlay").hide();
                }
              }
          });
        }else{
          swal({
                title: "",
                text: error,

            }, function () {
              $("#preview_image").attr("src","")

            })
            return false;
        }


        // formData.append("fileUpload", files);

        // var fileName = e.target.files[0].name;
        // alert('The file "' + fileName +  '" has been selected.');
    });
});

// (function($){
//         $(window).on("load",function(){
          // $(".right-header-contentChat").mCustomScrollbar({
          //   callbacks:{
          // onTotalScroll:function(){
          // console.log("Scrolled to end of content.");
          // }
          // }
          // });
    //     });
    // })(jQuery);
