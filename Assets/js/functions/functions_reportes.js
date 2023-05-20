var table_stock_minimo;
document.addEventListener('DOMContentLoaded', function () {
    table_stock_minimo = $('#table_stock_minimo').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Reportes/reporteStock",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "codigo" },
            { "data": "nombre" },
            { "data": "stock" }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i>Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fa fa-file-excel'></i> Excel",
                "titleAttr": "Esportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Esportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2]
                }
            }
        ],
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
});
$('#table_stock_minimo').dataTable();