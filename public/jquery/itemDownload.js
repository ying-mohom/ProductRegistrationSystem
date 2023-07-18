$(document).ready(function () {
    //Set item Id to hidden input field in pdf and excel
    $("#itemId").keyup(function () {
        var itemId = $(this).val();
        $("#pdfItemId").val(itemId);
        $("#excelItemId").val(itemId);
    });

    //Set item code  to hidden input field in pdf and excel
    $("#itemCode").keyup(function () {
        var itemCode = $(this).val();
        $("#pdfItemCode").val(itemCode);
        $("#excelItemCode").val(itemCode);
    });

    //Set item Name to hidden input field in pdf and excel
    $("#itemName").keyup(function () {
        var itemName = $(this).val();
        $("#pdfItemName").val(itemName);
        $("#excelItemName").val(itemName);
    });
    
    //Set category id  to hidden input field in pdf and excel 
    $("#category").change(function () {
        var selectedValue = $(this).val();
        $("#pdfCategory").val(selectedValue);
        $("#excelCategory").val(selectedValue);
    });
  
    //Get Value after click search and put value to hidden field
    var urlParams = new URLSearchParams(window.location.search);
    var itemId = urlParams.get("itemId");
    var itemCode = urlParams.get("itemCode");
    var itemName = urlParams.get("itemName");
    var category = urlParams.get("category");

     //Put the value to  field after submit
    $("#itemId").val(itemId);
    $("#itemCode").val(itemCode);
    $("#itemName").val(itemName);
    $("#category").val(category);
   
    //Put the value to hidden field after submit
    $("#pdfItemId").val(itemId);
    $("#pdfItemCode").val(itemCode);
    $("#pdfItemName").val(itemName);
    $("#pdfCategory").val(category);

    //Put the value to hidden field after submit
    $("#excelItemId").val(itemId);
    $("#excelItemCode").val(itemCode);
    $("#excelItemName").val(itemName);
    $("#excelCategory").val(category);
    
    
   
});
