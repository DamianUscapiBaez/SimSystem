var tableProveedores;

$(document).ready(function () {
    tableProveedores = $('#tableProveedores').DataTable({
        "aprocessing": true,
        "aserverSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": base_url + "/Proveedores/getProveedores",
            "dataSrc": ""
        },
        "columns": [
            { "data": "idprovider", "width": "5%" },
            { "data": "typedocument", "width": "15%" },
            { "data": "documentnumber", "width": "10%" },
            { "data": "nameprovider", "width": "20%" },
            { "data": "addressofprovider", "width": "20%" },
            { "data": "phonenumber", "width": "5%" },
            { "data": "statusprovider", "width": "5%" },
            { "data": "options", "width": "10%" }
        ],
        "responsive": true,
        "destroy": true,
        "pageLength": 10,
        "searching": false,
        "order": [[0, "desc"]]
    });

    // formulario de proveedor
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
                    tableProveedores.ajax.reload();
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        });
    });
});

// functions modal
function openModal() {
    $('#formProveedor').removeClass("was-validated");
    $('#idproveedor').val("");
    $('.md-header').removeClass("bg-warning").addClass("bg-primary");
    $('#btnActionForm').removeClass("btn-info").addClass("btn-primary");
    $('#titleModal').html("Nuevo proveedor");
    $('#btnText').html(" Guardar");
    $('#formProveedor')[0].reset();
    $('#modalFormProveedor').modal('show');
}

function closeModal() {
    $('#modalFormProveedor').modal('hide');
}

function closeModalView() {
    $('#modalViewProveedor').modal('hide');
}

// functions actions proveedor
function fntEditProveedor(idproveedor) {
    $('#titleModal').html("Actualizar Proveedor");
    $('.md-header').removeClass("bg-primary").addClass("bg-warning");
    $('#btnActionForm').removeClass("btn-primary").addClass("btn-info");
    $('#btnText').html(" Actualizar");

    $.ajax({
        type: "GET",
        url: base_url + "/Proveedores/getProveedor/" + idproveedor,
        success: function (response) {
            var objData = JSON.parse(response);

            if (objData.status) {
                $("#idproveedor").val(objData.data.idprovider);
                // $("#tipodocumento").val(objData.data.typedocument);
                $("#numerodocumento").val(objData.data.documentnumber);
                $("#nombreproveedor").val(objData.data.nameprovider);
                $("#correoproveedor").val(objData.data.emailprovider);
                $("#telefonoproveedor").val(objData.data.phonenumber);
                $("#direccionproveedor").val(objData.data.addressofprovider);

                $('#tipodocumento').val(objData.data.typedocument);
                $('#statusproveedor').val(objData.data.statusprovider);

                $('#modalFormProveedor').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    });
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
            var strData = 'idproveedor=' + idproveedor;

            $.ajax({
                type: "POST",
                url: base_url + "/Proveedores/delProveedor/",
                data: strData,
                success: function (response) {
                    var objData = JSON.parse(response);
                    if (objData.status) {
                        swal("Eliminar!", objData.msg, "success");
                        tableProveedores.ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                },
                error: function () {
                    swal("Atención!", "Error externo", "error");
                }
            });
        }
    });
}

function fntViewProveedor(idproveedor) {
    $.ajax({
        type: "GET",
        url: base_url + "/Proveedores/getProveedor/" + idproveedor,
        success: function (response) {
            var objData = JSON.parse(response);
            if (objData.status) {
                let statusproveedor = objData.data.statusprovider == 1 ?
                    '<span class="status_btn_success">Activo</span>' :
                    '<span class="status_btn_error">Inactivo</span>';

                $("#tipodocumentotb").html(objData.data.tipodocumentoview);
                $("#numerodocumentotb").html(objData.data.documentnumber);
                $("#nombreproveedortb").html(objData.data.nameprovider);
                $("#correoproveedortb").html(objData.data.emailprovider);
                $("#telefonoproveedortb").html(objData.data.phonenumber);
                $("#direccionproveedortb").html(objData.data.addressofprovider);
                $("#statusproveedortb").html(statusproveedor);

                $('#modalViewProveedor').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    });
}
