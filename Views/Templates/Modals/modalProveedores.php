<div class="modal fade" id="modalFormProveedor" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header md-header bg-primary" style="color: #fff;">
                <h5 class="modal-title text-white" id="titleModal">Nuevo Proveedor</h5>
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="closeModal();">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formProveedor" name="formProveedor">
                <div class="modal-body">
                    <input type="hidden" id="idproveedor" name="idproveedor" value="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="exampleInputEmail1">Tipo Documento</label>
                            <select name="tipodocumento" id="tipodocumento" class="form-control">
                                <?php
                                    foreach (tipodocumento() as $documento) {
                                        echo '<option value="' . $documento->codigo . '">' . $documento->documento . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="numerodocumento">Numero de Documento</label>
                            <input type="text" class="form-control" id="numerodocumento" name="numerodocumento"
                                placeholder="Ejem. 10098398343" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="nombreproveedor">Razon Social</label>
                            <input type="text" class="form-control" id="nombreproveedor" name="nombreproveedor"
                                placeholder="Ejem. 10098398343" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="correoproveedor">Direccion de Correo Electrónico</label>
                            <input type="text" class="form-control" id="correoproveedor" name="correoproveedor"
                                placeholder="Ejem. 10098398343">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="telefonoproveedor">Numero Telefonico</label>
                            <input type="text" class="form-control" id="telefonoproveedor" name="telefonoproveedor"
                                placeholder="Ejem. 10098398343">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="statusproveedor">Estado</label>
                            <select name="statusproveedor" id="statusproveedor" class="form-control">
                                <option value="1">ACTIVO</option>
                                <option value="2">INACTIVO</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="direccionproveedor">Direccion</label>
                            <input type="text" class="form-control" id="direccionproveedor" name="direccionproveedor"
                                placeholder="Ejem. 10098398343">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnActionForm" class="btn btn-primary text-white" type="submit">
                        <i class="fa fa-check-circle"></i><span id="btnText">Guardar</span>
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalViewProveedor" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info" style="color: #fff;">
                <h5 class="modal-title text-white">Informacion de proveedor</h5>
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
                        <span class="f_s_14 f_w_400 text_color_11">Nombre proveedor</span>
                    </div>
                    <div class="user_info" id="nombreproveedortb"></div>
                </div>
                <div class="single_user_pil d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Correo electronico</span>
                    </div>
                    <div class="user_info" id="correoproveedortb"></div>
                </div>
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Numero telefono</span>
                    </div>
                    <div class="user_info" id="telefonoproveedortb"></div>
                </div>
                <div class="single_user_pil d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Direccion</span>
                    </div>
                    <div class="user_info" id="direccionproveedortb"></div>
                </div>
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Estado</span>
                    </div>
                    <div class="user_info" id="statusproveedortb"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="imgCategoria"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>