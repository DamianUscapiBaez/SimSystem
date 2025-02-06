var tableClientes;

$(document).ready(function () {
	tableClientes = $('#tableClientes').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": base_url + "/Clientes/getClientes",
			"dataSrc": ""
		},
		"columns": [
			{ "data": "idclient" },
			{ "data": "typedocument" },
			{ "data": "documentnumber" },
			{ "data": "nameclient" },
			{ "data": "phonenumber" },
			{ "data": "addressofclient" },
			{ "data": "statusclient" },
			{ "data": "options" }
		],
		"responsive": true,
		"bDestroy": true,
		"iDisplayLength": 10,
		"searching": false,
		"order": [[0, "desc"]]
	});

	$('#frmCliente').submit(function (e) {
		e.preventDefault();

		var tipodocumento = $('#tipodocumento').val();
		var numerodocumento = $('#numerodocumento').val();
		var nombrecliente = $('#nombrecliente').val();

		if (tipodocumento == '' || numerodocumento == '' || nombrecliente == '') {
			swal("Atención", "Todos los campos son obligatorios.", "error");
			return false;
		}

		$.ajax({
			type: "POST",
			url: base_url + '/Clientes/setCliente',
			data: new FormData($('#frmCliente')[0]),
			processData: false,
			contentType: false,
			success: function (response) {
				var objData = JSON.parse(response);

				if (objData.status) {
					$('#modalFormCliente').modal("hide");
					$('#frmCliente')[0].reset();
					swal("Cliente", objData.msg, "success");
					tableClientes.api().ajax.reload();
				} else {
					swal("Error", objData.msg, "error");
				}
			}
		});
	});

	// Rest of the code remains the same, but using jQuery syntax
});

function openModal() {
	$('#idcliente').val("");
	$('.md-header').removeClass("bg-warning").addClass("bg-primary");
	$('#btnActionForm').removeClass("btn-info").addClass("btn-primary");
	$('#titleModal').html("Nuevo Cliente");
	$('#btnText').html("Guardar");
	$('#frmCliente').trigger('reset');
	$('#modalFormCliente').modal('show');
}

function closeModal() {
	$('#modalFormCliente').modal('hide');
}

function closeModalView() {
	$('#modalViewCliente').modal('hide');
}

function fntViewCliente(idcliente) {
	$.get(base_url + '/Clientes/getCliente/' + idcliente, function (data) {
		var objData = JSON.parse(data);

		if (objData.status) {
			var estado = objData.data.statusclient == 1 ?
				'<span class="status_btn_success">Activo</span>' :
				'<span class="status_btn_error">Inactivo</span>';

			$("#tipodocumentotb").html(objData.data.tipodocumentoview);
			$("#numerodocumentotb").html(objData.data.documentnumber);
			$("#nombreclientetb").html(objData.data.nameclient);
			$("#direccionclientetb").html(objData.data.addressofclient);
			$("#telefonoclientetb").html(objData.data.phonenumber);
			$("#statusclientetb").html(estado);
			$('#modalViewCliente').modal('show');
		} else {
			swal("Error", objData.msg, "error");
		}
	});
}

function fntEditCliente(idcliente) {
	var elements = {
		modalTitle: $('#titleModal'),
		modalHeader: $('.md-header'),
		btnActionForm: $('#btnActionForm'),
		btnText: $('#btnText'),
		idcliente: $("#idcliente"),
		numerodocumento: $("#numerodocumento"),
		nombrecliente: $("#nombrecliente"),
		direccioncliente: $("#direccioncliente"),
		telefonocliente: $("#telefonocliente"),
		tipodocumento: $('#tipodocumento'),
		statuscliente: $('#statuscliente')
	};

	elements.modalTitle.html("Actualizar Cliente");
	elements.modalHeader.removeClass("bg-primary").addClass("bg-warning");
	elements.btnActionForm.removeClass("btn-primary").addClass("btn-info");

	elements.btnText.html("Actualizar");

	$.get(base_url + '/Clientes/getCliente/' + idcliente, function (data) {
		var objData = JSON.parse(data);

		if (objData.status) {
			elements.idcliente.val(objData.data.idclient);
			elements.numerodocumento.val(objData.data.documentnumber);
			elements.nombrecliente.val(objData.data.nameclient);
			elements.direccioncliente.val(objData.data.addressofclient);
			elements.telefonocliente.val(objData.data.phonenumber);

			elements.tipodocumento.val(objData.data.typedocument);
			elements.statuscliente.val(objData.data.statusclient);

			$('#modalFormCliente').modal('show');
		}
	});
}

function fntDelCliente(idcliente) {
	swal({
		title: "Eliminar Cliente",
		text: "¿Realmente quiere eliminar el Cliente?",
		type: "warning",
		icon: "warning",
		buttons: [
			'No, Cancelar!',
			'Si, Eliminar!'
		],
		dangerMode: true
	}).then(function (isConfirm) {

		if (isConfirm) {
			$.post(base_url + '/Clientes/delCliente', { idcliente: idcliente }, function (data) {
				var objData = JSON.parse(data);

				if (objData.status) {
					swal("Eliminar!", objData.msg, "success");
					tableClientes.api().ajax.reload();
				} else {
					swal("Atención!", objData.msg, "error");
				}
			});
		}
	});
}
