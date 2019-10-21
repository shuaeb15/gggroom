var site_url = $("#site_url").val();

$('#invoice_table').dataTable({
    searching: false,
    paging: false,
    ordering: false,
    dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
});
$("#cust_name").autocomplete({

    source: '/phpprojects/osm/invoice/getusername',
    select: function (event, ui) {

        $("#cust_name").val(ui.item.label);
        $("#c_id").val(ui.item.key_a);
        $("#email").val(ui.item.email);

    },
    change: function (event, ui) {
        if (ui.item) {
            $("#cust_name").val(ui.item.label);
            $("#c_id").val(ui.item.key_a);
            $("#email").val(ui.item.email);

        }
    },
    focus: function (event, ui) {
        $("#cust_name").val(ui.item.label);

    }
});

 $(function () {
        $("#send_accept").click(function (e) {
          //alert("hii12334");
            // passing down the event
            var id = $('#i_id').val();
            var site_root=$("#site_root").val();
           // alert(site_root);
//            var base_url = '<?php echo site_url('invoice/acceptinvoice') ?>/' + id;
//            alert(base_url);
            $.ajax({
                url: site_root + "invoice/acceptinvoice/"+ id,
                type: 'POST',
                data: {invoice_id: id},
                success:function () {
                        $('#send_accept').css('display', 'none');
                        window.location.href = site_root + "invoice/invoice_view";
                },

            });
            e.preventDefault(); // could also use: return false;
        });
    });


  $(function () {
     var v= $("#reject_form").validate({

            rules: {
                comment: {
                    required: true

                }
            }

        });
        $("#send_reject").click(function (e) {
//            alert("h123");
            if(!v.form()){ return false;}
            var id1 = $('#rej_id').val();
            var com_id = $('#com_id').val();
            var site_root=$("#site_root").val();
//            alert(com_id);
//            var base_url = '<?php echo site_url('invoice/rejectinvoice') ?>/' + id1;
//            alert(base_url);
            $.ajax({
//                url: base_url,
              url: site_root + "invoice/rejectinvoice/"+ id1,

                type: 'POST',
                data: {invoice_id1: id1, comment: com_id},
                success: function () {
//alert(data);

                        $('#send_reject').css('display', 'none');
                        window.location.href = site_root + "invoice/invoice_view";

                },
                error: function () {
                    alert("Fail")
                }
            });
            e.preventDefault(); // could also use: return false;
        });
    });
