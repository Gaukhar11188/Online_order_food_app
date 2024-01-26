
function showOrder() {
    var id = $('#id').val();
    $.ajax({
        url: 'php/show_order.php',
        type: 'GET',
        dataType: 'json',
        data: { id: id },
        success: function(data) {
            if (data.length > 0) {
                var message = 'ORDER INFORMATION\n';
                for (var i = 0; i < data.length; i++) {
                    message += 
                    'Order Id: ' + data[i].order_id + '\n' +
                    'Name: ' + data[i].customer_name + ' ' + data[i].customer_last_name + '\n' +
                    'Email: ' + data[i].customer_email + '\n' +
                    'Phone: ' + data[i].customer_phone_number + '\n' +
                    'Address: ' + data[i].customer_address + '\n' +
                    'Date: ' + data[i].order_date + '\n' +
                    'Total amount: ' + data[i].total_amount + '\n' +
                    'Status: ' + data[i].status + '\n'+
                    'Menu items: ' + data[i].menu_items_names + '\n' +
                    'Quantities: ' + data[i].quantities + '\n';
                }
                alert(message);
            } else {
                alert('Order with given id not found!');
            }
        },
        error: function(error) {
            console.error('Error fetching order information:', error);
        }
    });
}

function updateStatus(){
    var id1 = document.getElementById('id1').value;
    var statusSelect = document.getElementById('statusSelect').value;

    $.ajax({
        type: 'POST',
        url: 'php/update_order.php',
        data: {     
            id1: id1,
            statusSelect: statusSelect
        },
        success: function (response) {
            if (response === 'success') {
                alert('Status is updated!');
            } else {
                alert(response);
            }
        },
        error: function () {
            alert('An error occurred during status update.');
        }
    });
}

function pad(number) {
    return (number < 10 ? '0' : '') + number;
}
function showOrders() {
    var dateString = document.getElementById("orderDate").value;

    if (dateString.trim() !== "") {
        var dateObject = new Date(dateString);
        var formattedDate = dateObject.getFullYear() + '-' + pad((dateObject.getMonth() + 1)) + '-' + pad(dateObject.getDate());

        var content = 'ORDERS INFORMATION\n';

        $.ajax({
            url: 'php/show_orders.php',
            type: 'GET',
            dataType: 'json',
            data: { formattedDate: formattedDate },
            success: function (data) {
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        content +=
                            'Order Id: ' + data[i].order_id + '\n' +
                            'Date: ' + data[i].order_date + '\n' +
                            'Total amount: ' + data[i].total_amount + '\n' +
                            'Status: ' + data[i].status + '\n' +
                            'Menu items: ' + data[i].menu_items_names + '\n' +
                            'Quantities: ' + data[i].quantities + '\n\n';
                    }

                    // Create a Blob with the content and trigger a download
                    var blob = new Blob([content], { type: 'text/plain' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'orders_info.doc';
                    link.click();
                } else {
                    alert('Orders not found!');
                }
            },
            error: function (error) {
                console.error('Error fetching order information:', error);
            }
        });
    }
}
