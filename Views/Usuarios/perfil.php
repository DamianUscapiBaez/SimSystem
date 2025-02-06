<?php headerAdmin($data); ?>
<?php getModal('modalRoles', $data); ?>
<div class="container-fluid">
  <div class="row mt-2">
    <div class="col-md-4 col-lg-3">
      <div class="card custom-card">
        <div class="card-header p-0">
          <img class="img-fluid w-100 h20" style="height: 250px;" src="<?= media(); ?>/images/nature.jpg" alt="Fondo">
        </div>
        <div class="card-profile text-center mt-n5">
          <img class="rounded-circle border border-3 border-white" src="<?= media(); ?>/images/users/user.png"
            alt="Imagen de usuario" width="100">
        </div>
        <div class="text-center profile-details mt-2">
          <h4 class="mb-0"><?= $_SESSION['userData']['username']; ?></h4>
          <p class="text-muted"><?= $_SESSION['userData']['namerole']; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-lg-9">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs" id="userTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="user-data-tab" data-bs-toggle="tab" data-bs-target="#user-data"
                type="button" role="tab" aria-controls="user-data" aria-selected="true">Datos personales</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="user-edit-tab" data-bs-toggle="tab" data-bs-target="#user-edit" type="button"
                role="tab" aria-controls="user-edit" aria-selected="false">Actualizar datos de usuario</button>
            </li>
          </ul>
          <div class="tab-content" id="userTabsContent">
            <div class="tab-pane fade show active" id="user-data" role="tabpanel" aria-labelledby="user-data-tab">
              <div class="user-data mt-3">
                <h4>Datos personales</h4>
                <table class="table table-striped mt-3">
                  <tbody>
                    <tr>
                      <td><strong>Nombre de usuario:</strong></td>
                      <td><?= $_SESSION['userData']['username'] ?></td>
                    </tr>
                    <tr>
                      <td><strong>Nombre:</strong></td>
                      <td><?= $_SESSION['userData']['firstname'] ?></td>
                    </tr>
                    <tr>
                      <td><strong>Email:</strong></td>
                      <td><?= $_SESSION['userData']['emailuser'] ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="user-edit" role="tabpanel" aria-labelledby="user-edit-tab">
              <div class="tile useredit mt-3">
                <h4>Actualizar datos de usuario</h4>
                <form id="formPerfil" name="formPerfil" class="needs-validation mt-3 row" novalidate>
                  </p>
                  <div class="mb-3 col-md-6">
                    <label for="txtUsername" class="form-label">Username <span class="required">*</span></label>
                    <input type="text" class="form-control" id="txtUsername" name="txtUsername"
                      value="<?= $_SESSION['userData']['username']; ?>" required maxlength="100">
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="txtNombre" class="form-label">Nombres <span class="required">*</span></label>
                    <input type="text" class="form-control" id="txtNombre" name="txtNombre"
                      value="<?= $_SESSION['userData']['firstname']; ?>" required maxlength="200">
                  </div>
                  <div class="mb-3 col-md-12">
                    <label for="txtEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="txtEmail" name="txtEmail"
                      value="<?= $_SESSION['userData']['emailuser']; ?>" required readonly>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="txtPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" maxlength="100">
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="txtPasswordConfirm" class="form-label">Confirmar Password</label>
                    <input type="password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm"
                      maxlength="100">
                  </div>
                  <div class="d-flex justify-content-end">
                    <button id="btnActionForm" class="btn btn-info text-white" type="submit">Actualizar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php footerAdmin($data); ?>