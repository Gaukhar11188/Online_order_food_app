
    function addSuperUser() {
        var login = $('#login').val();
        var password = $('#password').val();

        $.ajax({
            type: 'POST',
            url: 'php/add_superuser.php',
            data: {
                login: login,
                password: password
            },
            success: function (response) {
                if (response === 'success') {
                    alert('New user is added!');
                } else {
                    alert(response);
                }
            },
            error: function () {
                alert('An error occurred during user addition.');
            }
        });
    }

    function deleteSuperUser() {
        var userid = $('#userid').val();

        $.ajax({
            type: 'POST',
            url: 'php/delete_superuser.php',
            data: {
                userid: userid
            },
            success: function (response) {
                if (response === 'success') {
                    alert('User deleted successfully!');
                } else {
                    alert(response);
                }
            },
            error: function () {
                alert('An error occurred during user deletion.');
            }
        });
    }

    function resetPassword() {
        var login1 = $('#login1').val();
        var password1 = $('#password1').val();
    
        $.ajax({
            type: 'POST',
            url: 'php/update_user.php', 
            data: {
                login1: login1,
                password1: password1
            },
            success: function (response) {
                if (response === 'success') {
                    alert('User password updated!');
                } else {
                    alert(response);
                }
            },
            error: function () {
                alert('An error occurred during user password update.');
            }
        });
    }
    
    