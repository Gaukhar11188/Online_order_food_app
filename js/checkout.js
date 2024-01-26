function loadCartItems() {
    $.ajax({
        url: 'php/cart.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Cart contents:', data);
            displayCartItems(data);
            getTotalCost();
            getSubtotalCost();
        },
        error: function (error) {
            console.error('Error fetching cart items: ', error);
        }
    });
}

$(document).ready(loadCartItems())

function displayCartItems(cartItems) {
    var tableBody = $('#checkTable');
    let cart = Object.values(cartItems);
    tableBody.empty();
    
    if (cart.length > 0) {
        $.each(cart, function (index, item) {
            var row = '<tr>' + 
		                      '<td>' + item.name + '<strong class="mx-2">x</strong>' + item.quantity + '</td>' +
		                      '<td>$ ' + item.price * item.quantity + '</td>' +
		                    '</tr>';                         		                    	                   
            tableBody.append(row);

        });
    } else {
        tableBody.append('<tr><td colspan="6">Your cart is empty.</td></tr>');
    }
}

