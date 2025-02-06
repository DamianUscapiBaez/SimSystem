<div class="modal fade" id="modalFormProducto" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header md-header bg-primary" style="color: #fff;">
                <h5 class="modal-title text-white" id="titleModal">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formProductos" name="formProductos">
                <div class="modal-body">
                    <input type="hidden" id="idproducto" name="idproducto" value="">
                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="nombreproducto" class="form-label">Nombre del producto</label>
                                    <input name="nombreproducto" id="nombreproducto" placeholder="Nombre del Producto"
                                        type="text" class="form-control" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="codigoproducto" class="form-label">Codigo del producto</label>
                                    <input name="codigoproducto" id="codigoproducto" placeholder="Codigo del Producto"
                                        type="text" class="form-control" required>
                                </div>
                                <!-- <div class="col-md-5 mb-3">
                                    <label for="tipounidad" class="form-label">Tipo de unidad</label>
                                    <select name="tipounidad" id="tipounidad" class="form-control">
                                        <?php
                                            foreach (tipounidad() as $unidad) {
                                                echo '<option value="' . $unidad->codigo . '">' . $unidad->unidad . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div> -->
                                <div class="col-md-10 mb-3">
                                    <label class="">Categoria</label>
                                    <select class="form-control" data-live-search="true" name="categoriaid"
                                        id="categoriaid"></select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <button type="button" class="icon-button successbtn" title="Agregar Categoria">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="preciounitario" class="form-label">Precio unitario</label>
                                    <input name="preciounitario" id="preciounitario" type="number" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cantidadminima" class="form-label">Cantidad minima</label>
                                    <input name="cantidadminima" id="cantidadminima" type="number" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="statusproducto" class="form-label">Estado</label>
                                    <select name="statusproducto" id="statusproducto" class="form-control">
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="foto_actual" id="foto_actual" value="">
                                    <input type="hidden" name="foto_remove" id="foto_remove" value="0">
                                    <div class="photo">
                                        <label for="foto">Foto (570x380)</label>
                                        <div class="prevPhoto" style="height:285px">
                                            <span class="delPhoto notBlock">X</span>
                                            <label for="foto"></label>
                                            <div>
                                                <img id="img" src="<?=media();?>/images/uploads/box.png"
                                                    alt="Vista previa de la foto">
                                            </div>
                                        </div>
                                        <div class="upimg">
                                            <input type="file" name="foto" id="foto">
                                        </div>
                                        <div id="form_alert"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button id="btnActionForm" class="btn btn-primary text-white" type="submit"><i
                            class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i
                            class="fa fa-times-circle"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewProducto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary" style="color: #fff;">
                <h5 class="modal-title text-white">Informacion de Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalView()">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                            <div class="user_pils_thumb d-flex align-items-center">
                                <span class="f_s_14 f_w_400 text_color_11">Nombre producto</span>
                            </div>
                            <div class="user_info" id="nombreproductotb"></div>
                        </div>
                        <div class="single_user_pil d-flex align-items-center justify-content-between">
                            <div class="user_pils_thumb d-flex align-items-center">
                                <span class="f_s_14 f_w_400 text_color_11">Categoria</span>
                            </div>
                            <div class="user_info" id="categoriatb"></div>
                        </div>
                        <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                            <div class="user_pils_thumb d-flex align-items-center">
                                <span class="f_s_14 f_w_400 text_color_11">Tipo documento</span>
                            </div>
                            <div class="user_info" id="tipounidadtb"></div>
                        </div>
                        <div class="single_user_pil d-flex align-items-center justify-content-between">
                            <div class="user_pils_thumb d-flex align-items-center">
                                <span class="f_s_14 f_w_400 text_color_11">Precio unitario</span>
                            </div>
                            <div class="user_info" id="preciounitariotb"></div>
                        </div>
                        <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                            <div class="user_pils_thumb d-flex align-items-center">
                                <span class="f_s_14 f_w_400 text_color_11">Cantidad</span>
                            </div>
                            <div class="user_info" id="cantidadproductotb"></div>
                        </div>
                        <div class="single_user_pil d-flex align-items-center justify-content-between">
                            <div class="user_pils_thumb d-flex align-items-center">
                                <span class="f_s_14 f_w_400 text_color_11">Cantidad minima</span>
                            </div>
                            <div class="user_info" id="cantidadminimatb"></div>
                        </div>
                        <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                            <div class="user_pils_thumb d-flex align-items-center">
                                <span class="f_s_14 f_w_400 text_color_11">Estado</span>
                            </div>
                            <div class="user_info" id="statusproductotb"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="row">
                            <div class="text-center info-box-content">
                                <label for="">codigo</label>
                                <div id="printCode">
                                    <svg id="barcode"></svg>
                                </div>
                                <button class="btn btn-success btn-sm" type="button"
                                    onClick="fntPrintBarcode('#printCode')"><i
                                        class="fas fa-print"></i> Imprimir</button>
                            </div>
                            <div class="col-md-12">
                                <div id="Foto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>