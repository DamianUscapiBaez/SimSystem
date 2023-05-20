<?php 
  headerAdmin($data); 
  getModal('modalProveedores',$data);
?>
  <div class="container-fluid">
    <div id="contentAjax"></div>
    <div class="row mt-1">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between"> 
              <h5>PROVEEDORES</h5>
              <button class="btn btn-new" onclick="openModal();" type="button">
                <i class="fas fa-plus"></i> NUEVO
              </button>
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
              <table class="table m-0" id="tableProveedores" style="width:100%">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>RUC</th>
                    <th>NOMBRE DE PROVEEDOR</th>
                    <th>DIRECCION</th>
                    <th>TELEFONO</th>
                    <th>ESTADO</th>
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