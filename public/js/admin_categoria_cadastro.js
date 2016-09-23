$(document).ready(function() {

	//validacao
	jQuery.extend(jQuery.validator.messages, {
		required: "Este campo é obrigatório",
	});

	$(".categoria").validate({
		rules : {
			"categoria" : {
				required : true,
			}
		},
		tooltip_options : {
			categoria : {
				trigger : 'focus'
			},
		}
	});
	// ------------------------------------------

});