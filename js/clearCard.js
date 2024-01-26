function clearCart(){
    $.ajax({
        url: 'php/cartManager.php',
        method: 'POST',
        data: {
            functionName: functionName = "clearCart",
        },
        dataType: 'json',
        success: function (response) {
            console.log('deleting response:', response);
            updateSingleProductCounter(productId, response.cartContents, response.totalItems);
           
        },
        error: function (error) {
            console.error('Error deleting the amount: ', error);
        }
    });
}