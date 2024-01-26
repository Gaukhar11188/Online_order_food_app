$(document).ready(function() {
    // Use the form's onsubmit event
    $("form").submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        uploadImage();
    });

    function uploadImage() {
        var fileInput = document.getElementById('fileToUpload');
        var file = fileInput.files[0];

        if (file) {
            var formData = new FormData();
            formData.append('fileToUpload', file);

            $.ajax({
                type: 'POST',
                url: 'php/upload_image.php',
                data: formData,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                success: function(response) {
                    alert(response);
                },
                error: function(error) {
                    alert(error);
                }
            });
        } else {
            alert('Please select an image to upload.');
        }
    }
});
