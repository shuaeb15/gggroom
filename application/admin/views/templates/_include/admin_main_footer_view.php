<!-- footer content -->
<footer>
    <div class="pull-right">
        <?php echo 'gggRoom'; ?>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<script src="<?php echo site_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js') ?> "></script>
<script src="<?php echo site_url('assets/vendors/nprogress/nprogress.js') ?> "></script>
<script src="<?php echo site_url('assets/vendors/Chart.js/dist/Chart.min.js') ?> "></script>
<script src="<?php echo site_url('assets/vendors/jquery-sparkline/dist/jquery.sparkline.min.js') ?> "></script>
<script src="<?php echo site_url('assets/js/bootstrapValidator.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?php echo site_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<script src="<?php echo site_url('assets/build/js/custom.min.js') ?> "></script>
<script src="<?php echo site_url('assets/js/jquery.validate.js') ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<?php if (!empty($full_js_file) && is_array($full_js_file)){ ?>
<?php foreach ($full_js_file as $row){?>
<script src="<?php echo $row;?>" defer="defer"></script>
<?php }?>
<?php }?>
<?php if (!empty($js_file) && is_array($js_file)){ ?>
<?php foreach ($js_file as $row){?>
<script src="<?php echo site_url($row);?>" defer="defer"></script>
<?php }?>
<?php }?>
<script src="<?php echo site_url('assets/build/js/fSelect.js') ?>"></script>
<script src="<?php echo site_url('assets/build/js/Inline_script013.js') ?>"></script>
<?php echo $before_body; ?>
</body>
</html>
