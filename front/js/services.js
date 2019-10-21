$(document).ready(function($) {
	var site_url = $("#site_url").val();
	$(".shopRadioCheck").click(function(event) {
		var form_data = [{"name": "shopid","value": $(this).attr('data-shopid')}];
		$.ajax({
		    url: site_url + 'service/GetShopWorkerData',
		    type: "POST",
		    data: form_data,
		    success: function(data) {
		    	// alert(data); return false;
		        // console.log(data);
		        // return false;
		        $(".ShopWorker").html(data);
		    }
		});
	});

	$(document).on('click', ".btn_save_services", function () {
	  if($(".span-form-title").is(':visible')){
	    if (!$('.btn-group-mainsubcat > button.btn').hasClass("active")) {
	      swal({
	            title: "",
	            text: "Please select sub category",

	        }, function () {
	          $('html, body').animate({
	                  scrollTop: $('.clas-main-category').offset().top
	              }, 'slow');
	        })
	        return false;
	      }
	    }

	    if($(".span-form-title1").is(':visible')){
	      if (!$('.btn-group-subcat > button.btn').hasClass("active")) {
	        swal({
	              title: "",
	              text: "Please select sub category",

	          }, function () {
	            $('html, body').animate({
	                    scrollTop: $('.clas-main-category').offset().top
	                }, 'slow');
	          })
	          return false;
	        }
	      }

	      if(!$('input[name=radiog_list_detail]:checked').length > 0){
	        swal({
	              title: "",
	              text: "Please add the shop",

	          }, function () {
	            $('html, body').animate({
	                    scrollTop: $('.cls_shop_detail').offset().top
	                }, 'slow');
	          })
	          return false;
	      }

				var price = $('#range-price').val();
				if(price == ''){
					swal({
	              title: "",
	              text: "Please enter price",

	          }, function () {
	            $('html, body').animate({
	                    scrollTop: $('.service_range_slider').offset().top
	                }, 'slow');
	          })
						return false;
				}

	        if(!$('input[type=checkbox]:checked').length > 0){
	          swal({
	                title: "",
	                text: "Please select worker",

	            }, function () {
	              // $('html, body').animate({
	              //         scrollTop: $('.cls_shop_detail').offset().top
	              //     }, 'slow');
	            })
	            return false;
	        }
	});
	$("#search_services").autocomplete({
		source: function( request, response ) {
				$.ajax( {
						url: site_url + 'service/search_services',
						type: "POST",
						dataType: "json",
						data: {
						term: request.term,
						},
						success: function( data ) {
							/*console.log(data);
							return false;*/
								response( data );
						}
				} );
		},
		select: function(event, ui) {
			var filter_services = escape(ui.item.value);
			// alert(filter_services);
			// console.log(ui.item.value);
			// $("#search-content").find('li').html('');
			if(ui.item.value != ''){
				$.ajax({
						type: 'POST',
						url: site_url+'service/get_search_service_data',
						data:'filter_services='+filter_services,
						dataType:'json',
						beforeSend: function () {
						},
						success: function (data) {
							console.log(data[0]);
							var html = '<br><div class="list-timing"><ul id="content-slider" class="content-slider tabs lightSlider lSSlide lsGrab">';
							html += '<li class="lslide"><a href="javasccript:void(0);" data-btn-id="'+data[0].category_id+'"><div class="timing_date">'+data[0].cat_name+'</div></a></li></ul></div><div id="tb'+data[0].category_id+'" class="sub-cat-div"></div>';
							$("#search-content").html(html);
							$("#content-slider li").click(function(){
								// alert("asfd");
								var subCatSection = null;
						    var cat_id = $(this).children().attr('data-btn-id');
								var tabName = $(this).children().find('div').html();
								// alert(cat_id);
						      subCatSection = this.innerHTML;
						      // var cat_id = $(this).attr('data-btn-id');
						      // $('#main_category').val(cat_id);
						      var flag = '1';
						      $.ajax({
						          url: site_url+"service/get_sub_category/"+flag,
						          type: 'post',
						          dataType: 'json',
						          data: {cat_id:cat_id},
						          success: function (data) {
						            // subCatSection = this.innerHTML;
						            // console.log(data);
						            // alert(data.category_id);
						            $(".sub-cat-div").html('');
												if(data.length <= 0){
						              subCatSection += $(".sub-cat-div").append('There is no service added for <strong>'+tabName+'</strong> category.');
						            }else{
													jQuery.each( data, function( i, val ) {

						                  var service_name = 'service_name';
						                  var faCircle = 'fa-plus-circle';
						                // }
						                if(jsonObj.length > 0){
						                // jQuery.each( jsonObj, function( j, value ) {
						                for(var k = 0, max = jsonObj.length; k < max; k++) {
						                  var seen = {};
						                  // console.log(jsonObj[k].id);
						                  // console.log(val.id);

						                    if(jsonObj[k].id === val.id){
						                      var new_minus_id = val.id;
						                        subCatSection += $(".sub-cat-div").append('<div class="col-md-6 service_name_price" ><h4 class="service_name_font">'+val.service_name+'</h4><i class="fas fa-minus-circle add_service" id="'+val.id+'" cat-id="'+cat_id+'" service-name="'+val.service_name+'" price="'+val.price+'" duration="'+val.time+'"></i><div class="service_price">Price: $'+val.price+' Duration: '+val.time+'min</div></div></div>');
						                    }
						                  }
						                }else{
						                  // alert("out");
						                  subCatSection += $(".sub-cat-div").append('<div class="col-md-6 service_name" ><h4 class="service_name_font">'+val.service_name+'</h4><i class="fas fa-plus-circle add_service" id="'+val.id+'" cat-id="'+cat_id+'" service-name="'+val.service_name+'" price="'+val.price+'" duration="'+val.time+'"></i><div class="service_price">Price: $'+val.price+' Duration: '+val.time+'min</div></div></div>');
						                }
						              });
						              if(jsonObj.length > 0){
						                for( var i=data.length - 1; i>=0; i--){
						                  for( var j=0; j<jsonObj.length; j++){
						                      if(data[i] && (data[i].id === jsonObj[j].id)){
						                        data.splice(i, 1);
						                      }
						                    }
						                }
						                jQuery.each( data, function( i, val ) {
						                  subCatSection += $(".sub-cat-div").append('<div class="col-md-6 service_name" ><h4 class="service_name_font">'+val.service_name+'</h4><i class="fas fa-plus-circle add_service" id="'+val.id+'" cat-id="'+cat_id+'" service-name="'+val.service_name+'" price="'+val.price+'" duration="'+val.time+'"></i><div class="service_price">Price: $'+val.price+' Duration: '+val.time+'min</div></div></div>');
						                });
						              }
							            // jQuery.each( data, function( i, val ) {
							            //   console.log(val);
													// 	subCatSection += $(".sub-cat-div").append('<div class="col-md-6 service_name" ><h4 class="service_name_font">'+val.service_name+'</h4><i class="fas fa-plus-circle add_service" id="'+val.id+'"></i><div class="service_price">Price: $'+val.price+' Duration: '+val.time+'min</div></div></div>');
							            // });
												}

						            $(".add_service").click(function(){
													var serviceName = $(this).attr('service-name');
					                var price = $(this).attr('price');
					                var duration = $(this).attr('duration');
					               // console.log(jsonObj);

					  						if($(this).parent().hasClass('service_name_price') == true){
					  							// alert($(this).parent().hasClass('service_name_price'));
					  							$(this).parent().removeClass('service_name_price');
					  							$(this).parent().addClass('service_name');

					  							$(this).removeClass('fa-minus-circle');
					  							$(this).addClass('fa-plus-circle');
					  							$(this).css('color', '#000');
					                // $(this).attr('id',id);
					                // alert($(this).attr("id"));
					                for(var i = 0, max = jsonObj.length; i < max; i++) {
					                    var a = jsonObj[i];

					                    if(a.id === $(this).attr("id")) {
					                        jsonObj.splice(i, 1);
					                        break;
					                    }
					                }
					  						}else {
					  							$(this).parent().removeClass('service_name');
					  							$(this).parent().addClass('service_name_price');

					  							$(this).removeClass('fa-plus-circle');
					  							$(this).addClass('fa-minus-circle');
					  							$(this).css('color', '#ff0000');
					                if(typeof($(this).attr("id")) != 'undefined'){
					                   var id = $(this).attr("id");
					                   // var email = $(this).val();
					                   item = {}
					                   item ["id"] = id;
					                   item ["cat_id"] = cat_id;
					                   item ["serviceName"] = serviceName;
					                   item ["price"] = price;
					                   item ["duration"] = duration;
					                   // $("#categories").val(item);
					                   jsonObj.push(item);
					                   var hidden_cat = JSON.stringify(jsonObj);
					                   $("#categories").val(hidden_cat);
					                }
					  						}
						  						// if($(this).parent().hasClass('service_name_price') == true){
						  						// 	// alert($(this).parent().hasClass('service_name_price'));
						  						// 	$(this).parent().removeClass('service_name_price');
						  						// 	$(this).parent().addClass('service_name');
													//
						  						// 	$(this).removeClass('fa-minus-circle');
						  						// 	$(this).addClass('fa-plus-circle');
						  						// 	$(this).css('color', '#000');
						  						// }else {
						  						// 	$(this).parent().removeClass('service_name');
						  						// 	$(this).parent().addClass('service_name_price');
													//
						  						// 	$(this).removeClass('fa-plus-circle');
						  						// 	$(this).addClass('fa-minus-circle');
						  						// 	$(this).css('color', '#ff0000');
						  						// }
						  						// $(this).parent().addClass('service_name');
						  					});
						            // var cat_data = JSON.parse(data);
						            //   $("#overlay").hide();
						          },error: function(data){
						              alert("Something went wrong, please try again.");
						          }
						      });
							});

							// $("#content-slider li").click(function(){
						  //   var subCatSection = null;
						  //   var cat_id = $(this).children().attr('data-btn-id');
						  //     subCatSection = this.innerHTML;
						  //     var flag = '1';
						  //     $.ajax({
						  //         url: site_url+"service/get_sub_category/"+flag,
						  //         type: 'post',
						  //         dataType: 'json',
						  //         data: {cat_id:cat_id},
						  //         success: function (data) {
						  //           $(".sub-cat-div").html('');
						  //           jQuery.each( data, function( i, val ) {
						  //             console.log(val);
						  //             subCatSection += $(".sub-cat-div").append('<div class="col-md-6 service_name_price" ><h4 class="service_name_font">'+val.category_id+'</h4><i class="fas fa-minus-circle add_service" id="'+val.category_id+'" style="color: red"></i><div class="service_price">Price: $20 Duration: 30min</div></div></div>');
							// 						// $("#search-content").html(html+subCatSection);
						  //           });
							//
						  //           $(".add_service").click(function(){
							//
						  // 						if($(this).parent().hasClass('service_name_price') == true){
						  // 							$(this).parent().removeClass('service_name_price');
						  // 							$(this).parent().addClass('service_name');
							//
						  // 							$(this).removeClass('fa-minus-circle');
						  // 							$(this).addClass('fa-plus-circle');
						  // 							$(this).css('color', '#000');
						  // 						}else {
						  // 							$(this).parent().removeClass('service_name');
						  // 							$(this).parent().addClass('service_name_price');
							//
						  // 							$(this).removeClass('fa-plus-circle');
						  // 							$(this).addClass('fa-minus-circle');
						  // 							$(this).css('color', '#ff0000');
						  // 						}
						  // 					});
						  //         },error: function(data){
						  //             alert("Something went wrong, please try again.");
						  //         }
						  //     });
						  // });
						}
					});
			}
		},
		change: function( event, ui ){
		},
		response: function( event, ui ) {
		}
	});
	$("#content-slider").find("li a:first-child").trigger("click");


});
