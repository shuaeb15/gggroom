<!DOCTYPE html>
<html>
  <head>
	   <title><?=$title?></title>
	   <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="icon" type="image/png" sizes="24x24" href="<?php echo base_url('front/images/fav.png');?>" />
     <link rel="stylesheet" type="text/css" href="<?php echo base_url('front/css2/style.css');?>">
     <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('front/css/gggroom.css');?>"> -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

	   <link rel="stylesheet" type="text/css" href="<?php echo base_url('front/css2/bootstrap.min.css');?>">
     <link href="<?php echo base_url('front/css/owl.carousel.min.css');?>" rel="stylesheet">
     <link rel="stylesheet" href="<?php echo base_url('front/css/jquery.mCustomScrollbar.min.css');?>">
     <link href="<?php echo base_url('front/css/range-slider.css');?>" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <link href="<?php echo base_url('front/css/jquery.multiselect.css');?>" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css" />
     <link href="<?php echo base_url('front/css2/lightslider.css');?>" rel="stylesheet">
     <script src="<?php echo base_url('front/js/range-slider.min.js');?>"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
     <script src="<?php echo base_url('front/js/jquery.multiselect.js');?>"></script>
     <script src="<?php echo base_url('front/js/lightslider.js');?>"></script>

     <?php if (!empty($full_js_file) && is_array($full_js_file)){ ?>
     <?php foreach ($full_js_file as $value){?>
     <script src="<?php echo $value;?>" defer="defer"></script>
     <?php }?>
     <?php }?>
     <?php if (!empty($css_file) && is_array($css_file)){ ?>
     <?php foreach ($css_file as $row){?>
     <?php if($row == 'front/css/fullcalendar.print.min.css'){ $var = "media='print'"; }else{ $var = ""; } ?>
     <link rel="stylesheet" href="<?php echo site_url($row);?>" <?php echo $var; ?> />
     <?php }?>
     <?php }?>

  </head>
  <style type="text/css">
    a.btn-link-a {
    color: #fff !important;
  }
  a.btn-link-a:hover {
    color: #000 !important;
    transition: 0.5s;
  }
  .leftbox1{
    width: 89% !important;
    height: 215px;
  }
  .owl-carousel.owl-theme.service_carousel.owl-loaded.owl-drag {
    padding: 0% 1% !important;
}
.aero1 img {
    width: 2% !important;
    position: relative;
    float: left;
    margin-top: -138px !important;
    left: -14px !important;
}
  </style>
<body>
  <input type="hidden" name="site_url" id="site_url" value="<?php echo base_url(); ?>">
  <div id="overlay"><div class="loader"></div></div>
  <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;">
  	<div class="col-md-3" style="background-color: #299494">
  		<div class="logo">
  		<a href="<?php echo site_url();?>"><img src="<?php echo base_url('front/images2/logo.png');?>"></a></div>
  	</div>
