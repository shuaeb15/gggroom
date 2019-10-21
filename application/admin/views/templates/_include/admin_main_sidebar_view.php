<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <?php
            // $profile = $this->session->userdata('profile_picture');
            // if(@$profile){
            //     $adminlogoimg = '../assets/images/thumb/'.$profile;
            // }else{
            //    $adminlogoimg = '../assets/uploads/users/userflat_icon.png';
            // }
            ?>
            <a href="<?php echo site_url(); ?>" class="site_title sidebar_logo">
              <img src="<?php //echo site_url($adminlogoimg);?>" alt=""> <span>GGGroom</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
            </div>
            <div class="profile_info">
              <span><h2>Welcome, <?php echo $_SESSION['name'];?></h2></span>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
          <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
              <li>
                <a href="<?php echo site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
              </li>
              <?php if($admin_data[0]['user_promotion'] != 3){?>
                <li><a><i class="fa fa-user"></i> Users <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if($admin_data[0]['user_promotion'] != 3){?>
                    <li><a href="<?php echo site_url('user') ?>"> External users </a></li>
                    <?php }?>
                    <?php if($admin_data[0]['user_promotion'] == 1){?>
                    <li><a href="<?php echo site_url('admin') ?>"> Internal users </a></li>
                    <?php }?>
                  </ul>
                </li>
              <?php }?>
                <!-- <li>
                  <a href="<?php echo site_url('user') ?>"><i class="fa fa-user "></i> Users </a>
                </li> -->

              <li><a><i class="fa fa-list-alt"></i> Category <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a href="<?php echo site_url('category') ?>"> Parent Category </a></li>
                  <li><a href="<?php echo site_url('category/subcategory') ?>"> Sub Category </a></li>
                  <li><a href="<?php echo site_url('category/childcategory') ?>"> Child Category </a></li>
                </ul>
              </li>
              <li>
                <a href="<?php echo site_url('shop') ?>"><i class="fa fa-shopping-cart "></i> Shop </a>
              </li>
              <?php if($admin_data[0]['user_promotion'] != 3){?>
                <li><a href="<?php echo site_url('worker') ?>"><i class="fa fa-user "></i> Worker </a></li>
                <li><a href="<?php echo site_url('service') ?>"><i class="fa fa-reorder "></i> Service </a></li>
                <li><a><i class="fa fa-calendar-o "></i>Appointments <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('appointment') ?>">Appointments </a></li>
                    <li><a href="<?php echo site_url('calendar') ?>">Worker appointments </a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-list-alt"></i>CMS Pages <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('page/add_page') ?>"> Add page </a></li>
                    <li><a href="<?php echo site_url('page') ?>"> View page </a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-map-marker"></i>Location <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('location') ?>"> State </a></li>
                    <li><a href="<?php echo site_url('city') ?>"> City </a></li>
                  </ul>
                </li>
                <?php }?>
              <li><a href="<?php echo site_url('offers') ?>"><i class="fa fa-gift"></i> Promotions and offers </a></li>
              <!-- <?php if($admin_data[0]['user_promotion'] == 1){?>
              <li><a><i class="fa fa-list-alt"></i>User Permission <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a href="<?php echo site_url('admin/add_user') ?>"> Add User </a></li>
                  <li><a href="<?php echo site_url('admin') ?>"> View User </a></li>
                </ul>
              </li>
            <?php }?> -->
            <li><a><i class="fa fa-list-alt"></i>Document Types<span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="<?php echo site_url('document') ?>"> View Document Types </a></li>
              </ul>
            </li>
            <li><a><i class="fa fa-list-alt"></i>Poll<span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <!-- <li><a href="<?php echo site_url('poll/add_poll') ?>"> Add Poll </a></li> -->
                <li><a href="<?php echo site_url('poll') ?>"> Add / View Poll </a></li>
                <li><a href="<?php echo site_url('poll/get_poll_data') ?>"> Poll Submissions </a></li>
              </ul>
            </li>
            </ul>
          </div>
        </div>
    </div>
</div>
