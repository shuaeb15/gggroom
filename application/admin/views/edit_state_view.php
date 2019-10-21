<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>

<style media="screen">
.cls-chk input{
  width: auto !important;
  height: auto !important;
}
.cls-time-input{
  border-radius: 4px;
  text-align: left;
  border: solid 2px #ccc;
  margin-bottom:10px;
  font-size: 18px;
}
.cl_lbl_time{
    width: 12%;
    font-size:16px;
}
</style>

<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>States</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit State</h2>
            <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <?php if ($this->session->flashdata('error_message')) { ?>
          <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <?php echo $this->session->flashdata('error_message'); ?> </div>
              <?php } ?>
              <?php if ($this->session->flashdata('success_message')) { ?>
              <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                  <?php echo $this->session->flashdata('success_message'); ?> </div>
                    <?php } ?>
                  <div class="x_content">
                    <form enctype="multipart/form-data" method="post" class="form-horizontal" id="edit_state_form" name="edit_state_form" data-toggle="validator" action="<?php echo site_url("location/update_state"); ?>">
                      <input type="hidden" name="state_id" id="state_id" value="<?=$state_list->id?>">
                      <div class="col-md-8 col-xs-12 cls_all">
                         <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">State name</label><br>
                            <div class="col-xs-12">
                              <input id="state_name" class="form-control col-md-7 col-xs-12" name="state_name" type="text" value="<?php if(isset($state_list->name)){ echo $state_list->name;}?>">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12" style="margin-top:15px;">
                          <input type="checkbox" name="add_state_hours" id="add_state_hours" class="css-checkbox add_state_hours" style="width:15px;height:15px;" <?php if(!empty($state_list->start_time)){ echo 'checked';}?>/>
                          <label class="css-label css-label-check" style="margin-bottom: 15px !important;"><span class="form-title" style="font-size: 17px;">Add state working hours</span>
                        </div>
                        <div class="col-md-12 cls_state_hours" style="margin-top:20px;">
                          <label class="css-label css-label-check" style="margin-bottom: 15px !important;"><span class="form-title" style="font-size: 17px;">Working hours</span></label>
                          <div class="col-xs-12 cls-chk">
                            <p id="datepairExample1">
                              <input type="text" class="date start hide">
                              <label class="cl_lbl_time">Start Time</label>
                              <input type="text" class="time start ui-timepicker-input cls-time-input" id="hours_start_time" name="hours_start_time" value="<?php if(!empty($state_list->start_time)){ echo date("g:i A", strtotime($state_list->start_time));}?>"><br>
                              <label class="cl_lbl_time">End Time</label>
                              <input type="text" class="time end ui-timepicker-input cls-time-input" id="hours_end_time" name="hours_end_time" value="<?php if(!empty($state_list->end_time)){ echo date("g:i A", strtotime($state_list->end_time));}?>">
                              <input type="text" class="date end hide">
                            </p>
                          </div>
                        </div>
                        <div class="col-md-12" style="margin-top:20px;">
                          <label class="css-label css-label-check" style="margin-bottom: 15px !important;"><span class="form-title" style="font-size: 17px;">Breaking hours</span></label>
                          <div class="col-xs-12 cls-chk">
                            <p id="datepairExample2">
                              <input type="text" class="date start hide">
                              <label class="cl_lbl_time">Start Time</label>
                              <input type="text" class="time start ui-timepicker-input cls-time-input" id="break_hours_start_time" name="break_hours_start_time" value="<?php if(!empty($state_list->break_start_time)){ echo date("g:i A", strtotime($state_list->break_start_time));}?>"><br>
                              <label class="cl_lbl_time">End Time</label>
                              <input type="text" class="time end ui-timepicker-input cls-time-input" id="break_hours_end_time" name="break_hours_end_time" value="<?php if(!empty($state_list->break_end_time)){ echo date("g:i A", strtotime($state_list->break_end_time));}?>">
                              <input type="text" class="date end hide">
                            </p>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-3" id="eventsExample">
                            <input type="button" onclick="location.href = '<?php echo base_url(); ?>location'" class="btn btn-primary" value="Cancel">
                            <button id="send" type="submit" class="btn btn-success cls_btn_state">Update</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  if(!$(".add_state_hours").is(':checked')){
      $(".cls_state_hours").hide();
  }
  $('.add_state_hours').click(function() {
    if($(".add_state_hours").is(':checked')){
      $(".cls_state_hours").show();
    }else{
      $(".cls_state_hours").hide();
    }
  });

