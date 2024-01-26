function makePayment() {
    var totalCostString = document.getElementById('totalCost').innerText;

    var fname = document.getElementById('c_fname').value;
    var lname = document.getElementById('c_lname').value;
    var email = document.getElementById('c_email_address').value;
    var phone = document.getElementById('c_phone').value;
    var address = document.getElementById('c_address').value;

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phoneRegex = /^\d{11,}$/;

    var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
    
    if (!paymentMethod) {
        alert('Please select a payment method.');
        return;
    }

    if (!emailRegex.test(email)) {
        alert('Enter correct email');
        return;
    }

    if (!phoneRegex.test(phone)) {
        alert('Number must contain minimum 11 digits');
        return;
    }

    // Check if any required field is empty
    if (fname === '' || lname === '' || email === '' || phone === '' || address === '') {
        alert('Please fill in all required fields.');
        return;
    }

    var paymentMethodValue = paymentMethod.value;

    $.ajax({
        type: 'POST',
        url: 'php/add_payment.php',
        data: {     
            // totalCost: totalCost,
            paymentMethod: paymentMethodValue,
        },
        success: function (response) {
            if (response === 'success') {
                alert('Processing payment...');
                window.location.href = 'thankyou.html';
            } else {
                alert(response);
                window.location.href = 'index.html';
            }
        },
        error: function () {
            alert('An error occurred during the payment process.');
        }
    });
}

