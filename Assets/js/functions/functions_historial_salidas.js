var tableHistorialSalidas;
document.addEventListener('DOMContentLoaded', function () {
    tableHistorialSalidas = $('#tableSalidas').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Salidas/getSalidas/",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "idsalida" },
            { "data": "usuario" },
            { "data": "cliente" },
            { "data": "total" },
            { "data": "status" },
            { "data": "fecha_salida"},
            { "data": "reporte" }
        ],'columnDefs': [{
            'width': "10px",
            'targets': 0
          },
          {
            'width': "40px",
            'targets': 1
          },
          {
            'width': "40px",
            'targets': 2
          },
          {
            'width': "40px",
            'targets': 3
          },
          {
            'width': "50px",
            'targets': 4
          },
          {
            'width': "40px",
            'targets': 5
          },
          {
            'width': "40px",
            'targets': 6
          }
        ],
        "responsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
});
$('#tableSalidas').dataTable();
function btnAnular(idsalida) {
    swal({
        title: "¿Esta de seguro de Anular la salida?",
        text: "Se anulara la salida de producto",
        icon: "warning",
        buttons: [
            'No, Cancelar!',
            'Si, anular!'
        ],
        dangerMode: true,
    }).then(function (isConfirm) {
        if (isConfirm) {
            var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
            var ajaxUrl = base_url + '/Salidas/anularSalida/' + idsalida;
            request.open("GET", ajaxUrl, true);
            request.send();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    console.log(objData);
                    if (objData.status) {
                        swal("Salida anulada", objData.msg, "success");
                        tableHistorialSalidas.api().ajax.reload();
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            }
        }
    });
}
function generarFactura(idsalida){
    window.open(base_url + '/Salidas/generarReportePdf/' + idsalida, "_blanck","width=350","height=350");
}