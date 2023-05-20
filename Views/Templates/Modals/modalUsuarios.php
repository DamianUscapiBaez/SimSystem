<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="formUsuario" name="formUsuario">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-primary">todo los campos son obligatorios</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="idUsuario" name="idUsuario" value="">
                            <div class="position-relative form-group">
                                <label for="nombre" class="">Nombre de usuario</label>
                                <input name="txtUsername" id="txtUsername" placeholder="Nombre del usuario" type="text" class="form-control" required>
                            </div>
                            <div class="position-relative form-group">
                                <label for="nombre" class="">Nombre</label>
                                <input name="txtNombre" id="txtNombre" placeholder="Nombre del usuario" type="text" class="form-control" required>
                            </div>
                            <div class="position-relative form-group">
                                <label for="email" class="">Correo</label>
                                <input name="txtEmail" id="txtEmail" placeholder="example@iventario.com" type="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="">
                            <div class="position-relative form-group">
                                <label for="exampleSelect" class="">Contraseña</label>
                                <input name="txtPassword" id="txtPassword" placeholder="contraseña" type="password" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="selectpicker">tipo de usuario</label>
                                        <select name="listRolid" id="listRolid" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4 col-md-4">
                                    <a href="<?= base_url()?>/Roles" class="mt-2 btn btn-primary">nuevo rol</a>
                                </div>
                            </div>
        
                            <div class="position-relative form-group">
                                <label for="exampleSelect" class="">Estado</label>
                                <select name="listStatus" id="listStatus" class="form-control">
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
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Datos de usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table m-0" style="width:100%">
                        <tbody>
                            <tr>
                                <td>Nombre de usuario:</td>
                                <td id="celUsername"></td>
                            </tr>
                            <tr>
                                <td>Nombre:</td>
                                <td id="celNombre"></td>
                            </tr>
                            <tr>
                                <td>Tipo de usuario:</td>
                                <td id="celTipoUsuario"></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td id="celEmail"></td>
                            </tr>
                            <tr>
                                <td>Estado</td>
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




