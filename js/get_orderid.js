document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        var target = event.target;
        if (target && target.classList.contains('order-link')) {
            event.preventDefault(); 
            var orderId = target.getAttribute('data-order-id');
            window.location.href = 'order.html?order_id=' + orderId;
        }
    });
});
