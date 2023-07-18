//Add Category to database and append it in select box
$(document).ready(function () {
    $("#save").click(function () {
        var categoryName = $("#categoryName").val(); //Get category name

        var trimCategoryName = categoryName.trim().toLowerCase(); //trim space

        var url = $('script[src$="addCategory.js"]').attr("data-url");

        //Duplicate category name error
        var duplicateFound = false;

        var selectBoxOptions = document.getElementById("selectBox").options;

        //Iterate each option to check whether it equals to given category name
        for (var i = 0; i < selectBoxOptions.length; i++) {
            //If given category name is equal to category name in option break from the loop and set duplicateFound to true
            if (
                selectBoxOptions[i].text.trim().toLowerCase() == trimCategoryName) {
                duplicateFound = true;
                break; // Exit the loop early if a duplicate is found
            }
        }

        //If has duplicate show error message
        if (duplicateFound) {
            $("#validateCategoryInput").text(
                "* Category Name is already exist!"
            );
            return;
        }

        //Check Add Category Input Field
        //If input field is null show error message

        if (categoryName == "") {
            $("#validateCategoryInput").text("*Category Name is Required!*");
        }

        //If input field has data store in database and append to select boxes
        if (categoryName.trim() !== "") {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: url,
                method: "POST",
                data: {
                    categoryName: categoryName,
                },
                success: function (response) {
                    // Make an AJAX request to retrieve the latest ID
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "/getLatestCategoryId",
                        method: "GET",
                        success: function (response) {
                            var latestId = response.latestId;

                            // Create a new option element with the latest ID and category name
                            var option1 = $("<option>")
                                .val(latestId)
                                .text(categoryName)
                                .prop("selected", true);
                            var option2 = $("<option>")
                                .val(latestId)
                                .text(categoryName);

                            // Append the new option elements to the select boxes
                            $("#selectBox").append(option1);
                            $("#selectBox2").append(option2);
                            $("#noDeleteAbleCategory").text("Choose Category");
                        },
                        error: function (xhr, status, error) {
                            // Handle the error case appropriately
                            console.error(error);
                        },
                    });

                    // Hide the modal
                    $("#addCategory").modal("hide");
                    // Clear the input field
                    $("#categoryName").val("");
                    //Clear the vlidation field
                    $("#validateCategoryInput").text("");

                    alert("Category added Successfully!");
                   
                },
                error: function (xhr, status, error) {
                    console.log("Error occurred:", error);
                },
            });
        }
    });
 
    //Close Btn in Modal and clear input field
    $("#closeBtn").click(function () {
        $("#categoryName").val("");
        $("#validateCategoryInput").text("");
    });
});
