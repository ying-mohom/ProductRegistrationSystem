$(document).ready(function () {

    $(".force-delete").click(function () {
        var itemId = $(this).val(); // Get the value of the delete button
      
        $("#delete").val(itemId); // Set the value of the delete button in modal box
    });
    

    $("#delete").click(function () {

        var itemId = $(this).val();

        var itemCount = $("#itemCount").val(); //Get Item Count

        // Get the current page number and serach result from the URL
        const urlParams = new URLSearchParams(window.location.search);
        let currentPage = parseInt(urlParams.get("page")) || 1;
        var searchItemId = urlParams.get("itemId");
        var searchItemCode = urlParams.get("itemCode");
        var searchItemName = urlParams.get("itemName");
        var searchCategory = urlParams.get("category");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "item-delete",
            type: "POST",
            data: {
                item_id: itemId,
            },

            success: function (response) {
                if (response.success == true) {
                    $("#deleteModal").modal("hide");
                    //Show Message after delete is success
                    $(".alert-success").show();
                   
                } else {
                    $("#deleteModal").modal("hide");
                    //Show Error Message after delete is success
                    $(".alert-danger").show();
                }
                
                //Redirect Back to Search Result
                if ( searchItemId || searchItemCode || searchItemName || searchCategory) {
                    
                    var redirectUrl = "/items-search?search=search&";

                    if (searchItemId) {
                        redirectUrl += "itemId=" + searchItemId + "&";
                    }
                    if (searchItemCode) {
                        redirectUrl += "itemCode=" + searchItemCode + "&";
                    }
                    if (searchItemName) {
                        redirectUrl += "itemName=" + searchItemName + "&";
                    }
                    if (searchCategory) {
                        redirectUrl += "category=" + searchCategory + "&";
                    }

                    redirectUrl += "page=" + (itemCount > 1 ? currentPage : currentPage - 1);
                    window.location.href = redirectUrl;

                } else {
                    //Redirect Back to Paginate List
                    if(currentPage > 1) {
                    window.location.href = "/items-list?page=" + (itemCount > 1 ? currentPage : currentPage - 1);
                    } else {
                        window.location.href = "/items-list";
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log("Error occurred:", error);
            },
        });
    });
});
