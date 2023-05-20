var tableHistorialEntradas;
document.addEventListener('DOMContentLoaded', function () {
    var frmBuscarCodigo = document.querySelector("#buscar_producto");
    frmBuscarCodigo.onsubmit = function (e) {
        e.preventDefault();
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var buscar = document.getElementById('search_producto').value;
        if(buscar == ''){
            swal("atención", "ingresar un valor que buscar", "error");
			return false;
        }
        var ajaxUrl = base_url + '/Entradas/buscar_producto/' + buscar;
        request.open("POST", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                if (objData.status) {
                    let td = "";
                    document.getElementById('table_producto').innerHTML = "";
                    $.each(objData.data,function(data,row){
                        console.log(row);
                        td=`<td>${row.codigo}</td>
                           <td>${row.nombre}</td>
                           <td><button class="btn btn-success" onclick="cargarProducto(${row.idproducto})" type="button"><i class="fas fa-plus"></i></button></td>`;
                           document.getElementById('table_producto').innerHTML += td;
                    });
				} else {
                    document.getElementById('table_producto').innerHTML ="";
					swal("Error", objData.msg, "error");
				}
            }
        }
    } 
    var frmBuscarProveedor = document.querySelector("#buscar_proveedor");
    frmBuscarProveedor.onsubmit = function (e) {
        e.preventDefault();
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var buscar = document.getElementById('search_proveedor').value;
        if(buscar == ''){
            swal("atención", "ingresar un valor que buscar", "error");
			return false;
        }
        var ajaxUrl = base_url + '/Proveedores/buscar_proveedor/' + buscar;
        request.open("POST", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                if (objData.status) {
                    let td = "";
                    document.getElementById('table_proveedor').innerHTML = "";
                    $.each(objData.data,function(data,row){
                        td=`<td>${row.ruc}</td>
                           <td>${row.nombre}</td>
                           <td><button class="btn btn-success" onclick="cargarProveedor(${row.idproveedor})" type="button"><i class="fas fa-plus"></i></button></td>`;
                           document.getElementById('table_proveedor').innerHTML += td;
                    });
				} else {
					swal("Error", objData.msg, "error");
                    document.getElementById('table_proveedor').innerHTML ="";
				}
            }
        }
    }
    var frmEntradasProducto = document.querySelector("#frmEntradaProducto");
    frmEntradasProducto.onsubmit = function (e) {
        e.preventDefault();
        swal({
            title: "¿Esta de seguro de realizar la entrada?",
            text: "Se registrara la entrada",
            icon: "warning",
            buttons: [
                'No, Cancelar!',
                'Si, registrar!'
            ],
            dangerMode: true,
        }).then(function (isConfirm) {
            if (isConfirm) {
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
                var ajaxUrl = base_url + '/Entradas/registrarEntrada';
    
                request.open("POST", ajaxUrl, true);
                var formData = new FormData(frmEntradasProducto);
                request.send(formData);
    
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            swal("Se genero la entrada", objData.msg, "success");
                            generarFactura(objData.identrada);
                            table_tmp_entrada.api().ajax.reload();
                            document.querySelector('#txtNombreE').value = "";
                            document.querySelector('#txtDireccionE').value = "";
                            document.querySelector('#idproveedorE').value = "";
                        } else {
                            swal("Atención no se pudo realizar la peticion solicitada", objData.msg, "error");
                        }
                    } else {
                        swal("Atención!", "Error externo", "error");
                    }
                }
            }
        });
    }
    var formProveedor = document.querySelector("#formProveedor");
	formProveedor.onsubmit = function (e) {
		e.preventDefault();
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
                    recuperarProveedor(objData.id);
				} else {
					swal("Error", objData.msg, "error");
				}
			}
		}
	};
    cargarDetalle();
    calcularTotal();
});
function cargarProducto(idproducto){
    $('#modalCodigo').modal('hide');
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Entradas/getProducto/' + idproducto;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector("#codigo").value = objData.data.codigo;
				document.querySelector("#producto").value = objData.data.nombre;
                document.querySelector("#precio_compra").value = objData.data.precio_compra;
                document.getElementById("idproducto").value = objData.data.idproducto;
                $('#modalProducto').modal('hide');
                document.getElementById('table_producto').innerHTML = "";
                document.getElementById("search_producto").value = "";
                document.getElementById('cantidad').focus();
			} else {
				swal("Error", objData.msg, "Error");
			}
		}
	}
}
function cargarProveedor(idproveedor){
    $('#modalCodigo').modal('hide');
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Proveedores/getProveedor/' + idproveedor;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
                document.querySelector("#idproveedorE").value = objData.data.idproveedor;
				document.querySelector("#txtRucE").value = objData.data.ruc;
				document.querySelector("#txtNombreE").value = objData.data.nombre;
				document.querySelector("#txtDireccionE").value = objData.data.direccion;
                $('#modalBuscarProveedor').modal('hide');
                document.getElementById('table_proveedor').innerHTML = "";
                document.getElementById("search_proveedor").value = "";
			} else {
				swal("Error", objData.msg, "Error");
			}
		}
	}
}
function recuperarProveedor(idproveedor){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Proveedores/getProveedor/' + idproveedor;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
                document.querySelector("#idproveedorE").value = objData.data.idproveedor;
				document.querySelector("#txtRucE").value = objData.data.ruc;
				document.querySelector("#txtNombreE").value = objData.data.nombre;
				document.querySelector("#txtDireccionE").value = objData.data.direccion;
			} else {
				swal("Error", objData.msg, "Error");
			}
		}
	}
}
function buscarCodigo(e) {
    e.preventDefault();
    if (e.which == "13") {
        let cod = document.getElementById("codigo").value;
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
        var ajaxUrl = base_url + '/Entradas/buscarCodigo/' + cod;
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    document.getElementById("producto").value = objData.data.nombre;
                    document.getElementById("idproducto").value = objData.data.idproducto;
                    document.querySelector("#precio_compra").value = objData.data.precio_compra;

                    document.getElementById("cantidad").focus();
                } else {
                    document.getElementById("producto").value = "";
                    document.getElementById("idproducto").value = "";
                    swal("Error", objData.msg, "error");
                }
            }
        }
    }
}
function buscar_proveedor(e) {
    e.preventDefault();
    if (e.which == "13") {
        let ruc = document.querySelector("#txtRuc").value;
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
        var ajaxUrl = base_url + '/Proveedores/buscarProveedor/' + ruc;
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    document.querySelector("#idproveedorE").value = objData.data.idproveedor;
                    document.getElementById("txtNombreE").value = objData.data.nombre;
                    document.getElementById("txtDireccionE").value = objData.data.direccion;
                } else {
                    // document.getElementById("txtNombreE").value = "";
                    // document.getElementById("txtDireccionE").value = "";
                    swal("Error", objData.msg, "error");
                }
            }
        }
    }
}
function calcularSubtotal(e) {
    let cantidad = document.getElementById("cantidad").value;
    let precio = document.getElementById('precio_compra').value;
    e.preventDefault();
    if (e.which == "13") {
        if (cantidad > 0) {
            var formEntrada = document.querySelector("#frmEntrada");
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
            var ajaxUrl = base_url+'/Entradas/agregar_producto';
            var formData = new FormData(formEntrada);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        formEntrada.reset();
                        swal({
                            title: objData.msg,
                            text: objData.msg,
                            icon: "success",
                        });
                        table_tmp_entrada.api().ajax.reload();
                        calcularTotal();
                    } else {
                        swal("Error nose se pudo agregar", objData.msg, "error");
                    }
                }
            }
        }
    }
}
// function calcularSubtotalP(e) {
//     let precio = document.getElementById('precio_compra').value;
//     let cantidad = document.getElementById("cantidad").value;
//     document.querySelector('#sub_total').value = cantidad * precio;
//     e.preventDefault();
//     if (e.which == "13") {
//         document.getElementById("cantidad").focus();
//     }
// }

