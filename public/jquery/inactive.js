
$(document).ready(function () {
    $(".inactive-button").click(function () {
        var itemId = $(this).val(); // Get the value of the Inactive button
        console.log(itemId);
        $("#changeActive").val(itemId); // Set the value of the changeActive button
    });
    // Event handler for the click event on the "Active" button inside the modal box
    $("#changeActive").click(function () {
        var itemId = $(this).val();
        console.log(itemId);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "update-inactive-status",
            type: "PUT",
            data: {
                item_id: itemId,
            },

            success: function (response) {
                console.log(response);
                
                if (response.success == true) {
                    $("#activeModal").modal("hide");
                    $(".alert-success").show();
                    location.reload();
                } else {
                    $("#activeModal").modal("hide");
                    $(".alert-danger").show();
                    location.reload();
                }
                
            },
            error: function (xhr, status, error) {
                console.log("Error occurred:", error);
            },
        });
    });
});

