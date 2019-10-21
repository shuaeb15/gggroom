$(document).ready(function($) {
  var site_url = $("#site_url").val();

  // $(".heart_like_dislike").on("click", function() {
  $(document).on('click', ".heart_like_dislike", function () {
    var shopid = $(this).attr('data-shopid');
    var serviceid = $(this).attr('data-serviceid');
    var userid = $(this).attr('data-userid');

    // alert(shopid); return false;
    var current = this;
    if($(this).hasClass("fa-heart-o"))
    {
      if(shopid != undefined)
      {
        var form_data = [{"name": "shopid","value": shopid},{"name": "serviceid","value": serviceid}];
        $.ajax({
            url: site_url + 'favourite/AddToFav',
            type: "POST",
            data: form_data,
            success: function(data) {
                if($.trim(data) == "1")
                {
                  $(current).removeClass("fa-heart-o");
                  $(current).addClass("fa-heart");
                }
                if($.trim(data) == "2")
                {
                  window.location.href = site_url + "login";
                }
            }
        });
      }
      else
      {
        $(current).removeClass("fa-heart-o");
        $(current).addClass("fa-heart");
      }
    }
    else
    {
      if(shopid != undefined)
      {
        var form_data = [{"name": "shopid","value": shopid},{"name": "serviceid","value": serviceid}];
        $.ajax({
            url: site_url + 'favourite/AddToFav',
            type: "POST",
            data: form_data,
            success: function(data) {
                if($.trim(data) == "1")
                {
                  $(current).removeClass("fa-heart");
                  $(current).addClass("fa-heart-o");
                  if($(current).closest('.favourite_view').length)
                  {
                    $(current).parents('.favourite_view').fadeOut();
                  }
                }
            }
        });
      }
      else
      {
        $(current).removeClass("fa-heart");
        $(current).addClass("fa-heart-o");
      }
    }
  });


});
