<?php
  headerAdmin($data);
  getModal('modalMovimientos', $data);
  getModal('modalProveedores', $data);
?>
<div class="main_content_iner overly_inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
        <div class="page_title_left d-flex align-items-center">
          <h3 class="f_s_25 f_w_700 dark_text mr_30">Nueva Entrada</h3>
          <ol class="breadcrumb page_bradcam mb-0">
            <li class="breadcrumb-item"><a href="<?=base_url()?>/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url()?>/entradas/listadoentradas">Entradas</a></li>
            <li class="breadcrumb-item active">Nueva Entrada</li>
          </ol>
        </div>
        <div class="page_title_right">
          <div class="page_date_button d-flex align-items-center">
            <img src="<?=medias()?>/plantilla/img/icon/calender_icon.svg">
            <?=obtenerFecha();?>
            <div id="hora" style="margin-left:2px"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="card_box box_shadow position-relative mb_30">
        <div class="box_body">
          <h4>Datos de entrada</h4>
          <div class="row mb-3">
            <div class="col-md-8 mb-3 align-self-end">
              <label for="codigo" class="form-label"><i class="fa fa-barcode"></i> Código de barras</label>
              <input type="text" onkeyup="buscarCodigo(event)" class="form-control" id="codigo" name="codigo"
                  placeholder="Ingrese el código de barras">
            </div>
            <div class="col-md-2 mb-3 align-self-end">
              <label>&nbsp;</label>
              <div class="d-flex justify-content-end">
                <button id="btn_search" onclick="openCodigo()" class="btn btn-warning text-white w-100" type="button">
                  <i class="fa fa-search"></i> Buscar
                </button>
              </div>
            </div>
            <div class="col-md-2 mb-3 align-self-end">
              <label>&nbsp;</label>
              <div class="d-flex justify-content-end">
                <button id="btn_camare" onclick="fntCamare()" class="btn btn-primary text-white w-100" type="button">
                  <i class="fa fa-camera"></i> Escanear
                </button>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <input name="idproducto" id="idproducto" type="hidden">
            <div class="col-md-8 mb-3">
              <div class="position-relative form-group">
                <label for="producto" class="form-label">Producto</label>
                <input type="text" class="form-control" id="producto" name="producto" disabled>
              </div>
            </div>
            <div class="col-md-2 mb-3">
              <div class="position-relative form-group">
                <label for="cantidad" class="form-label">Precio</label>
                <input type="text" class="form-control" id="preciounitario" min="1" step="0.1" name="preciounitario">
              </div>
            </div>
            <div class="col-md-2 mb-3">
              <div class="position-relative form-group">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" min="1" onkeyup="agregarProducto(event)" pattern="[0-9]+" class="form-control"
                  id="cantidad" name="cantidad" placeholder="0">
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <h4>Detalle Producto</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="tableProductos" class="table table-striped table-hover">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Precio</th>
                      <th>Subtotal</th>
                      <th>Opciones</th>
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
    <div class="col-md-4">
      <div class="card_box position-relative mb_30 white_bg">
        <form id="frmEntrada">
          <input type="hidden" name="idproveedorentrada" id="idproveedorentrada">
          <div class="white_box_tittle blue_bg">
            <div class="main-title2 text-center">
              <input type="hidden" id="totalentrada" />
              <h3 class="mb-2 nowrap text_white">Total S/. <span id="total"></span></h3>
            </div>
          </div>
          <div class="box_body">
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="fechaemision" class="form-label">Fecha emision</label>
                <input name="fechaemision" id="fechaemision" type="date" class="form-control" maxlength="9">
              </div>
              <!-- <div class="col-md-6 mb-3">
                <div class="position-relative form-group">
                  <label for="tipoentrada" class="form-label">Tipo de entrada</label>
                  <select name="tipoentrada" id="tipoentrada" class="form-control">
                    <?php
                      foreach (tipoentrada() as $entrada) {
                        echo '<option value="' . $entrada->codigo . '">' . $entrada->entrada . '</option>';
                      }
                    ?>
                  </select>
                </div>
              </div> -->
            </div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="position-relative form-group">
                  <label for="tipodocumento" class="form-label">Tipo documento</label>
                  <select name="tipodocumento" id="tipodocumento" class="form-control">
                    <?php
                      foreach (tipodocumentoentrada() as $documentoentrada) {
                        echo '<option value="' . $documentoentrada->codigo . '">' . $documentoentrada->documento . '</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <label for="numerodocumento" class="form-label">N° de documento</label>
                <input name="numerodocumento" id="numerodocumento" placeholder="ejem. 999 999 999" type="text"
                  class="form-control" maxlength="9">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="numeroproveedor" class="form-label">N° documento proveedor</label>
                <div class="input-group">
                  <input name="numeroproveedor" id="numeroproveedor" placeholder="ejem. 999 999 999" type="text" class="form-control" maxlength="9" onkeyup="buscarProveedorInput(event)">
                  <button class="btn btn-block btn-primary" type="button" onclick="openBuscarProveedor()">                  
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <label for="nombreproveedorentrada" class="form-label">Nombre proveedor</label>
                <div class="input-group">
                  <input name="nombreproveedorentrada" id="nombreproveedorentrada" type="text" class="form-control" disabled>
                  <button class="btn btn-block btn-warning text-white" type="button" title="Agregar Proveedor" onclick="openProveedorNuevo()">                  
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label class="form-label" for="detalle">Motivo</label>
                <textarea name="detalle" id="detalle" placeholder="Ingrese el motivo de entrada"
                  class="form-control" rows="2"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button class="btn blue_bg text-white btn-lg btn-block" style="width: 100%;" type="submit">Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php footerAdmin($data);?>