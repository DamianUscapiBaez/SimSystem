var tableHistorialSalidas;
var tableHistorialSalidasAnulados;
var tableBoletas;
var tableBoletasAnulados;
document.addEventListener('DOMContentLoaded', function () {
    tableHistorialSalidas = $('#tableSalidas').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Salidas/getFacturahoy/",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "id" },
            { "data": "usuario" },
            { "data": "cliente" },
            { "data": "total" },
            { "data": "status" },
            { "data": "datecreated"},
            { "data": "timecreated"},
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
          },
          {
            'width': "90px",
            'targets': 7
          }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i>Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fa fa-file-excel'></i> Excel",
                "titleAttr": "Esportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Esportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }
        ],
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
    tableHistorialSalidasAnulados = $('#tableSalidasAnulados').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Salidas/getFacturahoyAnulados/",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "id" },
            { "data": "tipo_documento" },
            { "data": "serie_documento" },
            { "data": "usuario" },
            { "data": "cliente" },
            { "data": "total" },
            { "data": "status" },
            { "data": "datecreated"},
            { "data": "timecreated"},
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
          },
          {
            'width': "90px",
            'targets': 7
          }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i>Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fa fa-file-excel'></i> Excel",
                "titleAttr": "Esportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Esportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }
        ],
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
    tableBoletas = $('#tableBoletas').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Salidas/getBoletashoy/",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "id" },
            { "data": "tipo_documento" },
            { "data": "serie_documento" },
            { "data": "usuario" },
            { "data": "cliente" },
            { "data": "total" },
            { "data": "status" },
            { "data": "datecreated"},
            { "data": "timecreated"},
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
          },
          {
            'width': "90px",
            'targets': 7
          }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i>Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fa fa-file-excel'></i> Excel",
                "titleAttr": "Esportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Esportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }
        ],
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
    tableBoletasAnulados = $('#tableBoletasAnulados').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Salidas/getBoletasAnuladoshoy/",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "id" },
            { "data": "tipo_documento" },
            { "data": "serie_documento" },
            { "data": "usuario" },
            { "data": "cliente" },
            { "data": "total" },
            { "data": "status" },
            { "data": "datecreated"},
            { "data": "timecreated"},
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
          },
          {
            'width': "90px",
            'targets': 7
          }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i>Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fa fa-file-excel'></i> Excel",
                "titleAttr": "Esportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Esportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4 ,5 ,6 ,7 ,8]
                }
            }
        ],
        "responsieve": "true",
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
                        swal({
                          title: "se cancelo la salida",
                          text: objData.msg,
                          type: "success",
                          icon: "success",
                                        confirmButtonText: "Aceptar",
                                        closeOnConfirm: false,
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            location.reload();
                                        }
                                    });
                        tableHistorialSalidas.api().ajax.reload();
                        tableHistorialSalidasAnulados.api().ajax.reload();
                        tableBoletas.api().ajax.reload();
                        tableBoletasAnulados.api().ajax.reload();
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            }
        }
    });
}
function generarFactura(idsalida){
    window.open(base_url + '/Salidas/generarFacturaPdf/' + idsalida, "_blanck","height=570","width=520");
}
function generarBoleta(idsalida){
    window.open(base_url + '/Salidas/generarBoletaPdf/' + idsalida, "_blanck","height=570","width=520");
}