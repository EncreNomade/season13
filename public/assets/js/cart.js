
var cart = (function(Export) {
	var cart = Export; // just a shortcut
	var cartContainer = null;
	var cartBtn = null;

	function ajaxError(jqXHR) {		
		if(config.readerMode == "debug") {			
			var newWindow = window.open('_blank');
			newWindow.document.write(jqXHR.responseText);
		}
	}

	Export.init = function() {
		cartContainer = $('#cart_dialog .cart_container');
		cartBtn = $('#cart');
		cartBtn.click(cart.show);
		cartContainer.on('click', 'button.remove_product', function(e) {
			cart.remove($(this).data('pid'));
		});
	};

	Export.show = function(e) {		
	    $('.dialog').removeClass('show');
	    $('#cart_dialog').addClass('show');
	    var $this = e instanceof jQuery.Event ? $(this) : cartBtn; 	// if the e is an event this is the element clicked
	    $this.siblings(':not(.text_sep_vertical)').addClass('inactive');
	    $this.removeClass('inactive');
	};

	Export.add = function(pid) {
		$.ajax({
			url: config.base_url + 'achat/cart/add',
			type: "POST",
			dataType: "html",
			data: { productId: pid },
			success: function(data) {
				cartContainer.html(data);
				cart.show();
			},
			error: ajaxError
		});		
	};

	Export.remove = function(pid) {
		$.ajax({
			url: config.base_url + 'achat/cart/remove',
			type: "POST",
			dataType: "html",
			data: { productId: pid },
			success: function(data) {
				cartContainer.html(data);
				cart.show();
			},
			error: ajaxError
		});	
	};

	return Export;
})({});

$(document).ready(cart.init);


