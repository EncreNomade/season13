(function(){
	var container,
		modifyBtn,
		sendModifBtn,
		createBtn;

	function ajaxError(jqXHR) {		
		if(config.readerMode == "debug") {			
			var newWindow = window.open('_blank');
			newWindow.document.write(jqXHR.responseText);
		}
	}

	function init() {
		container = $('#order-adresse');
		modifyBtn = $('#askModifyAddress');
		sendModifBtn = $('#sendModifyAddress');
		createBtn = $('#sendCreateAddress');

		container.on('click', '#askModifyAddress', modify);
		container.on('submit', 'form', function(e) {
			if($(this).find('#sendCreateAddress').length == 1)
				create.call(this, e);
			else if ($(this).find('#sendModifyAddress').length == 1)
				sendModif.call(this, e);
		});
	}
	$(document).ready(init);


	function create(e) {
		e.preventDefault();
		$.ajax({
			url: this.action,
			type: "POST",
			data: $(this).serialize(),
			dataType: "html",
			success: function(data) {
				container.html(data);
			},
			error: ajaxError
		});
	}

	// just retrieve the edit form
	function modify(e) {
		$.ajax({
			url: config.base_url + 'user/address/edit/' + $(this).data('addr_id'),
			type: "GET",
			dataType: "html",
			success: function(data) {
				container.html(data);
			},
			error: ajaxError
		});
	}

	function sendModif(e) {
		e.preventDefault();
		$.ajax({
			url: this.action,
			type: "POST",
			data: $(this).serialize(),
			dataType: "html",
			success: function(data) {
				container.html(data);
			},
			error: ajaxError
		});
	}

})();
