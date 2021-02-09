$(document).ready(function () {
    $("#username").on("change paste keyup", function(e){
        $(e.target).val($(e.target).val().replace(/[^a-z0-9_]/gi,''));
    });
});