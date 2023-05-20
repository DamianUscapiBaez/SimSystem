var tableUsuarios;
document.addEventListener('DOMContentLoaded', function () {
	tableUsuarios = $('#tableUsuarios').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": " " + base_url + "/Usuarios/getUsuarios",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "idusuario" },
			{ "data": "username" },
			{ "data": "nombre" },
			{ "data": "rol" },
			{ "data": "email" },
			{ "data": "status" },
			{ "data": "options" }
		],
		"responsive": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});
	if(document.querySelector('#formUsuario')){
		var formUsuario = document.querySelector('#formUsuario');
		formUsuario.onsubmit = function (e) {
			e.preventDefault();
			var strNombre = document.querySelector('#txtNombre').value;
			var strEmail = document.querySelector('#txtEmail').value;
			var intTipousuario = document.querySelector('#listRolid').value;
			var intStatus = document.querySelector('#listStatus').value;
	
			if (strNombre == '' || strEmail == '' || intTipousuario == '' || intStatus == '') {
				swal("atención", "todos los campos son obligatorios.", "error");
				return false;
			}
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = base_url + '/Usuarios/setUsuario';
			var formData = new FormData(formUsuario);
			request.open("POST", ajaxUrl, true);
			request.send(formData);
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						$('#modalFormUsuario').modal("hide");
						formUsuario.reset();
						swal("Usuarios", objData.msg, "success");
						tableUsuarios.api().ajax.reload();
					} else {
						swal("Error", objData.msg, "error");
					}
				}
			}
		}
	}
    //Actualizar Perfil
    if(document.querySelector("#formPerfil")){
        let formPerfil = document.querySelector("#formPerfil");
        formPerfil.onsubmit = function(e) {
            e.preventDefault();
            let strUsername = document.querySelector('#txtUsername').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;

            // if(strUsername == '' || strNombre == '')
            // {
            //     swal("Atención", "Todos los campos son obligatorios." , "error");
            //     return false;
            // }

            if(strPassword != "" || strPasswordConfirm != "")
            {   
                if( strPassword != strPasswordConfirm ){
                    swal("Atención", "Las contraseñas no son iguales." , "info");
                    return false;
                }           
                if(strPassword.length < 5 ){
                    swal("Atención", "La contraseña debe tener un mínimo de 5 caracteres." , "info");
                    return false;
                }
            }
            let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/putPerfil'; 
            let formData = new FormData(formPerfil);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4 ) return; 
                if(request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal({
                            title: "datos actualizados",
                            text: objData.msg,
                            type: "success",
							icon: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false,
                        }).then(function(isConfirm) {
                            if (isConfirm) {
                                location.reload();
                            }
                        });
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                return false;
            }
        }
    }
}, false);
window.addEventListener("load", function () {
	setTimeout(() => {
		fntRolesUsuario();
	}, 500);
}, false);
function fntRolesUsuario() {
    if(document.querySelector('#listRolid')){
        let ajaxUrl = base_url+'/Roles/getSelectRoles';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listRolid').innerHTML = request.responseText;
                $('#listRolid').selectpicker('render');
            }
        }
    }
}
function fntViewUsuario(idpersona) {
	var idUsuario = idpersona;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Usuarios/getUsuario/' + idUsuario;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);

			if (objData.status) {
				var estadoUsuario = objData.data.status == 1 ?
					'<span class="badge badge-success">Activo</span>' :
					'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celUsername").innerHTML = objData.data.username;
				document.querySelector("#celNombre").innerHTML = objData.data.nombre;
				document.querySelector("#celEmail").innerHTML = objData.data.email;
				document.querySelector("#celTipoUsuario").innerHTML = objData.data.rol;
				document.querySelector("#celEstado").innerHTML = estadoUsuario;
				$('#modalViewUser').modal('show');
			} else {
				swal("Error", objData.msg, "error");
			}
		}
	}
}
function fntEditUsuario(idusuario) {
	document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Usuarios/getUsuario/' + idusuario;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector("#idUsuario").value = objData.data.idusuario;
				document.querySelector("#txtUsername").value = objData.data.username;
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#txtEmail").value = objData.data.email;
				document.querySelector("#listRolid").value = objData.data.idrol;
				$('#listRolid').selectpicker('render');
				if (objData.data.status == 1) {
					document.querySelector("#listStatus").value = 1;
				} else {
					document.querySelector("#listStatus").value = 2;
				}
				$('#listStatus').selectpicker('render');
				if(objData.data.idusuario ==1){
					document.querySelector("#txtUsername").disabled = "disabled";
					document.querySelector("#txtPassword").disabled = "disabled";
					document.querySelector("#listRolid").disabled = "disabled";
					document.querySelector('#listStatus').disabled = "disabled";
				}else{
					document.querySelector("#txtUsername").disabled = false;
					document.querySelector("#txtPassword").disabled = false;
					document.querySelector("#listRolid").disabled = false;
					document.querySelector('#listStatus').disabled = false;
				}
			}
		}
		$('#modalFormUsuario').modal('show');
	}
}
function fntDelUsuario(idpersona) {
	var idUsuario = idpersona;
	swal({
		title: "Eliminar Usuario",
		text: "¿Realmente quiere eliminar el Usuario?",
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
			var ajaxUrl = base_url + '/Usuarios/delUsuario';
			var strData = "idUsuario=" + idUsuario;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(strData);
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("Eliminar!", objData.msg, "success");
						tableUsuarios.api().ajax.reload();
					} else {
						swal("Atención!", objData.msg, "error");
					}
				}
			}
		}

	});
}
function openModal() {
	document.querySelector('#formUsuario').classList.remove("was-validated");
	document.querySelector('#idUsuario').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
	document.querySelector('#btnText').innerHTML = " Guardar";
	document.querySelector('#formUsuario').reset();
	$('#modalFormUsuario').modal('show');
}
function closeModal() {
	$('#modalFormRol').modal('hide');
}