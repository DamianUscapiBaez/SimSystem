<?php 
  headerAdmin($data); 
?>
  <div class="container-fluid">
    <div id="contentAjax"></div>
    <div class="row mt-1">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between"> 
              <h5>Salidas</h5>
                <a class="btn btn-new" href="<?= base_url()?>/Salidas">
                  <i class="fas fa-plus"></i> nuevo
                </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="tableSalidas" class="table m-0" style="width:100%">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>VENDEDOR</th>
                    <th>CLIENTE</th>
                    <th>TOTAL</th>
                    <th>ESTADO</th>
                    <th>FECHA SALIDA</th>
                    <th>ACCIONES</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php footerAdmin($data); ?>