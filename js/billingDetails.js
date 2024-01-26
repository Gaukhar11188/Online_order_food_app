$(document).ready(function () {
    $.ajax({
        url: 'php/getBillingDetails.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                console.error(data.error);
            } else {
             
                if (Object.keys(data).length > 0) {
             
                    var html = '<h2 class="h3 mb-3 text-black">Billing Details</h2>';
                    html += '<div class="p-3 p-lg-5 border bg-white">';
                    html += '<p>Please, fill in the form below.</p>';
                    html += '<div class="form-group row">';
                    html += '<div class="col-md-6">';
                    html += '<label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_fname" name="c_fname" value="' + (data.first_name || '') + '">';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_lname" name="c_lname" value="' + (data.last_name || '') + '">';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="form-group row">';
                    html += '<div class="col-md-12">';
                    html += '<label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_address" name="c_address" placeholder="Street address, apartment, unit etc." value="' + (data.address || '') + '">';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="form-group row mb-5">';
                    html += '<div class="col-md-6">';
                    html += '<label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_email_address" name="c_email_address" value="' + (data.email || '') + '">';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_phone" name="c_phone" placeholder="Phone Number" value="' + (data.phone_number || '') + '">';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="form-group">';
                    html += '<label for="c_order_notes" class="text-black">Order Notes</label>';
                    html += '<textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>';
                    html += '</div>';

                    html += '</div>';
                    html += '</div>';

                    $('#billingDetailsContainer').html(html);
                } else {

                    var html = '<h2 class="h3 mb-3 text-black">Billing Details</h2>';
                    html += '<div class="p-3 p-lg-5 border bg-white">';
                    html += '<p>Please, fill in the form below.</p>';
                    html += '<div class="form-group row">';
                    html += '<div class="col-md-6">';
                    html += '<label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_fname" name="c_fname">';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_lname" name="c_lname">';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="form-group row">';
                    html += '<div class="col-md-12">';
                    html += '<label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_address" name="c_address" placeholder="Street address, apartment, unit etc.">';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="form-group row mb-5">';
                    html += '<div class="col-md-6">';
                    html += '<label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_email_address" name="c_email_address">';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>';
                    html += '<input type="text" class="form-control" id="c_phone" name="c_phone" placeholder="Phone Number">';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<button class="btn btn-black btn-sm btn-block" onclick="addCustomer()">Add</button>';
                    html += '</div>';
                    html += '</br>';
                    html += '<div class="form-group">';
                    html += '<label for="c_order_notes" class="text-black">Order Notes</label>';
                    html += '<textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>';
                    html += '</div>';

                    html += '</div>';
                    html += '</div>';

                    
                    $('#billingDetailsContainer').html(html);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
});
