$( document ).ready(function() {
    $('.sa-warning').click(function(){

    var delid = $(this).attr("data-id");
    var custid = $(this).attr("data-name");

    swal({
        title: "Are you sure you want to delete this Customer?",
        text: "You will not be able to recover this Customer!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete!",
        closeOnConfirm: true
    }, function(){
        var form_data = [{"name":"id","value":custid}];
        $.ajax({
            url: "deletecustomer",
            type: "POST",
            data: form_data,
            success: function (msg) {
                $("#dytr_"+delid).toggle();
                // swal("Deleted!", "Customer has been deleted.", "success");
                //window.location.href="services";
            }
        });
    });
});
});
