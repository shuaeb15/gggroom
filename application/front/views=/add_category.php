<?php $this->load->view('templates/_include/header_view1'); ?>

<style media="screen">
  .cls_new_button{
    height: 36px;
    border-radius: 4px;
    border: solid 2px #008080;
    font-weight: 500;
    color: #000;
    font-size: 14px;
    background: #f3f3f3;
  }
  .cls_title_label{
    margin: 0 auto 10px auto !important;
    font-size: 19px !important;
    font-weight: 600 !important;
  }
  .cls_md_12{
    margin-bottom: 30px;
  }
@media only screen and (max-width:480px){
  .cls_add_s{
    margin-bottom: 20px;
  }
}
</style>

<section class="block bg_white">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12">
        <div class="edit-form shop-form">
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

          <form enctype="multipart/form-data" method="post"  id="add_s_cat" name="add_s_cat" data-toggle="validator" action="<?php echo site_url("category/insert_category/"); ?>">
            <div class="col-xs-12 col-sm-12 col-md-12 cls_top" style="text-align: center;">
                <span class="form-title" style="float:none;font-size: 25px;margin: 0 auto 30px auto;">Add Service Category</span>
            </div>
            <div class="col-md-12 col-xs-12 cls_md_12 ">
              <div class="col-md-12">
                <span class="form-title cls_title_label">Parent Category</span>
              </div>
              <div class="col-md-3 cls_add_s">
                <select class="form-control" name="parent_category" id="parent_category">
                  <option value="">Select Parent Category</option>
                  <?php foreach ($parent_category as $key => $cat){?>
                          <option value="<?=$cat->category_id?>"><?=$cat->cat_name?></option>
                  <?php }?>
                </select>
              </div>
              <div class="col-md-2 cls_add_s">
                <button class="form-control cls_new_button" type="button" id="add_new_parent_cat">Add New</button>
              </div>
              <div class="col-md-3 cls_parent cls_add_s">
                <input type="text" class="form-control" name="add_parent_category" id="add_parent_category" placeholder="Enter name">
              </div>
              <div class="col-md-2 cls_parent cls_add_s">
                <button class="form-control cls_new_button" type="button" id="remove_parent_cat">Remove</button>
              </div>
            </div>
            <div class="col-md-12 col-xs-12 cls_md_12">
              <div class="col-md-12">
                <span class="form-title cls_title_label">Sub Category</span>
              </div>
              <div class="col-md-3 cls_add_s">
                <select class="form-control" name="sub_category" id="sub_category">
                  <option value="">Select Sub Category</option>
                </select>
              </div>
              <div class="col-md-2 cls_add_s">
                <button class="form-control cls_new_button" type="button" id="add_new_sub_cat">Add New</button>
              </div>
              <div class="col-md-3 cls_sub cls_add_s">
                <input type="text" class="form-control" name="add_sub_category" id="add_sub_category" placeholder="Enter name">
              </div>
              <div class="col-md-2 cls_sub cls_add_s">
                <button class="form-control cls_new_button" type="button" id="remove_sub_cat">Remove</button>
              </div>
            </div>
            <div class="col-md-12 col-xs-12 cls_md_12">
              <div class="col-md-12">
                <span class="form-title cls_title_label">Child Category</span>
              </div>
              <div class="col-md-3 cls_add_s">
                <select class="form-control" name="child_category" id="child_category">
                  <option value="">Select Child Category</option>
                </select>
              </div>
              <div class="col-md-2 cls_add_s">
                <button class="form-control cls_new_button" type="button" id="add_new_child_cat">Add New</button>
              </div>
              <div class="col-md-3 cls_child cls_add_s">
                <input type="text" class="form-control" name="add_child_category" id="add_child_category" placeholder="Enter name">
              </div>
              <div class="col-md-2 cls_child cls_add_s">
                <button class="form-control cls_new_button" type="button" id="remove_child_cat">Remove</button>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line margin_bottom_30">
            </div>
            <div class="col-md-12 center_btn_main">
              <div class="center_btn_sub">
                <div class="center_btn_subitem">
                  <button type="button" class="dlt_shop_btn" id="btn-submit">Cancel</button>
                </div>
                <div class="center_btn_subitem">
                  <button type="submit" class="save_shop_btn btn_save_services">Save</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  $(document).ready(function(){
    $('#add_parent_category').on('keypress', function(e){
    if (e.keyCode == 13){
       return false;
    };
  });
  $('#add_sub_category').on('keypress', function(e){
  if (e.keyCode == 13){
     return false;
  };
});
$('#add_child_category').on('keypress', function(e){
if (e.keyCode == 13){
   return false;
};
});

    $('.dlt_shop_btn').click(function(){
        window.location.href = '<?php echo base_url(); ?>profile';
    })
    //parent category
      $('.cls_parent').hide();
      $('#add_new_parent_cat').click(function(){
          $('.cls_parent').show();
          $('#parent_category').prop('disabled', true);
          $('#parent_category').val('');
          var sub_html = '<option value="">Select Sub Category</option>';
          $('#sub_category').html(sub_html);
          var child_html = '<option value="">Select Child Category</option>';
          $('#child_category').html(child_html);
      });
      $('#remove_parent_cat').click(function(){
          $('.cls_parent').hide();
          $('#add_parent_category').val('');
          $('#parent_category').prop('disabled', false);
      });

      //sub category
      $('.cls_sub').hide();
      $('#add_new_sub_cat').click(function(){
          $('.cls_sub').show();
          $('#sub_category').prop('disabled', true);
          $('#sub_category').val('');
          var child_html = '<option value="">Select Child Category</option>';
          $('#child_category').html(child_html);
      });
      $('#remove_sub_cat').click(function(){
          $('.cls_sub').hide();
          $('#add_sub_category').val('');
          $('#sub_category').prop('disabled', false);
      });

      //child category
      $('.cls_child').hide();
      $('#add_new_child_cat').click(function(){
          $('#child_category').val('');
          $('.cls_child').show();
          $('#child_category').prop('disabled', true);
      });
      $('#remove_child_cat').click(function(){
          $('.cls_child').hide();
          $('#add_child_category').val('');
          $('#child_category').prop('disabled', false);
      });

      $('#parent_category').change(function(){
          $('#sub_category').val('');
          $('#child_category').val('');
          var parent_cat_id = $(this).val();
          var flag = 1;
          var datastring = 'cat_id=' + parent_cat_id + '&flag=' + flag;
          $.ajax({
              url: "<?php echo base_url(); ?>category/get_sub_category",
              type: 'post',
              data: datastring,
              success: function(data){
                var data1 = JSON.parse(data);
                console.log(data1);
                var html = '<option value="">Select Sub Category</option>';
                for (var i = 0; i < data1.length; i++) {
                   html += '<option value="'+ data1[i].category_id +'">'+ data1[i].cat_name +'</option>';
                }
                $('#sub_category').html(html);
              }
          });
      });

      $('#sub_category').change(function(){
        $('#child_category').val('');
        var parent_cat_id = $(this).val();
        var flag = 2;
        var datastring = 'cat_id=' + parent_cat_id + '&flag=' + flag;
        $.ajax({
            url: "<?php echo base_url(); ?>category/get_sub_category",
            type: 'post',
            data: datastring,
            success: function(data){
              var data1 = JSON.parse(data);
              console.log(data1);
              var html = '<option value="">Select Child Category</option>';
              for (var i = 0; i < data1.length; i++) {
                 html += '<option value="'+ data1[i].category_id +'">'+ data1[i].cat_name +'</option>';
              }
              $('#child_category').html(html);
            }
        });
      });

      $('.btn_save_services').click(function(){
        if($(".cls_parent").is(':visible')){
            var parent_cat = $('#add_parent_category').val();
        }else{
            var parent_cat = $('#parent_category').val();
        }

        if($(".cls_sub").is(':visible')){
            var sub_cat = $('#add_sub_category').val();
        }else{
            var sub_cat = $('#sub_category').val();
        }

        if($(".cls_child").is(':visible')){
            var child_cat = $('#add_child_category').val();
        }else{
            var child_cat = $('#child_category').val();
        }

        if(parent_cat == '' && sub_cat == '' && child_cat == ''){
          swal({
                title: "",
                text: "Please select category",

            }, function () {
              $('html, body').animate({
                      scrollTop: $('.cls_top').offset().top
                  }, 'slow');
            })
            return false;
        }else{
          if(sub_cat != ''){
              if(parent_cat == ''){
                swal({
                      title: "",
                      text: "Please first enter parent category",

                  }, function () {
                    $('html, body').animate({
                            scrollTop: $('.cls_top').offset().top
                        }, 'slow');
                  })
                  return false;
              }
          }
          else if(sub_cat != '' && child_cat != ''){
              if(parent_cat == ''){
                swal({
                      title: "",
                      text: "Please first enter parent category",

                  }, function () {
                    $('html, body').animate({
                            scrollTop: $('.cls_top').offset().top
                        }, 'slow');
                  })
                  return false;
              }
          }
          else if(child_cat != ''){
              if(sub_cat == ''){
                swal({
                      title: "",
                      text: "Please first enter sub category",

                  }, function () {
                    $('html, body').animate({
                            scrollTop: $('.cls_top').offset().top
                        }, 'slow');
                  })
                  return false;
              }
          }
        }
      });
  });

</script>
