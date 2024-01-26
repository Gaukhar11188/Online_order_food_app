$(document).ready(function () {

    $.ajax({
    url: 'php/getsuperheader.php',
    method: 'GET',
    dataType: 'html',
    success: function (data) {
        $('#icon_list').html(data);},
    error: function (error) {
        console.error('Error fetching: ', error);
    }
});
});
