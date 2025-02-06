<nav class="sidebar">
    <div class="logo d-flex justify-content-between">
        <a class="large_logo" href="<?= base_url() ?>/">SIM SYSTEM</a>
        <a class="small_logo" href="<?= base_url() ?>/"><img src="<?= medias() ?>/plantilla/img/mini_logo.png"></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">
        <li>
            <a href="<?= base_url() ?>/">
                <div class="nav_icon_small">
                    <i class="fa fa-home"></i>
                </div>
                <div class="nav_title">
                    <span>Inicio</span>
                </div>
            </a>
        </li>
        <?php if (!empty($_SESSION['permissions'][3]['statuspermissions']) || !empty($_SESSION['permissions'][4]['statuspermissions'])) { ?>
            <li>
                <a class="has-arrow" href="#" aria-expanded="false">
                    <div class="nav_icon_small">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="nav_title">
                        <span>Control de acesso</span>
                    </div>
                </a>
                <ul>
                    <?php if (!empty($_SESSION['permissions'][3]['statuspermissions'])) { ?>
                        <li><a href="<?= base_url() ?>/Roles"><i class="fas fa-users-cog"></i> Roles</a></li>
                    <?php } ?>
                    <?php if (!empty($_SESSION['permissions'][4]['statuspermissions'])) { ?>
                        <li><a href="<?= base_url() ?>/Usuarios"><i class="fas fa-users"></i> Usuario</a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permissions'][7]['statuspermissions']) || !empty($_SESSION['permissions'][8]['statuspermissions'])) { ?>
            <li>
                <a class="has-arrow" href="#" aria-expanded="false">
                    <div class="nav_icon_small">
                        <i class="fas fa-address-book"></i>
                    </div>
                    <div class="nav_title">
                        <span>Gestion comercial</span>
                    </div>
                </a>
                <ul>
                    <?php if (!empty($_SESSION['permissions'][7]['statuspermissions'])) { ?>
                        <li>
                            <a href="<?= base_url() ?>/Proveedores">
                                <div class="nav_icon_small">
                                    <i class="fa fa-truck"></i>
                                </div>
                                <div class="nav_title">
                                    <span>Proveedores</span>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($_SESSION['permissions'][8]['statuspermissions'])) { ?>
                        <li>
                            <a href="<?= base_url() ?>/Clientes">
                                <div class="nav_icon_small">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="nav_title">
                                    <span>Clientes</span>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permissions'][5]['statuspermissions']) || !empty($_SESSION['permissions'][6]['statuspermissions'])) { ?>
            <li>
                <a class="has-arrow" href="#" aria-expanded="false">
                    <div class="nav_icon_small">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="nav_title">
                        <span>Inventario</span>
                    </div>
                </a>
                <ul>
                    <?php if (!empty($_SESSION['permissions'][5]['statuspermissions'])) { ?>
                        <li>
                            <a href="<?= base_url() ?>/Categorias">
                                <div class="nav_icon_small">
                                    <i class="fas fa-shapes"></i>
                                </div>
                                <div class="nav_title">
                                    <span>Categorias</span>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($_SESSION['permissions'][6]['statuspermissions'])) { ?>
                        <li>
                            <a href="<?= base_url() ?>/Productos">
                                <div class="nav_icon_small">
                                    <i class="fa fa-boxes"></i>
                                </div>
                                <div class="nav_title">
                                    <span>Productos</span>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permissions'][3]['statuspermissions']) || !empty($_SESSION['permissions'][4]['statuspermissions'])) { ?>
            <li>
                <a class="has-arrow" href="#" aria-expanded="false">
                    <div class="nav_icon_small">
                        <i class="fas fa-dolly"></i>
                    </div>
                    <div class="nav_title">
                        <span>Movimientos</span>
                    </div>
                </a>
                <ul>
                    <?php if (!empty($_SESSION['permissions'][4]['statuspermissions'])) { ?>
                        <li>
                            <a href="<?= base_url() ?>/entradas/listadoentradas"> <i class="fas fa-shopping-basket"></i>
                                Entradas</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($_SESSION['permissions'][3]['statuspermissions'])) { ?>
                        <li><a href="<?= base_url() ?>/Salidas"><i class="fas fa-parachute-box fa-fw"></i> Salidas</a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
    </ul>
</nav>