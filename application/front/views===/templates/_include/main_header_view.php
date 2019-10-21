
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?=$title?></title>
    <link rel="icon" type="image/png" sizes="24x24" href="<?php echo base_url('front/images/fav.png');?>" />
    <link href="<?php echo base_url('front/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('front/css/owl.carousel.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('front/css/style.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('front/css/jquery.mCustomScrollbar.min.css');?>">
    <link href="<?php echo base_url('front/css/range-slider.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('front/css/gggroom.css?ver=1.3');?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css" />
    <script src="<?php echo base_url('front/js/range-slider.min.js');?>"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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

<style media="screen">
.mylivechat_collapsed {
  background-color: #000 !important;
  border-color: #000 !important;
}
.mylivechat_expanded{
  background-color: #000 !important;
  border-color: #000 !important;
}

.mylivechat_template5 button{
  background-color: #000 !important;
  border-color: #000 !important;
}
</style>
<body class="loaded">

    <input type="hidden" name="site_url" id="site_url" value="<?php echo base_url(); ?>">
    <script>
    var CI = {
    'base_url': '<?php echo base_url(); ?>'
    };
    var time= '<?php echo date("H:i")?>';
    var site_url = '<?php echo site_url();?>';
    </script>
    <!-- <div id="loadingDiv">
        <div>
            <h7>Please wait...</h7>
        </div>
    </div> -->
    <div id="overlay"><div class="loader"></div></div>
