<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>
<link href="<?php echo base_url('../front/css/gggroom.css?ver=1.3');?>" rel="stylesheet">
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
.fa{
  font-size: 22px;
  cursor: pointer;
  padding: 0 10px;
}
.css-label{
  width: 100%;
}
/* .add{
  font-family: 'Roboto', sans-serif;
  font-size: 14px;
} */
</style>

<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Poll</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add Poll</h2>
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
                    <form enctype="multipart/form-data" method="post" class="form-horizontal" id="insert_page" name="insert_page" data-toggle="validator" action="<?php echo site_url("poll/insert_poll"); ?>">
                      <div class="row x_title mainQuestionDiv" id="questionDiv1">
                        <div class="col-md-9 col-xs-12">
                           <div class="item form-group">
                             <label for="">Question 1:</label>
                             <input type="text" name="question-1" class="form-control">
                             <br>
                             <select class="form-control questionDiv" name="queOption-1" id="queOption1" data-value="1" onchange="changeOption(1, this.value);">
                               <option value="1">Radio Button</option>
                               <option value="2">Text Area</option>
                             </select>
                             <br>
                              <div class="col-xs-12 radioGroup" id="option1">
                                <div class="col-xs-12 inner-radioGroup1">
                                  <input type="radio" name="radio_opt11" id="radio1" class="css-checkbox radio_day" value="1"/>
                                  <label for="radio1" class="css-label radGroup1 radGroup2">
                                    <span>Option 1</span>
                                  </label>
                                  <input type="text" name="option-1-1" class="form-control" placeholder="Please enter option for your question">
                                  <hr>
                                </div>
                                <i class="fa fa-plus-circle addo" id="add1" title="Add Option" onclick="addOption(1, 1);"></i><label for="add-option">Add New Radio Button</label>
                                <i class="fa fa-minus-circle remove" id="RemoveButton1" title="Add Option" onclick="removeOption(1);"></i><label for="remove-option">Remove Radio Button</label>
                                <!-- <label for="radioi" class="">Add New Radio Button</label><br><br> -->
                                <!-- <a href="" style="color:#000; text-decoration:underline;"><i class="fa fa-minus-circle"></i> Remove Question</a> -->
                                <a href="javascript:void(0);" title="Add New Question" id="add-new-question" style="color:#000; text-decoration:underline; float:right;" data-num="1" onclick="addNewQuestion(1);">Add New Question</a><i class="fa fa-plus-circle addque" style="float:right;"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-9 col-xs-12">
                           <div class="item form-group">
                             <a href="javascript:void(0);" title="Add New Question" id="add-new-question" style="color:#000; text-decoration:underline; float:right;" data-num="1" onclick="addNewQuestion(1);">Add New Question</a><i class="fa fa-plus-circle addque" style="float:right;"></i>
                           </div>
                        </div>
                        <!-- <div class="row x_title">
                          <div class="col-md-9 col-xs-12">
                             <div class="item form-group">
                               <label for="">Question 2:</label>
                               <input type="text" name="" class="form-control"><br>
                               <select class="form-control" name="">
                                 <option value="">Text Area</option>
                                 <option value="">Radio Button</option>
                               </select>
                                <div class="col-xs-12">
                                  </br></br>
                                  <a href="" style="color:#000; text-decoration:underline;">Add Question</a>
                                </div>
                              </div>
                            </div>
                        </div> -->
                        <div class="row" style="background:#f2f2f2;">
                          <div class="col-md-9 col-xs-12">
                            <div class="form-group">
                              <div class="col-md-6 col-md-offset-3">
                                <input type="button" onclick="location.href = '<?php echo base_url(); ?>page'" class="btn btn-primary" value="Cancel">
                                <button id="send" type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>
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
<script src="<?=base_url()?>assets/js/poll_view.js"></script>
<script type="text/javascript">
// function addOption(){
//   alert("Asdf");
//   var newI = parseInt($(".radioGroup input:radio:last").attr('value'))+1;
//   optionsHTML = '<input type="radio" name="radio_day" id="radio'+newI+'" class="css-checkbox radio_day" value="'+newI+'"/> <label for="radio'+newI+'" class="css-label radGroup1 radGroup2"> <span>Option '+newI+'</span> </label><input type="text" name="option'+newI+'" class="form-control" placeholder="Please enter option for your question"><hr>';
//   $(".inner-radioGroup").append(optionsHTML);
// }
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
