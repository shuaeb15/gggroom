<section>
	<div class="footer_new">
		<div class="container col-heads">
			<div class="col-md-3">
				<div class="footer_image" style="display: block;">
					<img src="<?php echo base_url('front/images2/logo.png');?>" style="margin-left: 7px;width: 75%;">
					<!-- <img src="<?php echo base_url('front/images2/android.png');?>" width="80%"> -->
					<img src="<?php echo base_url('front/images2/app-store.png');?>" width="80%">
					<img src="<?php echo base_url('front/images2/play-store.png');?>" width="80%">
				</div>
			</div>
			<div class="col-md-3 col-heads">
				<h3 style="color: white">Learn more</h3>
				<p style="font-weight: bold; padding-top: 0px; color: white;">
					<a href="<?=base_url();?>faq">FAQs<br /></a>
					<a href="<?=base_url();?>policy">Privacy Policy<br /></a>
					<a href="<?=base_url();?>Terms">Terms of Use <br /></a>
					<a href="<?=base_url();?>press">Press <br /></a>
					<!-- <a href="<?=base_url();?>tos">Terms of Services<br /></a> -->
				</p>
			</div>
			<div class="col-md-3 col-heads">
				<h3 style="color: white">Top Cities</h3>
				<p style="font-weight: bold; padding-top: 0px; color: white;">
					<a href="<?=base_url();?>">Raleigh, NC<br /></a>
				</p>
			</div>
			<div class="col-md-3 col-heads">
				<h3 style="color: white">Talk To Us</h3>
				<div class="social-area">
          <a href="https://twitter.com/GgGroom" target = '_blank'><img src="<?php echo base_url('front/images2/twitter.png');?>"></a>
          <a href="https://www.facebook.com/gggroom/" target = '_blank'><img src="<?php echo base_url('front/images2/facebook-icon.png');?>"></a>
          <a href="https://www.instagram.com/gggroomapp/" target = '_blank'><img src="<?php echo base_url('front/images2/insta-icon.png');?>"></a>
        </div>
			</div>
		</div>
	</div>
  <div class="tiny_footer">
	   © <?=date("Y");?> GGGroom, LLC.
  </div>
</section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
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
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: '22a42423-37dd-46a6-b0cc-7551d9b9b34e', f: true }); done = true; } }; })();
</script>

<!-- <script type="text/javascript">function add_chatinline(){var hccid=35597665;var nt=document.createElement("script");nt.async=true;nt.src="https://mylivechat.com/chatinline.aspx?hccid="+hccid;var ct=document.getElementsByTagName("script")[0];ct.parentNode.insertBefore(nt,ct);}
add_chatinline();</script> -->

</body>
</html>
