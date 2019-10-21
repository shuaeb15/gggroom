<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>

<style media="screen">

.cls_shop_info{
  height: 36px;
border-radius: 4px;
text-align: left;
font-size: 14px;
background: #f3f3f3;
margin-left: 10px;
}
.cls_lable_info{
  margin-top: 8px;
    font-weight: 100;
}
.cls_main{
  margin-bottom: 10px;
}
.cls_breaks{
  border-radius: 4px;
text-align: left;
padding: 10px;
/* border: solid 2px #008080; */
font-size: 14px;
background: #f3f3f3;
margin-left: 10px;
}
@media only screen and (max-width:480px){
.cls_all_field{
      width:100%;
  }
}
</style>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Shop info</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Service Info</h2>
            <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-12 cls_main">
              <div class="item form-group">
                <?php
                $img = @$service_data[0]->image;
                $temp_file = base_url()."../front/images/banner.jpg";
                $main_file = "../assets/uploads/service_image/".$img;
                $filename = FCPATH.$main_file;
                if (file_exists($filename)) {
                  if($img != ''){
                      $main_image =  base_url().$main_file;
                  }else{
                      $main_image =  $temp_file;
                  }
                }else{
                  $main_image =  $temp_file;
                }?>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                  <img src="<?=$main_image?>" alt="" id="preview_image" title="" class="img-responsive" style="border-radius: 10px;" /><br>
                </div>
               </div>
            </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Service Name</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$service_data[0]->service_name?></label><br>
                  </div>
                 </div>
              </div>
              <?php
              if(!empty($service_data[0]->und_sub_category->cat_name)){
                  $category = $service_data[0]->und_sub_category->cat_name.', '.$service_data[0]->sub_category->cat_name.', '.$service_data[0]->service_name;
              }
              else if(!empty($service_data[0]->sub_category->cat_name)){
                  $category = $service_data[0]->sub_category->cat_name.', '.$service_data[0]->service_name;
              }
              else{
                    $category = $service_data[0]->service_name;
              }

              // if($service_data[0]->type == 1){
              //     $service_type = 'Shop';
              // }
              // else if($service_data[0]->type == 2){
              //     $service_type = 'Home';
              // }
              // else if($service_data[0]->type == 3){
              //     $service_type = 'Boths';
              // }
               ?>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Category</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$category?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">price</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info">$<?=$service_data[0]->price?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">time</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$service_data[0]->time?>min</label><br>
                  </div>
                 </div>
              </div>
              <?php
              if(empty($service_data[0]->worker)){
                  $all_worker = '';
              }else{
                  $all_worker = $service_data[0]->worker;
              }
               ?>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Worker</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$all_worker?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Shop</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$service_data[0]->shop->shop_name?></label><br>
                  </div>
                 </div>
              </div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3">
                    <input type="button" onclick="location.href = '<?php echo base_url(); ?>service'" class="btn btn-primary" value="Cancel">
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
