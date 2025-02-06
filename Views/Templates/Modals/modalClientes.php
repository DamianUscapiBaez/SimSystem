<div class="modal fade" id="modalFormCliente" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header md-header bg-primary" style="color: #fff;">
                <h5 class="modal-title text-white" id="titleModal">Nuevo Cliente</h5>
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="closeModal();">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmCliente" name="frmCliente">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="idcliente" name="idcliente" value="">
                        <div class="col-md-6 mb-3">
                            <label for="tipodocumento" class="form-label">Tipo de documento</label>
                            <select name="tipodocumento" id="tipodocumento" class="form-control">
                                <?php
                                    foreach (tipodocumento() as $documento) {
                                        echo '<option value="' . $documento->codigo . '">' . $documento->documento . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="numerodocumento" class="form-label">Numero de Documento</label>
                            <input name="numerodocumento" id="numerodocumento" placeholder="Numero de documento"
                                type="text" class="form-control" required maxlength="11">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="nombrecliente" class="form-label">Nombre cliente</label>
                            <input name="nombrecliente" id="nombrecliente" placeholder="Nombre del cliente" type="text"
                                class="form-control" required maxlength="300">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="direccioncliente" class="form-label">Direccion</label>
                            <input name="direccioncliente" id="direccioncliente" placeholder="Direccion" type="text"
                                    class="form-control" maxlength="200">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefonocliente" class="form-label">Telefono</label>
                            <input name="telefonocliente" id="telefonocliente" placeholder="ejem. 999 999 999"
                                    type="text" class="form-control" maxlength="9">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="statuscliente" class="form-label">Estado</label>
                            <select name="statuscliente" id="statuscliente" class="form-control">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnActionForm" class="btn btn-primary text-white" type="submit"><i
                            class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i
                            class="fa fa-times-circle"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalViewCliente" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary" style="color: #fff;">
                <h5 class="modal-title text-white" id="titleModal">Informacion del cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalView();">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Tipo documento</span>
                    </div>
                    <div class="user_info" id="tipodocumentotb"></div>
                </div>
                <div class="single_user_pil d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Numero documento</span>
                    </div>
                    <div class="user_info" id="numerodocumentotb"></div>
                </div>
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Nombre cliente</span>
                    </div>
                    <div class="user_info" id="nombreclientetb"></div>
                </div>
                <div class="single_user_pil d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Direccion</span>
                    </div>
                    <div class="user_info" id="direccionclientetb"></div>
                </div>
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Numero telefono</span>
                    </div>
                    <div class="user_info" id="telefonoclientetb"></div>
                </div>
                <div class="single_user_pil d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Estado</span>
                    </div>
                    <div class="user_info" id="statusclientetb"></div>
                </div>
            </div>
        </div>
    </div>
</div>