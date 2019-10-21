
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo COMPANY_NAME; ?> | Login</title>

        <!-- Bootstrap -->
        <link href="<?php echo site_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('assets/css/bootstrapValidator.min.css'); ?>" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?php echo site_url('assets/build/css/custom.min.css'); ?>" rel="stylesheet">
    </head>

    <body class="login">
        <style>
            body{
                background: url('<?php echo FRONT_URL; ?>/images/memento-category-bg.jpg')!important;
            }
            @media (min-width: 992px){
                footer {
                    margin-left: 0;
                }
            }
            .main_container .top_nav {
                margin-left: 0;
            }
            .x_panel{
                margin-top: 25%;
            }
            #send{
                margin: 0px auto;
                display: table;
            }
            .error{
                color:red;
            }
        </style>
        <div role="main">
            <div class="">
                <div class="row1" style="height:600px">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Change password </h2>
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
                            </div>
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
                                <form enctype="multipart/form-data" method="post" class="form-horizontal" id="changepassword_frm" name="changepassword_frm" data-toggle="validator" action="<?php echo site_url("Dashboard/changepassword"); ?>">
                                    <input type="hidden"  name="token" value="<?php echo $token; ?>">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="password" name="password" placeholder="Enter password" class="form-control col-md-7 col-xs-12 email_id" type="password">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="c_password">Confirm password
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="c_password" name="c_password" placeholder="Enter Confirm password" class="form-control col-md-7 col-xs-12 email_id" type="password">
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
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
        <script src="<?php echo site_url('assets/vendors/jquery/dist/jquery.min.js'); ?>"></script>
        <script src="<?php echo site_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo site_url('assets/js/bootstrapValidator.min.js'); ?>"></script>
        <script src="<?php echo site_url('assets/js/jquery.validate.js') ?>" type="text/javascript" charset="utf-8"></script>
        <script>
            $('#changepassword_frm').validate({
                rules: {
                    password: {
                        required: true
                    },
                    c_password: {
                        required: true,
                        equalTo: "#password"
                    }
                }
            });
        </script>
    </body>
</html>
