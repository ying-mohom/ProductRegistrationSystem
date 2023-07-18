
  $(document).ready(function() {
    // Autocomplete for itemId input
    $('#itemId').autocomplete({
      source: '/autocomplete/itemId',
      minLength: 1 ,
    });

    // Autocomplete for itemCode input
    $('#itemCode').autocomplete({
      source: '/autocomplete/itemCode',
      minLength: 1 
    });

    // Autocomplete for itemName input
    $('#itemName').autocomplete({
      source: '/autocomplete/itemName', 
      minLength: 1 
    });
  
  });

