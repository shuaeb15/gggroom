<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>

<link href="<?php echo base_url('../front/css/gggroom.css?ver=1.3');?>" rel="stylesheet">
<style media="screen">
.cls-time-title{
  font-size: 22px;
color: rgb(0, 0, 0);
font-weight: bold;
margin-bottom: 10px;
}
.business_hrs{
  margin-bottom: 10px;
}
.cls_break_day_time{
  margin-right: 10px !important;
  margin-left: 88px !important;
}
.cls-chk{
  font-size: 20px;
    margin-bottom: 18px;
}
.cls-chk input{
  width: auto !important;
  height: auto !important;
}
.cls-time-input{
  border-radius: 4px;
  text-align: left;
  border: solid 2px #008080;
  margin-bottom:10px;
  font-size: 20px;
}
.cls_shop_info{
  height: 36px;
border-radius: 4px;
text-align: left;
/* border: solid 2px #008080; */
font-size: 14px;
/* background: #f3f3f3; */
margin-left: 10px;
}
.cls_lable_info{
  /* border: solid 2px #008080;
  border-radius: 4px; */
  margin-left: -9px;
    /* background: #f3f3f3;
    font-weight: 100; */
}
.cls_main{
  margin-bottom: 25px;
}
.cls_breaks{
  border-radius: 4px;
text-align: left;
padding: 10px;
/* border: solid 2px #008080; */
font-size: 14px;
/* background: #f3f3f3; */
margin-left: 10px;
}
.cls_radio{
  margin-right: 10px;
}
.camera_upload{
  margin-top: -27px;
  margin-left: 93px;
  width: 35px;
}
.upload_img{
  width: 150px;
    height: 150px;
}
.cls-chk1 label{
    font-weight: 100;
    font-size: 20px;
}
.cls-chk1{
	font-size: 25px !important;
}
.cls-chk1 input{
	width: 17px !important;
  height: 17px !important;
  margin-right: 6px !important;
}
.cl_lbl_time{
    width: 12%;
    font-size:21px;
}
.cl_lbl_end_time{
    width: 12%;
    font-size:21px;
    margin-left:70px;
}
.ui-multiselect{
  border: 1px solid #ccc !important;
  height: 34px !important;
  background-color: #fff !important;
}
.ui-multiselect-checkboxes span{
  margin-left: 7px;
}
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover{
  background:#ccc !important;
}

@media only screen and (max-width:480px){
  .cls_md_8{
    padding-left:0px !important;
  }
  .cls_main{
    padding-left:0px !important;
  }
  .cl_lbl_time{
      width: 100%;
  }
  .cl_lbl_end_time{
      width: 100%;
      margin-left:0px;
  }
  .cls_day{
    width: 100% !important;
  }
  .cls_day label.css-label-check{
    margin-bottom: 0px !important;
  }
  .cls-chk{
    border-right: none !important;
  }
  .business_hrs span {
    font-size: 15px;
  }
  .business_hrs img {
    margin-right: 10px;
  }
  .cls_all_field{
        width:100%;
    }
}

</style>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Shop</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <form enctype="multipart/form-data" method="post"  id="add_shop" name="add_shop" data-toggle="validator" action="<?=base_url()?>shop/insert_shop">
          <div class="x_title">
            <h2>Add shop</h2>
            <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="col-md-8 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Shop Name</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="shop_name" id="shop_name">
                  </div>
                 </div>
              </div>
              <div class="col-md-8 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Shop Email</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="shop_email" id="shop_email">
                  </div>
                 </div>
              </div>
              <div class="col-md-8 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Mobile No</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="mobile_no" id="mobile_no">
                  </div>
                 </div>
              </div>
              <div class="col-md-8 cls_main cls_all_field cls_addline">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Address Line 1</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="address_1" id="address_1">
                  </div>
                 </div>
              </div>
              <div class="col-md-8 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Address Line 2</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="address_2" id="address_2">
                  </div>
                 </div>
              </div>
              <div class="col-md-8 cls_md_8">
                <div class="col-md-5 cls_main cls_all_field" style="padding-left:0px;">
                  <div class="item form-group">
                   <label class="control-label1 col-xs-12" for="product">City</label><br>
                    <div class="col-md-12 cls_shop_info cls_all_field" style="margin-left: 0px;">
                      <select class="city form-control" id="city" name="city[]" multiple="multiple">
                        <?php foreach ($city as $city_val) {?>
                          <option value="<?=$city_val->id?>"><?=$city_val->name?></option>
                          <?php }?>
                      </select>
                    </div>
                   </div>
                </div>
                <div class="col-md-4 cls_main cls_all_field">
                  <div class="item form-group">
                   <label class="control-label1 col-xs-12" for="product">State</label><br>
                    <div class="col-md-12 cls_shop_info cls_all_field">
                      <select class="form-control cls_lable_info" name="state" id="state">
                        <option value="">--Select--</option>
                        <?php foreach ($state as $val) {?>
                          <option value="<?=$val->id?>"><?=$val->name;?></option>
                          <?php }?>
                      </select>
                    </div>
                   </div>
                </div>
                <div class="col-md-3 cls_main cls_all_field">
                  <div class="item form-group">
                   <label class="control-label1 col-xs-12" for="product">Zip code</label><br>
                    <div class="col-md-12 cls_shop_info cls_all_field">
                      <input type="text" class="form-control cls_lable_info" name="zipcode" id="zipcode">
                    </div>
                   </div>
                </div>
              </div>
              <div class="col-md-8 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1">Description</label><br>
                  <div class="col-md-12 cls_all_field">
                    <textarea rows="8" class="form-control cls_lable_info cls_all_field" name="discription" id="discription" placeholder="Please add a description"></textarea>
                  </div>
                 </div>
              </div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3">
                    <input type="button" onclick="location.href = '<?php echo base_url(); ?>shop'" class="btn btn-primary" value="Cancel">
                    <button id="send" type="submit" class="btn btn-success edit_shop_btn">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$("#city").multiselect({
header: ['checkAll','uncheckAll'],
});
});
</script>
