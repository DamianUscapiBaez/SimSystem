var tableUsuarios;

$(document).ready(function () {
    tableUsuarios = $('#tableUsuarios').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": base_url + "/Usuarios/getUsuarios",
            "dataSrc": ""
        },
        "columns": [
            { "data": "iduser" },
            { "data": "firstname" },
            { "data": "username" },
            { "data": "namerole" },
            { "data": "emailuser" },
            { "data": "statususer" },
            { "data": "options" }
        ],
        "responsive": true,
        "destroy": true,
        "pageLength": 10,
        "searching": false,
        "order": [[0, "desc"]]
    });

    if ($('#formUsuario').length) {
        $('#formUsuario').submit(function (e) {
            e.preventDefault();
            var strNombre = $('#txtNombre').val();
            var strEmail = $('#txtEmail').val();
            var intTipousuario = $('#listRolid').val();
            var intStatus = $('#listStatus').val();

            if (strNombre == '' || strEmail == '' || intTipousuario == '' || intStatus == '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }

            $.ajax({
                type: 'POST',
                url: base_url + '/Usuarios/setUsuario',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (response) {
                    var objData = JSON.parse(response);
                    if (objData.status) {
                        $('#modalFormUsuario').modal("hide");
                        $('#formUsuario')[0].reset();
                        swal("Usuarios", objData.msg, "success");
                        tableUsuarios.ajax.reload();
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            });
        });
    }

    if ($('#formPerfil').length) {
        $('#formPerfil').submit(function (e) {
            e.preventDefault();
            var strUsername = $('#txtUsername').val();
            var strNombre = $('#txtNombre').val();
            var strPassword = $('#txtPassword').val();
            var strPasswordConfirm = $('#txtPasswordConfirm').val();

            if (strUsername === '' || strNombre === '' || intStatus === '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            // Verificar que las contraseñas no estén vacías y sean iguales
            if (strPassword === '' || strPasswordConfirm === '') {
                swal("Atención", "Las contraseñas no pueden estar vacías.", "error");
                return false;
            }

            if (strPassword !== strPasswordConfirm) {
                swal("Atención", "Las contraseñas no coinciden.", "error");
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + '/Usuarios/putPerfil',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (response) {
                    var objData = JSON.parse(response);
                    if (objData.status) {
                        swal({
                            title: "Datos actualizados",
                            text: objData.msg,
                            type: "success",
                            icon: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false,
                        }).then(function (isConfirm) {
                            if (isConfirm) {
                                location.reload();
                            }
                        });
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            });
        });
    }

    setTimeout(() => {
        fntRolesUsuario();
    }, 500);
});

function fntRolesUsuario() {
    if ($('#listRolid').length) {
        $.get(base_url + '/Roles/getSelectRoles', function (data) {
            $('#listRolid').html(data);
        });
    }
}

function fntViewUsuario(iduser) {
    $.get(base_url + '/Usuarios/getUsuario/' + iduser, function (data) {
        var objData = JSON.parse(data);
        if (objData.status) {
            var status = objData.data.statususer == 1 ?
                '<span class="status_btn_success">Activo</span>' :
                '<span class="status_btn_error">Inactivo</span>';
            $("#usernametb").html(objData.data.username);
            $("#nombretb").html(objData.data.firstname);
            $("#emailtb").html(objData.data.emailuser);
            $("#roltb").html(objData.data.namerole);
            $("#statustb").html(status);
            $('#modalViewUser').modal('show');
        } else {
            swal("Error", objData.msg, "error");
        }
    });
}

function fntEditUsuario(idusuario) {
    $('#titleModal').html("Actualizar Usuario");
    $('.md-header').removeClass("bg-primary").addClass("bg-warning");
    $('#btnActionForm').removeClass("btn-primary").addClass("btn-info");
    $('#btnText').html("Actualizar");

    $.get(base_url + '/Usuarios/getUsuario/' + idusuario, function (data) {
        var objData = JSON.parse(data);
        if (objData.status) {
            $("#idUsuario").val(objData.data.iduser);
            $("#txtUsername").val(objData.data.username);
            $("#txtNombre").val(objData.data.firstname);
            $("#txtEmail").val(objData.data.emailuser);
            $('#listStatus').val(objData.data.statususer);
            $('#listRolid').val(objData.data.idrole);

            if (objData.data.idusuario == 1) {
                $("#txtUsername").prop('disabled', true);
                $("#txtPassword").prop('disabled', true);
                $("#listRolid").prop('disabled', true);
                $('#listStatus').prop('disabled', true);
            } else {
                $("#txtUsername").prop('disabled', false);
                $("#txtPassword").prop('disabled', false);
                $("#listRolid").prop('disabled', false);
                $('#listStatus').prop('disabled', false);
            }
        }
        $('#modalFormUsuario').modal('show');
    });
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
            // $.post(base_url + '/Usuarios/delUsuario', {idUsuario: idUsuario}, function (data) {
            //     var objData = JSON.parse(data);
            //     if (objData.status) {
            //         swal("Eliminar!", objData.msg, "success");
            //         tableUsuarios.ajax.reload();
            //     } else {
            //         swal("Atención!", objData.msg, "error");
            //     }
            // });
            swal("Eliminar!", 'Se ha eliminado el usuario', "success");
        }
    });
}

function openModal() {
    $('#idUsuario').val("");
    $('.md-header').removeClass("bg-warning").addClass("bg-primary");
    $('#btnActionForm').removeClass("btn-info").addClass("btn-primary");
    $('#titleModal').html("Nuevo Usuario");
    $('#btnText').html("Guardar");
    $('#formUsuario')[0].reset();
    $('#modalFormUsuario').modal('show');
}

function closeModal() {
    $('#modalFormUsuario').modal('hide');
}

function closeModalView() {
    $('#modalViewUser').modal('hide');
}
