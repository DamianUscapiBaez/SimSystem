<div class="modal fade" id="modalFormCliente" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Nuevo Cliente</h5>
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="frmCliente" name="frmCliente">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="idcliente" name="idcliente" value="">
                            <div class="position-relative form-group">
                                <label for="nombre" class="">Tipo de documento</label>
                                <select name="listDocumento" id="listDocumento" class="form-control selectpicker">
                                    <option value="1">RUC</option>
                                    <option value="2">DNI</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="">
                            <div class="position-relative form-group">
                                <label for="exampleSelect" class="">Numero de Documento</label>
                                <input name="txtDocumento" id="txtDocumento" placeholder="Numero de documento" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="nombre" class="">Nombres</label>
                                <input name="txtNombre" id="txtNombre" placeholder="Nombre del cliente" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="nombre" class="">Direccion</label>
                                <input name="txtDireccion" id="txtDireccion" placeholder="Direccion" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="position-relative form-group">
                                <label for="exampleSelect" class="">Telefono</label>
                                <input name="txtTelefono" id="txtTelefono" placeholder="ejem. 999 999 999" type="number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleSelect" class="">Estado</label>
                                <select name="listStatus" id="listStatus" class="form-control selectpicker">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="title-footer text-center">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i class="fa fa-times-circle"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalViewCliente" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Datos del cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table m-0" style="width:100%">
                        <tbody>
                            <tr>
                                <td>Tipo de Documento:</td>
                                <td id="tipo_documento"></td>
                            </tr>
                            <tr>
                                <td>Documento:</td>
                                <td id="documento"></td>
                            </tr>
                            <tr>
                                <td>Nombres del cliente:</td>
                                <td id="nombre_cliente"></td>
                            </tr>
                            <tr>
                                <td>Direccion:</td>
                                <td id="direccion"></td>
                            </tr>
                            <tr>
                                <td>Telefono:</td>
                                <td id="telefono"></td>
                            </tr>
                            <tr>
                                <td>Estado</td>
                                <td id="status"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>