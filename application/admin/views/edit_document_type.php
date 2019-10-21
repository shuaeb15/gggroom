<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>
<style media="screen">
@media only screen and (max-width:480px){
.cls-chk {
    font-size: 20px !important;
  }
}
</style>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Docuement Type</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Document Type</h2>
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
                    <form enctype="multipart/form-data" method="post" class="form-horizontal" id="edit_frm_document_type" name="edit_frm_document_type" data-toggle="validator" action="<?php echo site_url("document/update_document_type"); ?>">
                      <div class="col-md-8 col-xs-12">
                        <div class="item form-group">
                          <label class="control-label1 col-xs-12" for="product">Document Type Name</label><br>
                           <div class="col-xs-12">
                             <input id="document_id" class="form-control col-md-7 col-xs-12" name="document_id" type="hidden" value="<?php if(isset($document_list)){ echo $document_list->id;}?>">
                             <input id="d_name" class="form-control col-md-7 col-xs-12" name="d_name" type="text" value="<?php if(isset($document_list)){ echo $document_list->name;}?>">
                           </div>
                         </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <input type="button" onclick="location.href = '<?php echo base_url(); ?>User'" class="btn btn-primary" value="Cancel">
                          <button id="send" type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
