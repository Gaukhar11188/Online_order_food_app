$(document).ready(function () {

    $.ajax({
    url: 'php/isReturning.php',
    method: 'GET',
    dataType: 'html',
    success: function (data) {
        $('#isReturning').html(data);},
    error: function (error) {
        console.error('Error fetching top products: ', error);
    }
});
});