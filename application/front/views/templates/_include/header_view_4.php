<style media="screen">
.cls-home-search-text{
  margin-top: 89px;
color: white;
text-align: center;
font-size: 39px;
line-height: 45px;
}
</style>
<div style="background-image: url(<?php echo base_url('front/images/banner2.jpg'); ?>" class="home_header_main">
   <div class="header-afterlogin header-home">
      <nav class="">
         <div class="container-fluid">
            <div class="navbar-header">
              <?php if(!empty($userlist)){?>
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <?php }?>
               <a class="navbar-brand" href="<?php echo site_url();?>">
                  <div class="logo">
                     <img src="<?php echo base_url('front/images/logo.png'); ?>" alt="" title="" class="img-responsive" />
                  </div>
               </a>
            </div>
            <div class="navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav">
                  <li style="float:right;"><a href="<?php echo base_url("login/register"); ?>">SIGN UP</a></li>
                  <li style="float:right;"><a href="<?php echo base_url('login'); ?>">LOG IN</a></li>
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
                    <img src="<?php echo base_url('front/images/search.png'); ?>">
                  </button> -->
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
