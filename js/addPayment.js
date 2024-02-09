function makePayment() {
    var fname = document.getElementById('c_fname').value;
    var lname = document.getElementById('c_lname').value;
    var email = document.getElementById('c_email_address').value;
    var phone = document.getElementById('c_phone').value;
    var address = document.getElementById('c_address').value;

    var chname = document.getElementById('ch_name').value;
    var cname = document.getElementById('c_name').value;
    var cdate = document.getElementById('c_date').value;
    var cvv = document.getElementById('c_cvv').value;
    var totalCostString = document.getElementById('totalCost').innerText;
    var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');

    if (!paymentMethod) {
        alert('Please select a payment method.');
        return;
    }

    if (fname === '' || lname === '' || email === '' || phone === '' || address === '') {
        alert('Please fill in all required fields.');
        return;
    }

    var paymentMethodValue = paymentMethod.value;

    if (paymentMethodValue == 2) {
        if (chname === '' || cname === '' || cdate === '' || cvv === '') {
            alert('Please fill in all required fields.');
            return;
        }
    }

    $.ajax({
        type: 'POST',
        url: 'php/add_payment.php',
        data: {
            paymentMethod: paymentMethodValue,
        },
        success: function (response) {
            if (response === 'success') {
                alert('Processing payment...');
                window.location.href = 'thankyou.html';
                }
            else if(response === 'Insufficient funds on the credit card.')
            {
                alert('Insufficient funds on the credit card.');
                window.location.href = 'checkout.html';  
            }    
             else {
                alert('Processing payment...');
                alert(response);
                window.location.href = 'thankyou.html';
            }
        },
        error: function () {
            alert('An error occurred during the payment process.');
        }
    });
}
