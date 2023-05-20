<?php headerAdmin($data); ?>
  <div class="container-fluid">
    <div class="row mt-5">
      <div class="col-md-10 offset-md-1">
        <div class="card border-0">
          <div class="card-body">
            <form action="" id="formEmpresa" name="formEmpresa">
              <h4><i class="fa fa-address-card"></i> Datos de empresa</h4>
              <div class="row">
                <div class="col-md-6 mt-2">
                  <div class="position-relative form-group">
                    <label for="nombre" class="">RUC</label>
                    <input value="<?= $_SESSION['dataConfig']['ruc'];?>" name="txtRuc" id="txtRuc" placeholder="Ruc" type="text"
                      class="form-control mt-2">
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <div class="position-relative form-group">
                    <label for="nombre" class="">NOMBRE O RAZON SOCIAL</label>
                    <input value="<?= $_SESSION['dataConfig']['nombre'];?>" name="txtNombre" id="txtNombre"
                      placeholder="Nombre de la empresa" type="text" class="form-control mt-2">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="position-relative form-group">
                    <label for="nombre" class="">DIRECCION</label>
                    <input value="<?= $_SESSION['dataConfig']['direccion'];?>" name="txtDireccion" id="txtDireccion"
                      placeholder="Dirección de la empresa" type="text" class="form-control mt-2">
                  </div>
                </div>
              </div>
              <h4><i class="fa fa-phone"></i> Informacion de contacto</h4>
              <div class="row">
                <div class="col-md-6 mt-2">
                  <div class="position-relative form-group">
                    <label for="nombre" class="">Telefono</label>
                    <input value="<?= $_SESSION['dataConfig']['telefono']?>" name="txtTelefono" id="txtTelefono"
                      placeholder="Telefono" type="text" class="form-control mt-2">
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <div class="position-relative form-group">
                    <label for="nombre" class="">EMAIL</label>
                    <input value="<?= $_SESSION['dataConfig']['correo']?>" name="txtEmail" id="txtEmail" placeholder="Email"
                      type="email" class="form-control mt-2">
                  </div>
                </div>
              </div>
              <div class="mt-4 text-center">
                <button id="btnActionForm" class="btn btn-success" type="submit"><i
                    class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">ACTUALIZAR</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php footerAdmin($data); ?>