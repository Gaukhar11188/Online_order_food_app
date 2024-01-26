
    function addProduct() {
        var name = $('#name').val();
        var category = $('#category').val();
        var price = $('#price').val();
        var image = $('#image').val();

        $.ajax({
            type: 'POST',
            url: 'php/add_product.php',
            data: {
                name: name,
                category: category,
                price: price,
                image: image
            },
            success: function (response) {
                if (response === 'success') {
                    alert('New product is added!');
                } else {
                    alert(response);
                }
            },
            error: function () {
                alert('An error occurred during product addition.');
            }
        });
    }


    function deleteProduct() {
        var id = $('#id').val();

        $.ajax({
            type: 'POST',
            url: 'php/delete_product.php',
            data: {
                id: id
            },
            success: function (response) {
                if (response === 'success') {
                    alert('Product deleted successfully!');
                } else {
                    alert(response);
                }
            },
            error: function () {
                alert('An error occurred during product deletion.');
            }
        });
    }

    function showProduct() {
        var itemid = $('#itemid').val();
        $.ajax({
            url: 'php/show_product.php',
            type: 'GET',
            dataType: 'json',
            data: { itemid: itemid},
            success: function(data) {
                if (data.length > 0) {
                    var message = 'Product information:\n';
                    for (var i = 0; i < data.length; i++) {
                        message += 'Name: ' + data[i].name  + '\n' +
                        'Item id: ' + data[i].item_id + '\n' +
                        'Category: ' + data[i].category + '\n' +
                        'Price: ' + data[i].price + '\n';
                    }
                    alert(message);
                } else {
                    alert('Product not found!');
                }
            },
            error: function(error) {
                console.error('Error fetching product information:', error);
            }
        });
    }