<?php $this->load->view('templates/_include/header_view1');  ?>
<style media="screen">
.btn:hover{
  background-color: #059797 !important;
  color: #fff !important;
}
.input-group-addon {
    padding: 6px 12px !important;
    font-size: 30px  !important;
    font-weight: 400  !important;
    line-height: 1  !important;
    color: #fff  !important;
    text-align: center  !important;
    background-color: #008080  !important;
    border: 1px solid #008080  !important;
    border-radius: 0px  !important;
}
.cls_btn_back{
  float: left;
font-size: 20px;
color: #fff;
background: #059797;
border: none;
height: auto;
padding: 9px 92px;
}
.cls_btn_back:hover{
color: #fff;
background: #059797;
}
.employee_lable{
  width: 100%;
    text-align: center;
    color: #fff;
    font-size: 20px;
    background: #059797;
    margin: 15px 0;
    padding: 12px 12px;
    font-weight: 100;
    text-transform: none;
}
.cls_btn_back {
  float: left !important;
  margin-left: 0px !important;
}
.top-cal-button{
  margin-top: 58px !important;
}
@media only screen and (max-width:480px){
  .cls_btn_back{
    width: 100%;
  }
  .cls_btn_back {
    margin-top:-30px !important;
  }
  .today-button{
    float: left !important;
  }
  .top-cal-button{
    margin-top: 14px !important;
    margin-left: 7px !important;
  }
}
</style>
<section class="block" style="padding-top: 30px;">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
            <span class="form-title">Business Calendar</span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;padding-bottom: 50px;">
            <div class="col-xs-12 col-sm-6 col-md-5 col-md-offset-4 col-sm-offset-3">
                <div id="" class="input-group custom_drpdwn" style="width: 100%;">
                   <select class="form-control" id="AllshopDropDown" style="height: 50px;border-radius: 0; text-align: left; border: solid 2px #008080; font-weight: 500; color: #000; font-size: 20px; background-color: transparent; appearance: none; -moz-appearance: none; -webkit-appearance: none;cursor: pointer;">
                      <option value="">All Shops</option>
                        <?php foreach ($ShopData as $value) { ?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['shop_name']; ?></option>
                        <?php } ?>
                   </select>
                   <span class="input-group-addon CalDropD" style="position: absolute; height: 50px; width: 45px; right: 0;"><span class="fa fa-caret-down"></span></span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <a href="<?php echo base_url();?>profile" class="btn btn-default cls_btn_back"><span>Go back</span></a>
            <button type="button" class="pull-right btn btn-default top-cal-button next-button"><i class="fa fa-arrow-right"></i></button>
            <button type="button" class="pull-right btn btn-default top-cal-button prev-button"><i class="fa fa-arrow-left"></i></button>
            <select id="selected_view" class="form-control pull-right top-cal-button">
                <option value="month">Month</option>
                <option value="agendaWeek">Week</option>
                <option value="agendaDay">Day</option>
            </select>
            <button type="button" class="pull-right btn btn-default top-cal-button today-button">Today</button>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
          <label class="employee_lable">Employee</label>
            <!-- <button type="button" class="btn btn-default full-width-btn emboss-btn">Employee</button> -->
            <div class="service_category">
                <div class="btn-group-maincat WorkerDiv" data-toggle="buttons-radio">
                    <?php foreach ($WorkersData as $worker) { ?>
                        <button type="button" class="btn WorkerData full-width-btn" data-id="<?php echo $worker->id; ?>"><?php echo $worker->name; ?></button>
                    <?php } ?>
                    <!-- <button type="button" class="btn secondemployee full-width-btn">Clark</button>
                    <button type="button" class="btn thirdemployee full-width-btn">Coraddo</button>
                    <button type="button" class="btn getallevents full-width-btn">David</button> -->
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-9">
            <div id='calendar'></div>
        </div>
    </div>
</section>


<!--- Event Model Popup start --->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Event</h4>
          </div>
          <div class="modal-body">
                <div class="form-group">
                    <label for="event_title" class="col-md-2 control-label">Event Title</label>
                    <div class="input-group">
                        <input class="form-control" id="event_title" name="event_title" type="text" value="">
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="start_date_time" class="col-md-2 control-label">Start Date</label>
                    <div class="input-group date form_datetime" data-date="" data-date-format="hh:ii" data-link-format="hh:ii" data-link-field="start_date_time">
                        <input class="form-control" size="16" type="text" value="" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                    <input type="hidden" id="start_date_time" value="" /><br/>
                </div>
                <div class="form-group">
                    <label for="end_date_time" class="col-md-2 control-label">End Date</label>
                    <div class="input-group date form_datetime" data-date="" data-date-format="hh:ii" data-link-format="hh:ii" data-link-field="end_date_time">
                        <input class="form-control" size="16" type="text" value="" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                    <input type="hidden" id="end_date_time" value="" /><br/>
                </div> -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
          </div>
        </div>

      </div>
    </div>
<!--- Event Model Popup end --->
<script type="text/javascript">
    $(document).ready(function($) {
        /*$(".CalDropD").click(function(event) {

        });*/
    });
</script>
