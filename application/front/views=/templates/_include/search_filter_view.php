<style type="text/css" media="screen">
/* -------------------- Page Styles (not required) */

/* -------------------- Select Box Styles: bavotasan.com Method (with special adaptations by ericrasch.com) */
/* -------------------- Source: http://bavotasan.com/2011/style-select-box-using-only-css/ */
.styled-select {
   /*background: url(http://i62.tinypic.com/15xvbd5.png) no-repeat 96% 0;*/
   height: 29px;
   overflow: hidden;
   width: 100%;
}

/* -------------------- Rounded Corners */
.rounded {
   -webkit-border-radius: 20px;
   -moz-border-radius: 20px;
   border-radius: 20px;
}

#mainselection {
   overflow:hidden;
   width:350px;
   -moz-border-radius: 9px 9px 9px 9px;
   -webkit-border-radius: 9px 9px 9px 9px;
   border-radius: 9px 9px 9px 9px;
   box-shadow: 1px 1px 11px #330033;
   /*background: #58B14C url("http://i62.tinypic.com/15xvbd5.png") no-repeat scroll 319px center;*/
}
</style>
<div class="home_search">
	<section class="home_filter" style="background-image: url(<?=base_url()?>front/images2/banner2.jpg);">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12" style="background: #fff0f030;border-radius: 96px;padding-top: 60px; padding-left: 50px;padding-right: 50px;">
          <div class="">
            <div class="hello">
              <h3>Search</h3>
            </div>
            <!-- <form action="" method="post"> -->
              <div class="col-xs-12 col-sm-6 col-md-2">
                <div class="form-group" style="text-align: center;color: white;">
                  <label for="fname">By location</label>
                  <input type="text" class="form-control " autocomplete="off" name="filter_location" id="filter_location" placeholder="Zipcode" >
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="form-group" style="text-align: center;color: white">
                  <label for="sel1">Services</label>
									<!-- <div id="" class="input-group custom_drpdwn"> -->
                    <div class="">
										 <select class="form-control styled-select" name="filter_services" id="filter_services" style="cursor:pointer;">
												<option value="" style="color:#000;">Any</option>
												<?php
                          foreach ($filter_service_list as $key => $filter_service) {?>
                            <option value="<?=$filter_service->service_name?>" style="color:#000;"><?=$filter_service->service_name?></option>
                        <?php }?>
										 </select>
										 <!-- <span class="input-group-addon"><span class="fa fa-caret-down"></span></span> -->
									</div>

                  <!-- <dl class="dropdown">
                    <dt>
											<input type="hidden" class="checkitem" id="filter_services" name="filter_services"/>
											<input type="hidden" class="checkitem" id="filter_shops" name="filter_shops"/>
											<input type="hidden" class="checkitem" id="filter_max_price" name="filter_max_price"/>
											<input type="hidden" class="checkitem" id="filter_min_price" name="filter_min_price"/>
												<input type="hidden" class="checkitem" id="filter_date" name="filter_date"/>
		                      <a href="#">
                        <span class="hida">Any&nbsp; &nbsp; &nbsp;<span class="fa fa-caret-down"></span></span>
                        <p class="multiSel" style="font-size: 10px !important"></p>
                      </a>
                    </dt>
                    <dd>
                      <div class="mutliSelect">
                        <div class="button"></div>
                        <ul>
                          <li>
                            <input type="checkbox" value="30 Minutes with Male" class="checkitem"/> 30 Minutes with Male
                          </li>
                          <li>
                            <input type="checkbox" value="Adult's Hair Cut" class="checkitem" /> Adult's Hair Cut - with Mustache Trim
                          </li>
                          <li>
                            <input type="checkbox" value="Tattoo" class="checkitem"/> Tattoo
                          </li>
                        </ul>
                      </div>
                    </dd>
                  </dl> -->
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
              <div class="form-group" style="text-align: center;color: white">
                <label for="sel1">Shops</label>
								<div id="" class="">
									 <select class="form-control styled-select" name="filter_shops" id="filter_shops" style="cursor:pointer;">
											<option value="" style="color:#000;">Any</option>
											<?php
                        foreach ($filter_shop_list as $key => $filter_shop) {?>
                          <option value="<?=$filter_shop->id?>" style="color:#000;"><?=$filter_shop->shop_name?></option>
                      <?php }?>
									 </select>
									 <!-- <span class="input-group-addon"><span class="fa fa-caret-down"></span></span> -->
								</div>
								<!--
                <dl class="dropdown" style="top:61%;">
                  <dt>
                    <a href="#">
                      <span class="hidas">Any&nbsp; &nbsp; &nbsp;<span class="fa fa-caret-down"></span></span>
                      <p class="multiSels" style="font-size: 10px !important"></p>
                    </a>
                  </dt>
                  <dd>
                    <div class="mutliSelects">
                      <div class="button"></div>
                        <ul>
                          <li>
                            <input type="checkbox" value="Taka Hair Salon" class="checkitem"/> Taka Hair Salon - Sawtelle
                          </li>
                          <li>
                            <input type="checkbox" value="SmartStyle Hair Salon" class="checkitem" />SmartStyle Hair Salon
                          </li>
                          <li>
                            <input type="checkbox" value="Estelle Salon Vastrapur" class="checkitem"/> Estelle Salon Vastrapur
                          </li>
                          <li>
                            <input type="checkbox" value="Terri's Braid and Wash" class="checkitem"/> Terri's Braid and Wash
                          </li>
                        </ul>
                      </div>
                    </dd>
                  </dl> -->
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-offset-4 col-md-2" style="margin-left:0px;">
                <div class="price_input">
                  <div style="text-align: center;color: white">
                    <div class="range-slider">
                      <label for="fname">Price</label>
											<input type="hidden" class="checkitem" id="filter_min_price" name="filter_min_price" value="0"/>
											<input type="hidden" class="checkitem" id="filter_date" name="filter_date" value=""/>
                      <input class="range-slider__range" name="filter_max_price" id="filter_max_price" type="range" value="0" min="0" step="10" max="500" style="height: 30px;border:2px solid #edf3f3;background: #ffffff00">
											<div class="output"><output class="cls_main_output" style="color:#fff;">0</output></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-2">
                <div class="form-group" style="color: white; text-align: center;">
                   <label for="sel1">Sort By</label>
                   <div id="" class="">
                      <select class="form-control styled-select" name="filter_sorting" id="filter_sorting" style="cursor:pointer;">
                         <option value="" style="color:#000;">Select</option>
                         <option value="asc" style="color:#000;">Asc</option>
                         <option value="desc" style="color:#000;">Desc</option>
                      </select>
                      <!-- <span class="input-group-addon"><span class="fa fa-caret-down"></span></span> -->
                   </div>
                </div>
             </div>
             <div class="col-xs-12 col-sm-6 col-md-2 col-md-offset-7" style="clear:both;">
                <button type="button" class="btn btn-default full-width-btn emboss-btn btn_reset_service">RESET</button>
             </div>
             <div class="col-xs-12 col-sm-6 col-md-2">
                <button type="button" class="btn btn-default full-width-btn emboss-btn btn_filter_service">SEARCH</button>
             </div>
          <!-- </form> -->
       </div>
     </div>
    </div>
  </section>
</div>
<?php //}?>
