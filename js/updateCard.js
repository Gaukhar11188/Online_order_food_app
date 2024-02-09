function updateCard() {
    var chname = document.getElementById('ch_name').value;
    var cname = document.getElementById('c_name').value;
    var cdate = document.getElementById('c_date').value;
    var cvv = document.getElementById('c_cvv').value;


    var cardRegex = /^\d{16}$/;
    var cvvRegex = /^\d{3}$/;
    var dateRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;

    if (!cardRegex.test(cname)) {
        alert('Enter 16 digits card number!');
        return;
    }
    if (!cvvRegex.test(cvv)) {
        alert('Enter 3 digits cvv number');
        return;
    }

    if (!dateRegex.test(cdate)) {
        alert('Enter date in MM/YY format only!');
        return;
    }

    if (chname === '' || cname === '' || cdate === '' || cvv === '') {
        alert('Please fill in all required fields.');
        return;
    }

    $.ajax({
        type: 'POST',
        url: 'php/update_card.php',
        data: {     
            chname: chname,
            cname: cname,
            cdate: cdate,
            cvv: cvv
        },
        success: function (response) {
            if (response === 'success') {
                alert('Card data is updated!');
            } else {
                alert(response);
            }
        },
        error: function () {
            alert('An error occurred during card data update.');
        }
    });
}

