<div style="background-image: url(<?=base_url()?>front/images/home_banner.jpg);" class="home_header_main">
   <div class="header-afterlogin header-home">
      <nav class="">
         <div class="container-fluid">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="<?php echo site_url();?>">
                  <div class="logo">
                     <img src="<?=base_url()?>front/images/logo.png" alt="" title="" class="img-responsive" />
                  </div>
               </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav">
                  <li><a href="<?php echo base_url('booking'); ?>">BOOKINGS</a></li>
                  <li><a href="<?php echo base_url('favourite'); ?>">FAVORITES</a></li>
                  <li><a href="<?php echo base_url('chat'); ?>">MESSAGES</a></li>
                  <li class="dropdown edit-profile-menu">
                    <?php
                    $img = $userlist->image;
                    $temp_file = base_url()."front/images/user.png";
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
                     <a href="<?php echo site_url();?>profile" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="<?=$main_image?>" alt="" title="" class="img-responsive pull-right img-circle menu_profile hidden-xs" />
                        <div class="hidden-sm hidden-md hidden-lg"> PROFILE <span class="caret"></span> </div>
                     </a>
                     <div class="dropdown-menu">
                        <h3><?=$userlist->firstname?> <?=$userlist->lastname?></h3>
                        <p><?=$userlist->username?></p>
                        <div role="separator" class="divider"></div>
                        <div class="dropdown_btn">
                           <div>
                              <a href="<?php echo base_url();?>profile"><div class="button_link">Profile</div></a>
                           </div>
                           <div>
                              <a href="<?php echo base_url();?>login/logout"><div class="button_link">Logout</div></a>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
   </div>
   <div class="custom-search">
      <div class="container">
         <div class="row">
            <div class="search_sec">
               <form class="frm_search_home" id="frm_search_home" action="<?php echo base_url();?>searchresults" method="get">
                  <div id="custom-search-input">
                     <div class="input-group col-md-12">
                       <div class="col-md-11">
                         <input type="text" name="search" class="form-control input-lg headerSearch" id="search" placeholder="Search Anything" />
                       </div>
                       <div class="col-md-1 cls_btn_search">
                         <button type="submit" class="advance_search">
                           <span class="input-group-btn">
                             <i class="glyphicon glyphicon-search"></i>
                           </span>
                         </button>
                       </div>
                     </div>
                  </div>
                  <!-- <button type="submit" class="advance_search">
                    <i class="glyphicon glyphicon-search" style="top: 5px;font-size: 30px;"></i>
                    <img src="<?php echo base_url('front/images/search.png'); ?>">
                  </button> -->
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
