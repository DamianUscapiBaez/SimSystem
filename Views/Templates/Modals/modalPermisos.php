<div class="modal fade modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title h4" >Permisos Roles de Usuario</h5>
            <button id="btnclose" type="button" class="close" data-dismiss="modal" onclick="closeModalPermisos();" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <?php 
                //dep($data);
             ?>
            <div class="col-md-12">
              <div class="tile">
                <form action="" id="formPermisos" name="formPermisos">
                  <input type="hidden" id="idrol" name="idrol" value="<?= $data['idrol']; ?>" required="">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Módulo</th>
                            <th>Permiso</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no=1;
                                $modulos = $data['modulos'];
                                for ($i=0; $i < count($modulos); $i++) { 

                                    $permisos = $modulos[$i]['permisos'];
                                    $rCheck = $permisos['status'] == 1 ? " checked " : "";

                                    $idmod = $modulos[$i]['idmodulo'];
                            ?>
                          <tr>
                            <td>
                                <?= $no; ?>
                                <input type="hidden" name="modulos[<?= $i; ?>][idmodulo]" value="<?= $idmod ?>" required >
                            </td>
                            <td>
                                <?= $modulos[$i]['titulo']; ?>
                            </td>
                            <td>
                                <input type="checkbox" name="modulos[<?= $i; ?>][status]" <?= $rCheck ?> >
                            </td>
                          </tr>
                          <?php 
                                $no++;
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i> Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModalPermisos();"><i class="fa fa-times-circle"></i> Cancelar</button>
                    </div>
                </form>
              </div>
            </div>
        </div>

    </div>
  </div>
</div>