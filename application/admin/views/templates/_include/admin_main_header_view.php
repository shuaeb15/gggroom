<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo 'gggRoom';?>  </title>

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css" />
        
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script> 
        
        
        <link href="<?php echo site_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('assets/css/bootstrapValidator.min.css'); ?>" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo site_url('assets/vendors/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo site_url('assets/vendors/nprogress/nprogress.css'); ?>" rel="stylesheet">
        <!-- bootstrap-daterangepicker -->
        <link href="<?php echo site_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('assets/css/jquery-ui.css'); ?>" rel="stylesheet">
        <!-- Custom Theme Style -->

        <link href="<?php echo site_url('../front/css/style4.css'); ?>" rel="stylesheet" type="text/css">
        <!-- <link href="<?php //echo FRONT_URL; ?>css/style4.css" rel="stylesheet" type="text/css"> -->
        <link href="<?php echo site_url('assets/build/css/custom.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('assets/build/css/fSelect.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('assets/build/css/demo.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo site_url('assets/css/validate/screen.css');?>" type="text/css" media="screen" />
        <link href="<?php echo base_url('../front/images/fav.png');?>" rel="shortcut icon"  type="images/favicon" />
        <link href="<?php echo base_url('../front/css/jquery.multiselect.css');?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- <script src="<?php echo site_url('assets/vendors/jquery/dist/jquery.min.js') ?> "></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="<?php echo base_url('../front/js/jquery.multiselect.js');?>"></script>
        <?php echo $before_head; ?>
        <?php if (!empty($full_css_file) && is_array($full_css_file)){ ?>
        <?php foreach ($full_css_file as $value){?>
        <link rel="stylesheet" type="text/css" href="<?php echo $value;?>" />
        <?php }?>
        <?php }?>
        <?php if (!empty($css_file) && is_array($css_file)) { ?>
            <?php foreach ($css_file as $row) { ?>
                <link rel="stylesheet" href="<?php echo site_url($row); ?>" />
            <?php } ?>
        <?php } ?>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>
                            <input type="hidden" name="site_root" id="site_root" value="<?php echo site_url(); ?>">
                            <ul class="nav navbar-nav navbar-right">
                                   <?php if($this->session->userdata('admin_id') != ''){?>
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                     <?php
                     // $profile = $this->session->userdata('profile_picture');
                     // if(@$profile){
                     //     $adminlogoimg = 'assets/images/thumb/'.$profile;
                     // }else{
                     //     $adminlogoimg = 'assets/uploads/users/userflat_icon.png';
                     // }
                     ?>
                    <img src="<?php //echo site_url($adminlogoimg);?>" alt="">
                    Welcome, <?php echo $this->session->userdata('name');?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <!--<li><a href="<?php echo site_url('Customer/EditCustomer');?>">Edit Profile</a></li>-->
                    <li><a href="<?php echo site_url("Dashboard/change_password");?>"> Change Password</a></li>
                    <li><a href="<?php echo site_url("Dashboard/settings");?>"> Setting</a></li>
                    <li><a href="<?php echo site_url("Dashboard/logout");?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
                  <?php } ?>

                            </ul>
                        </nav>
                    </div>
                </div>
                <input type="hidden" name="site_url" id="site_url" value="<?php echo base_url(); ?>">
                <!-- /top navigation -->
                <!-- <script>
 var CI = {
            'base_url': '<?php //echo base_url(); ?>'
          };
          var time= '<?php //echo date("H:i")?>';
          var site_url = '<?php //echo site_url();?>';
</script> -->
<style>
    .notification_scroll{
    max-height:  500px;
  overflow-y: auto;
}
</style>
