var tableProveedores;
document.addEventListener('DOMContentLoaded', function () {
	tableProveedores = $('#tableProveedores').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": " " + base_url + "/Proveedores/getProveedores",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "idproveedor" },
			{ "data": "ruc" },
			{ "data": "nombre" },
			{ "data": "direccion" },
			{ "data": "telefono" },
			{ "data": "status" },
			{ "data": "options" }
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});
	var formProveedor = document.querySelector("#formProveedor");
	formProveedor.onsubmit = function (e) {
		e.preventDefault();

		var intIdProveedor = document.querySelector("#idProveedor").value;
		var intRuc = document.querySelector("#txtRuc").value;
		var strNombre = document.querySelector("#txtNombre").value;
		var strDireccion = document.querySelector("#txtDireccion").value;
		var strTelefono = document.querySelector("#txtTelefono").value;
		var intStatus = document.querySelector("#listStatus").value;
		if (intRuc == '' || strNombre == '' || strDireccion == '' || strTelefono == '' || intStatus == '') {
			swal("atención", "todos los campos son obligatorios.", "error");
			return false;
		}
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = base_url + '/Proveedores/setProveedor';
		var formData = new FormData(formProveedor);
		request.open("POST", ajaxUrl, true);
		request.send(formData);
		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#modalFormProveedor').modal("hide");
					formProveedor.reset();
					swal("Proveedor de productos", objData.msg, "success");
					tableProveedores.api().ajax.reload();
				} else {
					swal("Error", objData.msg, "error");
				}
			}
		}
	};
});

$('#tableProveedores').dataTable();

function openModal() {
	document.querySelector('#formProveedor').classList.remove("was-validated");
	document.querySelector('#idProveedor').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#titleModal').innerHTML = "Nuevo proveedor";
	document.querySelector('#btnText').innerHTML = " Guardar";
	document.querySelector('#formProveedor').reset();
	$('#modalFormProveedor').modal('show');
}

function closeModal() {
	$('#modalFormProveedor').modal('hide');
}
function fntEditProveedor(idproveedor) {
	document.querySelector('#titleModal').innerHTML = "Actualizar Proveedor";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = " Actualizar";
    var idmarca = idmarca;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Proveedores/getProveedor/' + idproveedor;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);

			if (objData.status) {
				document.querySelector("#idProveedor").value = objData.data.idproveedor;
				document.querySelector("#txtRuc").value = objData.data.ruc;
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#txtDireccion").value = objData.data.direccion;
				document.querySelector("#txtTelefono").value = objData.data.telefono;
				if (objData.data.status == 1) {
					document.querySelector('#listStatus').value = 1;
				} else {
					document.querySelector('#listStatus').value = 2;
				}
				$('#listStatus').selectpicker('render');
				$('#modalFormProveedor').modal('show');
			} else {
				swal("Error", objData.msg, "Error");
			}
		}
	}
}

function fntDelProveedor(idproveedor) {
	swal({
		title: "Eliminar proveedor",
		text: "¿Realmente desea Eliminar el proveedor?",
		icon: "warning",
		buttons: [
			'No, Cancelar!',
			'Si, Eliminar!'
		],
		dangerMode: true,
	}).then(function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
			var ajaxUrl = base_url + '/Proveedores/delProveedor/';
			var strData = 'idproveedor=' + idproveedor;

			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send(strData);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("Eliminar!", objData.msg, "success");
						tableProveedores.api().ajax.reload();
					} else {
						swal("Atención!", objData.msg, "error");
					}
				} else {
					swal("Atención!", "Error externo", "error");
				}
			}

		}
	});
}
function fntViewProveedor(idproveedor) {
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Proveedores/getProveedor/' + idproveedor;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				var estadoProveedor = objData.data.status == 1 ?
					'<span class="badge badge-success">Activo</span>' :
					'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celRuc").innerHTML = objData.data.ruc;
				document.querySelector("#celNombre").innerHTML = objData.data.nombre;
				document.querySelector("#celDireccion").innerHTML = objData.data.direccion;
				document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
				document.querySelector("#celEstado").innerHTML = estadoProveedor;
				$('#modalViewProveedor').modal('show');
			} else {
				swal("Error", objData.msg, "error");
			}
		}
	}
}
