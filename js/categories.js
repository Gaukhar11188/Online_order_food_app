$(document).ready(function () {
   
    function loadMenuItems(category) {
        $.ajax({
            type: 'GET',
            url: 'php/get_menu_items.php',
            data: { category: category },
            success: function (response) {
                $('#menuAll').html(response);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }

    $('.category-link').on('click', function (e) {
        e.preventDefault();
        var category = $(this).attr('id');

        if (category === 'All') {
            loadAllMenuItems();
        } else {
            loadMenuItems(category);
        }
    });

    loadAllMenuItems();

    function loadAllMenuItems() {
        $.ajax({
            type: 'GET',
            url: 'php/getmenu.php',
            success: function (response) {
                $('#menuAll').html(response);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
});
