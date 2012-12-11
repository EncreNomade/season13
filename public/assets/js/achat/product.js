$(document).ready(function(){
	var addMetaBtn = $('#meta_add'),
		metaValue  = $('#form_meta_value'),
		metaType   = $('#form_meta_type'),
		parent 	   = addMetaBtn.parent();


	function removeMeta(e) {
		e.preventDefault();
		$(this).parent().remove();
	}
	$()

	addMetaBtn.click(function (e) {
		e.preventDefault();
		if (metaValue.val() == '') 
			return;

		var div = $('<div>');
		var theMetaType = metaType.clone()
								  .prop('disabled', 'true')
								  .prop('name', ''); 									// for the apparence (disabled element is note send in post)
		var hidden = $('<input type="hidden" />').prop('name', "meta_type_content[]")
												 .val(metaType.val());					// data wich is send for the meta type

		var theMetaVal = metaValue.clone()
								  .prop('name', 'meta_value_content[]')
								  .prop('readonly', 'true');							// the meta key
		metaValue.val('');																// reset

		var deleteBtn = $("<button>").text("Delete")									// adding a deleta meta btn
									 .addClass('btn btn-danger remove-meta');


		div.append(theMetaType, hidden, theMetaVal, deleteBtn)
		   .appendTo(parent);
	});

	$('.remove-meta').on('click', removeMeta);
});