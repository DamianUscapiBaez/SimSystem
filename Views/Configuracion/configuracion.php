<?php headerAdmin($data); ?>
<div class="container-fluid mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h4 class="card-title"><i class="fa fa-address-card me-2"></i> Datos de la Empresa</h4>
          <form id="formEmpresa" name="formEmpresa">
            <div class="row">
              <div class="col-md-6 mb-4">
                <div class="form-group">
                  <label for="txtRuc">RUC</label>
                  <input type="text" class="form-control mt-2" id="txtRuc" name="txtRuc" placeholder="RUC"
                    maxlength="11" value="<?= $_SESSION['dataCompany']['documentnumber']; ?>">
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="form-group">
                  <label for="txtNombre">Nombre o Razón Social</label>
                  <input type="text" class="form-control mt-2" id="txtNombre" name="txtNombre"
                    placeholder="Nombre de la Empresa" maxlength="100"
                    value="<?= $_SESSION['dataCompany']['namecompany']; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mb-4">
                <div class="form-group">
                  <label for="txtDireccion">Dirección</label>
                  <input type="text" class="form-control mt-2" id="txtDireccion" name="txtDireccion"
                    placeholder="Dirección de la Empresa" maxlength="200"
                    value="<?= $_SESSION['dataCompany']['addressofcompany']; ?>">
                </div>
              </div>
            </div>
            <h4 class="card-title mt-2"><i class="fa fa-phone me-2"></i> Información de Contacto</h4>
            <div class="row">
              <div class="col-md-6 mb-4">
                <div class="form-group">
                  <label for="txtTelefono">Teléfono</label>
                  <input type="text" class="form-control mt-2" id="txtTelefono" name="txtTelefono"
                    placeholder="Teléfono" maxlength="9" value="<?= $_SESSION['dataCompany']['phonenumber']; ?>">
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="form-group">
                  <label for="txtEmail">Email</label>
                  <input type="email" class="form-control mt-2" id="txtEmail" name="txtEmail" placeholder="Email"
                    maxlength="200" value="<?= $_SESSION['dataCompany']['emailcompany']; ?>">
                </div>
              </div>
            </div>
            <div class="mt-5 text-center">
              <button id="btnActionForm" class="btn btn-success" type="submit">
                <i class="fa fa-check-circle me-2"></i><span id="btnText">Actualizar</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php footerAdmin($data); ?>