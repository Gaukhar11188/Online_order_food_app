function addToCartButton(productId) {
    $.ajax({
        url: 'php/isLogin.php',
        method: 'GET',
        dataType: 'html',
        success: function (data) {
            console.log(data);
            if (data == 1) {
                addToCart(productId);
            } else {
                window.location.href = "./customer_login.html";
            }
        },
        error: function (error) {
            console.error('Error checking login status: ', error);
        }
    });
}

function addToCart(productId) {
    // Add the product to the cart
    $.ajax({
        url: 'php/addToCart.php',
        method: 'POST',
        data: { productId: productId },
        dataType: 'json',
        success: function (response) {
            console.log('addToCart response:', response);
            updateCartCounter(response.totalItems);
        },
        error: function (error) {
            console.error('Error adding to cart: ', error);
        }
    });
}

function updateCartCounter(count) {
    if(count === 0){
        console.log(count)
        $("#cartTable").append('<tr><td colspan="6">Your cart is empty.</td></tr>');
    }
    $('#cartCounter').text(count);
}
