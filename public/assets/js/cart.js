
var cart = (function(Export) {
	var cart = Export, // just a shortcut
		cartContainer = null,
		cartBtn = null,
		cartNotif = null;

	$(document).ready(function () {
		cartContainer = $('#cart_dialog .cart_container');
		cartBtn = $('#cart');
		cartNotif = cartBtn.children('span');
		cartBtn.click(cart.show);
		cartContainer.on('click', '.remove_product button', function(e) {
			cart.remove($(this).data('productref'), $(this).parents('.cart_product'));
		});
		checkProductNotf();
	});

	function ajaxError(jqXHR) {		
		if(config.readerMode == "debug") {			
			var newWindow = window.open('_blank');
			newWindow.document.write(jqXHR.responseText);
		}
	}

	function displayInCart(data) {
		cartContainer.fadeOut(function(){
			cartContainer.html(data);
			cartContainer.fadeIn();
			checkProductNotf();
		});
	}

	function checkProductNotf() {		
		var numProducts = cartContainer.children('.cart_product').length;
		if (numProducts > 0) 
			cartNotif.text(numProducts).fadeIn();
		else
			cartNotif.fadeOut();
	}


	Export.show = function(e) {		
	    $('.dialog').removeClass('show');
	    $('#cart_dialog').addClass('show');
	    var $this = e instanceof jQuery.Event ? $(this) : cartBtn; 	// if the e is an event this is the element clicked
	    $this.siblings(':not(.text_sep_vertical)').addClass('inactive');
	    $this.removeClass('inactive');
	};

	Export.add = function(productRef) {
		$.ajax({
			url: config.base_url + 'achat/cart/add',
			type: "POST",
			dataType: "html",
			data: { "product_ref": productRef },
			success: function(data) {
				displayInCart(data);
				cart.show();
			},
			error: ajaxError
		});		
	};

	Export.remove = function(productRef, jQProduct) {
		$.ajax({
			url: config.base_url + 'achat/cart/remove',
			type: "POST",
			dataType: "html",
			data: { "product_ref": productRef },
			success: function(data) {
				displayInCart(data);
				cart.show();
			},
			error: ajaxError
		});	
	};

	return Export;
})({});



