<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>
<style>
    #send{
        margin: 0px auto;
        display: table;
    }
    .error{
        color:red;
    }
</style>
<div class="right_col" role="main" style="min-height: 959px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Profile1</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <!-- <div class="x_title">
                        <h2>Profile </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div> -->
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
                    <div class="x_content">
                        <form enctype="multipart/form-data" method="post" class="form-horizontal" id="settings_frm" name="settings_frm" data-toggle="validator" action="<?php echo site_url("Dashboard/settings"); ?>">
                            <!-- <input type="hidden"  name="token" value="<?php echo $token; ?>"> -->
                            <?php
                            // echo '<pre>'; print_r($admin[0]);exit;
                            ?>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Firstname
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="firstname" name="firstname" placeholder="Enter Firstname" class="form-control col-md-7 col-xs-12 email_id" type="text" value="<?= (($admin[0]['firstname'] && $admin[0]['firstname'] != '') ? $admin[0]['firstname'] : '') ?>">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="c_password">Lastname
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="lastname" name="lastname" placeholder="Enter lastname" class="form-control col-md-7 col-xs-12 email_id" type="text" value="<?= (($admin[0]['lastname'] && $admin[0]['lastname'] != '') ? $admin[0]['lastname'] : '') ?>">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="c_password">Username
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="username" name="username" placeholder="Enter username" class="form-control col-md-7 col-xs-12 email_id" type="text" value="<?= (($admin[0]['username'] && $admin[0]['username'] != '') ? $admin[0]['username'] : '') ?>">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="c_password">Email
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="email" name="email" placeholder="Enter email" class="form-control col-md-7 col-xs-12 email_id" type="text" value="<?= (($admin[0]['email'] && $admin[0]['email'] != '') ? $admin[0]['email'] : '') ?>">
                                </div>
                            </div>
                             <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Product Image
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12 ">
                                        <input class="form-control col-md-7 col-xs-12" type="file" name="p_logo" id="admin_logo"/><br>
                                        <?php
                                        if ($admin[0]['profile_img'] != '') {
                                            $i_src = site_url('assets/images/thumb/' . $admin[0]['profile_img']);
                                            $image_name = $admin[0]['profile_img'];
                                        } else {
                                            $i_src = site_url('assets/images/img-default.gif');
                                            $image_name = '';
                                        }
                                        ?>
                                        <img id="admin_preview"  alt="your image" src="<?php echo $i_src ?>" height="150" width="150" /><br><br>
                                        <input type="hidden" name="old_image" value="<?php echo $image_name; ?>">
                                    </div>
                                </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="send" type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
