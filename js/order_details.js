$(document).ready(function () {
    var urlParams = new URLSearchParams(window.location.search); 
    var orderId = urlParams.get('order_id'); 

    if (orderId) { 
        $.ajax({
            url: 'php/get_orderDetails.php',
            type: 'GET',
            data: { order_id: orderId }, 
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    console.error(data.error);
                } else {
                    var html = ''; 
                    if (data.length > 0) { 
                        data.forEach(function(item) { 
                            html += '<tr id="single_product' + item.item_id + '">';
                            html += '<td class="product-thumbnail"><img src="images/' + item.img_pc + '" alt="Image" class="img-fluid"></td>';
                            html += '<td class="product-name"><h2 class="h5 text-black">' + item.name + '</h2></td>';
                            html += '<td>$' + item.price + '</td>';
                            html += '<td>' + item.quantity + '</td>';
                            html += '<td id="price' + item.item_id + '">$' + (item.price * item.quantity) + '</td>';
                            html += '</tr>';
                        });
                    } else {
                        html = '<tr><td colspan="6">No items found</td></tr>';
                    }
                    $('#orderTable').html(html); 
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    } else {
        console.error('Missing order_id parameter in URL'); 
    }
});
