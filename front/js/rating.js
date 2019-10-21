$(document).ready(function($) {
	$(document).on('click', ".starSection", function (event) {
	// $(".starSection").click(function(event) {
		var id = $(this).attr('data-id');
		for (var i = 0; i < $(".starSection").length; i++)
		{
			if(i < id)
			{
				$(".starSection").eq(i).addClass('star-checked');
			}
			else
			{
				$(".starSection").eq(i).removeClass('star-checked');
			}
		}
		$("#serviceData").attr('data-star',id);
	});

	$(document).on('click', ".starSection1", function (event) {
	// $(".starSection").click(function(event) {
		var id = $(this).attr('data-id');
		for (var i = 0; i < $(".starSection1").length; i++)
		{
			if(i < id)
			{
				$(".starSection1").eq(i).addClass('star-checked');
			}
			else
			{
				$(".starSection1").eq(i).removeClass('star-checked');
			}
		}
		$("#serviceData1").attr('data-star',id);
	});

	$(document).on('click', ".starSection2", function (event) {
	// $(".starSection").click(function(event) {
		var id = $(this).attr('data-id');
		for (var i = 0; i < $(".starSection1").length; i++)
		{
			if(i < id)
			{
				$(".starSection2").eq(i).addClass('star-checked');
			}
			else
			{
				$(".starSection2").eq(i).removeClass('star-checked');
			}
		}
		$("#serviceData2").attr('data-star',id);
	});

	$(document).on('click', ".starSection3", function (event) {
	// $(".starSection").click(function(event) {
		var id = $(this).attr('data-id');
		for (var i = 0; i < $(".starSection1").length; i++)
		{
			if(i < id)
			{
				$(".starSection3").eq(i).addClass('star-checked');
			}
			else
			{
				$(".starSection3").eq(i).removeClass('star-checked');
			}
		}
		$("#serviceData3").attr('data-star',id);
	});

	$(document).on('click', ".starSection4", function (event) {
	// $(".starSection").click(function(event) {
		var id = $(this).attr('data-id');
		for (var i = 0; i < $(".starSection1").length; i++)
		{
			if(i < id)
			{
				$(".starSection4").eq(i).addClass('star-checked');
			}
			else
			{
				$(".starSection4").eq(i).removeClass('star-checked');
			}
		}
		$("#serviceData4").attr('data-star',id);
	});

	$(document).on('click', ".addReview", function (event) {
	// $(".addReview").click(function(event) {
		for (var i = 0; i < $(".starSection").length; i++)
		{
			$(".starSection").eq(i).removeClass('star-checked');
		}
		var worker_name = $(this).attr('data-worker-name');
		$('#lbl_worker_name').html(worker_name);
		var shop = $(this).attr('data-shop');
		var service = $(this).attr('data-service');
		var appointment = $(this).attr('data-appointment');
		var worker_id = $(this).attr('data-worker-id');
		$("#serviceData").attr('data-shop',shop);
		$("#serviceData").attr('data-service',service);
		$("#serviceData").attr('data-appointment',appointment);
		$("#serviceData").attr('data-worker-id', worker_id);

		var form_data = [{"name": "shopid","value": shop},{"name": "serviceid","value": service},{"name": "workerid","value": worker_id},{"name": "appointment","value": appointment}];
       	$.ajax({
            url: site_url + 'booking/CheckReview',
            type: "POST",
            data: form_data,
            success: function(data) {
                if($.trim(data) != "1")
                {
                	var obj = JSON.parse(data);
                	var review = obj.review;
                	var star = obj.star;
                	var worker_star = obj.worker_star;
                	var service_quality = obj.service_quality;
                	var friendliness = obj.friendliness;
                	var cleanliness = obj.cleanliness;
                	var value_for_mony = obj.value_for_mony;
                	//console.log('obj',service_quality);
                	$("#add_review").val(review);
                	$("#serviceData").attr('data-star',worker_star);
                	$("#serviceData1").attr('data-star',service_quality);
                	$("#serviceData2").attr('data-star',friendliness);
                	$("#serviceData3").attr('data-star',cleanliness);
                	$("#serviceData4").attr('data-star',value_for_mony);
                	// alert($(".modelPopupStar .starSection").length);
                	for (var i = 0; i < $(".modelPopupStar .starSection").length; i++)
					{
						if(i < worker_star)
						{
							$(".starSection").eq(i).addClass('star-checked');
						}
						else
						{
							$(".starSection").eq(i).removeClass('star-checked');
						}
					}

					for (var i = 0; i < $(".modelPopupStar .starSection1").length; i++)
					{
						if(i < service_quality)
						{
							$(".starSection1").eq(i).addClass('star-checked');
						}
						else
						{
							$(".starSection1").eq(i).removeClass('star-checked');
						}
					}
                    
                    for (var i = 0; i < $(".modelPopupStar .starSection2").length; i++)
					{
						if(i < friendliness)
						{
							$(".starSection2").eq(i).addClass('star-checked');
						}
						else
						{
							$(".starSection2").eq(i).removeClass('star-checked');
						}
					}

					for (var i = 0; i < $(".modelPopupStar .starSection3").length; i++)
					{
						if(i < cleanliness)
						{
							$(".starSection3").eq(i).addClass('star-checked');
						}
						else
						{
							$(".starSection3").eq(i).removeClass('star-checked');
						}
					}

					for (var i = 0; i < $(".modelPopupStar .starSection4").length; i++)
					{
						if(i < value_for_mony)
						{
							$(".starSection4").eq(i).addClass('star-checked');
						}
						else
						{
							$(".starSection4").eq(i).removeClass('star-checked');
						}
					}


                }
            }
        });
		$("#add_review").val("");
		$('#myModal').modal('show');
	});

$(document).on('click', "#SaveReview", function () {
	// $("#SaveReview").on("click", function () {
		var shop = $("#serviceData").attr('data-shop');
		var service = $("#serviceData").attr('data-service');
		var appointment = $("#serviceData").attr('data-appointment');
		var star1 = $("#serviceData1").attr('data-star');
		var star2 = $("#serviceData2").attr('data-star');
		var star3 = $("#serviceData3").attr('data-star');
		var star4 = $("#serviceData4").attr('data-star');
		var worker_star = $("#serviceData").attr('data-star');

		var star = ((parseInt(star1,10) + parseInt(star2,10) + parseInt(star3,10) + parseInt(star4,10)) / 2).toFixed(2); 

		//var star = starn.toFixed(2);


		var review = $("#add_review").val();
		var worker_id = $("#serviceData").attr('data-worker-id');

		var form_data = [{"name": "value_for_mony","value": star4},{"name": "cleanliness","value": star3},{"name": "friendliness","value": star2},{"name": "service_quality","value": star1},{"name": "worker_star","value": worker_star},{"name": "shopid","value": shop},{"name": "serviceid","value": service},{"name": "workerid","value": worker_id},{"name": "appointment","value": appointment},{"name": "star","value": star},{"name": "review","value": review}];
		
       	$.ajax({
            url: site_url + 'booking/AddReview',
            type: "POST",
            data: form_data,
            success: function(data) {
							// console.log(data);
							if(data == 1){
								$('.cls_success_msg').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Review update successfully</div>');
							}
							else{
								$('.cls_success_msg').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Review add successfully</div>');
							}

							setTimeout(function () {
								$('.cls_success_msg').hide();
							}, 5000);
            }
        });
	});


});
