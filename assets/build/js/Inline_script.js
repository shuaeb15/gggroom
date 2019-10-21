$("#frm_category").validate({
    rules: {
        cname: {
            required: true
        }
    }
});
$("#frm_brand").validate({
    rules: {
        bname: {
            required: true
        }
    }
});
$("#frm_postion").validate({
    rules: {
        position: {
            required: true
        }
    }
});
$("#frm_colour").validate({
    rules: {
        colour: {
            required: true
        }
    }
});
$('#category_table').dataTable();
$('#user_table').dataTable();


$('#brand_table').dataTable();
$('#postion_table').dataTable();
$('#colour_table').dataTable();
$('#product_table').dataTable();
$('.show_hide_row.fa-plus-circle').on('click', function () {
    $subcat = $(this).attr('itemid');
    $(this).addClass('fa-minus-circle');
    $(this).removeClass('fa-plus-circle');
    $('.r_' + $subcat + '.c_tr').css('display', 'table-row');

});
$('.show_hide_row.fa-minus-circle').on('click', function () {
    $subcat = $(this).attr('itemid');
    $(this).removeClass('fa-minus-circle');
    $(this).addClass('fa-plus-circle');
    $('.r_' + $subcat + '.c_tr').css('display', 'none');

});

$('#colour_select').fSelect();
$('#category_select').fSelect();
$('#brand_select').fSelect();

CKEDITOR.replace('product_description');

function readURL(input) {
    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#preview_logo').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
jQuery("#p_logo").change(function () {
    readURL(this);
});
function ConfirmDelete(id) {

    if (confirm("Are you want to delete this form?")) {
        $.ajax({
            url: site_url + '/Category/Delete_cat',
            method: "POST",
            data: {id: id},
            async: false,
            success: function (data) {
//                    alert(data);
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                    $('#row_' + obj.id).remove();
                    $('.r_' + obj.id).remove();
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Category deleted Successfully!</div>');

                }
                else if (obj.unsuccess == 'unsuccess') {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                } else {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
            }
        });
    }
}
function BrandDelete(id) {

    if (confirm("Are you want to delete this form?")) {
        $.ajax({
            url: site_url + '/Brand/Delete_brand',
            method: "POST",
            data: {id: id},
            async: false,
            success: function (data) {
//                    alert(data);
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                    $('#row_' + obj.id).remove();
                    $('.r_' + obj.id).remove();
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Brand deleted Successfully!</div>');

                }
                else if (obj.unsuccess == 'unsuccess') {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                } else {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
            }
        });
    }
}
function BrandDelete(id) {

    if (confirm("Are you want to delete this form?")) {
        $.ajax({
            url: site_url + '/Brand/Delete_brand',
            method: "POST",
            data: {id: id},
            async: false,
            success: function (data) {
//                    alert(data);
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                    $('#row_' + obj.id).remove();
                    $('.r_' + obj.id).remove();
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Brand deleted Successfully!</div>');

                }
                else if (obj.unsuccess == 'unsuccess') {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                } else {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
            }
        });
    }
}
function PositionDelete(id) {

    if (confirm("Are you want to delete this form?")) {
        $.ajax({
            url: site_url + '/Positions/Delete_position',
            method: "POST",
            data: {id: id},
            async: false,
            success: function (data) {
//                    alert(data);
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                    $('#row_' + obj.id).remove();
                    $('.r_' + obj.id).remove();
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Position deleted Successfully!</div>');

                }
                else if (obj.unsuccess == 'unsuccess') {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                } else {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
            }
        });
    }
}
function colourDelete(id) {

    if (confirm("Are you want to delete this form?")) {
        $.ajax({
            url: site_url + '/Colour/Delete_colour',
            method: "POST",
            data: {id: id},
            async: false,
            success: function (data) {
//                    alert(data);
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                    $('#row_' + obj.id).remove();
                    $('.r_' + obj.id).remove();
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Colour deleted Successfully!</div>');

                }
                else if (obj.unsuccess == 'unsuccess') {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                } else {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
            }
        });
    }
}
$('.brand_div .fs-option').on('click', function () {
    var brand_id = $(this).attr('data-value');
    var brand_name = $(this).find('.fs-option-label').text();
    var checked = $(this).attr('class');
    if (checked.indexOf('selected') != -1) {
         $( '#bd_' + brand_id ).remove();
    }
    else {
//         alert('check');
        $.ajax({
            url: site_url + '/product/Get_postion',
            method: "POST",
            data: {brand_id: brand_id, brand_name: brand_name},
            async: false,
            success: function (data) {
//                    alert(data);
                if (data) {
                    $('.brand_option').append(data);
                }
                else {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
            }
        });
    }
});
$('.brand_option').on('click', '.position_check', function () {
    var brand_id = $(this).attr('branditem');
    var pos_id = $(this).attr('posid');
    var pos_name = $(this).next().text();
    if (this.checked) {
        if (pos_id == '0') {
            $('#bd_' + brand_id + ' .position_check.more_pos').css('visibility', 'hidden');
            $('#bd_' + brand_id + ' .postion_lable.more_lable').css('visibility', 'hidden');
            $('#bd_' + brand_id +' .postion_appenddiv .getcolourdiv').remove();
        }
        $.ajax({
            url: site_url + '/product/Get_colour',
            method: "POST",
            data: {brand_id: brand_id, pos_id: pos_id,pos_name:pos_name},
            async: false,
            success: function (data) {
//                    alert(data);
                if (data) {
                    $('#bd_' + brand_id +' .postion_appenddiv').append(data);
                }
                else {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
            }
        });
    }
    else {
        if (pos_id == '0') {
            $('#bd_' + brand_id + ' .position_check.more_pos').css('visibility', 'visible');
            $('#bd_' + brand_id + ' .postion_lable.more_lable').css('visibility', 'visible');
            $('#bd_' + brand_id + ' .position_check').prop('checked', false);
        }
        $( '#bd_' + brand_id +' .postion_appenddiv .pos_div_'+pos_id ).remove();
    }
});
$('.brand_option').on('click', '.fa-plus-square.large', function () {
//    alert('afd');
    var brand_id = $(this).attr('itembrand');
    $('.quantity_' + brand_id).append('<input type="text" class="input_quntity col-md-5 col-xs-12" name="qty_' + brand_id + '[]">\n\
<p class="col-md-1"></p>\n\
<input type="text" class="input_price col-md-5 col-xs-12" name="price_' + brand_id + '[]">')
})
