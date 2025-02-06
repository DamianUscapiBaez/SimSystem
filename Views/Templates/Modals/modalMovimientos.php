<div class="modal fade" id="modalCamare" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Buscar producto</h5>
        <button id="btnclose" type="button" onclick="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div id="camera"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <div class="modal fade" id="modalCamare" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Buscar producto</h5>
        <button type="button" onclick="cloaseModalCam()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div id="camera"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
<!-- buscar producto -->
<div class="modal fade" id="modalProducto" tabindex="-1" role="dialog" aria-hidden="true">  
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title text-white" id="titleModal">Buscar producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalproducto();">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="buscar_producto">
          <p class="mb-3">Ingresar código o nombre del producto</p>
          <div class="form-group">
            <div class="row">
              <div class="col-md-10">
                <input name="search_producto" id="search_producto" type="text" class="form-control" placeholder="Buscar producto...">
              </div>
              <div class="col-md-2">
                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i> Buscar</button>
              </div>
            </div>
          </div>
        </form>
        <div class="col-md-12 mt-3">
          <div class="table-responsive QA_table mb_30">
            <table class="table table-responsive lms_table_active">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Código</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Opciones</th>
                </tr>
              </thead>
              <tbody id="table_producto">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- buscar proveedor -->
<div class="modal fade" id="modalBuscarProveedor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Buscar proveedor</h5>
        <button type="button" onclick="closeModalSearchProveedor()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="buscar_proveedor">
          <p>Ingresar RUC o nombre del proveedor</p>
          <div class="row">
            <div class="col-md-10 text-center">
              <input name="search_proveedor" id="search_proveedor" type="text" class="form-control">
            </div>
            <div class="col-md-2">
              <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i>buscar</button>
            </div>
          </div>
        </form>
        <div class="mt-3 row">
          <div class="col-md-12">
            <div class="table-responsive QA_table mb_30">
              <table class="table table-responsive lms_table_active">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tipo documento</th>
                    <th scope="col">N° documento</th>
                    <th scope="col">Razon social</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody id="bodyproveedor">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <div class="modal fade" id="modalBuscarCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Buscar cliente</h5>
        <button type="button" onclick="closeModalCliente()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="buscar_cliente">
          <p>Ingresar Ruc, Dni o nombre del cliente</p>
          <div class="row">
            <div class="col-md-12 text-center">
              <input name="search_cliente" id="search_cliente" type="text" class="form-control">
              <button class="mt-3 btn btn-primary" type="submit"><i class="fa fa-search"></i>buscar</button>
            </div>
          </div>
        </form>
        <div class="mt-2 row d-flex justify-content-center">
          <div class="col-md-12">
            <table class="table m-0" style="width: 100%;">
              <tbody id="table_cliente">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
<!-- modal de nuevo proveedor -->
<!-- <div class="modal fade" id="modalFormProveedor" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister" style="color: #fff;">
                <h5 class="modal-title" id="titleModal">Nuevo Proveedor</h5>
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form class="needs-validation" id="formProveedor" name="formProveedor">
                    <input type="hidden" id="idProveedor" name="idProveedor" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleText" class="">Ruc</label>
                                <input name="txtRuc" id="txtRuc" placeholder="Ejem. 10098398343" type="text"
                                    class="form-control" maxlength="11" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleText" class="">telefono</label>
                                <input name="txtTelefono" id="txtTelefono" placeholder="Ejem. 999 999 999" type="text"
                                    class="form-control" maxlength="9" required>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleText" class="">nombre</label>
                        <input name="txtNombre" id="txtNombre" placeholder="Ejem. System Tecnology" type="text"
                            class="form-control" required  maxlength="100">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="exampleText" class="">Direccion</label>
                                <input name="txtDireccion" id="txtDireccion" placeholder="Ejem. Calle peral N° 897" type="text"
                                    class="form-control" maxlength="200">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="position-relative form-group">
                                <label for="exampleText" class="">correo</label>
                                <input name="txtEmail" id="txtEmail" placeholder="Ejem. example@example.com" type="email"
                                    class="form-control" maxlength="200">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="exampleSelect" class="">Estado</label>
                                <select name="listStatus" id="listStatus" class="form-control selectpicker">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="title-footer text-center">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i
                                class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i
                                class="fa fa-times-circle"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->
