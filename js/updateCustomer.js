function updateCustomer() {
    var fname = document.getElementById('c_fname').value;
    var lname = document.getElementById('c_lname').value;
    var email = document.getElementById('c_email_address').value;
    var phone = document.getElementById('c_phone').value;
    var address = document.getElementById('c_address').value;

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phoneRegex = /^\+\d{11}$/;

    if (!emailRegex.test(email)) {
        alert('Enter correct email');
        return;
    }
    if (!phoneRegex.test(phone)) {
        alert('Phone number must contain one plus sign and 11 digits');
        return;
    }

    // Check if any required field is empty
    if (fname === '' || lname === '' || email === '' || phone === '' || address === '') {
        alert('Please fill in all required fields.');
        return;
    }

    $.ajax({
        type: 'POST',
        url: 'php/update_customer.php',
        data: {     
            fname: fname,
            lname: lname,
            email: email,
            phone: phone,
            address: address
        },
        success: function (response) {
            if (response === 'success') {
                alert('Customer data is updated!');
            } else {
                alert(response);
            }
        },
        error: function () {
            alert('An error occurred during customer data update.');
        }
    });
}

