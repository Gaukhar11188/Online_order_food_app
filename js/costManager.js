function getTotalCost(){
    let totalCost = 0;
    $.ajax({
        url: 'php/costManager.php',
        method: 'POST',
        data: {
            functionName: functionName = "getTotalCost",
            code: "",
        },
        dataType: 'json',
        success: function (response) {
            console.log('totalCost response:', response);
            totalCost = response;
            $("#totalCost").text("$"+totalCost.toFixed(2));
        },
        error: function (error) {
            console.error('Error totalCost: ', error);
        }
    });
}

function getSubtotalCost(){
    let totalCost = 0;
    $.ajax({
        url: 'php/costManager.php',
        method: 'POST',
        data: {
            functionName: functionName = "getSubtotalCost",
            code: "",
            totalCost: totalCost, 
        },
        dataType: 'json',
        success: function (response) {
            console.log('subtotalCost response:', response);
            totalCost = response;
            $("#subtotalCost").text("$"+totalCost.toFixed(2));
        },
        error: function (error) {
            console.error('Error subtotalCost: ', error);
        }
    });
}


$(document).ready(function (){
    $.ajax({
        url: 'php/costManager.php',
        method: 'POST',
        data: {
            functionName: functionName = "getLastDiscount",
            code: "",
        },
        dataType: 'json',
        success: function (response) {
            console.log('Coupone response:', response);


            if(response['discount'] != undefined){
                $("#code_name").text(response['code_name']);
                $("#discount").text("-" + response['discount'] + "%");
            }
        },
        error: function (error) {
            console.error('Error coupone: ', error);
        }
    });
})


function enterCoupone(){
    let code = $("#coupon").val();
    $.ajax({
        url: 'php/costManager.php',
        method: 'POST',
        data: {
            functionName: functionName = "getDiscountByCoupone",
            code: code.toLowerCase(),
        },
        dataType: 'json',
        success: function (response) {
            console.log('Coupone response:', response);
            getTotalCost();
            $("#code_name").text(response['code_name'])
            $("#discount").text("-" + response['discount'] + "%");
        },
        error: function (error) {
            console.error('Error coupone: ', error);
        }
    });
}
