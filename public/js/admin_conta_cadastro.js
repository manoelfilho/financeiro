$(document).ready(function() {

	//validacao
	jQuery.extend(jQuery.validator.messages, {
		required: "Este campo é obrigatório",
		remote: "Por favor, corrija este campo.",
		email: "Por favor, forneça um endereço eletronico válido",
		url: "Por favor, forneça uma URL válida.",
		date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
		dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
		number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
		digits: "Por favor, digite apenas números",
		creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
		equalTo: "As senhas não correspondem",
		cpf: "Por favor, forneça um CPF correto."
	});

	$(".conta").validate({
		rules : {
			"conta" : {
				required : true,
			},
			"saldo" : {
				required : true,
				number : true
			}
		},
		tooltip_options : {
			conta : {
				trigger : 'focus'
			},
			saldo : {
				trigger : 'focus'
			},
		}
	});
	// ------------------------------------------

});