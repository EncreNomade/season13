(function(){
	var cgvCheckbox,
	
	    addraddrContainer,
		modifyAddrBtn,
		sendModifAddrBtn,
		createAddrBtn,
		
		paypal_submit,
		paypal_dg,
		
		checkoutBtn,
		removeProdBtn;

	function ajaxError(jqXHR) {		
		if(config.readerMode == "debug") {			
			var newWindow = window.open('_blank');
			newWindow.document.write(jqXHR.responseText);
		}
	}

	function init() {
	    cgvCheckbox = $('#accept-cgv');
	    cgv = $('#cgv_dialog');
	    
		addrContainer = $('#order-adresse');
		modifyAddrBtn = $('#askModifyAddress');
		sendModifAddrBtn = $('#sendModifyAddress');
		createAddrBtn = $('#sendCreateAddress');
		paypal_submit = $('#paypal_submit');
		checkoutBtn = $('#checkout');

		removeProdBtn = $('#order-detail .remove_product');

		removeProdBtn.click(removeProduct);

		addrContainer.on('click', '#askModifyAddress', modifyAddr);
		addrContainer.on('submit', 'form', function(e) {
			if($(this).find('#sendCreateAddress').length == 1)
				createAddr.call(this, e);
			else if ($(this).find('#sendModifyAddress').length == 1)
				sendModifAddr.call(this, e);
		});
		
		cgvCheckbox.change(function() {
		    if(cgvCheckbox.prop('checked')) 
		        cgvCheckbox.parent().removeClass('alert');
		    else
		        cgvCheckbox.parent().addClass('alert');
		});
		
		$('#show_cgv').click(function() {
		    $.ajax({
		        'url': config.publicRoot + 'achat/order/CGV',
		        'type': 'GET',
		        success: function(data) {
		            cgv.children('.sep_line').nextAll().remove();
		            cgv.children('.sep_line').after(data);
		            cgv.addClass('show');
		        }
		    });
		});
		
		if(window.PAYPAL) {
        	dg = new PAYPAL.apps.DGFlow({
        		//trigger: 'paypal_submit',
        		expType: 'instant'
        		//PayPal will decide the experience type for the buyer based on his/her 'Remember me on your computer' option.
        	});
		}
		
		checkoutBtn.click(function(e) {
		    // Verify CGV checkbox
		    if(!cgvCheckbox.prop('checked')) {
		        cgvCheckbox.parent().addClass('alert');
		        e.preventDefault();
		        return;
		    }
		    
		    // Verify address
		    var addrForm = addrContainer.find('form');
		    if(addrForm.length > 0) {
		        var alert = addrContainer.children('.flash-alert');
		        if(alert.length == 0)
		            alert = $('<div class="flash-alert">').insertBefore(addrForm);
		        alert.append('<p>Tu dois valider ton adresse d\'abord</p>');
		        e.preventDefault();
		        return;
		    }
		});
		
		paypal_submit.click(function(e) {
		    e.preventDefault();
		    
		    // Verify CGV checkbox
		    if(!cgvCheckbox.prop('checked')) {
		        cgvCheckbox.parent().addClass('alert');
		        return;
		    }
		    
		    // Verify address
		    var addrForm = addrContainer.find('form');
		    if(addrForm.length > 0) {
		        var alert = addrContainer.children('.flash-alert');
		        if(alert.length == 0)
		            alert = $('<div class="flash-alert">').insertBefore(addrForm);
		        alert.append('<p>Tu dois valider ton adresse d\'abord</p>');
		        return;
		    }
		    
		    dg.startFlow(config.base_url+"achat/order/paypalCheckout");
		    
		    // Observe the popup window close action for cancel the order checkout
		    var timer = setInterval(function() {
		        try {
		            // Window closed
		            if(!dg.isOpen())
		                updateOrder(timer);
		        }
		        catch (error) {
		            // Safari 
		            if(error.name == "TypeError")
		                updateOrder(timer);
		            // Firefox
		            else clearInterval(timer);
		        }
		    }, 1000);
		});
	}
	$(document).ready(init);
	
	
	function updateOrder(timer) {
	    if(timer) clearInterval(timer);
	    $.ajax({
	    	url: config.base_url + 'achat/orderrest/update',
	    	type: "GET",
	    	dataType: "json",
	    	success: function(data) {
	    	    switch(data.action) {
	    	    case "NO_PAYMENT":
	    	    case "CANCEL_PAYMENT":
	    	        document.location.reload();
	    	        break;
	    	    case "CONFIRM_PAYMENT":
	    	        document.location.href = config.base_url;
	    	        break;
	    	    }
	    	}
	    });
	}


	function createAddr(e) {
		e.preventDefault();
		$.ajax({
			url: this.action,
			type: "POST",
			data: $(this).serialize(),
			dataType: "html",
			success: function(data) {
				addrContainer.html(data);
			},
			error: ajaxError
		});
	}

	// just retrieve the edit form
	function modifyAddr(e) {
		$.ajax({
			url: config.base_url + 'user/address/edit/' + $(this).data('addr_id'),
			type: "GET",
			dataType: "html",
			success: function(data) {
				addrContainer.html(data);
			},
			error: ajaxError
		});
	}

	function sendModifAddr(e) {
		e.preventDefault();
		$.ajax({
			url: this.action,
			type: "POST",
			data: $(this).serialize(),
			dataType: "html",
			success: function(data) {
				addrContainer.html(data);
			},
			error: ajaxError
		});
	}

	function removeProduct(e) {
		var ref = $(this).data('productref');
		$.ajax({
			url: config.base_url + 'achat/cart/remove',
			type: 'POST',
			data: { product_ref: ref },
			success: function(data) {
				window.location.reload();
			},
			error: ajaxError
		});
	}

})();
