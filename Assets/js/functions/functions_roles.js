var tableRoles;
document.addEventListener('DOMContentLoaded', function () {
	tableRoles = $('#tableRoles').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": " " + base_url + "/Roles/getRoles",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "idrol" },
			{ "data": "rol" },
			{ "data": "descripcion" },
			{ "data": "status" },
			{ "data": "options" }
		],
		"responsive": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

	//NUEVO ROL
	var formRol = document.querySelector("#formRol");

	formRol.onsubmit = function (e) {
		e.preventDefault();
		var intIdRol = document.querySelector("#idRol").value;
		var strNombre = document.querySelector("#txtNombre").value;
		var strDescripcion = document.querySelector("#txtDescripcion").value;
		var intStatus = document.querySelector("#listStatus").value;
		if (strNombre == '' || strDescripcion == '' || intStatus == '') {
			swal("atención", "todos los campos son obligatorios.", "error");
			return false;
		}
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = base_url + '/Roles/setRol';
		var formData = new FormData(formRol);
		request.open("POST", ajaxUrl, true);
		request.send(formData);
		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#modalFormRol').modal("hide");
					formRol.reset();
					swal("Roles de usuario", objData.msg, "success");
					tableRoles.api().ajax.reload();
				} else {
					swal("Error", objData.msg, "error");
				}
			}
		}
	};
});

$('#tableRoles').DataTable();

function openModal() {
	document.querySelector('#formRol').classList.remove("was-validated");
	document.querySelector('#idRol').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
	document.querySelector('#btnText').innerHTML = " Guardar";
	document.querySelector('#formRol').reset();
	$('#modalFormRol').modal('show');
}

function closeModal() {
	$('#modalFormRol').modal('hide');
}
function closeModalPermisos(){
	$('.modalPermisos').modal('hide');
}
function fntEditRol(idrol) {
	const btnEditRol = document.querySelectorAll(".btnEditRol");
	document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = " Actualizar";

	var idrol = idrol;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Roles/getRol/' + idrol;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);

			if (objData.status) {
				document.querySelector("#idRol").value = objData.data.idrol;
				document.querySelector("#txtNombre").value = objData.data.rol;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
				if (objData.data.status == 1) {
					document.querySelector("#listStatus").value = 1;
				} else {
					document.querySelector("#listStatus").value = 2;
				}
				$('#listStatus').selectpicker('render');
				$('#modalFormRol').modal('show');
			} else {
				swal("Error", objData.msg, "Error");
			}
		}
	}
}

function fntDelRol(idrol) {
	var idrol = idrol;
	swal({
		title: "Eliminar Rol",
		text: "¿Realmente desea Eliminar el Rol?",
		icon: "warning",
		buttons: [
			'No, Cancelar!',
			'Si, Eliminar!'
		],
		dangerMode: true,
	}).then(function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
			var ajaxDelRol = base_url+'/Roles/delRol/';
			var strData = 'idrol='+idrol;

			request.open("POST", ajaxDelRol, true);
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send(strData);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("Eliminar!", objData.msg, "success");
						tableRoles.api().ajax.reload();
					} else {
						swal("Atención!", objData.msg, "error");
					}
				} else {
					swal("Atención!", "Error externo", "error");
				}
			}
			//--------------------------------
		}
	});
};

function fntPermisos(idrol){
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = base_url+ '/Permisos/getPermisosRol/'+ idrol;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = ()=>{
		if(request.readyState == 4 && request.status == 200){
			document.querySelector("#contentAjax").innerHTML = request.responseText;
			$('.modalPermisos').modal('show');
			document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false)
		}
	}
}

function fntSavePermisos(evnet){
	evnet.preventDefault();
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = base_url + '/Permisos/setPermisos'; 
	var formElement = document.querySelector("#formPermisos");
	var formData = new FormData(formElement);
	request.open("POST",ajaxUrl,true);
	request.send(formData);
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var objData = JSON.parse(request.responseText);
			if(objData.status){
				swal("Permisos de usuario", objData.msg,"success");
			}else{
				swal("Error", objData.msg, "error");
			}
		}
	}
}