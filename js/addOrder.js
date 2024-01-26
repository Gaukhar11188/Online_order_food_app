function placeOrder() {
   
    var totalCostString = document.getElementById('totalCost').innerText;
    
    var totalCost = parseFloat(totalCostString.replace(/[^0-9.-]+/g, ''));
     
    
    $.ajax({
        type: 'POST',
        url: 'php/add_order.php',
        data: {     
            totalCost: totalCost,
        },
        success: function (response) {
            if (response === 'success') {
                alert('New order is added!');
                window.location.href = 'checkout.html';
            } else {
                alert(response);
                // window.location.href = 'checkout.html';
            }
        },
        error: function () {
            alert('An error occurred during order addition.');
        }
    });
}
