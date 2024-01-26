
function updateSingleProductCounter(productId, cartContents, totalItems){
    let quantity = 0;
    let price = 0;
    let cart = Object.values(cartContents);
    for (let i = 0; i < cart.length; i++) {
        if (productId == cart[i]['item_id']) {
            quantity = cart[i]['quantity'];
            price = quantity * cart[i]['price'];
            break;
        }
    }

    if(quantity === 0){
        $("#single_product" + productId).remove();
        updateCartCounter(totalItems);
    }

    getTotalCost();
    getSubtotalCost();

    $("#count" + productId).val(quantity);
    $("#price" + productId).text("$"+price.toFixed(2));
}

function decreaseButtonClick(productId){
    $.ajax({
        url: 'php/cartManager.php',
        method: 'POST',
        data: {
            productId: productId,
            functionName: functionName = "decrease",
        },
        dataType: 'json',
        success: function (response) {
            console.log('Decrease response:', response);
            console.log('Decrease response:', response.cartContents);
            updateSingleProductCounter(productId, response.cartContents, response.totalItems);
        },
        error: function (error) {
            console.error('Error decreasing the amount: ', error);
        }
    });
}

function increaseButtonClick(productId){
    $.ajax({
        url: 'php/cartManager.php',
        method: 'POST',
        data: {
            productId: productId,
            functionName: functionName = "increase",
        },
        dataType: 'json',
        success: function (response) {
            console.log('Decrease response:', response);
            updateSingleProductCounter(productId, response.cartContents, response.totalItems);
        },
        error: function (error) {
            console.error('Error increaseing the amount: ', error);
        }
    });
}

function inputQuantity(productId){
    let quantity = $("#count" + productId).val();
    if (isNaN(quantity) || quantity < 1) {
        $('#count' + productId).val(1);
    }

    $.ajax({
        url: 'php/cartManager.php',
        method: 'POST',
        data: {
            productId: productId,
            functionName: functionName = "inputByText",
            quantity: quantity = $("#count" + productId).val(),
        },
        dataType: 'json',
        success: function (response) {
            console.log('Decrease response:', response);
            updateSingleProductCounter(productId, response.cartContents, response.totalItems);
        },
        error: function (error) {
            console.error('Error decreasing the amount: ', error);
        }
    });
}

function deletePosition(productId){
    $.ajax({
        url: 'php/cartManager.php',
        method: 'POST',
        data: {
            productId: productId,
            functionName: functionName = "deletePosition",
        },
        dataType: 'json',
        success: function (response) {
            console.log('deleting response:', response);
            updateSingleProductCounter(productId, response.cartContents, response.totalItems);
            // $("#single_product" + productId).remove();
            // updateCartCounter(response.totalItems);
        },
        error: function (error) {
            console.error('Error deleting the amount: ', error);
        }
    });
}





