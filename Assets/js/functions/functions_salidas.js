document.addEventListener('DOMContentLoaded', function () {
    var frmBuscarCodigo = document.querySelector("#buscar_producto");
    frmBuscarCodigo.onsubmit = function (e) {
        e.preventDefault();
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var buscar = document.getElementById('search_producto').value;
        if (buscar == '') {
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
                    $.each(objData.data, function (data, row) {
                        console.log(row);
                        td = `<td>${row.codigo}</td>
                           <td>${row.nombre}</td>
                           <td><button class="btn btn-success" onclick="cargarProducto(${row.idproducto})" type="button"><i class="fas fa-plus"></i></button></td>`;
                        document.getElementById('table_producto').innerHTML += td;
                    });
                } else {
                    swal("Error", objData.msg, "error");
                    document.getElementById('table_producto').innerHTML = "";
                }
            }
        }
    }
    var frmBuscarCliente = document.querySelector("#buscar_cliente");
    frmBuscarCliente.onsubmit = function (e) {
        e.preventDefault();
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var buscar = document.getElementById('search_cliente').value;
        if (buscar == '') {
            swal("atención", "ingresar un valor que buscar", "error");
            return false;
        }
        var ajaxUrl = base_url + '/Clientes/buscar_cliente/' + buscar;
        request.open("POST", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                if (objData.status) {
                    let td = "";
                    document.getElementById('table_cliente').innerHTML = "";
                    $.each(objData.data, function (data, row) {
                        console.log(row);
                        td = `<td>${row.documento}</td>
                           <td>${row.nombre}</td>
                           <td><button class="btn btn-success" onclick="cargarCliente(${row.idcliente})" type="button"><i class="fas fa-plus"></i></button></td>`;
                        document.getElementById('table_cliente').innerHTML += td;
                    });
                } else {
                    document.getElementById('table_cliente').innerHTML = "";
                    swal("Error", objData.msg, "error");
                }
            }
        }
    }
    var frmSalidaProducto = document.querySelector("#frmSalidaProducto");
    frmSalidaProducto.onsubmit = function (e) {
        e.preventDefault();
        swal({
            title: "¿Esta de seguro de realizar la salida?",
            text: "Se registrara la salida",
            icon: "warning",
            buttons: [
                'No, Cancelar!',
                'Si, registrar!'
            ],
            dangerMode: true,
        }).then(function (isConfirm) {
            if (isConfirm) {
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
                var ajaxUrl = base_url + '/Salidas/registrarSalida';

                request.open("POST", ajaxUrl, true);
                var formData = new FormData(frmSalidaProducto);
                request.send(formData);

                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            swal("Se genero la salida", objData.msg, "success");
                            document.querySelector('#idcliente').value = "";
                            document.querySelector('#txtDocumento').value = "";
                            document.querySelector('#txtNombre').value = "";
                            document.querySelector('#txtDireccion').value = "";
                            table_tmp_salida.api().ajax.reload();
                        } else {
                            swal("Atención no se pudo guardar!", objData.msg, "error");
                        }
                    } else {
                        swal("Atención!", "Error externo", "error");
                    }
                }
            }
        });
    }
    if (document.querySelector('#frmCliente')) {
        var frmCliente = document.querySelector('#frmCliente');
        frmCliente.onsubmit = function (e) {
            e.preventDefault();
            var intDocumento = document.querySelector('#txtDocumento').value;
            var strNombre = document.querySelector('#txtNombre').value;
            var strDireccion = document.querySelector('#txtDireccion').value;
            var intTelefono = document.querySelector('#txtTelefono').value;

            if (intDocumento == '' || strNombre == '' || strDireccion == '' || intTelefono == '') {
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
                        $('#modalNewCliente').modal("hide");
                        frmCliente.reset();
                        swal("Cliente", objData.msg, "success");
                        fntgetCliente(objData.id);
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            }
        }
    }
    cargarDetalle();
    calcularTotal();
});

function cargarDetalle() {
    table_tmp_salida = $('#table_tmp_salida').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Salidas/listarProductos",
            /* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [ /* Campos de la base de datos*/
            { "data": "id" },
            { "data": "producto" },
            { "data": "cantidad" },
            { "data": "precio" },
            { "data": "subtotal" },
            { "data": "options" }
        ],
        "responsieve": "true",
        "bFilter": false,
        "bPaginate": false,
        /*Mostrará los primero 10 registros*/
    });
}

function calcularTotal() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
    var ajaxUrl = base_url + '/Salidas/CalcularTotal';
    request.open("POST", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            document.querySelector('#total').value = objData.total;
        }
    }
}

