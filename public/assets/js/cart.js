
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
		    var product = $(this).parents('.cart_product');
			if(product.length > 0) 
			    cart.remove(product.data('productref'), product.data('cartpid'), product);
		});
		checkProductNotf();
		
		cartContainer.on('click', '.click_to_offer', cart.offerclicked);
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

	Export.remove = function(productRef, cartpid, jQProduct) {
		$.ajax({
			url: config.base_url + 'achat/cart/remove',
			type: "POST",
			dataType: "html",
			data: { "product_ref": productRef, "cart_product_id": cartpid },
			success: function(data) {
				displayInCart(data);
				cart.show();
			},
			error: ajaxError
		});	
	};
	
	Export.offer = function(cartpid, offerTar) {
		$.ajax({
			url: config.base_url + 'achat/cart/offer',
			type: "POST",
			dataType: "html",
			data: { "offer_target": offerTar, "cart_product_id": cartpid },
			success: function(data) {
				displayInCart(data);
				cart.show();
			},
			error: ajaxError
		});
	};
	
	Export.offerclicked = function(e) {
	    var product = $(this).parents('.cart_product');
	    if(product.length > 0) {
	        var p = $(this).parent();
	        
	        $(this).replaceWith('<input type="email" placeholder="Adresse email"/><button>Confirme</button>');
	        p.children('button').click(function() {
	            var mail = p.children('input').val();
	            if(mail && mail != "")
	                Export.offer( product.data('cartpid'), mail );
	        });
	    }
	};

	return Export;
})({});



