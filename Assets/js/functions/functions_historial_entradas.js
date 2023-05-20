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
        "columns": [/* Campos de la base de datos*/
            { "data": "identrada"},
            { "data": "usuario"},
            { "data": "proveedor" },
            { "data": "total" },
            { "data": "status" },
            { "data": "fecha_entrada"},
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
            'width': "60px",
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
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
});
$('#tableEntradas').dataTable();

function btnAnular(identrada) {
    swal({
        title: "¿Esta de seguro de Anular la entrada?",
        text: "Se anulara la entrada",
        icon: "warning",
        buttons: [
            'No, Cancelar!',
            'Si, anular!'
        ],
        dangerMode: true,
    }).then(function (isConfirm) {
        if (isConfirm) {
            var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
            var ajaxUrl = base_url + '/Entradas/anularEntrada/' + identrada;
            request.open("GET", ajaxUrl, true);
            request.send();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    console.log(objData);
                    if (objData.status) {
                        swal("Entrada anulada", objData.msg, "success");
                        tableHistorialEntradas.api().ajax.reload();
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            }
        }
    });
}
function generarFactura(identrada){
    window.open(base_url + '/Entradas/generarFacturaPdf/' + identrada, "_blanck","width=350","height=350");
}