function buscar_cliente(e) {
    e.preventDefault();
    if (e.which == "13") {
        let ruc = document.querySelector("#txtDocumento").value;
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
        var ajaxUrl = base_url + '/Clientes/buscarCliente/' + ruc;
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    document.querySelector("#idclienteS").value = objData.data.idcliente;
                    document.getElementById("txtNombreS").value = objData.data.nombre;
                    document.querySelector("#txtDocumentoS").value = objData.data.documento;
                    document.getElementById("txtDireccionS").value = objData.data.direccion;
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        }
    }
}
function fntgetCliente(idcliente) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
    var ajaxUrl = base_url + '/Clientes/getCliente/' + idcliente;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                console.log(objData)
                document.querySelector("#idclienteS").value = objData.data.idcliente;
                document.querySelector("#txtDocumentoS").value = objData.data.documento;
                document.getElementById("txtNombreS").value = objData.data.nombre;
                document.querySelector("#txtDireccionS").value = objData.data.direccion;
            }
        }
        $('#modalFormCliente').modal('show');
    }
}

function cargarProducto(idproducto) {
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
                document.getElementById("idproducto").value = objData.data.idproducto;
                document.getElementById("precio_venta").value = objData.data.precio_venta;
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
                    document.getElementById("precio_venta").value = objData.data.precio_venta;
                    document.getElementById("cantidad").focus();
                } else {
                    document.getElementById("producto").value = "";
                    document.getElementById("idproducto").value = "";
                    swal("Error", "el producto no existe", "error");
                }
            }
        }
    }
}

function cargarCliente(idcliente) {
    $('#modalCodigo').modal('hide');
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
    var ajaxUrl = base_url + '/Clientes/getCliente/' + idcliente;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#idclienteS").value = objData.data.idcliente;
                document.querySelector("#txtDocumentoS").value = objData.data.documento;
                document.querySelector("#txtNombreS").value = objData.data.nombre;
                document.querySelector("#txtDireccionS").value = objData.data.direccion;
                $('#modalBuscarCliente').modal('hide');
                document.getElementById('table_cliente').innerHTML = "";
                document.getElementById("search_cliente").value = "";
            } else {
                swal("Error", objData.msg, "Error");
            }
        }
    }
}

function agregar_producto_detalle(e) {
    let cantidad = document.getElementById("cantidad").value;
    let precio = document.getElementById("precio_venta").value;
    e.preventDefault();
    if (e.which == "13") {
        if (cantidad > 0) {
            var formSalida = document.querySelector("#frmSalida");
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
            var ajaxUrl = base_url + '/Salidas/agregar_producto';
            var formData = new FormData(formSalida);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    console.log(request.responseText);
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        formSalida.reset();
                        swal({
                            title: objData.msg,
                            text: objData.msg,
                            icon: "success",
                        });
                        calcularTotal();
                        table_tmp_salida.api().ajax.reload();
                    } else {
                        swal("Error nose se pudo agregar", objData.msg, "error");
                    }
                }
            }
        }
    }
}

function deleteDetalle(id_detalle) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
    var ajaxUrl = base_url + '/Salidas/deleteDetalle/' + id_detalle;
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
                table_tmp_salida.api().ajax.reload();
                document.querySelector("#idclienteS").value = "";
                document.getElementById("txtNombreS").value = "";
                document.getElementById("txtDireccionS").value = "";
                document.getElementById("total").value = "";
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
                if (objData) {
                    document.getElementById("producto").value = objData.nombre;
                    document.getElementById("identrada").value = objData.idproducto;
                    document.getElementById("cantidad").focus();
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
    document.getElementById("search_producto").value = "";
}

function openBuscarCliente() {
    $('#modalBuscarCliente').modal('show');
}

function closeModal() {
    Quagga.stop();
    $('#modalCamare').modal('hide');
}

function closeModalproducto() {
    document.getElementById('table_producto').innerHTML = "";
    document.getElementById("search_producto").value = "";
    $('#modalProducto').modal('hide');
}

function closeModalCliente() {
    document.getElementById('table_cliente').innerHTML = "";
    document.getElementById("search_cliente").value = "";
    $('#modalBuscarCliente').modal('hide');
}

function generarFactura(idsalida) {
    window.open(base_url + '/Salidas/generarFacturaPdf/' + idsalida, "_blanck", "height=570", "width=520");
}

function generarBoleta(idsalida) {
    window.open(base_url + '/Salidas/generarBoletaPdf/' + idsalida, "_blanck", "height=570", "width=520");
}

function fntComprobante(e) {
    var select = e.target.selectedOptions[0].getAttribute("data-nit")
    document.getElementById("serie").value = select;
    var selectcomprobante = document.getElementById("selectcomprobante").value;
    document.getElementById("tipo_documento").value = selectcomprobante;
}
function openNewCliente() {
    $('#modalNewCliente').modal('show');
}