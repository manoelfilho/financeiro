$(document).ready(function() {

	//validacao
	jQuery.extend(jQuery.validator.messages, {
		required: "Este campo é obrigatório",
		digits: "Por favor, digite apenas números"
	});

	$(".movimentacao").validate({
		rules : {
			"conta" : {
				required : true,
			},
			"categoria" : {
				required : true,
			},
			"valor" : {
				required : true,
			},
			"data_" : {
				required : true,
			}
		},
		tooltip_options : {
			valor : {
				trigger : 'focus'
			},
		}
	});
	// ------------------------------------------
	
	//datas
	
	$('#inputData').datepicker({format: "dd/mm/yyyy"});
	
	// ------------------------------------------

});