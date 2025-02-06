<div class="modal fade" id="modalFormRol" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header md-header bg-primary" style="color: #fff;">
                <h5 class="modal-title text-white" id="titleModal">Nuevo Rol</h5>
                <button type="button" class="close" id="btnclose" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formRol" name="formRol">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="idRol" name="idRol" value="">
                        <div class="col-md-12 mb-3">
                            <label for="txtNombre" class="form-label">Nombre rol</label>
                            <input name="txtNombre" id="txtNombre" placeholder="Nombre del rol" type="text" class="form-control mt-2" required maxlength="50">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="txtDescripcion" class="form-label">Descripcion</label>
                            <textarea name="txtDescripcion" id="txtDescripcion" placeholder="Descripcion del rol" class="form-control mt-2" rows="2"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="listStatus" class="form-label">Estado</label>
                            <select name="listStatus" id="listStatus" class="form-control">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnActionForm" class="btn btn-primary text-white" type="submit"><i class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i class="fa fa-times-circle"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
