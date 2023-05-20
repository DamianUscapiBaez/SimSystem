var table_kardex;
document.addEventListener('DOMContentLoaded', function() {
    table_kardex = $('#table_kardex').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        'serverMethod': 'post',
        'searching': true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Reportes/kardex_productos",
            "dataSrc": ""
        },
        'dom': 'Bfrtip',
        'buttons': [{
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i>",
            "className": "btn btn-secondary",
            "exportOptions": {
                "columns": [0, 1, 2,3,4,5]
            }
        }, {
            "extend": "excelHtml5",
            "text": "<i class='fa fa-file-excel'></i>",
            "className": "btn btn-success",
            "exportOptions": {
                "columns": [0, 1, 2,3,4,5]
            }
        }, {
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i>",
            "className": "btn btn-danger",
            "exportOptions": {
                "columns": [0, 1, 2,3,4,5]
            }
        }],
        "columns": [ /* Campos de la base de datos*/
            { "data": "idmovimiento" },
            { "data": "fechas" },
            { "data": "producto" },
            { "data": "iven_inicial" },
            { "data": "entradas" },
            { "data": "salidas" },
            { "data": "existencias" },
            { "data": "options" }
        ],
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        /*Mostrará los primero 10 registros*/
        "order": [
            [0, "desc"]
        ] /*Ordenar de forma Desendente*/
    });
});

$('#table_kardex').dataTable();

function fntViewInfo(idmovimiento) {

    $('#modalViewKardex').modal('show');
    table_kardex = $('#table_kardex_producto').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        'serverMethod': 'post',
        'searching': true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + '/Reportes/getKardexProducto/' + idmovimiento,
            "dataSrc": ""
        },
        'dom': 'lBfrtip',
        'buttons': [{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr": "Esportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": {
                "columns": [0, 1, 2, 3, 4, 5, 6]
            }
        }],
        'columnDefs': [{
                'width': "10px",
                'targets': 0
            },
            {
                'width': "10px",
                'targets': 1
            },
            {
                'width': "10px",
                'targets': 2
            },
            {
                'width': "80px",
                'targets': 3
            },
            {
                'width': "10px",
                'targets': 4
            },
            {
                'width': "20px",
                'targets': 5
            },
            {
                'width': "20px",
                'targets': 6
            }
        ],
        "columns": [ /* Campos de la base de datos*/
            { "data": "id" },
            { "data": "datecreated" },
            { "data": "tipomovimiento" },
            { "data": "descripcion" },
            { "data": "cantidad" },
            { "data": "precio_S" },
            { "data": "total_S" }
        ],
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        /*Mostrará los primero 10 registros*/
        "order": [
            [0, "asc"]
        ] /*Ordenar de forma Desendente*/
    });
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Reportes/getProducto/' + idmovimiento;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData) {
                document.getElementById('titleModal').innerHTML = 'KARDEX ' + objData.fechas.toUpperCase() + ' ( ' + objData.producto.toUpperCase() + ' )';
                document.getElementById('text-body-1').innerHTML = 'Entrada por unidad : ' + objData.entradas;
                document.getElementById('text-body-2').innerHTML = 'Salidas por unidad : ' + objData.salidas;
                document.getElementById('text-body-3').innerHTML = 'Iventario inicial : ' + objData.iven_inicial;
                document.getElementById('text-body-4').innerHTML = 'Iventario actual : ' + objData.existencias;
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Reportes/getTotalEntradas/' + idmovimiento;
                request.open("GET", ajaxUrl, true);
                request.send();
                request.onreadystatechange = function() {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData === "0") {
                            document.getElementById('text-body-5').innerHTML = 'Costo de unidades :  s/. 0';
                        } else {
                            document.getElementById('text-body-5').innerHTML = 'Costo de unidades :  s/. ' + objData.total_entradas;
                        }
                    }
                }

                let request1 = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl2 = base_url + '/Reportes/getTotalSalidas/' + idmovimiento;
                request1.open("GET", ajaxUrl2, true);
                request1.send();
                request1.onreadystatechange = function() {
                    if (request1.readyState == 4 && request1.status == 200) {
                        let objData = JSON.parse(request1.responseText);
                        if (objData.total1 === "0") {
                            document.getElementById('text-body-6').innerHTML = 'Costo de unidades :  s/. 0';
                        } else {
                            document.getElementById('text-body-6').innerHTML = 'Costo de unidades :  s/. ' + objData.total_salidas;
                        }
                    }
                }
            }
        }
    }
}

function closeModal() {
    $('#modalViewKardex').modal('hide');
    document.getElementById('titleModal').innerHTML = "";
}