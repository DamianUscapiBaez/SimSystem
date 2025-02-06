<div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title text-white">Permisos Roles de Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form action="" id="formPermisos" name="formPermisos">
                        <input type="hidden" id="idrol" name="idrol" value="<?= $data['idrole']; ?>" required>
                        <div class="QA_section">
                            <div class="QA_table mb_30">
                                <table class="table custom-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Módulo</th>
                                        <th>Permiso</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no = 1;
                                    $modulos = $data['modulos'];
                                    foreach ($modulos as $modulo) {
                                        $permisos = $modulo['permissions'];
                                        $rCheck = $permisos['statuspermissions'] == 1 ? "checked" : "";
                                        $idmod = $modulo['idmodule'];
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><span class="module-name"><?= $modulo['title']; ?></span></td>
                                            <td>

                                                <div class="checkbox_wrap d-flex align-items-center">
                                                    <label class="form-label lms_checkbox_1" for="course<?= $idmod; ?>">
                                                        <input type="checkbox" id="course<?= $idmod; ?>"
                                                               name="modulos[<?= $idmod; ?>][statuspermissions]" <?= $rCheck; ?>>
                                                        <div class="slider-check round"></div>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer mt-4">
                            <button class="btn btn-success" type="submit">Guardar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"
                                    onclick="closeModalPermisos();">Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
