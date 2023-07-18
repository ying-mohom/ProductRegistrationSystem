$(document).ready(function () {
    $(".active-button").click(function () {
        var itemId = $(this).val(); // Get the value of the active button
        console.log(itemId);
        $("#changeInactive").val(itemId); // Set the value of the changeInactive button
    });

    // Event handler for the click event on the "Inactive" button inside the modal box
    $("#changeInactive").click(function () {
        var itemId = $(this).val();
        console.log(itemId);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "update-active-status",
            type: "PUT",
            data: {
                item_id: itemId,
            },

            success: function (response) {
                console.log(response);

                if (response.success == true) {
                    $("#inactiveModal").modal("hide");
                    $(".alert-success").show();
                    location.reload();
                } else {
                    $("#inactiveModal").modal("hide");
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
