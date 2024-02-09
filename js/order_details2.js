$(document).ready(function () {
    var urlParams = new URLSearchParams(window.location.search); 
    var orderId = urlParams.get('order_id'); 

    if (orderId) { 
        $.ajax({
            url: 'php/order_info.php',
            method: 'GET',
            data: { order_id: orderId }, 
            dataType: 'html',
            success: function (data) {
                $('#personalinfo2').html(data);
            },
            error: function (error) {
                $('#personalinfo2').html('<p>Error fetching info: ' + error + '</p>');
            }
        });
    } else {
        $('#personalinfo2').html('<p>Missing order_id parameter in URL</p>'); 
    }
});
