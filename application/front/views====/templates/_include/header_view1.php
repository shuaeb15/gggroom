<style>
    @media screen and (max-width: 768px) {
        .logo img {
            margin: 0px auto !important;
            display: flex !important;
            padding: 14px 0px !important;
        }
        .topnav {
            float: unset !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 38px 0px !important;
        }
        .topnav a {
            display: unset !important;
            padding: 0px 4px !important;
            font-size: 10px !important;
        }
        .home_search {
            padding-top: 0px !important;
        }
        .home_filter {
            padding-top: 50px !important;
            padding-bottom: 1px !important;
        }
        .home_filter .hello h3 {
            text-align: center !important;
        }
        .sign-body {
            padding: 60px 0px 10px !important;
        }
        .form-check {
            width: 50% !important;
        }
        .past-booking h4 {
            font-size: 11px !important;
            text-align: center !important;
        }
        .like_dislike .fav {
            margin-top: 38px !important;
        }
        .like_dislike i {
            margin-top: 40px !important;
        }
        .locate ul {
            overflow: auto;
        }
        .cls_name {
            font-size: 20px !important;
        }
        .top-cal-button {
            margin: 14px -1px 0px 6px !important;
        }
        .p-detail-list {
            margin-bottom: 20px !important;
        }
        #load_data_message h2 {
            font-size: 18px !important;
        }
    }
    @media screen and (min-width: 769px) and (max-width: 1024px) {
        .logo img {
            margin-left: 20px !important;
        }
        .topnav {
            padding: 10px !important;
        }
        .form-check {
            width: 50% !important;
        }
    }
</style>
<!--
<?php if(!empty($userlist)){?>
<div class="col-md-12" style="text-align: right;">
	<form class="example frm_search_home" id="frm_search_home" action="<?php echo base_url();?>searchresults" method="get">
			<input type="text" id="search" class="headerSearch" placeholder="Search Anything" name="search">
			<button type="submit" class="advance_search"><i class="fa fa-search"></i></button>
	</form>
</div>
<?php }?> -->
<script>

</script>
<div class="col-md-9" style="background-color: #e6e6e6; height: 90px;">
	<div class="col-md-12" style="text-align: right;">
		<div class="topnav" id="myTopnav">
			<!-- <ul> -->
				<?php
				if(!empty($userlist)){?>
					<a href="<?php echo base_url('booking'); ?>">BOOKINGS</a>
					<a href="<?php echo base_url('favourite'); ?>">FAVORITES</a>
					<a href="<?php echo base_url('chat'); ?>">MESSAGES</a>
			<!-- <li><a href="<?php echo base_url('booking'); ?>">BOOKINGS</a></li>
			<li><a href="<?php echo base_url('favourite'); ?>">FAVORITES</a></li>
			<li><a href="<?php echo base_url('chat'); ?>">MESSAGES</a></li> -->
			<?php
				$img = $userlist->image;
				$temp_file = base_url()."front/images2/user.png";
				$main_file = "assets/uploads/profile_image/".$img;
				$filename = FCPATH.$main_file;
				if (file_exists($filename)) {
					if($img != ''){
							$main_image =  base_url().$main_file;
					}else{
							$main_image =  $temp_file;
					}
				}else{
					$main_image =  $temp_file;
				}?>
				<a href="<?php echo site_url();?>profile">PROFILE </a>
				<a href="<?php echo base_url();?>login/logout">LOGOUT</a>
				<!-- <li class="dropdown edit-profile-menu open" style="padding-right: 10px;"> -->
					<a href="<?php echo site_url();?>profile" class="dropdown edit-profile-menu open">
					<img src="<?=$main_image?>" alt="" title="" class="img-responsive pull-right img-circle menu_profile hidden-xs">
				</a>
				<!-- </li> -->
			<!-- <li><a href="<?php echo site_url();?>profile">PROFILE </a>&nbsp;&nbsp;&nbsp; |</li>
			<li><a href="<?php echo base_url();?>login/logout">LOGOUT</a></li>
			<li class="dropdown edit-profile-menu open" style="padding-right: 10px;">
				<a href="<?php echo site_url();?>profile">
				<img src="<?=$main_image?>" alt="" title="" class="img-responsive pull-right img-circle menu_profile hidden-xs">
			</a>
			</li> -->
			<a href="javascript:void(0);" class="icon" onclick="myFunction()">
		    <i class="fa fa-bars"></i>
		  </a>
		<?php }else{
			//echo "Asdf";exit;?>
			<a href="<?php echo base_url('login'); ?>">LOGIN</a>
			<a href="<?php echo base_url("login/register"); ?>">SIGN UP</a>
		<?php }?>
			<!-- </ul> -->
		</div>
	</div>
</div>
</div>

<?php
// echo "<pre>1"; print_r($userlist);exit;
//if(!empty($userlist)){?>
