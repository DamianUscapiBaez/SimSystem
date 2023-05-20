function openModal() {
	document.querySelector('#idcliente').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
	document.querySelector('#btnText').innerHTML = " Guardar";
	document.querySelector('#frmCliente').reset();
	$('#modalFormCliente').modal('show');
}

function closeModal() {
	$('#modalFormCliente').modal('hide');
}

var tableClientes;
document.addEventListener('DOMContentLoaded', function () {
	tableClientes = $('#tableClientes').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": " " + base_url + "/Clientes/getClientes",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "idcliente" },
			{ "data": "tipo_documento" },
			{ "data": "documento" },
			{ "data": "nombre" },
			{ "data": "telefono" },
            { "data": "direccion" },
			{ "data": "status" },
			{ "data": "options" }
		],
		"responsive": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});
    if(document.querySelector('#frmCliente')){
		var frmCliente = document.querySelector('#frmCliente');
		frmCliente.onsubmit = function (e) {
			e.preventDefault();
			var intDocumento = document.querySelector('#txtDocumento').value;
			var strNombre = document.querySelector('#txtNombre').value;
			var strDireccion = document.querySelector('#txtDireccion').value;
			var intTelefono = document.querySelector('#txtTelefono').value;
	
			if (intDocumento == '' || strNombre == ''|| strDireccion == '' || intTelefono == '') {
				swal("atención", "todos los campos son obligatorios.", "error");
				return false;
			}
			var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = base_url + '/Clientes/setCliente';
			var formData = new FormData(frmCliente);
			request.open("POST", ajaxUrl, true);
			request.send(formData);
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						$('#modalFormCliente').modal("hide");
						frmCliente.reset();
						swal("Cliente", objData.msg, "success");
						tableClientes.api().ajax.reload();
					} else {
						swal("Error", objData.msg, "error");
					}
				}
			}
		}
	}
}, false);
function fntViewCliente(idcliente) {
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Clientes/getCliente/' + idcliente;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);

			if (objData.status) {
				var estado = objData.data.status == 1 ?
					'<span class="badge badge-success">Activo</span>' :
					'<span class="badge badge-danger">Inactivo</span>';
                var tipo_documento = objData.data.tipo_documento == 1 ?
					'<b>RUC</b>' :
					'<b>DNI</b>';
                document.querySelector("#tipo_documento").innerHTML = tipo_documento;
				document.querySelector("#documento").innerHTML = objData.data.documento;
				document.querySelector("#nombre_cliente").innerHTML = objData.data.nombre;
				document.querySelector("#direccion").innerHTML = objData.data.direccion;
				document.querySelector("#telefono").innerHTML = objData.data.telefono;
				document.querySelector("#status").innerHTML = estado;
				$('#modalViewCliente').modal('show');
			} else {
				swal("Error", objData.msg, "error");
			}
		}
	}
}
function fntEditCliente(idcliente) {
	document.querySelector('#titleModal').innerHTML = "Actualizar Cliente";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Clientes/getCliente/' + idcliente;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector("#idcliente").value = objData.data.idcliente;
				document.querySelector("#txtDocumento").value = objData.data.documento;
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#txtDireccion").value = objData.data.direccion;
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                if (objData.data.tipo_documento == 1) {
					document.querySelector("#listDocumento").value = 1;
				} else {
					document.querySelector("#listDocumento").value = 2;
				}
				$('#listDocumento').selectpicker('render');
				if (objData.data.status == 1) {
					document.querySelector("#listStatus").value = 1;
				} else {
					document.querySelector("#listStatus").value = 2;
				}
				$('#listStatus').selectpicker('render');
			}
		}
		$('#modalFormCliente').modal('show');
	}
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
		dangerMode: true,
	}).then(function (isConfirm) {

		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = base_url + '/Clientes/delCliente';
			var strData = 'idcliente=' + idcliente;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(strData);
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("Eliminar!", objData.msg, "success");
						tableClientes.api().ajax.reload();
					} else {
						swal("Atención!", objData.msg, "error");
					}
				}
			}
		}

	});
}