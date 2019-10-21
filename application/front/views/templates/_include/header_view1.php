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
