$(document).ready(function () {

    $.ajax({
        url: 'php/getOrderId.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $("#orderInfo").text("You order #" + data + " was successfuly completed.");
            clearCart();
            //alert(data);
            },
        error: function (error) {
            console.error('Error fetching top products: ', error);
        }
    });
});