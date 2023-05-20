<div class="modal fade" id="modalFormProducto" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Nuevo Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="formProductos" name="formProductos">
                    <input type="hidden" id="idProducto" name="idProducto" value="">
                    <input type="hidden" name="foto_actual" id="foto_actual" value="">
                    <input type="hidden" name="foto_remove" id="foto_remove" value="0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="nombre" class="">Producto</label>
                                <input name="txtNombre" id="txtNombre" placeholder="Nombre del Producto" type="text"
                                    class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="position-relative form-group">
                                        <label class="listCategoria">Categoria</label>
                                            <select class="form-control" data-live-search="true" name="listCategoria" id="listCategoria"></select>
                                    </div>
                                </div>
                                <div class="mt-4 col-md-2">
                                    <a href="<?= base_url()?>/Categorias" class="mt-2 btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">Precio Compra</label>
                                        <input type="number" name="precio_compra" min="1"  step="0.01" id="precio_compra"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">Precio Venta</label>
                                        <input type="number" name="precio_venta" min="1"  step="0.01" id="precio_venta"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">Cantidad</label>
                                        <input type="number" name="txtStock" type="number" value="1" min="1" id="txtStock"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">Estado</label>
                                        <select name="listStatus" id="listStatus" class="form-control">
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="codigo" class="">Codigo</label>
                                <input name="txtCodigo" id="txtCodigo" placeholder="Codigo del Productos" type="text"
                                    class="form-control">
                            </div>
                            <div id="boxproveedor" class="row">
                                <div class="col-md-10">
                                    <div class="position-relative form-group">
                                        <label class="listCategoria">Proveedor</label>
                                            <select class="form-control" data-live-search="true" name="listProveedor" id="listProveedor"></select>
                                    </div>
                                </div>
                                <div class="mt-4 col-md-2">
                                    <a href="<?= base_url()?>/Proveedores" class="mt-2 btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="position-relative form-group">
                                <div class="photo">
                                    <label for="foto">Foto (570x380)</label>
                                    <div class="prevPhoto">
                                        <span class="delPhoto notBlock">X</span>
                                        <label for="foto"></label>
                                        <div>
                                            <img id="img" src="<?= media(); ?>/images/uploads/portada_categoria.png">
                                        </div>
                                    </div>
                                    <div class="upimg">
                                        <input type="file" name="foto" id="foto">
                                    </div>
                                    <div id="form_alert"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="exampleText" class="">Descripcion</label>
                                <textarea name="txtDescripcion" id="txtDescripcion" placeholder="Descripcion del producto" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
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

<!-- Modal -->
<div class="modal fade" id="modalViewProducto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="titleModal">Datos del Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <td>Producto:</td>
                                    <td id="Producto"></td>
                                </tr>
                                <tr>
                                    <td>Categoria:</td>
                                    <td id="Categoria"></td>
                                </tr>
                                <tr>
                                    <td>Precio de Compra:</td>
                                    <td id="precioCompra"></td>
                                </tr>
                                <tr>
                                    <td>Precio de venta:</td>
                                    <td id="precioVenta"></td>
                                </tr>
                                <tr>
                                    <td>Cantidad:</td>
                                    <td id="Cantidad"></td>
                                </tr>
                                <tr>
                                    <td>Descripcion:</td>
                                    <td id="descripcion"></td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td id="Estado"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center info-box-content">
                            <label for="">codigo</label>
                            <div id="printCode">
                                <svg id="barcode"></svg>
                            </div>
                            <button class="btn btn-success btn-sm" type="button"
                                onClick="fntPrintBarcode('#printCode')"><i class="fas fa-print"></i>Imprimir</button>
                        </div>
                        <div class="col-md-12">
                            <div id="Foto"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>