<?php $this->load->view('templates/_include/header_view1'); ?>

 <div class="container">
   <div class="col-md-12" style="margin-top: 60px;margin-bottom: 20px;">
     <div class="col-md-12" style="text-align:center;font-size: 35px;">
       <span class="">All Review</span>
     </div>
     <div class="cls_main_section product_round_sub" id="load_data">
       <h2><?=$all_review_list[0]->shop_name?></h2>
       <?php foreach ($all_review_list as $key => $value) {?>
         <div class="" style="border-bottom:1px solid #c2c2c2;margin-bottom:35px;">
                <h3><?=$value->firstname?> <?=$value->lastname?></h3>
                <h5><?=$value->service_name?></h5>
                <?php
                $start = '';
                for ($i=0; $i < 5; $i++) {
                  if($i <= $value->star){
                    $start .= '<i class="fa fa-star fa-2x star-checked" id="star-'.$i.'"></i>';
                  }else{
                    $start .= '<i class="fa fa-star fa-2x" id="star-'.$i.'"></i>';
                  }
                }?>
                <?=$start?>
                <p><?=$value->review?></p>
                </div>
       <?php }?>
     </div>
   </div>

 </div>
