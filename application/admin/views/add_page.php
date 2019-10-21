<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>
<style media="screen">
body {
padding:5px;
}
#footer_page{
  display: block;
    width: 23%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
}
</style>

<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Page</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add Page</h2>
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
                    <form enctype="multipart/form-data" method="post" class="form-horizontal" id="insert_page" name="insert_page" data-toggle="validator" action="<?php echo site_url("page/insert_page"); ?>">
                      <div class="col-md-9 col-xs-12">
                       <div class="item form-group">
                         <label class="control-label1 col-xs-12" for="product">Name</label><br>
                          <div class="col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" name="name" type="text">
                          </div>
                        </div>
                        <div class="item form-group">
                          <label class="control-label1 col-xs-12" for="product">Page url</label><br>
                           <div class="col-xs-12">
                             <input id="page_url" class="form-control col-md-7 col-xs-12" name="page_url" type="text">
                           </div>
                         </div>
                        <div class="item form-group">
                          <label class="control-label1 col-xs-12" for="product">Title</label><br>
                           <div class="col-xs-12">
                             <input id="title" class="form-control col-md-7 col-xs-12" name="title" type="text">
                           </div>
                         </div>
                         <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">Footer page</label><br>
                            <div class="col-xs-12">
                              <select class="footer_page" name="footer_page" id="footer_page">
                                  <option value="">select</option>
                                  <option value="1">Footer page1</option>
                                  <option value="2">Footer page2</option>
                                  <option value="3">Footer page3</option>
                              </select>
                            </div>
                          </div>
                         <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">Description</label><br>
                            <div class="col-xs-12">
                              <textarea id="description" name="description"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-3">
                            <input type="button" onclick="location.href = '<?php echo base_url(); ?>page'" class="btn btn-primary" value="Cancel">
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

<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>

<script type="text/javascript">
tinymce.init({
selector: 'textarea',
height: 250,
menubar: false,
plugins: [
  'advlist autolink lists link image charmap print preview anchor textcolor',
  'searchreplace visualblocks code fullscreen',
  'insertdatetime media table contextmenu paste code help wordcount'
],
toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
content_css: [
  '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
  '//www.tinymce.com/css/codepen.min.css']
});
</script>
