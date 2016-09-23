$(document).ready(function() {

	// validacao
	jQuery.extend(jQuery.validator.messages, {
		required : "Este campo é obrigatório",
		email : "Por favor, forneça um endereço eletronico válido",
	});

	$(".usuario, .login, #recuperarsenha").validate({
		rules : {
			"email" : {
				required : true,
				email : true,
			},
			"nome" : {
				required : true,
			},
			"senha" : {
				required : true,
			},
			"sexo" : {
				required : true,
			},
			"estado" : {
				required : true,
			},
			"municipio" : {
				required : true,
			},
			"password" : {
				required : true,
			}
		},
		tooltip_options : {
			email : {
				trigger : 'focus'
			},
		}
	});
	// ------------------------------------------

	// reposicionamento do preloader do estado
	$('#preloader').hide();
	function switchElements($ele1, $ele2) {
		$ele2.after($ele1);
	}
	switchElements($('#preloader'), $('#selectEstado'));
	// ----------------------------------------

	// ajax estados e municípios
	$("#selectEstado").bind("change", function(event) {
		$.ajax({
			async : true,
			beforeSend : function(XMLHttpRequest) {
				$("#preloader").show()
			},
			complete : function(XMLHttpRequest, textStatus) {
				$("#preloader").hide()
			},
			data : $("#selectEstado").serialize(),
			dataType : "html",
			success : function(data, textStatus) {
				$("#selectMunicipio").html(data);
			},
			type : "post",
			url : "\/portal\/usuario\/listarmunicipios"
		});
		return false;
	});
	// ------------------------------------------

	// ajax do email
	$("#inputEmail").bind("focusout", function(event) {
		$.ajax({
			async : true,
			data : $("#inputEmail").serialize(),
			dataType : "html",
			success : function(data, textStatus) {
				$(".infocpf").html(data);
			},
			type : "post",
			url : "\/portal\/usuario\/verificaremail"
		});
		return false;
	});
	// ------------------------------------------

	// reposicionamento do br dos labels dos checkboxes
	$("#br").insertBefore("form fieldset fieldset label");

	// checkboxes do formulário de cadastro
	$('input[name="grupos[]"]').iCheck({
		checkboxClass : 'icheckbox_square-red',
	});
	// ------------------------------------------

});