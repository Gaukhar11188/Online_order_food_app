$(document).ready(function () {
	$.ajax({
		url: 'php/orders_info.php',
		method: 'GET',
		dataType: 'html',
		success: function (data) {
			$('#cartTable777').html(data);
		},
		error: function (error) {
			console.error('Error fetching info: ', error);
		}
	});
});