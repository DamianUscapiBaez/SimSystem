var tableHistorialEntradas;
document.addEventListener('DOMContentLoaded', function () {
    tableHistorialEntradas = $('#tableEntradas').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Entradas/getEntradas/",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [
            { "data": "idmovements" },
            { "data": "datemovements" },
            { "data": "typedocument" },
            { "data": "documentnumber" },
            { "data": "reason" },
            { "data": "total" },
            { "data": "username" },
            { "data": "statusmovements" },
            { "data": "options" }
        ],
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "searching": false,
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
});
$('#tableEntradas').dataTable();

function btnAnular(identrada) {
    swal({
        title: "¿Esta de seguro de Anular la salida?",
        text: "Se anulara la salida",
        icon: "warning",
        buttons: [
            'No, Cancelar!',
            'Si, anular!'
        ],
        dangerMode: true,
    }).then(function (isConfirm) {
        if (isConfirm) {
            swal("Entrada anulada", 'Se ha anulado la salida', "success");
            // var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
            // var ajaxUrl = base_url + '/Entradas/anularEntrada/' + identrada;
            // request.open("GET", ajaxUrl, true);
            // request.send();
            // request.onreadystatechange = function () {
            //     // if (request.readyState == 4 && request.status == 200) {
            //     //     var objData = JSON.parse(request.responseText);
            //     //     console.log(objData);
            //     //     if (objData.status) {
            //     //         swal("Entrada anulada", objData.msg, "success");
            //     //         tableHistorialEntradas.api().ajax.reload();
            //     //     } else {
            //     //         swal("Error", objData.msg, "error");
            //     //     }
            //     // }
            //     swal("Entrada anulada", 'Se ha anulado la entrada', "success");
            // }
        }
    });
}
function generarFactura(identrada) {
    window.open(base_url + '/Entradas/generarFacturaPdf/' + identrada, "_blanck", "width=350", "height=350");
}
function viewDetalle() {
    $('#detalleEntradas').modal('show');
}