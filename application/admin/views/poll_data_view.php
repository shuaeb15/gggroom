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
.menu_profile{
  width: 50px;
  height: 50px;
  float: left !important;
}
.question-h2{
  padding: 10px;
}
/* .add{
  font-family: 'Roboto', sans-serif;
  font-size: 14px;
} */
</style>
<?php
// echo '<pre>'; print_r($poll_data); exit; ?>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>View Submitted Polls</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
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
                      // echo '<pre>'; print_r($poll_data);exit;
                      foreach($poll_data as $key=>$value){
                      ?>
                      <div class="row x_title mainQuestionDiv">
                        <div class="col-md-12 col-xs-12">
                           <div class="item form-group">
                             <div class="x_title">
                                 <?php

                           				$img = $value[0]['image'];
                           				$temp_file = FRONT_URL."images2/user.png";
                           				$main_file = "assets/uploads/profile_image/".$img;
                           				$filename = '/home/dekhli007/public_html/ggg/'.$main_file;
                                  // echo $filename;
                           				if (file_exists($filename)) {
                           					if($img != ''){
                           							$main_image =  DOMAIN_URL.$main_file;
                           					}else{
                           							$main_image =  $temp_file;
                           					}
                           				}else{
                           					$main_image =  $temp_file;
                           				}?>
                                  <img src="<?=$main_image?>" alt="" title="" class="img-responsive pull-right img-circle menu_profile hidden-xs">
                                 <h2 class="question-h2"><?=$value[0]['email']?></h2>
                               <div class="clearfix"></div>
                             </div>
                             <?php
                             // $value = array_unique($value);
                             // $value = array_map("unserialize", array_unique(array_map("serialize", $value)));
                             // $value = array_unique($value, SORT_REGULAR);
                             // echo '<pre>'; print_r($value);
                             foreach ($value as $k => $v) {
                               echo '<div class="row">';
                               echo '<label>'.$v['qst'].'</label><br>';
                               echo '<span>'.$v['opt'].'</span><br><br><hr>';
                               echo '</div>';
                             }
                             ?>
                           </div>
                        </div>
                      </div>
                      <?php
                      $j++;
                      }?>
                        <!-- end poll --->
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
