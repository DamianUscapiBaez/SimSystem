<div class="modal fade" id="modalFormRol" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Nuevo Rol</h5>
                <button type="button" class="close" id="btnclose" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="formRol" name="formRol">
                    <input type="hidden" id="idRol" name="idRol" value="">
                    <div class="form-group mt-2">
                        <label for="nombre" class="">Nombre</label>
                        <input name="txtNombre" id="txtNombre" placeholder="Nombre del rol" type="text" class="form-control mt-2" required>
                        <div class="valid-feedback">Correcto!</div>
                        <div class="invalid-feedback">Nombre incorrecto</div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleText" class="">Descripcion</label>
                        <textarea name="txtDescripcion" id="txtDescripcion" placeholder="Descripcion del rol" class="form-control mt-2" rows="2" required></textarea>
                        <div class="valid-feedback">Correcto!</div>
                        <div class="invalid-feedback"> Agregar descripcion</div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="listStatus">Estado</label>
                        <select name="listStatus" id="listStatus" class="mt-2 form-control selectpicker">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                    <div class="title-footer text-center mt-4">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i class="fa fa-times-circle"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

