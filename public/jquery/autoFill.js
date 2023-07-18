//Auto fill with Item ID
$(document).ready(function () {
    $('input[name="itemId"]').on("input", function () {
        var itemId = $(this).val();

        // Make an AJAX request to retrieve item details
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "items-fetch",
            method: "POST",
            data: {
                item_id: itemId,
            },
            success: function (response) {
                if (response.success) {
                    // Populate the item name and item code input fields
                    $("#itemName").val(response.data.item_name);
                    // console.log($("#itemName").val(response.data.item_name));

                    $("#itemCode").val(response.data.item_code);
                } else {
                    // Clear the input fields if item ID is not found
                    $("#itemName").val("");
                    $("#itemCode").val("");
                }
            },
            error: function () {
                // Handle any errors that occur during the AJAX request
            },
        });
    });
});
