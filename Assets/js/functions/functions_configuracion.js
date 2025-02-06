document.addEventListener('DOMContentLoaded', function(){
    if(document.querySelector("#formEmpresa")){
        let formEmpresa = document.querySelector("#formEmpresa");
        formEmpresa.onsubmit = function(e) {
            e.preventDefault();
            let intRuc = document.querySelector('#txtRuc').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strDireccion = document.querySelector('#txtDireccion').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strEmail = document.querySelector('#txtEmail').value;

            if(intRuc == '' || strNombre == '' || strDireccion == '' || intTelefono == '' || intTelefono == '' || strEmail == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Configuracion/Update_Business'; 
            let formData = new FormData(formEmpresa);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4 ) return; 
                if(request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal({
                            title: "Datos actualizados",
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
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                return false;
            }
        }
    }
});
