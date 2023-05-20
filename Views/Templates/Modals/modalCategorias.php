<div class="modal fade" id="modalFormCategoria" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Nueva Categoria</h5>
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="formCategoria" name="formCategoria">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="nombre" class="">Nombre</label>
                                <input name="txtNombre" id="txtNombre" placeholder="Nombre de la Categoria" type="text" class="form-control" required>
                                <div class="valid-feedback">Correcto!</div>
                                <div class="invalid-feedback">Nombre incorrecto</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="idCategoria" name="idCategoria" value="">
                            <input type="hidden" name="foto_actual" id="foto_actual" value="">
                            <input type="hidden" name="foto_remove" id="foto_remove" value="0">
                            <div class="position-relative form-group">
                                <label for="exampleText" class="">Descripcion</label>
                                <textarea name="txtDescripcion" id="txtDescripcion" placeholder="Descripcion de la categoria" class="form-control" rows="5" required></textarea>
                                <div class="valid-feedback">Correcto!</div>
                                <div class="invalid-feedback"> Agregar descripcion</div>
                            </div>
                            <div class="position-relative form-group">
                                <label for="exampleSelect" class="">Estado</label>
                                <select name="listStatus" id="listStatus" class="form-control selectpicker">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                    <div class="mt-4 title-footer text-center">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i class="fa fa-times-circle"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalViewCategoria" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Datos de categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalView();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table m-0" style="width:100%">
                        <tbody>
                            <tr>
                                <td>Nombre de categoria:</td>
                                <td id="celNombre"></td>
                            </tr>
                            <tr>
                                <td>Descripcion:</td>
                                <td id="celDescripcion"></td>
                            </tr>
                            <tr>
                                <td>Estado:</td>
                                <td id="celEstado"></td>
                            </tr>
                        </tbody>
                    </table>
                   
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="imgCategoria"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalView();" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>