$(document).ready(function () {
	$.ajax({
		url: 'php/selectdb.php',
		method: 'GET',
		dataType: 'html',
		success: function (data) {
			$('#topProductsContainer').html(data);
		},
		error: function (error) {
			console.error('Error fetching top products: ', error);
		}
	});
});
