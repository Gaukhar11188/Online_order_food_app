$(document).ready(function () {
    $.ajax({
        url: 'php/getCardDetails.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                console.error(data.error);
            } else {
             
                if (Object.keys(data).length > 0) {
                var cardNumber = data.cardholder_number || '';
                var formattedCardNumber = cardNumber.slice(0, 4) + '********' + cardNumber.slice(-4);

            var html = '<h2 class="h3 mb-3 text-black">Credit Card</h2>';
			html += '<img src="images/images-2.png" alt="Visa, Mastercard" width="200" height="50">';
			html += '</br>';
			html += '<p>Please, check credit card details.</p>';
			html += '<div class="form-group row">';
			html += '<div class="col-md-12">';
			html += '<label for="ch_name" class="text-black">Cardholder name<span class="text-danger">*</span></label>';
			html += '<input type="text" class="form-control" id="ch_name" name="ch_name" placeholder="Enter cardholder name" value="' + (data.cardholder_name || '') + '">';
			html += '</div>';
			html += '</div>';
			html += '<div class="form-group row">';
			html += '<div class="col-md-12">';
			html += '<label for="c_name" class="text-black">Card number<span class="text-danger">*</span></label>';
			html += '<input type="text" class="form-control" id="c_name" name="c_name" placeholder="Enter 16 digits card number" value="' + formattedCardNumber + '">';
			html += '</div>';
			html += '</div>';
			html += '<div class="form-group row mb-5">';
			html += '<div class="col-md-6">';
			html += '<label for="c_date" class="text-black">Expiration date<span class="text-danger">*</span></label>';
			html += '<input type="text" class="form-control" id="c_date" name="c_date" placeholder="MM/YYYY" value="' + (data.expiry_date || '') + '">';
			html += '</br>';
            html += '<div class="form-group">';
            html += '<button id="creditcard" class="btn btn-black btn-sm btn-block" onclick="updateCard()">Update</button>';
            html += '</div>';
            html += '</div>';
			html += '<div class="col-md-6">';
		    html += '<label for="c_cvv" class="text-black">cvv<span class="text-danger">*</span></label>';
			html += '<input type="text" class="form-control" id="c_cvv" name="c_cvv" placeholder="***" value="***">';
            
			html += '</div>';
			html += '</div>';			
            $('#creditCardSection').html(html);
            } else {
                var html = '<h2 class="h3 mb-3 text-black">Credit Card</h2>';
                html += '<img src="images/images-2.png" alt="Visa, Mastercard" width="200" height="50">';
                html += '</br>';
                html += '<p>Please, fill in credit card details.</p>';
                html += '<div class="form-group row">';
                html += '<div class="col-md-12">';
                html += '<label for="ch_name" class="text-black">Cardholder name<span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control" id="ch_name" name="ch_name" placeholder="Enter cardhodler name" value="">';
                html += '</div>';
                html += '</div>';
                html += '<div class="form-group row">';
                html += '<div class="col-md-12">';
                html += '<label for="c_name" class="text-black">Card number<span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control" id="c_name" name="c_name" placeholder="Enter 16 digits card number" value="">';
                html += '</div>';
                html += '</div>';
                html += '<div class="form-group row mb-5">';
                html += '<div class="col-md-6">';
                html += '<label for="c_date" class="text-black">Expiration date<span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control" id="c_date" name="c_date" placeholder="MM/YYYY" value="">';
                html += '</div>';
                html += '<div class="col-md-6">';
                html += '<label for="c_cvv" class="text-black">cvv<span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control" id="c_cvv" name="c_cvv" placeholder="***" value="">';
                html += '</div>';
                
                html += '<div class="form-group">';
                html += '</br>';
                html += '<button class="btn btn-black btn-sm btn-block" onclick="addCard()">Add</button>';
                html += '</div>';
                html += '</br>';
                html += '<div class="form-group">';
                html += '</div>';			
                $('#creditCardSection').html(html);
            }
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
});
