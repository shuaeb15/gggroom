<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>

<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Promotions and offers</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add offer</h2>
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
                    <form enctype="multipart/form-data" method="post" class="form-horizontal" id="add_offer_form" name="add_offer_form" data-toggle="validator" action="<?php echo site_url("offers/insert_offer"); ?>">
                      <div class="col-md-8 col-xs-12">
                         <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">Offer code</label><br>
                            <div class="col-xs-12">
                              <input id="offer_code" class="form-control col-md-7 col-xs-12" name="offer_code" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-8 col-xs-12">
                           <div class="item form-group">
                             <label class="control-label1 col-xs-12" for="product"></label><br>
                             <label class="control-label1 col-xs-12" for="product">Discount</label><br>
                              <div class="col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="discount_type" id="discount_type">
                                  <option value="">select</option>
                                  <option value="1">Percent discount</option>
                                    <option value="2">Fixed amount</option>
                                </select>
                              </div>
                              <div class="col-xs-12">
                                <input id="price" class="form-control col-md-7 col-xs-12" name="price" type="number" style="margin-top:10px;" placeholder="Enter price">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-xs-12">
                          <label class="control-label1 col-xs-12" for="product"></label><br>
                          <div class="item form-group">
                             <div class="col-xs-12 cls-chk" style="font-size: 19px !important;">
                                 <input type="radio" class="offer_radio_type" name="offer_radio_type" id="offer_radio_type" value="1" checked>General Offer
                                 <input type="radio" class="cls-chk-input offer_radio_type" name="offer_radio_type" id="offer_radio_type" value="2">Service Offer
                             </div>
                           </div>
                        </div>
                        <div class="col-md-8 col-xs-12 cls_service">
                          <div class="item form-group">
                            <label class="control-label1 col-xs-12" for="product"></label><br>
                            <label class="control-label1 col-xs-12" for="product">Services</label><br>
                            <div class="col-xs-12">
                              <input type="hidden" class="form-control col-md-7 col-xs-12" name="service_id" id="service_id" value="">
                              <!-- <input type="text" class="form-control col-md-7 col-xs-12" name="service_name" id="service_name" value=""> -->
                              <select class="form-control col-md-7 col-xs-12" name="service_name" id="service_name">
                                <option value="">Select</option>
                                <?php foreach ($services_list as $key => $value): ?>
                                  <option value="<?=$value->id?>"><?=$value->service_name?> - <?=$value->shop_name?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label1 col-xs-12" for="product"></label><br>
                          <div class="col-md-6 col-md-offset-3" id="eventsExample">
                            <input type="button" onclick="location.href = '<?php echo base_url(); ?>offers'" class="btn btn-primary" value="Cancel">
                            <button id="send" type="submit" class="btn btn-success">Add</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  var site_url = $("#site_url").val();
</script>
<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="Stylesheet"></link>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#service_name').editableSelect().on('select.editable-select', function (e, li) {
        $('#last-selected').html(
          $('#service_id').val(li.val())
        );
    });

// $("#service_name").autocomplete({
//       source: function( request, response ) {
//           $.ajax( {
//               url: site_url + 'offers/Get_services_Data',
//               type: "POST",
//               dataType: "json",
//               data: {
//               term: request.term,
//               },
//               success: function( data ) {
//                   response( data );
//               }
//           } );
//       },
//       select: function( event, ui ) {
//         var service_id = ui.item.id;
//         $('#service_id').val(service_id);
//       },
//   });

  $(".offer_radio_type").click(function(e) {
      var offer_type1 = $("input[name='offer_radio_type']:checked").val();
      if(offer_type1 == 1){
          $('.cls_service').hide();
     }else{
        $('.cls_service').show();
     }
  });

  var offer_type = $("input[name='offer_radio_type']:checked").val();
  if(offer_type == 1){
    $('.cls_service').hide();
  }else{
    $('.cls_service').show();
  }

  $(document).on('click', "#send", function () {
    var offer_type = $("input[name='offer_radio_type']:checked").val();
    if(offer_type == 2){

      var services = $("#service_name").val();
      if(services == ''){
        swal({
              title: "",
              text: "Please enter service",

          }, function () {
            $('html, body').animate({
                    scrollTop: $('.cls_service').offset().top
                }, 'slow');
          })
          return false;
      }
    }
  });
});
</script>
