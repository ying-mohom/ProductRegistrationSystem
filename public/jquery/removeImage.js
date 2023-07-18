$(document).ready(function () {
    // Clear file value and remove image
    $("#removeFile").click(function () {
        $("#fileInput").val("");
        $("#imageOutput").attr("src", "");
        $("#removeImage").val("true");
    });

    // Submit button click event
    $("#update").click(function () {
        // Check the value of the removeImage field
        var removeImage = $("#removeImage").val();

        var  url = "/image-delete";


        if (removeImage === "true") {
            // Delete the image from the database

            // Get the file name from the data attribute
            var fileName = $("#removeImage").data("file-name");
           
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: url,
                method: "POST",
                data: {
                    fileName: fileName,
                },
                success: function (response) {
                    console.log("Remove Image Successfull!");
                },
                error: function (xhr, status, error) {
                   
                    console.log("Remove Image Fail");
                },
            });
        }
    });
});
