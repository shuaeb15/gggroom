
<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>
<style>
.color-white{
    color: #fff !important;
}
/* #chartdiv {
width: 50%;
height: 250px;
} */
@media only screen and (max-width:480px){
  #chartdiv{
    height: 250px;
  }
}
</style>

<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<!-- page content -->
<div class="right_col" role="main" style="min-height: 500px;">
    <!-- top tiles -->
    <div class="row tile_count">
      <?php if($admin_data[0]['user_promotion'] != 3){?>
        <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a href="<?php echo site_url('User');?>">
                <div class="tile-stats" style="background-color: #F1C40F;">
                    <div class="icon color-white"><i class="fa fa-user"></i></div>
                    <div class="count color-white"><?php echo $user_val; ?></div>
                    <h3 class="color-white">Total User</h3>
                </div>
            </a>
        </div>
        <?php }?>
        <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a href="<?php echo site_url('Category');?>">
                <div class="tile-stats" style="background-color: #BAC3D0;">
                    <div class="icon color-white"><i class="fa fa-list-alt"></i></div>
                    <div class="count color-white"><?php echo $category_list; ?></div>
                    <h3 class="color-white">Total Category</h3>
                </div>
            </a>
        </div>
        <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a href="<?php echo site_url('Shop');?>">
                <div class="tile-stats" style="background-color: #FF7F50;">
                    <div class="icon color-white"><i class="fa fa-tags"></i></div>
                    <div class="count color-white"><?php echo $shop_list; ?></div>
                    <h3 class="color-white">Total Shop</h3>
                </div>
            </a>
        </div>
        <?php if($admin_data[0]['user_promotion'] != 3){?>
          <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <a href="<?php echo site_url('Appointment');?>">
                  <div class="tile-stats" style="background-color: #3CB371;">
                      <div class="icon color-white"><i class="fa fa-calendar-o"></i></div>
                      <div class="count color-white"><?php echo $appointment_list; ?></div>
                      <h3 class="color-white">Total Appointment</h3>
                  </div>
              </a>
          </div>
          <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <a href="<?php echo site_url('service');?>">
                  <div class="tile-stats" style="background-color: #8FBC8F;">
                      <div class="icon color-white"><i class="fa fa-reorder"></i></div>
                      <div class="count color-white"><?php echo $service_list; ?></div>
                      <h3 class="color-white">Total Services</h3>
                  </div>
              </a>
          </div>
        <?php }?>
        <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a href="<?php echo site_url('Appointment');?>">
                <div class="tile-stats" style="background-color: #FFA07A;">
                    <div class="icon color-white"><i class="fa fa-dollar"></i></div>
                    <div class="count color-white">$<?php echo $collection_list; ?></div>
                    <h3 class="color-white">Total Collection</h3>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="font-size: 22px; color: #73879C;">Transaction Summary </div>
        <div id="myfirstchart" style="height: 250px;margin-bottom: 50px;"></div>
    </div>
    <div class="col-md-12 col-xs-12">
      <hr class="hr_line margin_bottom_30">
    </div>
    <div class="row">
      <div class="col-md-12" style="font-size: 22px; color: #73879C;margin-bottom: 20px;">Service Matrix</div>
      <div class="col-md-12">
      <div class="col-md-2">
        <p style="margin-left: 10px;color:grey;"><?=$count_service_list[0]->cat_name?></p>
        <div style="text-align: center; margin-bottom: 17px">
          <span class="chart" data-percent="<?=$count_service_list[0]->percent?>">
            <span class="percent"></span>
          </span>
        </div>
      </div>
      <div class="col-md-2">
        <p style="margin-left: 10px;color:grey;"><?=$count_service_list[1]->cat_name?></p>
        <div style="text-align: center; margin-bottom: 17px">
          <span class="chart" data-percent="<?=$count_service_list[1]->percent?>">
            <span class="percent"></span>
          </span>
        </div>
      </div>
      <div class="col-md-2">
        <p style="margin-left: 10px;color:grey;"><?=$count_service_list[2]->cat_name?></p>
        <div style="text-align: center; margin-bottom: 17px">
          <span class="chart" data-percent="<?=$count_service_list[2]->percent?>">
            <span class="percent"></span>
          </span>
        </div>
      </div>
      <div class="col-md-2">
        <p style="margin-left: 10px;color:grey;"><?=$count_service_list[3]->cat_name?></p>
        <div style="text-align: center; margin-bottom: 17px">
          <span class="chart" data-percent="<?=$count_service_list[3]->percent?>">
            <span class="percent"></span>
          </span>
        </div>
      </div>
    </div>
    </div>
    <div class="col-md-12 col-xs-12">
      <hr class="hr_line margin_bottom_30">
    </div>
    <div class="row">
      <div class="col-md-12" style="font-size: 22px; color: #73879C;">Web Matrix </div>
      <div id="chartdiv" style="height: 350px;margin-bottom: 100px;"></div>
      <!-- <div id="chartdiv" style="margin-bottom:130px;"></div> -->
    </div>
    <div class="col-md-12 col-xs-12">
      <hr class="hr_line margin_bottom_30">
    </div>
    <div class="row">
      <div class="col-md-12" style="font-size: 22px; color: #73879C;">Location and Payment Matrix </div>
      <div id="chartdiv1" style="height: 350px;margin-bottom: 100px;"></div>
    </div>
    <div class="row">
    <div class="col-md-12 col-xs-12">
      <hr class="hr_line margin_bottom_30">
    </div>
    <div class="col-md-12">
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
    </div>
  </div>
</div>
