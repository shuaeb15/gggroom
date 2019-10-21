<br>
  <div class="list-timing">
  <ul id="content-slider" class="content-slider tabs">
    <?php
      $k = 1;
      foreach ($main_category as $cat) {
        // echo "<pre>"; print_r($cat);exit;
        $categories = extract($main_category);
        ?>
        <li>
          <a href="#tb<?=$cat->category_id?>" data-btn-id="<?=$cat->category_id?>"><div class="timing_date"><?=$cat->cat_name?></div></a>
        </li>
        <?php }?>
  </ul>
</div>
<?php
// echo "<pre>"; print_r($main_category);exit;
foreach ($main_category as $cat) {
  // echo "<pre>"; print_r($cat);exit;
  ?>
<div id='tb<?=$cat->category_id?>' class="sub-cat-div"></div>
<?php }?>