function cargarDetalle() {
    table_tmp_entrada = $('#table_tmp_entrada').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Entradas/listarProductos",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "id" },
            { "data": "producto"},
            { "data": "cantidad"},
            { "data": "precio"},
            { "data": "subtotal"},
            { "data": "options" }
        ],
        "responsieve": "true",
        "bDestroy": true,
        "bFilter": false,
        "bPaginate": false
    });
}
function calcularTotal(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
    var ajaxUrl = base_url+'/Entradas/CalcularTotal';
    request.open("POST", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            document.querySelector('#total').value = objData.total;
        }
    }
}
function deleteDetalle(id_detalle) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
    var ajaxUrl = base_url + '/Entradas/deleteDetalle/' + id_detalle;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                swal({
                    title: "Se elimino correctamento",
                    text: objData.msg,
                    icon: "success"
                });
                table_tmp_entrada.api().ajax.reload();
                calcularTotal();
            } else {
                swal("Error nose se pudo eliminar", objData.msg, "error");
            }
        }
    }
}
function fntCamare() {
    $('#modalCamare').modal('show');
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#camera'),
            constraints: {
                width: 350,
                height: 350,
                facing: "environment" // or user
            }
        },
        decoder: {
            readers: ["code_128_reader"]
        }
    }, function (err) {
        if (err) {
            console.log(err);
            return
        }
        Quagga.start();
    });

    Quagga.onDetected(function (result) {
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
        var ajaxUrl = base_url + '/Entradas/buscarCodigo/' + result.codeResult.code;
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    console.log(objData);
                    document.getElementById("producto").value = objData.data.nombre;
                    document.getElementById("idproducto").value = objData.data.idproducto;
                    document.getElementById("precio_compra").value = objData.data.precio_compra;
                    document.getElementById("precio_compra").focus();
                } else {
                    Quagga.stop();
                    swal("Error", "el producto no existe", "error");
                }
            }
        }
        Quagga.stop();
        document.getElementById('codigo').value = result.codeResult.code;
        $('#modalCamare').modal('hide');
    });
}
function openCodigo() {
    $('#modalProducto').modal('show');
    document.getElementById("search_producto").value= "";
}
function openBuscarProveedor(){
    $('#modalBuscarProveedor').modal('show');
}
function openNewProveedor(){
    $('#modalFormProveedor').modal('show');
}
function openGuia(){
    $('#modalguia').modal('show');
}
function closeModal() {
    document.getElementById('table_proveedor').innerHTML = "";
    document.getElementById("search_proveedor").value= "";
   
}
function cloaseModalCam(){
    Quagga.stop();
    $('#modalCamare').modal('hide');
}
function closeModalproducto() {
    document.getElementById('table_producto').innerHTML = "";
    document.getElementById("search_producto").value= "";
    $('#modalProducto').modal('hide');
}

function generarFactura(identrada){
    window.open(base_url + '/Entradas/generarFacturaPdf/' + identrada, "_blanck","height=570","width=520");
}