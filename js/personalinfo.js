$(document).ready(function () {
	$.ajax({
		url: 'php/personal_info.php',
		method: 'GET',
		dataType: 'html',
		success: function (data) {
			$('#personalinfo').html(data);
		},
		error: function (error) {
			console.error('Error fetching info: ', error);
		}
	});
});