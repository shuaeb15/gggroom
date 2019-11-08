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
<?php
//echo '<pre>'; print_r($poll_data); exit; ?>
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
            <h2>Add/Edit Poll</h2>
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
                      <!-- start poll --->
                      <?php
                      $j=1;
                      foreach($poll_data as $k=>$v){
                      ?>
                      <div class="row x_title mainQuestionDiv" id="questionDiv<?=$v['qst_id']?>">
                        <div class="col-md-9 col-xs-12">
                           <div class="item form-group">
                             <label for="">Question <?=$v['qst_id']?>:</label>
                             <input type="text" name="question-<?=$v['qst_id']?>" value="<?=($v['qst']) && $v['qst'] != '' ? $v['qst'] : ''?>" class="form-control">
                             <br>
                             <select class="form-control questionDiv" name="queOption-<?=$v['qst_id']?>" id="queOption<?=$v['qst_id']?>" data-value="<?=$v['qst_id']?>" onchange="changeOption(<?=$v['qst_id']?>, this.value);">
                               <option value="1" <?=($v['textbox'] == '1')  ? 'selected="selected"' : ''?>>Radio Button</option>
                               <option value="2" <?=($v['textbox'] == '2') || $v['textbox'] == '' ? 'selected="selected"' : ''?>>Text Area</option>
                             </select>
                             <br>
                              <div class="col-xs-12 radioGroup" id="option<?=$v['qst_id']?>">
                                <?php
                                //  echo $v['textbox'];
                                if($v['textbox'] != '' || $v['textbox'] == '1'){

                               
                                  ?>
                                  <div class="col-xs-12 inner-radioGroup<?=$v['qst_id']?>">
                                  <?php
                                  for($i = 1; $i <= 8; $i++) {
                                    if($v['opt'.$i] != ''){
                                    ?>
                                        <input type="radio" name="radio_opt<?=$v['qst_id'].$i?>" id="radio<?=$v['qst_id'].$i?>" class="css-checkbox radio_day" value="<?=$v['qst_id'].$i?>"/>
                                        <label for="radio<?=$v['qst_id'].$i?>" class="css-label radGroup1 radGroup2">
                                          <span>Option <?=$i?></span>
                                        </label>
                                        <input type="text" name="option-<?=$v['qst_id'].'-'.$i?>" class="form-control" value="<?=($v['opt'.$i]) && $v['opt'.$i] != '' ? $v['opt'.$i] : ''?>" placeholder="Please enter option for your question">
                                        <hr>
                                  <?php
                                    }
                                  } ?>
                                  </div>
                                  <i class="fa fa-plus-circle addo" id="add<?=$v['qst_id']?>" title="Add Option" onclick="addOption(<?=$v['qst_id']?>);"></i><label for="add-option">Add New Radio Button</label>
                                  <i class="fa fa-minus-circle remove" id="RemoveButton1" title="Add Option" onclick="removeOption(<?=$v['qst_id']?>);"></i><label for="remove-option">Remove Radio Button</label>
                                  <?php
                                }else{

                                }
                                //if($j == $num_of_data){ ?>
                                  <!-- <a href="javascript:void(0);" title="Add New Question" id="add-new-question" style="color:#000; text-decoration:underline; float:right;" data-num="1" onclick="addNewQuestion(<?=($v['qst_id'])?>);">Add New Question</a><i class="fa fa-plus-circle addque" style="float:right;"></i> -->
                                <?php //}else{ ?>
                                  <a href="javascript:void(0);" title="Remove Question" style="color:#000; text-decoration:underline; float:right;" data-num="<?=($v['qst_id'])?>" onclick="removeQuestion(<?=($v['qst_id'])?>);">Remove Question</a><i class="fa fa-minus-circle addque" style="float:right;"></i>
                              <?php //} ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php
                      $j++;
                      }?>
                      <div class="row x_title">
                        <div class="col-md-9 col-xs-12">
                          <div class="col-md-2">
                            <label for="add-option">Poll Status </label>
                          </div>
 <div class="col-md-4">
                          <select class="form-control " name="display" id="queOption<?=$v['qst_id']?>">
                               <option value="1" <?=($v['display'] == '1')  ? 'selected="selected"' : ''?>>Show</option>
                               <option value="0" <?=($v['display'] == '0') || $v['textbox'] == '' ? 'selected="selected"' : ''?>>Hide</option>
                             </select>
                           </div>
 <div class="col-md-6">
                           <div class="item form-group">
                              <a href="javascript:void(0);" title="Add New Question" id="add-new-question" style="color:#000; text-decoration:underline; float:right;" data-num="1" onclick="addNewQuestion(<?=($v['qst_id'])?>);">Add New Question</a><i class="fa fa-plus-circle addque" style="float:right;"></i>
                            </div>
</div>

                          </div>
                        </div>
                        <!-- end poll --->
                        <div class="row" style="background:#f2f2f2;">
                          <div class="col-md-9 col-xs-12">
                            <div class="form-group">
                              <div class="col-md-6 col-md-offset-3">
                                <input type="button" onclick="location.href = '<?php echo base_url(); ?>page'" class="btn btn-primary" value="Cancel">
                                <button id="send" type="submit" class="btn btn-success">Update</button>
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
