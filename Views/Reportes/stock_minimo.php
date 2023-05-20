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
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Productos con stock minimo</h3>
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="table_stock_minimo" style="width:100%">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Producto</th>
                  <th>Cantidad</th>
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