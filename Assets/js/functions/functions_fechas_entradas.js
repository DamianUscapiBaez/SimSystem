document.addEventListener('DOMContentLoaded', function () {
    var frm_fechas_entradas = document.querySelector("#frm_entradas");
    frm_fechas_entradas.onsubmit = function(e){
        e.preventDefault();
        let fecha_inicial = document.querySelector('#date_from').value;
        let fecha_final = document.querySelector('#date_to').value;
        if(fecha_inicial == '' || fecha_final == ''){
            swal("atención", "todos los campos son obligatorios.", "error");
            return false;
        }
        if(fecha_inicial>fecha_final){
            swal("atención", "la fecha inicial no puede ser mayor a la fecha final", "error");
            return false;
        }
        var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/Reportes/validar_fechas';
        var formData = new FormData(frm_fechas_entradas);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    swal("pdf generado", objData.msg, "success");
                    let fechas = [fecha_inicial,fecha_final];
                    const ruta = base_url + '/Reportes/generar_pdf_entradas/' + fechas;
                    window.open(ruta)
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        }
    }
});

