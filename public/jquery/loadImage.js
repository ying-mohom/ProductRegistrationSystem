var loadFile = function(event) {
    var output = document.getElementById('imageOutput');//Get image Element
    imageOutput.src = URL.createObjectURL(event.target.files[0]);//Set Url to img src
    imageOutput.onload = function() {
        URL.revokeObjectURL(output.src) 
    }
};