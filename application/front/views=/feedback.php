
<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
@media only screen and (max-width:480px){
  .radio_main_div {
    max-width: 100%;
 }
 .css-label{
   margin-right: 14px !important;
 }
}
</style>
<!-- <section class="block"> -->
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="edit-form">
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
                    <span class="form-title">FEEDBACK</span>
                    <!-- <div id="div_6585814"></div> -->
                    <div id="div_6756416"></div>
                </div>
            </div>
        </div>
    </div>
<!-- </section> -->
<!-- <script>
EMBED_PARAMS = {};
EMBED_PARAMS.surveyID =6756416;
EMBED_PARAMS.domain ="//www.questionpro.com";
EMBED_PARAMS.src ="//www.questionpro.com/a/TakeSurvey?tt=5swy6NY2Dhw%3D";
EMBED_PARAMS.width ="100%";
EMBED_PARAMS.height = "1181px";
EMBED_PARAMS.border = "hidden";
</script>
<script src="//www.questionpro.com/javascript/embedsurvey.js?version=1"></script> -->

<script>
EMBED_PARAMS = {};
EMBED_PARAMS.surveyID =6756416;
EMBED_PARAMS.domain ="//www.questionpro.com";
EMBED_PARAMS.src ="//www.questionpro.com/a/TakeSurvey?tt=wup1/pUIvf4%3D&id=123&custom1=flowers.com";
EMBED_PARAMS.width ="100%";
EMBED_PARAMS.height = "1181px";
EMBED_PARAMS.border = "hidden";
</script>
<div id="div_6756416"></div>
<script src="//www.questionpro.com/javascript/embedsurvey.js?version=1"></script>



<!-- <script>
<div id="div_3420957"></div>
EMBED_PARAMS = {};
EMBED_PARAMS.surveyID =3420957;
EMBED_PARAMS.domain ="//www.questionpro.com";
EMBED_PARAMS.src ="//www.questionpro.com/a/TakeSurvey?tt=APSJxRTNH2A%3D";
EMBED_PARAMS.width ="100%";
EMBED_PARAMS.height = "1181px";
EMBED_PARAMS.border = "hidden";
</script> -->

<script src="//www.questionpro.com/javascript/embedsurvey.js?version=1"></script>
