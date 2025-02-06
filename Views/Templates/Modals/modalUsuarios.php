<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header md-header bg-primary" style="color: #fff;">
                <h5 class="modal-title text-white" id="titleModal">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModal();">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUsuario" name="formUsuario">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-primary">todo los campos son obligatorios</p>
                            <input type="hidden" id="idUsuario" name="idUsuario" value="">
                        </div>
                        <div class="col-md-6 col-sm-12 mt-2">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="nombre" class="form-label">Nombre de usuario</label>
                                    <input name="txtUsername" id="txtUsername" placeholder="Nombre del usuario"
                                           type="text" class="form-control" maxlength="100">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input name="txtNombre" id="txtNombre" placeholder="Nombre del usuario" type="text"
                                           class="form-control" required maxlength="100">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label">Correo</label>
                                    <input name="txtEmail" id="txtEmail" placeholder="example@iventario.com"
                                           type="email" class="form-control" required maxlength="100">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-2">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="exampleSelect" class="form-label">Contraseña</label>
                                    <input name="txtPassword" id="txtPassword" placeholder="contraseña" type="password"
                                           class="form-control" maxlength="100">
                                </div>
                                <div class="col-md-10 mb-3">
                                    <label for="exampleSelect" class="form-label">Tipo de usuario</label>
                                    <select name="listRolid" id="listRolid" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3 mt-2">
                                    <button type="button" class="icon-button successbtn" title="Agregar Rol">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="exampleSelect" class="form-label">Estado</label>
                                    <select name="listStatus" id="listStatus" class="form-control">
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button id="btnActionForm" class="btn btn-primary text-white" type="submit"><i
                            class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i
                            class="fa fa-times-circle"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary" style="color: #fff;">
                <h5 class="modal-title text-white" id="titleModal">Datos de usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalView();">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Nombre usuario</span>
                    </div>
                    <div class="user_info" id="usernametb"></div>
                </div>
                <div class="single_user_pil d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Nombres</span>
                    </div>
                    <div class="user_info" id="nombretb"></div>
                </div>
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Tipo usuario</span>
                    </div>
                    <div class="user_info" id="roltb"></div>
                </div>
                <div class="single_user_pil d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Email</span>
                    </div>
                    <div class="user_info" id="emailtb"></div>
                </div>
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Estado</span>
                    </div>
                    <div class="user_info" id="statustb"></div>
                </div>
            </div>
        </div>
    </div>
</div>
