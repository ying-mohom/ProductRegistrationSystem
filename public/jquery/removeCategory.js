//Remove Category from database and select box
$(document).ready(function () {
    //Check Wherether Categories are deleteable or not
    checkCategoryAvailability();

    $("#remove").click(function () {
        // Remove category with modal box
        var selectedValue = $("#selectBox2").val();

        //Show Error Message If user do not choose category
        if (selectedValue === "noSelect") {

            //IF there is noDeleteAble Category show error message
            if ( $("#noDeleteAbleCategory").text() === "*No Categories Can Be Delete!*") {

                $("#noCategorySelect").text(
                    "*There are no categories to delete!"
                );
            } else {
                //IF there is category and do not choose category show this error message
                $("#noCategorySelect").text(
                    "*Choose category you want to remove!"
                );
            }

            return;
        }

        var url = $('script[src$="removeCategory.js"]').attr("data-url"); //Get URL

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            method: "POST",
            data: {
                selectedValue: selectedValue,
            },

            success: function (response) {

                if (response.success == true) {
                    // Remove the selected option from the select box
                    $("#selectBox2 option").each(function () {
                        if ($(this).val() === selectedValue) {
                            $(this).remove();
                        }
                    });
                    $("#selectBox option").each(function () {
                        if ($(this).val() === selectedValue) {
                            $(this).remove();
                        }
                    });

                    // Hide the remove dialog box
                    $("#removeCategory").modal("hide");
                    $("#noCategorySelect").text("");
                    alert("Category Remove Successfully");
                    location.reload();

                } else {
                    
                    $("#removeCategory").modal("hide");
                    $("#noCategorySelect").text("");               
                    alert("Category remove Fail");              
             
                }
            },
            error: function (xhr, status, error) {
                console.log("Error occurred:", error);
            },
        });
    });

    //Check Wherether Categories are deleteable or not
    function checkCategoryAvailability() {
        var categoryCount = $("#selectBox2 option").length;
        if (categoryCount === 1) {
            $("#noDeleteAbleCategory").text("*No Categories Can Be Delete!*");
        }
    }

    //Close Btn in Modal and clear input field
    $(".btn-close").click(function () {
        $("#noCategorySelect").text("");
    });
});
