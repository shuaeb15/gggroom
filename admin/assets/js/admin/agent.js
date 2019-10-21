  // $('.sa-dispatch-warning').click(function(){
    $(document).on('click', ".sa-agent-warning", function () {
        var delid = $(this).attr("data-id");
        var custid = $(this).attr("data-name");

        swal({
            title: "Are you sure you want to delete this Agent?",
            text: "You will not be able to recover this Agent!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: true
        }, function () {
            var form_data = [{"name": "id", "value": custid}];
            $.ajax({
                url: "deleteagent",
                type: "POST",
                data: form_data,
                success: function (msg) {
                    $("#dytr_" + delid).toggle();
                    // swal("Deleted!", "Agent has been deleted.", "success");
                    //window.location.href="services";
                }
            });
        });
    });
