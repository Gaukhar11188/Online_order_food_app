function addToCartButton(productId) {
    // Check if the user is logged in
    $.ajax({
        url: 'php/isLogin.php',
        method: 'GET',
        dataType: 'html',
        success: function (data) {
            console.log(data);
            if (data == 1) {
                // If logged in, add the product to the cart
                addToCart(productId);
            } else {
                // If not logged in, redirect to the login page
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
    // Update the cart counter in the navbar
    $('#cartCounter').text(count);
}
