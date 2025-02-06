<?php
headerAdmin($data);
getModal('modalMovimientos', $data);
?>
<div class="container-fluid">
  <div class="row mt-3">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <h4>Datos de salida</h4>
          <form id="frmSalida">
            <div class="row">
              <div class="col-md-9">
                <input type="hidden" id="idproducto" name="idproducto" value="">
                <div class="position-relative form-group">
                  <label for="codigo"><i class="fa fa-barcode"></i> Codigo de barras</label>
                  <input type="text" onkeyup="buscarCodigo(event)" class="form-control" id="codigo" name="codigo">
                </div>
              </div>
              <div class="col-md-3">
                <label>buscar</label>
                <div class="d-flex justify-content-between">
                  <button id="btn_search" style="width:60px"  onclick="openCodigo()" class="mt-1 btn btn-warning text-white" type="button"><i
                    class="fa fa-search"></i></button>
                    <button id="btn_camare" style="width:60px"  onclick="fntCamare()" class="mt-1 btn btn-info" type="button"><i
                    class="fa fa-camera"></i></button>
                  </button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="position-relative form-group">
                  <label for="producto">Producto</label>
                  <input type="text" class="form-control" id="producto" name="producto" disabled>
                </div>
              </div>
              <div class="col-md-3">
                <div class="position-relative form-group">
                  <label for="cantidad">Cantidad</label>
                  <input type="number" onkeyup="agregar_producto_detalle(event)" min="1" pattern="[0-9]+"
                    class="form-control" id="cantidad" name="cantidad" placeholder="0">
                </div>
              </div>
              <div class="col-md-3">
                <div class="position-relative form-group">
                  <label for="cantidad">Precio</label>
                  <input type="text" class="form-control" id="precio_venta" value="0" name="precio_compra" disabled>
                </div>
              </div>
            </div>
          </form>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="table_tmp_salida" class="table row-border table-sm" style="width:100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>producto</th>
                      <th>Cantidad</th>
                      <th>Precio</th>
                      <th>Subtotal</th>
                      <th></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card">
        <div class="card-body">
          <div class="position-relative form-group">
            <label for="">Total a pagar</label>
            <input type="text" class="form-control" value="0" id="total" disabled>
          </div>
          <h6>Datos del cliente</h6>
          <div class="row">
            <div class="col-md-12">
              <div class="position-relative form-group">
                <label for="exampleText" class="">Documento</label>
                <div class="d-flex ">
                  <input onkeyup="buscar_cliente(event)" name="txtDocumento" id="txtDocumentoS"
                    placeholder="Ejem.10098398343" type="text" class="form-control" required>
                  <button style="width:40px" onclick="openBuscarCliente()" class="btn btn-warning text-white ml-1 mr-1">
                    <i class="fas fa-search"></i>
                  </button>
                  <button style="width:40px" onclick="openNewCliente()" class="btn btn-success ml-1 mr-1">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="position-relative form-group">
                <label for="exampleText" class="">Nombres</label>
                <input name="txtNombre" id="txtNombreS" placeholder="Ejem. System Tecnology" type="text"
                  class="form-control" disabled>
              </div>
            </div>
            <div class="col-md-12">
              <div class="position-relative form-group">
                <label for="exampleText" class="">Direccion</label>
                <input name="txtDireccion" id="txtDireccionS" placeholder="Ejem. Calle peral N° 897" type="text"
                  class="form-control" disabled>
              </div>
            </div>
            <div class="col-md-12">
              <form id="frmSalidaProducto">
                <input type="hidden" id="idclienteS" name="idcliente" value="">
                <input type="hidden" id="tipo_documento" name="tipo_documento" value="">
                <button type="submit" class="mt-1 btn btn-block btn-success">Generar salida</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php footerAdmin($data); ?>