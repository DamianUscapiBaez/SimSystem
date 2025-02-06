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
        <div class="card">
          <div class="card-body">
            <form id="frm_salidas" action="">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">fecha desde</label>
                    <input type="date" value="<?php echo date('Y-m-d')?>" class="form-control" name="date_from"
                      id="date_from">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">fecha hasta</label>
                    <input type="date" value="<?php echo date('Y-m-d')?>" class="form-control" name="date_to"
                      id="date_to">
                  </div>
                </div>
                <div class="mt-4 col-md-4 text-center">
                  <div class="form-group">
                    <button type="submit" class="mt-1 btn btn-danger"> <i class="fas fa-file-pdf"></i> generar
                      pdf</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php footerAdmin($data); ?>