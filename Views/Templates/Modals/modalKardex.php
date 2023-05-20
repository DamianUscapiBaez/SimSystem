<div class="modal fade" id="modalViewKardex" tabindex="-1" aria-labelledby="modalFormRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success" style="color: #fff;">
                <h5 class="modal-title" id="titleModal"></h5>
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-group">
                    <div class="card">
                        <div class="card-header">
                            <h4 id="text-card">ENTRADAS</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <p id="text-body-1"></p>
                                    <p id="text-body-5"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 id="text-card">SALIDAS</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <p id="text-body-2"></p>
                                    <p id="text-body-6"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 id="text-card">Existencias</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <p id="text-body-3"></p>
                                    <p id="text-body-4"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_kardex_producto" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Unidades</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>