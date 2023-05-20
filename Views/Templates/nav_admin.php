<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <a class="navbar-brand text-navbar" href="<?= base_url() ?>/Dashboard">SYSTEM</a>
  <button class="navbar-toggler text-navbar" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars"></i>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link active text-navbar" href="<?= base_url() ?>/">Inicio</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-navbar" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          Configuracion
        </a>
        <ul class="dropdown-menu">
          <?php if (!empty($_SESSION['permisos'][2]['status'])) { ?>
            <li><a class="dropdown-item text-navbar" href="<?= base_url() ?>/Configuracion">Datos de empresa</a></li>
          <?php } ?>
          <li><a class="dropdown-item text-navbar" href="<?= base_url() ?>/Usuarios/perfil">Perfil</a></li>
        </ul>
      </li>
      <?php if (!empty($_SESSION['permisos'][3]['status']) || !empty($_SESSION['permisos'][4]['status'])) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-navbar" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Roles y Usuarios
          </a>
          <ul class="dropdown-menu">
            <?php if (!empty($_SESSION['permisos'][3]['status'])) { ?>
              <li><a class="dropdown-item text-navbar" href="<?= base_url() ?>/Roles">Roles</a></li>
            <?php } ?>
            <?php if (!empty($_SESSION['permisos'][4]['status'])) { ?>
              <li><a class="dropdown-item text-navbar" href="<?= base_url() ?>/Usuarios">Usuarios</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>
      <?php if (!empty($_SESSION['permisos'][5]['status']) || !empty($_SESSION['permisos'][6]['status']) || !empty($_SESSION['permisos'][7]['status']) || !empty($_SESSION['permisos'][8]['status'])) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-navbar" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Inventario
          </a>
          <ul class="dropdown-menu">
            <?php if (!empty($_SESSION['permisos'][5]['status'])) { ?>
              <li><a class="dropdown-item text-navbar" href="<?= base_url() ?>/Categorias">Categorias</a></li>
            <?php } ?>
            <?php if (!empty($_SESSION['permisos'][6]['status'])) { ?>
              <li><a class="dropdown-item text-navbar" href="<?= base_url() ?>/Proveedores">Proveedores</a></li>
            <?php } ?>
            <?php if (!empty($_SESSION['permisos'][7]['status'])) { ?>
              <li><a class="dropdown-item text-navbar" href="<?= base_url() ?>/Clientes">Clientes</a></li>
            <?php } ?>
            <?php if (!empty($_SESSION['permisos'][8]['status'])) { ?>
              <li><a class="dropdown-item text-navbar" href="<?= base_url() ?>/Productos">Productos</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>
      <?php if (!empty($_SESSION['permisos'][9]['status'])) { ?>
        <li class="nav-item">
          <a class="nav-link text-navbar" href="<?= base_url() ?>/Entradas/historialEntradas">Entradas</a>
        </li>
      <?php } ?>
      <?php if (!empty($_SESSION['permisos'][10]['status'])) { ?>
        <li class="nav-item">
          <a class="nav-link text-navbar" href="<?= base_url() ?>/Salidas/historialSalidas">Salidas</a>
        </li>
      <?php } ?>
      <?php if (!empty($_SESSION['permisos'][11]['status'])) { ?>
        <li class="nav-item">
          <a class="nav-link text-navbar" href="<?= base_url() ?>/Reportes/Kardex">Kardex</a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link text-navbar" href="<?= base_url() ?>/Logout">Salir</a>
      </li>
    </ul>
  </div>
</nav>