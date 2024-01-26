function ExitButtonClick() {

    $.ajax({
        url: 'php/exitUser2.php',
        method: 'GET',
        dataType: 'html',
        success: function (data) {
            window.location.href = 'staff_login.html';
            exit(); 
            $('#icon_list').html(data);},
        error: function (error) {
            console.error('Error fetching: ', error);
        }
    });}