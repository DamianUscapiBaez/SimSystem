<div class="modal fade" id="modalFormCategoria" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header md-header bg-primary" style="color: #fff;">
                <h5 class="modal-title text-white" id="titleModal">Nueva Categoria</h5>
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="closeModal();">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <form id="formCategoria" name="formCategoria">
                <div class="modal-body">
                    <input type="hidden" id="idcategoria" name="idcategoria" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="nombrecategoria" class="form-label">Nombre de la Categoría</label>
                                    <input name="nombrecategoria" id="nombrecategoria" placeholder="Ingrese el nombre"
                                        type="text" class="form-control" required maxlength="100">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="statuscategoria" class="form-label">Estado</label>
                                    <select name="statuscategoria" id="statuscategoria" class="form-control">
                                        <option value="1">ACTIVO</option>
                                        <option value="2">INACTIVO</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="descripcioncategoria">Descripción</label>
                                    <textarea name="descripcioncategoria" id="descripcioncategoria"
                                        placeholder="Ingrese la descripción de la categoría" class="form-control"
                                        rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnActionForm" class="btn btn-primary text-white" type="submit"><i
                            class="fa fa-check-circle"></i><span id="btnText"> Guardar</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i
                            class="fa fa-times-circle"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalViewCategoria" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info" style="color: #fff;">
                <h5 class="modal-title text-white" id="titleModal">Informacion de categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalView();">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Nombre de categoria</span>
                    </div>
                    <div class="user_info" id="nombrecategoriatb"></div>
                </div>
                <div class="single_user_pil d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Descripcion</span>
                    </div>
                    <div class="user_info" id="descripcioncategoriatb"></div>
                </div>
                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                    <div class="user_pils_thumb d-flex align-items-center">
                        <span class="f_s_14 f_w_400 text_color_11">Estado</span>
                    </div>
                    <div class="user_info">
                        <div id="statuscategoriatb"></div>
                    </div>
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