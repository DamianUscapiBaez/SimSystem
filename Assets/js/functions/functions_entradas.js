var tableEntradas = [];
var total = 0;
$(document).ready(function () {
    $('#buscar_producto').submit(function (e) {
        e.preventDefault();
        var buscar = $('#search_producto').val().trim();
        if (buscar === '') {
            swal("Atención", "Ingresar un valor para buscar", "error");
            return false;
        }
        var ajaxUrl = base_url + '/Productos/buscarProducto/' + buscar;
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            success: function (response) {
                var objData = JSON.parse(response);
                var tableProducto = $('#table_producto');
                tableProducto.empty();
                if (objData.status) {
                    $.each(objData.data, function (index, row) {
                        var tr = $('<tr>').append(
                            $('<td>').text(index + 1),
                            $('<td>').text(row.codigoproducto),
                            $('<td>').text(row.nombreproducto),
                            $('<td>').text(row.cantidadproducto),
                            $('<td>').append(
                                $('<button>').addClass("action_btn border-0").attr("title", "Agregar Producto").attr("type", "button").click(function () {
                                    cargarProducto(row);
                                }).append(
                                    $('<i>').addClass("fas fa-plus")
                                )
                            )
                        );
                        tableProducto.append(tr);
                    });
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        });
    });
    $('#buscar_proveedor').submit(function (e) {
        e.preventDefault();
        var buscar = $('#search_proveedor').val().trim();
        if (buscar === '') {
            swal("Atención", "Ingresar un valor para buscar", "error");
            return false;
        }
        var ajaxUrl = `${base_url}/Proveedores/buscarproveedor/${buscar}`;
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            success: function (response) {
                var objData = JSON.parse(response);
                var tableProveedor = $('#bodyproveedor');
                tableProveedor.empty();
                if (objData.status) {
                    $.each(objData.data, function (index, row) {
                        var tr = $('<tr>').append(
                            $('<td>').text(index + 1),
                            $('<td>').text(row.tipodocumento),
                            $('<td>').text(row.numerodocumento),
                            $('<td>').text(row.nombreproveedor),
                            $('<td>').append(
                                $('<button>').addClass("action_btn border-0").attr("title", "Agregar Proveedor").attr("type", "button").click(function () {
                                    cargarProveedor(row);
                                }).append(
                                    $('<i>').addClass("fas fa-plus")
                                )
                            )
                        );
                        tableProveedor.append(tr);
                    });
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        });
    });
    $("#formProveedor").submit(function (e) {
        e.preventDefault();

        var tipodocumento = $("#tipodocumento").val();
        var numerodocumento = $("#numerodocumento").val();
        var nombreproveedor = $("#nombreproveedor").val();
        var intStatus = $("#statusproveedor").val();

        if (tipodocumento == '' || numerodocumento == '' || nombreproveedor == '' || intStatus == '') {
            swal("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        $.ajax({
            type: "POST",
            url: base_url + "/Proveedores/setProveedor",
            data: new FormData($("#formProveedor")[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                var objData = JSON.parse(response);
                if (objData.status) {
                    $('#modalFormProveedor').modal("hide");
                    $("#formProveedor")[0].reset();
                    swal("Proveedor de productos", objData.msg, "success");
                    $('#idproveedorentrada').val(objData.idproveedor);
                    $('#numeroproveedor').val(numerodocumento);
                    $('#nombreproveedorentrada').val(nombreproveedor);
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        });
    });
    // $('#frmEntrada').submit(function (e) {
    //     e.preventDefault();
    //     var formData = $(this).serializeArray();
    //     const fechaemision = $('#fechaemision').val();
    //     if (fechaemision == '') {
    //         swal("Atención", "La fecha emision es obligatoria.", "error");
    //         return false;
    //     }
    //     if (tableEntradas.length <= 0) {
    //         swal("Atención", "El detalle producto no puede ir vacio.", "error");
    //         return false;
    //     }
    //     const formData = new FormData(this); 
    //     $.ajax({
    //         type: 'POST',
    //         url: `${base_url}/Categorias/setCategoria`,
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function (response) {
    //             const objData = JSON.parse(response);
    //             if (objData.status) {
    //                 $('#modalFormCategoria').modal("hide");
    //                 $('#formCategoria')[0].reset();
    //                 swal("Categoría de productos", objData.msg, "success");
    //                 tableCategorias.ajax.reload();
    //             } else {
    //                 swal("Error", objData.msg, "error");
    //             }
    //         },
    //         error: function (error) {
    //             console.log("Error:", error);
    //         }
    //     });
    // });
    console.log(total)
    $('#total, #totalentrada').html(total.toFixed(2));
});
// funciones de modal
function openCodigo() {
    $('#modalProducto').modal('show');
    document.getElementById("search_producto").value = "";
}
function openBuscarProveedor() {
    $('#modalBuscarProveedor').modal('show');
}
function openProveedorNuevo() {
    $('#modalFormProveedor').modal('show');
}
function openGuia() {
    $('#modalguia').modal('show');
}
function closeModal() {
    document.getElementById('table_proveedor').innerHTML = "";
    document.getElementById("search_proveedor").value = "";
}
function closeModalSearchProveedor() {
    $("#modalBuscarProveedor").modal('hide');
}
// fucntiones de carga
function cargarProducto(producto) {
    $('#modalCodigo').modal('hide');

    $("#idproducto").val(producto.idproducto);
    $("#codigo").val(producto.codigoproducto);
    $("#producto").val(producto.nombreproducto);
    $("#preciounitario").val(producto.preciounitario);

    $('#modalProducto').modal('hide');
    $('#table_producto').empty();
    $("#search_producto").val("");
    $("#cantidad").focus();
}

function cargarProveedor(proveedor) {
    $('#modalBuscarProveedor').modal('hide');
    $('#idproveedorentrada').val(proveedor.idproveedor);
    $('#numeroproveedor').val(proveedor.numerodocumento);
    $('#nombreproveedorentrada').val(proveedor.nombreproveedor);
}

function buscarCodigo(e) {
    if (e.which !== 13) return;

    e.preventDefault();

    let cod = $("#codigo").val();
    $.ajax({
        type: "GET",
        url: base_url + '/Productos/buscarProductoCodigo/' + cod,
        success: function (response) {
            var objData = JSON.parse(response);
            if (objData.status) {
                $("#producto").val(objData.data.nombreproducto);
                $("#idproducto").val(objData.data.idproducto);
                $("#preciounitario").val(objData.data.preciounitario);
                $("#cantidad").focus();
            } else {
                $("#producto").val("");
                $("#idproducto").val("");
                swal("Error", objData.msg, "error");
            }
        }
    });
}
function buscarProveedorInput(e) {
    if (e.which !== 13) return;

    e.preventDefault();

    let cod = $("#numeroproveedor").val();
    $.ajax({
        type: "GET",
        url: `${base_url}/Proveedores/buscarproveedorinput/${cod}`,
        success: function (response) {
            var objData = JSON.parse(response);
            if (objData.status) {
                $('#idproveedorentrada').val(objData.data.idproveedor);
                $('#numeroproveedor').val(objData.data.numerodocumento);
                $('#nombreproveedorentrada').val(objData.data.nombreproveedor);
            } else {
                $('#idproveedorentrada').val("");
                $('#numeroproveedor').val("");
                $('#nombreproveedorentrada').val("");
                swal("Error", objData.msg, "error");
            }
        }
    });

}

// function buscarProveedor(e) {
//     e.preventDefault();
//     if (e.which == "13") {
//         let ruc = document.querySelector("#txtRuc").value;
//         var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
//         var ajaxUrl = base_url + '/Proveedores/buscarProveedor/' + ruc;
//         request.open("GET", ajaxUrl, true);
//         request.send();
//         request.onreadystatechange = function () {
//             if (request.readyState == 4 && request.status == 200) {
//                 var objData = JSON.parse(request.responseText);
//                 if (objData.status) {
//                     document.querySelector("#idproveedorE").value = objData.data.idproveedor;
//                     document.getElementById("txtNombreE").value = objData.data.nombre;
//                     document.getElementById("txtDireccionE").value = objData.data.direccion;
//                 } else {
//                     // document.getElementById("txtNombreE").value = "";
//                     // document.getElementById("txtDireccionE").value = "";
//                     swal("Error", objData.msg, "error");
//                 }
//             }
//         }
//     }
// }

// function deleteDetalle(id_detalle) {
//     var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
//     var ajaxUrl = base_url + '/Entradas/deleteDetalle/' + id_detalle;
//     request.open("GET", ajaxUrl, true);
//     request.send();
//     request.onreadystatechange = function () {
//         if (request.readyState == 4 && request.status == 200) {
//             var objData = JSON.parse(request.responseText);
//             if (objData.status) {
//                 swal({
//                     title: "Se elimino correctamento",
//                     text: objData.msg,
//                     icon: "success"
//                 });
//                 table_tmp_entrada.api().ajax.reload();
//                 calcularTotal();
//             } else {
//                 swal("Error nose se pudo eliminar", objData.msg, "error");
//             }
//         }
//     }
// }
// function fntCamare() {
//     $('#modalCamare').modal('show');
//     Quagga.init({
//         inputStream: {
//             name: "Live",
//             type: "LiveStream",
//             target: document.querySelector('#camera'),
//             constraints: {
//                 width: 350,
//                 height: 350,
//                 facing: "environment" // or user
//             }
//         },
//         decoder: {
//             readers: ["code_128_reader"]
//         }
//     }, function (err) {
//         if (err) {
//             console.log(err);
//             return
//         }
//         Quagga.start();
//     });

//     Quagga.onDetected(function (result) {
//         var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
//         var ajaxUrl = base_url + '/Entradas/buscarCodigo/' + result.codeResult.code;
//         request.open("GET", ajaxUrl, true);
//         request.send();
//         request.onreadystatechange = function () {
//             if (request.readyState == 4 && request.status == 200) {
//                 var objData = JSON.parse(request.responseText);
//                 if (objData.status) {
//                     document.getElementById("producto").value = objData.data.nombreproducto;
//                     document.getElementById("idproducto").value = objData.data.idproducto;
//                     document.getElementById("precio_compra").value = objData.data.preciounitario;
//                     document.getElementById("precio_compra").focus();
//                 } else {
//                     Quagga.stop();
//                     swal("Error", "el producto no existe", "error");
//                 }
//             }
//         }
//         Quagga.stop();
//         document.getElementById('codigo').value = result.codeResult.code;
//         $('#modalCamare').modal('hide');
//     });
// }

function cloaseModalCam() {
    Quagga.stop();
    $('#modalCamare').modal('hide');
}
function closeModalproducto() {
    document.getElementById('table_producto').innerHTML = "";
    document.getElementById("search_producto").value = "";
    $('#modalProducto').modal('hide');
}

function generarFactura(identrada) {
    window.open(base_url + '/Entradas/generarFacturaPdf/' + identrada, "_blanck", "height=570", "width=520");
}
// funciones de tabla
function agregarProducto(event) {
    if (event.key !== "Enter") return;

    var idProducto = $("#idproducto").val();
    var nombreProducto = $("#producto").val();
    var cantidadProducto = parseFloat($("#cantidad").val()) || 0;
    var precioProducto = parseFloat($("#preciounitario").val()) || 0;
    var subTotal = (cantidadProducto * precioProducto).toFixed(2);

    // Buscar si el producto ya existe en el array
    var productoExistente = tableEntradas.find(function (producto) {
        return producto.idProducto === idProducto && producto.precioProducto === precioProducto;
    });

    if (productoExistente) {
        // Si el producto ya existe, actualizar la cantidad y recalcular el subtotal
        productoExistente.cantidadProducto += cantidadProducto;
        productoExistente.subTotal = (productoExistente.cantidadProducto * productoExistente.precioProducto).toFixed(2);
    } else {
        // Si el producto no existe, agregarlo al array
        var producto = {
            idProducto: idProducto,
            nombreProducto: nombreProducto,
            cantidadProducto: cantidadProducto,
            precioProducto: precioProducto,
            subTotal: subTotal
        };
        tableEntradas.push(producto);
    }

    // Actualizar la tabla y limpiar los campos del formulario
    actualizarTabla();
    $("#producto, #preciounitario, #cantidad, #codigo").val("");

    swal("Éxito", "Producto agregado correctamente", "success");
}

function calcularTotal() {
    var total = tableEntradas.reduce((acc, producto) => acc + parseFloat(producto.subTotal), 0);
    $('#total').html(total.toFixed(2)).end().find('#totalentrada').val(total.toFixed(2));
}

function actualizarTabla() {
    var tableBody = $('#tableProductos tbody');
    tableBody.empty();

    tableEntradas.forEach(function (producto, index) {
        var newRow = $('<tr>').append(
            $('<td>').text(index + 1),
            $('<td>').text(producto.nombreProducto),
            $('<td>').append($('<input>').attr({ type: 'text', class: 'form-label cantidad', name: 'cantidad', value: producto.cantidadProducto })),
            $('<td>').append($('<input>').attr({ type: 'text', class: 'form-label precio', name: 'precio', value: producto.precioProducto.toFixed(2) })),
            $('<td>').text(producto.subTotal),
            $('<td>').append($('<button>').attr({ type: 'button', class: 'action_btn border-0', title: 'Eliminar Producto' }).html('<i class="fa fa-trash"></i>').on('click', function () { eliminarFila(this); }))
        );

        tableBody.append(newRow);
    });

    $('.cantidad, .precio').on('change', function () {
        var rowIndex = $(this).closest('tr').index();
        var fieldName = $(this).attr('name');
        var newValue = parseFloat($(this).val()) || 0;

        if (fieldName === 'cantidad') {
            tableEntradas[rowIndex].cantidadProducto = newValue;
        } else if (fieldName === 'precio') {
            tableEntradas[rowIndex].precioProducto = newValue;
        }

        tableEntradas[rowIndex].subTotal = (tableEntradas[rowIndex].cantidadProducto * tableEntradas[rowIndex].precioProducto).toFixed(2);
        actualizarTabla();
    });
    calcularTotal();
}

function eliminarFila(button) {
    swal({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        buttons: ["Cancelar", "Sí, eliminar"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            var rowIndex = $(button).closest('tr').index();
            tableEntradas.splice(rowIndex, 1);
            actualizarTabla();
            calcularTotal();
            swal("¡Eliminado!", "La fila ha sido eliminada.", "success");
        }
    });
}