$('#datepairExample1 .time').timepicker({
    'showDuration': true,
    'timeFormat': 'g:i A'
});
$('#datepairExample1').datepair();

$("#hours_start_time").focusout(function(){
  $("#break_hours_start_time").val('');
  $("#break_hours_end_time").val('');
    if($("#hours_start_time").val() != '' && $("#hours_end_time").val() != ''){
      if($("#hours_start_time").val() == $("#hours_end_time").val())
      {
        setTimeout(function(){
          swal("", "You can't select less time, Please select another time.");
          $("#hours_start_time").val('');
        }, 500);
      }
    }
});

  $("#hours_end_time").focusout(function(){
    $("#break_hours_start_time").val('');
    $("#break_hours_end_time").val('');
    if($("#hours_start_time").val() != '' && $("#hours_end_time").val() != ''){
      if($("#hours_start_time").val() == $("#hours_end_time").val())
      {
        setTimeout(function(){
          swal("", "You can't select less time, Please select another time.");
          $("#hours_end_time").val('');
        }, 500);
      }
  }
});

$('#datepairExample2 .time').timepicker({
    'showDuration': true,
    'timeFormat': 'g:i A'
});
$('#datepairExample2').datepair();

$("#break_hours_start_time").focusout(function(){
    if($("#break_hours_start_time").val() != '' && $("#break_hours_end_time").val() != ''){
      if($("#break_hours_start_time").val() == $("#break_hours_end_time").val())
      {
        setTimeout(function(){
          swal("", "You can't select less time, Please select another time.");
          $("#break_hours_start_time").val('');
        }, 500);
      }
    }
});

  $("#break_hours_end_time").focusout(function(){
    if($("#break_hours_start_time").val() != '' && $("#break_hours_end_time").val() != ''){
      if($("#break_hours_start_time").val() == $("#break_hours_end_time").val())
      {
        setTimeout(function(){
          swal("", "You can't select less time, Please select another time.");
          $("#break_hours_end_time").val('');
        }, 500);
      }
  }
});

  $(document).on('click', ".cls_btn_state", function () {

      if($(".cls_state_hours").is(':visible')){
        var starttime = $('#hours_start_time').val();
        var endtime = $('#hours_end_time').val();

        if(starttime == ''){
          swal({
                title: "",
                text: "Please select working hours start time",

            }, function () {
              $('html, body').animate({
                      scrollTop: $('.cls_all').offset().top
                  }, 'slow');
            })
            return false;
        }
        else if(endtime == ''){
          swal({
                title: "",
                text: "Please select working hours end time",

            }, function () {
              $('html, body').animate({
                      scrollTop: $('.cls_all').offset().top
                  }, 'slow');
            })
            return false;
        }
      }
      var break_start_time = $('#break_hours_start_time').val();
      var break_end_time = $('#break_hours_end_time').val();
      if(break_start_time == ''){
        swal({
              title: "",
              text: "Please select break hours start time",

          }, function () {
            $('html, body').animate({
                    scrollTop: $('.cls_all').offset().top
                }, 'slow');
          })
          return false;
      }
      else if(break_end_time == ''){
        swal({
              title: "",
              text: "Please select break hours end time",

          }, function () {
            $('html, body').animate({
                    scrollTop: $('.cls_all').offset().top
                }, 'slow');
          })
          return false;
      }
    });
  $("#hours_start_time").focusout(function(){
    var start_time = $("#hours_start_time").val();
    var end_time = $("#hours_end_time").val();
      if(start_time != '' && end_time != ''){
        $('#datepairExample2 .time').timepicker('option', 'minTime', start_time);
        $('#datepairExample2 .time').timepicker('option', 'maxTime', end_time);
      }
  });
  $("#hours_end_time").focusout(function(){
    var start_time = $("#hours_start_time").val();
    var end_time = $("#hours_end_time").val();
      if(start_time != '' && end_time != ''){
        $('#datepairExample2 .time').timepicker('option', 'minTime', start_time);
        $('#datepairExample2 .time').timepicker('option', 'maxTime', end_time);
      }
  });

  var start_time = $("#hours_start_time").val();
  var end_time = $("#hours_end_time").val();
    if(start_time != '' && end_time != ''){
      $('#datepairExample2 .time').timepicker('option', 'minTime', start_time);
      $('#datepairExample2 .time').timepicker('option', 'maxTime', end_time);
    }
});
</script>
