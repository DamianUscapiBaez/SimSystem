var tableProductos;
document.addEventListener('DOMContentLoaded', function() {
    tableProductos = $('#tableProductos').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Productos/getProductos",
            /* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [ /* Campos de la base de datos*/
            { "data": "idproducto" },
            { "data": "imagen" },
            { "data": "nombre" },
            { "data": "categoria" },
            { "data": "precio_Compra" },
            { "data": "precio_Venta" },
            { "data": "stock" },
            { "data": "options" }
        ],
        'dom': 'Bfrtip',
        'buttons': [{
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i>",
            "titleAttr": "Copiar",
            "className": "btn btn-secondary",
            "exportOptions": {
                "columns": [0, 2, 3, 4, 5, 6]
            }
        }, {
            "extend": "excelHtml5",
            "text": "<i class='fa fa-file-excel'></i> ",
            "titleAttr": "Esportar a Excel",
            "className": "btn btn-success",
            "exportOptions": {
                "columns": [0, 2, 3, 4, 5, 6]
            }
        }, {
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> ",
            "titleAttr": "Esportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": {
                "columns": [0, 2, 3, 4, 5, 6]
            }
        }],
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        /*Mostrará los primero 10 registros*/
        "order": [
            [0, "desc"]
        ] /*Ordenar de forma Desendente*/
    });
    if (document.querySelector("#foto")) {
        var foto = document.querySelector("#foto");
        foto.onchange = function(e) {
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
        delPhoto.onclick = function(e) {
            document.querySelector("#foto_remove").value = 1;
            removePhoto();
        }
    }
    var formProductos = document.querySelector("#formProductos");

    formProductos.onsubmit = function(e) {
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        let intCodigo = document.querySelector('#txtCodigo').value;
        let precio_compra = document.querySelector('#precio_compra').value;
        let precio_venta = document.querySelector('#precio_venta').value;
        let intStock = document.querySelector('#txtStock').value;
        let strDescripcion = document.querySelector('#txtDescripcion').value
        if (strNombre == '' || intCodigo == '' || precio_compra == '' || precio_venta == '' || intStock == '' || strDescripcion == '') {
            swal("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        if (intCodigo.length < 5) {
            swal("Atención", "El código debe ser mayor que 5 dígitos.", "error");
            return false;
        }
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Productos/setProducto';
        let formData = new FormData(formProductos);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormProducto').modal("hide");
                    formProductos.reset();
                    swal("Productos", objData.msg, "success");
                    tableProductos.api().ajax.reload();
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
            return false;
        }
    };
    fntCategorias();
    fntProveedores();
});

$('#tableProductos').dataTable();

function fntCategorias() {
    if (document.querySelector('#listCategoria')) {
        let ajaxUrl = base_url + '/Categorias/getSelectCategorias';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}

function fntProveedores() {
    if (document.querySelector('#listProveedor')) {
        let ajaxUrl = base_url + '/Proveedores/getSelectProveedores';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                document.querySelector('#listProveedor').innerHTML = request.responseText;
                $('#listProveedor').selectpicker('render');
            }
        }
    }
}

function fntPrintBarcode(area) {
    console.log(area);
    let elemntArea = document.querySelector(area);
    let vprint = window.open(' ', 'popimpr', 'height=400,width=600');
    vprint.document.write(elemntArea.innerHTML);
    vprint.document.close();
    vprint.print();
    vprint.close();
}

function removePhoto() {
    document.querySelector('#foto').value = "";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if (document.querySelector('#img')) {
        document.querySelector('#img').remove();
    }
}

function openModal() {
    document.getElementById('boxproveedor').classList.remove('d-none');
    document.querySelector('#formProductos').classList.remove("was-validated");
    document.querySelector('#idProducto').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProductos").reset();
    $('#modalFormProducto').modal('show');
    removePhoto();
}

function closeModal() {
    $('#modalFormProducto').modal('hide');
}

function fntViewInfo(idProducto) {
    let request = (window.XMLHttpRequest) ?
        new XMLHttpRequest() :
        new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Productos/getProducto/' + idProducto;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let estadoProducto = objData.data.status == 1 ?
                    '<span class="badge badge-success">Activo</span>' :
                    '<span class="badge badge-danger">Inactivo</span>';
                let codigo = objData.data.codigo;
                JsBarcode("#barcode", codigo, { width: 2, height: 50 });
                document.querySelector("#Producto").innerHTML = objData.data.nombre;
                document.querySelector("#Categoria").innerHTML = objData.data.categoria;
                document.querySelector("#precioCompra").innerHTML = objData.data.precio_compra;
                document.querySelector("#precioVenta").innerHTML = objData.data.precio_venta;
                document.querySelector("#Estado").innerHTML = estadoProducto;
                document.querySelector("#descripcion").innerHTML = objData.data.descripcion;
                document.querySelector("#Cantidad").innerHTML = objData.data.stock;
                document.querySelector("#Foto").innerHTML = '<img class="mt-2 w-100"  height="250px" src="' + objData.data.url_portada + '">';
                $('#modalViewProducto').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntEditInfo(idProducto) {
    document.getElementById('boxproveedor').classList.add('d-none');
    document.querySelector('#titleModal').innerHTML = "Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector("#foto_remove").value = 0;
    let request = (window.XMLHttpRequest) ?
        new XMLHttpRequest() :
        new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Productos/getProducto/' + idProducto;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let objProducto = objData.data;
                document.querySelector("#idProducto").value = objProducto.idproducto;
                document.querySelector("#txtNombre").value = objProducto.nombre;
                document.querySelector("#txtCodigo").value = objProducto.codigo;
                document.querySelector("#listCategoria").value = objProducto.categoriaid;
                document.querySelector("#precio_compra").value = objProducto.precio_compra;
                document.querySelector("#precio_venta").value = objProducto.precio_venta;
                document.querySelector("#txtStock").value = objProducto.stock;
                document.querySelector('#foto_actual').value = objProducto.portada;
                document.querySelector("#listCategoria").value = objProducto.categoriaid;
                document.querySelector("#txtDescripcion").value = objProducto.descripcion;
                document.querySelector("#foto_remove").value = 0;
                if (document.querySelector('#img')) {
                    document.querySelector('#img').src = objData.data.url_portada;
                } else {
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src=" + objData.data.url_portada + ">";
                }
                if (objData.data.portada == 'portada_categoria.png') {
                    document.querySelector('.delPhoto').classList.add('notBlock');
                } else {
                    document.querySelector('.delPhoto').classList.remove('notBlock');
                }
                if (objData.data.status == 1) {
                    document.querySelector("#listStatus").value = 1;
                } else {
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
                $('#listCategoria').selectpicker('render');
                $('#modalFormProducto').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntDelInfo(idProducto) {
    swal({
        title: "Eliminar Producto",
        text: "¿Realmente quiere eliminar el producto?",
        type: "warning",
        buttons: [
            'No, Cancelar!',
            'Si, Eliminar!'
        ],
        dangerMode: true
    }).then(function(isConfirm) {
        if (isConfirm) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Productos/delProducto';
            let strData = "idProducto=" + idProducto;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Eliminar!", objData.msg, "success");
                        tableProductos.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}