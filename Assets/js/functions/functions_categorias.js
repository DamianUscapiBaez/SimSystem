var tableCategorias;

$(document).ready(function () {
    tableCategorias = $('#tableCategorias').DataTable({
        "aprocessing": true,
        "aserverSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
            "paginate": {
                "previous": '<i class="fas fa-chevron-left"></i>',
                "next": '<i class="fas fa-chevron-right"></i>'
            }
        },
        "ajax": {
            "url": `${base_url}/Categorias/getCategorias`,
            "dataSrc": ""
        },
        "columns": [
            { "data": "idcategory" },
            { "data": "namecategory" },
            { "data": "descriptioncategory" },
            { "data": "statuscategory" },
            { "data": "options" }
        ],
        "responsive": true,
        "destroy": true,
        "pageLength": 10,
        "searching": false,
        "order": [[0, "desc"]]
    });

    $('#formCategoria').on("submit", function (e) {
        e.preventDefault();

        const nombrecategoria = $("#nombrecategoria").val();
        const statuscategoria = $("#statuscategoria").val();
        if (nombrecategoria === '' || statuscategoria === '') {
            swal("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        const formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: `${base_url}/Categorias/setCategoria`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                const objData = JSON.parse(response);
                if (objData.status) {
                    $('#modalFormCategoria').modal("hide");
                    $('#formCategoria')[0].reset();
                    swal("Categoría de productos", objData.msg, "success");
                    tableCategorias.ajax.reload();
                } else {
                    swal("Error", objData.msg, "error");
                }
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });
    });
});

function openModal() {
    $('#idcategoria').val("");
    $('.md-header').removeClass("bg-warning").addClass("bg-primary");
    $('#btnActionForm').removeClass("btn-info").addClass("btn-primary");
    $('#titleModal').html("Nueva Categoria");
    $('#btnText').html("Guardar");
    $('#formCategoria').trigger('reset');
    $('#modalFormCategoria').modal('show');
}

function closeModal() {
    $('#modalFormCategoria').modal('hide');
}

function closeModalView() {
    $('#modalViewCategoria').modal('hide');
}

function fntEditCategoria(idcategoria) {
    const elements = {
        modalTitle: $('#titleModal'),
        modalHeader: $('.md-header'),
        btnActionForm: $('#btnActionForm'),
        btnText: $('#btnText'),
        fotoRemove: $("#foto_remove"),
        formCategoria: $("#formCategoria"),
        idcategoriaInput: $("#idcategoria"),
        nombrecategoriaInput: $("#nombrecategoria"),
        descripcioncategoriaInput: $("#descripcioncategoria"),
        statuscategoriaSelect: $('#statuscategoria'),
    };

    elements.modalTitle.html("Actualizar Categoria");
    elements.modalHeader.removeClass("bg-primary").addClass("bg-warning");
    elements.btnActionForm.removeClass("btn-primary").addClass("btn-info");
    elements.btnText.html(" Actualizar");

    $.get(`${base_url}/Categorias/getCategoria/${idcategoria}`, function (data) {
        const objData = JSON.parse(data);

        if (objData.status) {
            elements.formCategoria[0].reset();
            elements.idcategoriaInput.val(objData.data.idcategory);
            elements.nombrecategoriaInput.val(objData.data.namecategory);
            elements.descripcioncategoriaInput.val(objData.data.descriptioncategory);
            elements.statuscategoriaSelect.val(objData.data.statuscategory);
            $('#modalFormCategoria').modal('show');
        } else {
            swal("Error", objData.msg, "Error");
        }
    });
}

function fntDelCategoria(idcategoria) {
    swal({
        title: "Eliminar Categoria",
        text: "¿Realmente desea Eliminar la categoria?",
        icon: "warning",
        buttons: ['No, Cancelar!', 'Sí, Eliminar!'],
        dangerMode: true,
    }).then(function (isConfirm) {
        if (isConfirm) {
            $.post(`${base_url}/Categorias/delCategoria/`, { idcategoria: idcategoria }, function (data) {
                const objData = JSON.parse(data);

                if (objData.status) {
                    swal("Eliminar!", objData.msg, "success");
                    tableCategorias.ajax.reload();
                } else {
                    swal("Atención!", objData.msg, "error");
                }
            }).fail(function () {
                swal("Atención!", "Error externo", "error");
            });
        }
    });
}

function fntViewCategoria(idcategoria) {
    $.get(`${base_url}/Categorias/getCategoria/${idcategoria}`, function (data) {
        const objData = JSON.parse(data);

        if (objData.status) {
            const estadoCategoria = `<span class="status_btn_${objData.data.statuscategory == 1 ? 'success' : 'error'}">
                    ${objData.data.statuscategoria == 1 ? 'Activo' : 'Inactivo'}</span>`;

            $("#nombrecategoriatb").html(objData.data.namecategory);
            $("#descripcioncategoriatb").html(objData.data.descriptioncategory || "N.A.");
            $("#statuscategoriatb").html(estadoCategoria);

            $('#modalViewCategoria').modal('show');
        } else {
            swal("Error", objData.msg, "error");
        }
    });
}
