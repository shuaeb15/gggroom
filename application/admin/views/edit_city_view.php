<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>

<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>City</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit City</h2>
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
                    <form enctype="multipart/form-data" method="post" class="form-horizontal" id="edit_city_form" name="edit_city_form" data-toggle="validator" action="<?php echo site_url("city/update_city"); ?>">
                      <input type="hidden" name="city_id" id="city_id" value="<?=$city_list->id?>">
                      <div class="col-md-8 col-xs-12">
                         <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">City name</label><br>
                            <div class="col-xs-12">
                              <input id="city_name" class="form-control col-md-7 col-xs-12" name="city_name" type="text" value="<?php if(isset($city_list->name)){ echo $city_list->name;}?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-3" id="eventsExample">
                            <input type="button" onclick="location.href = '<?php echo base_url(); ?>city'" class="btn btn-primary" value="Cancel">
                            <button id="send" type="submit" class="btn btn-success">Update</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
