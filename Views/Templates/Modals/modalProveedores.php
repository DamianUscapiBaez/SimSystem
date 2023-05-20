<div class="modal fade" id="modalFormProveedor" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Nuevo Proveedor</h5>
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form class="needs-validation" id="formProveedor" name="formProveedor">
                    <input type="hidden" id="idProveedor" name="idProveedor" value="">
                    <div class="position-relative form-group">
                        <label for="exampleText" class="">Ruc</label>
                        <input name="txtRuc" id="txtRuc" placeholder="Ejem. 10098398343" type="text"
                            class="form-control"maxlength="11" required>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleText" class="">nombre</label>
                        <input name="txtNombre" id="txtNombre" placeholder="Ejem. System Tecnology" type="text"
                            class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleText" class="">Direccion</label>
                                <input name="txtDireccion" id="txtDireccion" placeholder="Ejem. Calle peral N° 897" type="text"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleText" class="">telefono</label>
                                <input name="txtTelefono" id="txtTelefono" placeholder="Ejem. 999 999 999" type="text"
                                    class="form-control" maxlength="9" required>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleSelect" class="">Estado</label>
                        <select name="listStatus" id="listStatus" class="form-control selectpicker">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                    <div class="title-footer text-center">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i
                                class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i
                                class="fa fa-times-circle"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="modalViewProveedor" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success" style="color: #fff;">
                    <h5 class="modal-title" id="titleModal">Datos de proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table m-0" style="width:100%">
                            <tbody>
                                <tr>
                                    <td>Ruc de proveedor:</td>
                                    <td id="celRuc"></td>
                                </tr>
                                <tr>
                                    <td>Nombre de proveedor:</td>
                                    <td id="celNombre"></td>
                                </tr>
                                <tr>
                                    <td>Direccion:</td>
                                    <td id="celDireccion"></td>
                                </tr>
                                <tr>
                                    <td>Telefono:</td>
                                    <td id="celTelefono"></td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td id="celEstado"></td>
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