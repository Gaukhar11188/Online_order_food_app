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
    var tableBody = $('#cartTable');
    let cart = Object.values(cartItems);
    tableBody.empty();


    if (cart.length > 0) {
        $.each(cart, function (index, item) {
            var row = '<tr id="single_product' + item.item_id + '">' +
                '<td class="product-thumbnail"><img src="images/' + item.image + '" alt="Image" class="img-fluid"></td>' +
                '<td class="product-name"><h2 class="h5 text-black">' + item.name + '</h2></td>' +
                '<td>$' + item.price + '</td>' +
                '<td>' +
                '<div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">' +
                '<div class="input-group-prepend"><button class="btn btn-outline-black decrease" type="button" onclick="decreaseButtonClick(' + item.item_id + ')">&minus;</button></div>' +
                '<input type="text" class="form-control text-center quantity-amount" oninput="inputQuantity(' + item.item_id + ')" value="' + item.quantity + '" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" id=count' + item.item_id + '>' +
                '<div class="input-group-append"><button class="btn btn-outline-black increase" type="button" onclick="increaseButtonClick(' + item.item_id + ')">&plus;</button></div>' +
                '</div>' +
                '</td>' +
                '<td id="price' + item.item_id + '">$' + item.price * item.quantity + '</td>' +
                '<td><button class="btn btn-black btn-sm" onclick="deletePosition(' + item.item_id + ')">X</button></td>' +
                '</tr>';
            tableBody.append(row);
        });
    } else {
        tableBody.append('<tr><td colspan="6">Your cart is empty.</td></tr>');
    }
}

