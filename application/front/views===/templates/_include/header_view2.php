<div class="col-md-9" style="background-color: #e6e6e6; height: 90px;">
	<div class="col-md-12" style="text-align: right;">
		<div class="list_nav cls_list_nav">
			<ul>
			<li><a href="">SHOP MANAGEMENT </a>&nbsp;&nbsp;&nbsp; |</li>
			<li><a href="<?php echo site_url();?>profile">PROFILE </a>&nbsp;&nbsp;&nbsp; |</li>
			<li><a href="<?php echo base_url();?>login/logout">LOGOUT</a></li>
			<li><a href=""><img src="<?php echo base_url('front/images2/alarm.png');?>"></a></li>
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
			<li class="dropdown edit-profile-menu open" style="padding-right: 10px;">
				<a href="<?php echo site_url();?>profile">
					<img src="<?=$main_image?>" alt="" title="" class="img-responsive pull-right img-circle menu_profile hidden-xs">
			  </a>
			</li>
			</ul>
		</div>
	</div>
</div>
</div>
