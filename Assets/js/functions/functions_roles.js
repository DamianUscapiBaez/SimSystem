var tableRoles;

$(document).ready(function () {
    tableRoles = $('#tableRoles').DataTable({
        "aprocessing": true,
        "aserverSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": base_url + "/Roles/getRoles",
            "dataSrc": ""
        },
        "columns": [
            {"data": "idrole"},
            {"data": "namerole"},
            {"data": "descriptionrole"},
            {"data": "statusrole"},
            {"data": "options"}
        ],
        "responsive": true,
        "destroy": true,
        "pageLength": 10,
        "searching": false,
        "order": [[0, "desc"]]
    });

    // NUEVO ROL
    var formRol = $("#formRol");

    formRol.submit(function (event) {
        event.preventDefault();

        var strNombre = $("#txtNombre").val();
        var intStatus = $("#listStatus").val();

        if (strNombre == '' || intStatus == '') {
            swal("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: base_url + '/Roles/setRol',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (response) {
                var objData = JSON.parse(response);
                if (objData.status) {
                    $('#modalFormRol').modal("hide");
                    formRol[0].reset();
                    swal("Datos de rol actualizados", objData.msg, "success");
                    tableRoles.ajax.reload();
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        });
    });
});

function openModal() {
    $('#idRol').val("");
    $('.md-header').removeClass("bg-warning").addClass("bg-primary");
    $('#btnActionForm').removeClass("btn-info").addClass("btn-primary");
    $('#titleModal').html("Nuevo Rol");
    $('#btnText').html(" Guardar");
    $('#formRol')[0].reset();
    $('#modalFormRol').modal('show');
}

function closeModal() {
    $('#modalFormRol').modal('hide');
}

function closeModalPermisos() {
    $('#modalPermisos').modal('hide');
}

function fntEditRol(idrol) {
    $('#titleModal').html("Actualizar Rol");
    $('.md-header').removeClass("bg-primary").addClass("bg-warning");
    $('#btnActionForm').removeClass("btn-primary").addClass("btn-info");
    $('#btnText').html(" Actualizar");

    var request = $.ajax({
        url: base_url + '/Roles/getRol/' + idrol,
        type: 'GET',
        dataType: 'json'
    });

    request.done(function (objData) {
        if (objData.status) {
            $('#idRol').val(objData.data.idrole);
            $('#txtNombre').val(objData.data.namerole);
            $('#txtDescripcion').val(objData.data.descriptionrole);
            $('#listStatus').val(objData.data.statusrole);
            $('#modalFormRol').modal('show');
        } else {
            swal("Error", objData.msg, "Error");
        }
    });
}

function fntDelRol(idrol) {
    swal({
        title: "Eliminar Rol",
        text: "¿Realmente desea eliminar el Rol?",
        icon: "warning",
        buttons: [
            'No, Cancelar!',
            'Sí, Eliminar!'
        ],
        dangerMode: true
    }).then(function (isConfirm) {
        if (isConfirm) {
            var request = $.ajax({
                url: base_url + '/Roles/delRol/',
                type: 'POST',
                data: {idrol: idrol},
                dataType: 'json'
            });

            request.done(function (objData) {
                if (objData.status) {
                    swal("Eliminar", objData.msg, "success");
                    tableRoles.ajax.reload();
                } else {
                    swal("Atención", objData.msg, "error");
                }
            });

            request.fail(function (jqXHR, textStatus) {
                swal("Error", "Error externo: " + textStatus, "error");
            });
        }
    });
}

function fntPermisos(idrol) {
    var request = $.ajax({
        url: base_url + '/Permisos/getPermisosRol/' + idrol,
        type: 'GET'
    });
    request.done(function (response) {
        $('#contentAjax').html(response);
        $('#modalPermisos').modal('show');
    });
}

function fntSavePermisos(event) {
    event.preventDefault();

    var request = $.ajax({
        url: base_url + '/Permisos/setPermisos',
        type: 'POST',
        data: new FormData($('#formPermisos')[0]),
        contentType: false,
        processData: false,
        dataType: 'json'
    });

    request.done(function (objData) {
        if (objData.status) {
            swal("Permisos de usuario", objData.msg, "success");
        } else {
            swal("Error", objData.msg, "error");
        }
    });

    request.fail(function (jqXHR, textStatus) {
        swal("Error", "Error externo: " + textStatus, "error");
    });
}
