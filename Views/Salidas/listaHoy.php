<?php 
  headerAdmin($data); 
?>
<div class="page-wrapper">
  <div id="contentAjax"></div>
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">
          <?=$data['page_title'];?>
        </h3>
        <div class="d-flex align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 p-0">
              <li class="breadcrumb-item"><a href="<?= base_url()?>/Dashboard" class="text-muted">Inicio</a></li>
              <li class="breadcrumb-item text-muted active" aria-current="page">
                <?=$data['page_tag'];?>
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
              data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Facturas <span class="badge badge-secondary">
                <?= $data['facturas']['total']?>
              </span>
            </button>
          </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <div class="table-responsive table-hover">
              <table id="tableSalidas" class="table m-0" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Comprobante</th>
                    <th>Serie</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha de salida</th>
                    <th>Hora de salida</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
              data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Facturas Anuladas <span class="badge badge-secondary">
                <?= $data['facturasA']['total']?>
              </span>
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <div class="table-responsive table-hover">
              <table id="tableSalidasAnulados" class="table table-hover table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Comprobante</th>
                    <th>Serie</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha de salida</th>
                    <th>Hora de salida</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
              data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Boletas <span class="badge badge-secondary">
                <?= $data['boletas']['total']?>
              </span>
            </button>
          </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
          <div class="card-body">
            <div class="table-responsive table-hover">
              <table id="tableBoletas" class="table table-hover table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Comprobante</th>
                    <th>Serie</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha de salida</th>
                    <th>Hora de salida</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingC">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
              data-target="#collapseC" aria-expanded="false" aria-controls="collapseC">
              Boletas Anuladas <span class="badge badge-secondary">
                <?= $data['boletasA']['total']?>
              </span>
            </button>
          </h2>
        </div>
        <div id="collapseC" class="collapse" aria-labelledby="headingC" data-parent="#accordionExample">
          <div class="card-body">
            <div class="table-responsive table-hover">
              <table id="tableBoletasAnulados" class="table table-hover table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Comprobante</th>
                    <th>Serie</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha de salida</th>
                    <th>Hora de salida</th>
                    <th>Acciones</th>
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
</div>
<?php footerAdmin($data); ?>