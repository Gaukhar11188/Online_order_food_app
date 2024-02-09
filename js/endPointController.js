$(document).ready(function () {
    $.ajax({
        url: 'php/isLogin.php',
        method: 'GET',
        dataType: 'html',
        success: function (data) {
            console.log(data);
            if (data == 1) {
                console.log("Session is active. Stay on the current page.");
            } else {
                window.location.href = "./customer_login.html";
            }
        },
        error: function (error) {
            console.error('Error checking login status: ', error);
        }
    });
});
