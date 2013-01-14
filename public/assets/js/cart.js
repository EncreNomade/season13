
function showCart() {
    $('.dialog').removeClass('show');
    $('#cart_dialog').addClass('show');
    var $this = $(this);
    $this.siblings(':not(.text_sep_vertical)').addClass('inactive');
    $this.removeClass('inactive');
}

function addToCart(pid) {

	$.ajax({
		url: config.base_url + 'achat/cart/add',
		type: "POST",
		dataType: "html",
		data: { productId: pid },
		success: function(data) {
			var cart = $('#cart_dialog');
			cart.html(data);
		},
		error: function() {
			console.log(arguments);
		}
	});
}

$(document).ready(function() {

});