<!-- modal de nuevo cliente -->
<!-- <div class="modal fade" id="modalNewCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Nuevo Cliente</h5>
        <button type="button" onclick="closeModalCliente()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="frmCliente" name="frmCliente">
          <div class="row">
            <div class="col-md-6">
              <input type="hidden" id="idcliente" name="idcliente" value="">
              <div class="position-relative form-group">
                <label for="nombre" class="">Tipo de documento</label>
                <select name="listDocumento" id="listDocumento" class="form-control selectpicker">
                  <option value="1">RUC</option>
                  <option value="2">DNI</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <input type="hidden" name="">
              <div class="position-relative form-group">
                <label for="exampleSelect" class="">Numero de Documento</label>
                <input name="txtDocumento" id="txtDocumento" placeholder="Numero de documento" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="position-relative form-group">
                <label for="nombre" class="">Nombres</label>
                <input name="txtNombre" id="txtNombre" placeholder="Nombre del cliente" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="position-relative form-group">
                <label for="nombre" class="">Direccion</label>
                <input name="txtDireccion" id="txtDireccion" placeholder="Direccion" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="position-relative form-group">
                <label for="exampleSelect" class="">Telefono</label>
                <input name="txtTelefono" id="txtTelefono" placeholder="ejem. 999 999 999" type="number" maxlength="" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="position-relative form-group">
                <label for="exampleSelect" class="">Estado</label>
                <select name="listStatus" id="listStatus" class="form-control selectpicker">
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
            </div>
          </div>

          <div class="title-footer text-center">
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i class="fa fa-times-circle"></i> Cancelar</button>
          </div>
        </form>
        <div class="mt-2 row d-flex justify-content-center">
          <div class="col-md-12">
            <table class="table m-0" style="width: 100%;">
              <tbody id="table_cliente">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
<!-- modal detalle entradas -->
<!-- <div class="modal fade" id="detalleEntradas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Nuevo Cliente</h5>
        <button type="button" onclick="closeModalCliente()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="frmCliente" name="frmCliente">
          <div class="row">
            <div class="col-md-6">
              <input type="hidden" id="idcliente" name="idcliente" value="">
              <div class="position-relative form-group">
                <label for="nombre" class="">Tipo de documento</label>
                <select name="listDocumento" id="listDocumento" class="form-control selectpicker">
                  <option value="1">RUC</option>
                  <option value="2">DNI</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <input type="hidden" name="">
              <div class="position-relative form-group">
                <label for="exampleSelect" class="">Numero de Documento</label>
                <input name="txtDocumento" id="txtDocumento" placeholder="Numero de documento" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="position-relative form-group">
                <label for="nombre" class="">Nombres</label>
                <input name="txtNombre" id="txtNombre" placeholder="Nombre del cliente" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="position-relative form-group">
                <label for="nombre" class="">Direccion</label>
                <input name="txtDireccion" id="txtDireccion" placeholder="Direccion" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="position-relative form-group">
                <label for="exampleSelect" class="">Telefono</label>
                <input name="txtTelefono" id="txtTelefono" placeholder="ejem. 999 999 999" type="number" maxlength="" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="position-relative form-group">
                <label for="exampleSelect" class="">Estado</label>
                <select name="listStatus" id="listStatus" class="form-control selectpicker">
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
            </div>
          </div>

          <div class="title-footer text-center">
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i><span id="btnText">Guardar</span></button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModal();"><i class="fa fa-times-circle"></i> Cancelar</button>
          </div>
        </form>
        <div class="mt-2 row d-flex justify-content-center">
          <div class="col-md-12">
            <table class="table m-0" style="width: 100%;">
              <tbody id="table_cliente">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
