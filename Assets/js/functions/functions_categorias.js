var tableCategorias;
document.addEventListener('DOMContentLoaded', function () {
	tableCategorias = $('#tableCategorias').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": " " + base_url + "/Categorias/getCategorias",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "idcategoria" },
			{ "data": "imagen" },
			{ "data": "nombre" },
			{ "data": "descripcion" },
			{ "data": "status" },
			{ "data": "options" }
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});
	if (document.querySelector("#foto")) {
		var foto = document.querySelector("#foto");
		foto.onchange = function (e) {
			var uploadFoto = document.querySelector("#foto").value;
			var fileimg = document.querySelector("#foto").files;
			var nav = window.URL || window.webkitURL;
			var contactAlert = document.querySelector('#form_alert');
			if (uploadFoto != '') {
				var type = fileimg[0].type;
				var name = fileimg[0].name;
				if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
					contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
					if (document.querySelector('#img')) {
						document.querySelector('#img').remove();
					}
					document.querySelector('.delPhoto').classList.add("notBlock");
					foto.value = "";
					return false;
				} else {
					contactAlert.innerHTML = '';
					if (document.querySelector('#img')) {
						document.querySelector('#img').remove();
					}
					document.querySelector('.delPhoto').classList.remove("notBlock");
					var objeto_url = nav.createObjectURL(this.files[0]);
					document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src=" + objeto_url + ">";
				}
			} else {
				alert("No selecciono foto");
				if (document.querySelector('#img')) {
					document.querySelector('#img').remove();
				}
			}
		}
	}

	if (document.querySelector(".delPhoto")) {
		var delPhoto = document.querySelector(".delPhoto");
		delPhoto.onclick = function (e) {
			document.querySelector("#foto_remove").value = 1;
			removePhoto();
		}
	}
	//NUEVO ROL
	var formCategoria = document.querySelector("#formCategoria");

	formCategoria.onsubmit = function (e) {
		e.preventDefault();

		var intIdCategoria = document.querySelector("#idCategoria").value;
		var strNombre = document.querySelector("#txtNombre").value;
		var strDescripcion = document.querySelector("#txtDescripcion").value;
		var intStatus = document.querySelector("#listStatus").value;
		if (strNombre == '' || strDescripcion == '' || intStatus == '') {
			swal("atención", "todos los campos son obligatorios.", "error");
			return false;
		}
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = base_url + '/Categorias/setCategoria';
		var formData = new FormData(formCategoria);
		request.open("POST", ajaxUrl, true);
		request.send(formData);
		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#modalFormCategoria').modal("hide");
					formCategoria.reset();
					swal("Categoria de productos", objData.msg, "success");
					tableCategorias.api().ajax.reload();
				} else {
					swal("Error", objData.msg, "error");
				}
			}
		}
	};
});

$('#tableCategorias').dataTable();

function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
	if(document.querySelector('#img')){
		document.querySelector('#img').remove();
	}
}
function openModal() {
	document.querySelector('#formCategoria').classList.remove("was-validated");
	document.querySelector('#idCategoria').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#titleModal').innerHTML = "Nueva Categoria";
	document.querySelector('#btnText').innerHTML = " Guardar";
	document.querySelector('#formCategoria').reset();
	$('#modalFormCategoria').modal('show');
	removePhoto();
}

function closeModal() {
	$('#modalFormCategoria').modal('hide');
}
function closeModalView() {
	$('#modalViewCategoria').modal('hide');
}
function fntEditCategoria(idcategoria) {
	document.querySelector('#titleModal').innerHTML = "Actualizar Categoria";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = " Actualizar";
	document.querySelector("#foto_remove").value = 0;

	var idcategoria = idcategoria;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Categorias/getCategoria/' + idcategoria;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);

			if (objData.status) {
				document.querySelector("#idCategoria").value = objData.data.idcategoria;
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                document.querySelector('#foto_actual').value = objData.data.portada;
				document.querySelector("#foto_remove").value= 0;
				if (objData.data.status == 1) {
					document.querySelector('#listStatus').value = 1;
				} else {
					document.querySelector('#listStatus').value = 2;
				}
				$('#listStatus').selectpicker('render');
				if(document.querySelector('#img')){
					document.querySelector('#img').src = objData.data.url_portada;
				}else{
					document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src=" + objData.data.url_portada + ">";	
				}
				if(objData.data.portada == 'portada_categoria.png'){
					document.querySelector('.delPhoto').classList.add('notBlock');
				}else{
					document.querySelector('.delPhoto').classList.remove('notBlock');
				}
				$('#modalFormCategoria').modal('show');
			} else {
				swal("Error", objData.msg, "Error");
			}
		}
	}
}

function fntDelCategoria(idcategoria) {
	var idcategoria = idcategoria;
	swal({
		title: "Eliminar Categoria",
		text: "¿Realmente desea Eliminar la categoria?",
		icon: "warning",
		buttons: [
			'No, Cancelar!',
			'Si, Eliminar!'
		],
		dangerMode: true,
	}).then(function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
			var ajaxDelCategoria = base_url + '/Categorias/delCategoria/';
			var strData = 'idcategoria=' + idcategoria;

			request.open("POST", ajaxDelCategoria, true);
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send(strData);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("Eliminar!", objData.msg, "success");
						tableCategorias.api().ajax.reload();
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
function fntViewCategoria(idcategoria) {
	var idcategoria = idcategoria;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Categorias/getCategoria/' + idcategoria;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				var estadoCategoria = objData.data.status == 1 ?
					'<span class="badge badge-success">Activo</span>' :
					'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celNombre").innerHTML = objData.data.nombre;
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				document.querySelector("#imgCategoria").innerHTML = '<img src="'+objData.data.url_portada+'">';
				document.querySelector("#celEstado").innerHTML = estadoCategoria;
				$('#modalViewCategoria').modal('show');
			} else {
				swal("Error", objData.msg, "error");
			}
		}
	}
}
