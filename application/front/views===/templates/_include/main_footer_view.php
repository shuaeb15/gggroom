
<footer class="white">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3 part-1">
                <h4>GGGroom App</h4>
                <ul>
                    <li><a href="#">Get the android app</a></li>
                    <li><a href="#">Get the iphone app</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-3 part-2">
                <h4>Learn more</h4>
                <ul>
                  <?php foreach ($footer_pages1 as $key => $page) {?>
                        <li><a href="<?=base_url().'page/'.$page->page_url?>"><?=$page->name?></a></li>
                  <?php }?>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-3 part-3">
                <h4>Top cities</h4>
                <ul>
                  <?php foreach ($footer_pages2 as $key => $page) {?>
                        <li><a href="<?=base_url().'page/'.$page->page_url?>"><?=$page->name?></a></li>
                  <?php }?>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-3 part-4">
                <h4>Talk to us</h4>
                <div class="social-area">
                  <a href="https://twitter.com/GgGroom" target = '_blank'><img src="<?=base_url()?>front/images/twitter.png" style="border-radius: 50%;"></a>
                  <a href="https://www.facebook.com/gggroom/" target = '_blank'><img src="<?=base_url()?>front/images/facebook-icon.png"></a>
                  <a href="https://www.instagram.com/gggroomapp/" target = '_blank'><img src="<?=base_url()?>front/images/insta-icon.png"></a>
                </div>
                <ul>
                  <!-- <li><a href="<?=base_url().'chat/'?>">Chat</a></li> -->
                  <!-- <?php foreach ($footer_pages3 as $key => $page) {?>
                        <li><a href="<?=base_url().'page/'.$page->page_url?>"><?=$page->name?></a></li>
                  <?php }?> -->
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; <?=date("Y");?> GGGroom,Inc.
        </div>
    </div>
</footer>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script> -->
<script src="<?=base_url()?>front/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url()?>front/js/owl.carousel.min.js"></script>
<script src="<?=base_url()?>front/js/jquery.validate.js"></script>
<script src="<?=base_url()?>front/js/custom_validation.js"></script>
<script src="<?=base_url()?>front/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=base_url()?>front/js/custom.js"></script>
<?php if (!empty($js_file) && is_array($js_file)){ ?>
<?php foreach ($js_file as $row){?>
<script src="<?php echo site_url($row);?>" defer="defer"></script>
<?php }?>
<?php }?>

<script type='text/javascript' data-cfasync='false'>
window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: '22a42423-37dd-46a6-b0cc-7551d9b9b34e', f: true }); done = true; } }; })();
</script>

<!-- <script type="text/javascript">function add_chatinline(){var hccid=35597665;var nt=document.createElement("script");nt.async=true;nt.src="https://mylivechat.com/chatinline.aspx?hccid="+hccid;var ct=document.getElementsByTagName("script")[0];ct.parentNode.insertBefore(nt,ct);}
add_chatinline(); </script> -->

</body>
</html>
