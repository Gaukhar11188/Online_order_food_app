    $(document).ready(function loadCartItems() {
            $.ajax({
                url: 'php/cart.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log('Cart contents:', data);
                    displayCartItems(data);
                },
                error: function (error) {
                    console.error('Error fetching cart items: ', error);
                }
            });
        })

    function displayCartItems(cartItems) {
        var tableBody = $('#cartTable');
        tableBody.empty();

        if (cartItems.length > 0) {
            $.each(cartItems, function (index, item) {
                var row = '<tr>' +
                    '<td class="product-thumbnail"><img src="images/' + item.image + '" alt="Image" class="img-fluid"></td>' +
                    '<td class="product-name"><h2 class="h5 text-black">' + item.name + '</h2></td>' +
                    '<td>$' + item.price + '</td>' +
                    '<td>' +
                    '<div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">' +
                    '<div class="input-group-prepend"><button class="btn btn-outline-black decrease" type="button">&minus;</button></div>' +
                    '<input type="text" class="form-control text-center quantity-amount" value="' + item.quantity + '" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">' +
                    '<div class="input-group-append"><button class="btn btn-outline-black increase" type="button">&plus;</button></div>' +
                    '</div>' +
                    '</td>' +
                    '<td>$' + item.price * item.quantity + '</td>' +
                    '<td><a href="#" class="btn btn-black btn-sm">X</a></td>' +
                    '</tr>';
                tableBody.append(row);
            });
        } else {
            tableBody.append('<tr><td colspan="6">Your cart is empty.</td></tr>');
        }
    }

