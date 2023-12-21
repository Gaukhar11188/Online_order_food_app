function addStaff() {
    var userId = document.getElementById('userid').value;
    var firstName = document.getElementById('fname').value;
    var lastName = document.getElementById('lname').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var address = document.getElementById('address').value;
    var position = document.getElementById('position').value;

    $.ajax({
        type: 'POST',
        url: 'php/add_staff.php',
        data: {     
            userid: userId,
            fname: firstName,
            lname: lastName,
            email: email,
            phone: phone,
            address: address,
            position: position
        },
        success: function (response) {
            if (response === 'success') {
                alert('New staff member is added!');
            } else {
                alert(response);
            }
        },
        error: function () {
            alert('An error occurred during staff member addition.');
        }
    });
}

function deleteStaff() {
    var id = $('#id').val();

    $.ajax({
        type: 'POST',
        url: 'php/delete_staff.php',
        data: {
            id: id
        },
        success: function (response) {
            if (response === 'success') {
                alert('Staff member deleted successfully!');
            } else {
                alert(response);
            }
        },
        error: function () {
            alert('An error occurred during user deletion.');
        }
    });
}

    function showStaff() {
        var fname1 = $('#fname1').val();
        var lname1 = $('#lname1').val();
        $.ajax({
            url: 'php/show_staff.php',
            type: 'GET',
            dataType: 'json',
            data: { fname1: fname1, lname1: lname1 },
            success: function(data) {
                if (data.length > 0) {
                    var message = 'Staff information:\n';
                    for (var i = 0; i < data.length; i++) {
                        message += 'Name: ' + data[i].first_name + ' ' + data[i].last_name + '\n' +
                        'Email: ' + data[i].email + '\n' +
                        'Phone: ' + data[i].phone_number + '\n' +
                        'Address: ' + data[i].address + '\n' +
                        'Position: ' + data[i].position + '\n' +
                        'User Id: ' + data[i].user_id + '\n' +
                        'Role Id: ' + data[i].role_id + '\n';
                    }
                    alert(message);
                } else {
                    alert('Staff member not found!');
                }
            },
            error: function(error) {
                console.error('Error fetching staff information:', error);
            }
        });
    }


