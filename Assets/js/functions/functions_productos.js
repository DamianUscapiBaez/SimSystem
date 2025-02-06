var tableProductos;

$(document).ready(function () {
    tableProductos = $('#tableProductos').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": base_url + "/Productos/getProductos",
            "dataSrc": ""
        },
        "columns": [
            { "data": "idproduct" },
            { "data": "imageproduct" },
            { "data": "nameproduct" },
            { "data": "namecategory" },
            // { "data": "tipounidad" },
            { "data": "quantity" },
            { "data": "unitprice" },
            { "data": "statusproduct" },
            { "data": "options" }
        ],
        'dom': 'Bfrtip',
        'buttons': [{
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i>",
            "titleAttr": "Copiar",
            "className": "btn btn-danger",
            "exportOptions": {
                "columns": [0, 2, 3, 4, 5, 6, 7]
            }
        }, {
            "extend": "excelHtml5",
            "text": "<i class='fa fa-file-excel'></i> ",
            "titleAttr": "Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": {
                "columns": [0, 2, 3, 4, 5, 6, 7]
            }
        }, {
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> ",
            "titleAttr": "Exportar a PDF",
            "className": "btn btn-danger",
            "searching": false,
            "exportOptions": {
                "columns": [0, 2, 3, 4, 5, 6, 7]
            }
        }],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "searching": false,
        "order": [[0, "desc"]],
    });

    if ($("#foto").length) {
        $("#foto").change(function (e) {
            var uploadFoto = $("#foto").val();
            var fileimg = $("#foto")[0].files;
            var nav = window.URL || window.webkitURL;
            var contactAlert = $("#form_alert");

            if (uploadFoto != '') {
                var type = fileimg[0].type;
                var name = fileimg[0].name;

                if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
                    contactAlert.html('<p class="errorArchivo">El archivo no es válido.</p>');

                    if ($("#img").length) {
                        $("#img").remove();
                    }

                    $(".delPhoto").addClass("notBlock");
                    $("#foto").val("");
                    return false;
                } else {
                    contactAlert.html('');
                    if ($("#img").length) {
                        $("#img").remove();
                    }

                    $(".delPhoto").removeClass("notBlock");

                    var objeto_url = nav.createObjectURL(fileimg[0]);
                    $(".prevPhoto div").html("<img id='img' src=" + objeto_url + ">");
                }
            } else {
                alert("No seleccionó foto");

                if ($("#img").length) {
                    $("#img").remove();
                }
            }
        });
    }

    if ($(".delPhoto").length) {
        $(".delPhoto").click(function (e) {
            $("#foto_remove").val(1);
            removePhoto();
        });
    }

    var formProductos = $("#formProductos");

    formProductos.submit(function (e) {
        e.preventDefault();

        var nombreproducto = $("#nombreproducto").val();
        var codigoproducto = $("#codigoproducto").val();
        var preciounitario = $("#preciounitario").val();

        if (nombreproducto == '' || codigoproducto == '' || preciounitario == '') {
            swal("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        if (codigoproducto.length < 5) {
            swal("Atención", "El código debe ser mayor que 5 dígitos.", "error");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: base_url + '/Productos/setProducto',
            data: new FormData(formProductos[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                var objData = JSON.parse(response);

                if (objData.status) {
                    $("#modalFormProducto").modal("hide");
                    formProductos[0].reset();
                    swal("Productos", objData.msg, "success");
                    tableProductos.ajax.reload();
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        });

        return false;
    });

    fntCategorias();
});

function removePhoto() {
    $("#foto").val("");
    $(".delPhoto").addClass("notBlock");

    if ($("#img").length) {
        $("#img").remove();
    }
}

function openModal() {
    $("#formProductos").removeClass("was-validated");
    $("#idproducto").val("");
    $(".md-header").removeClass("bg-warning").addClass("bg-primary");
    $("#btnActionForm").removeClass("btn-info").addClass("btn-primary");
    $("#btnText").html("Guardar");
    $("#titleModal").html("Nuevo Producto");
    $("#formProductos")[0].reset();
    $("#modalFormProducto").modal("show");
    removePhoto();
}

function closeModal() {
    $("#modalFormProducto").modal("hide");
}

function closeModalView() {
    $("#modalViewProducto").modal("hide");
}

function fntCategorias() {
    if ($("#categoriaid").length) {
        $.get(base_url + '/Categorias/getSelectCategorias', function (data) {
            $("#categoriaid").html(data);
        });
    }
}

function fntViewInfo(idProducto) {
    $.get(base_url + '/Productos/getProducto/' + idProducto, function (data) {
        var objData = JSON.parse(data);

        if (objData.status) {
            var statusproduct = objData.data.statusproduct == 1 ?
                '<span class="status_btn_success">Activo</span>' :
                '<span class="status_btn_error">Inactivo</span>';

            var codigo = objData.data.codeproduct;
            JsBarcode("#barcode", codigo, { width: 2, height: 50 });

            $("#nombreproductotb").html(objData.data.nameproduct);
            $("#categoriatb").html(objData.data.namecategory);
            // $("#tipounidadtb").html(objData.data.tipounidadview);
            $("#preciounitariotb").html(objData.data.unitprice);
            $("#cantidadproductotb").html(objData.data.quantity);
            $("#cantidadminimatb").html(objData.data.minimunquantity);
            $("#statusproductotb").html(statusproduct);
            $("#Foto").html('<img class="mt-2 w-100" height="250px" src="' + objData.data.imageproduct + '">');

            $("#modalViewProducto").modal("show");
        } else {
            swal("Error", objData.msg, "error");
        }
    });
}

function fntEditInfo(idProducto) {
    $("#titleModal").html("Actualizar Producto");
    $(".md-header").removeClass("bg-primary").addClass("bg-warning");
    $("#btnActionForm").removeClass("btn-primary").addClass("btn-info");
    $("#btnText").html("Actualizar");
    $("#foto_remove").val(0);

    $.get(base_url + '/Productos/getProducto/' + idProducto, function (data) {
        var objData = JSON.parse(data);

        if (objData.status) {
            var objProducto = objData.data;

            $("#idproducto").val(objProducto.idproducto);
            $("#nombreproducto").val(objProducto.nameproduct);
            $("#codigoproducto").val(objProducto.codeproduct);
            $("#preciounitario").val(objProducto.unitprice);
            $("#cantidadminima").val(objProducto.minimunquantity);

            $("#categoriaid").val(objData.data.categoryid);
            // $("#tipounidad").val(objData.data.tipounidad);
            $("#statusproducto").val(objData.data.statusproduct);

            $("#foto_remove").val(0);
            $("#foto_actual").val(objProducto.imageproduct);

            if (objData.data.portada == 'box.png') {
                $(".delPhoto").addClass("notBlock");
            } else {
                $(".delPhoto").removeClass("notBlock");
            }

            $("#modalFormProducto").modal("show");
        } else {
            swal("Error", objData.msg, "error");
        }
    });
}

function fntDelInfo(idProducto) {
    swal({
        title: "Eliminar Producto",
        text: "¿Realmente quiere eliminar el producto?",
        icon: "warning",
        buttons: [
            'No, Cancelar!',
            'Si, Eliminar!'
        ],
        dangerMode: true
    }).then(function (isConfirm) {
        if (isConfirm) {
            $.post(base_url + '/Productos/delProducto', { idProducto: idProducto }, function (data) {
                var objData = JSON.parse(data);
                if (objData.status) {
                    swal("Eliminar!", objData.msg, "success");
                    tableProductos.ajax.reload();
                } else {
                    swal("Atención!", objData.msg, "error");
                }
            });
        }
    });
}
