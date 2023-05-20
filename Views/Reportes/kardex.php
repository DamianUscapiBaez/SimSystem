<?php 
  headerAdmin($data); 
  getModal('modalKardex',$data);
?>
  <div class="container-fluid">
    <div id="contentAjax"></div>
    <div class="row mt-1">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="table_kardex" style="width:100%">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>FECHA</th>
                    <th>PRODUCTO</th>
                    <th>IVENTARIO INICIAL</th>
                    <th>ENTRADAS</th>
                    <th>SALIDAS</th>
                    <th>EXISTENCIAS</th>
                    <th>DETALLE</th>
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
