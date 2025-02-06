<?php headerAdmin($data); ?>
<div class="main_content_iner overly_inner">
    <div class="container-fluid p-0 ">
        <div class="row">
            <div class="col-12">
                <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                    <div class="page_title_left d-flex align-items-center">
                        <h3 class="f_s_25 f_w_700 dark_text mr_30">Inicio</h3>
                    </div>
                    <div class="page_title_right">
                        <div class="page_date_button d-flex align-items-center">
                            <img src="<?= medias() ?>/plantilla/img/icon/calender_icon.svg">
                            <?= obtenerFecha(); ?>
                            <div id="hora" style="margin-left:2px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CARDS -->
        <div class="row">
            <div class="col-md-5">
                <div class="white_card card_height_100 mb_30 user_crm_wrapper row">
                    <div class="col-md-6">
                        <div class="single_crm">
                            <div class="crm_head d-flex align-items-center justify-content-between crm_bg_1">
                                <div class="thumb">
                                    <i class="fa fa-truck f_s_11 white_text"></i>
                                </div>
                                <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                            </div>
                            <div class="crm_body">
                                <h4><?= $data['proveedores']['total'] ?></h4>
                                <p>PROVEEDORES REGISTRADOS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single_crm ">
                            <div class="crm_head d-flex align-items-center justify-content-between crm_bg_2">
                                <div class="thumb">
                                    <i class="fa fa-users f_s_11 white_text"></i>
                                </div>
                                <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                            </div>
                            <div class="crm_body">
                                <h4><?= $data['clientes']['total'] ?></h4>
                                <p>CLIENTES REGISTRADOS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single_crm">
                            <div class="crm_head d-flex align-items-center justify-content-between crm_bg_3">
                                <div class="thumb">
                                    <i class="fas fa-shapes f_s_11 white_text"></i>
                                </div>
                                <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                            </div>
                            <div class="crm_body">
                                <h4><?= $data['categorias']['total'] ?></h4>
                                <p>CATEGORIAS REGISTRADAS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single_crm">
                            <div class="crm_head d-flex align-items-center justify-content-between crm_bg_4">
                                <div class="thumb">
                                    <i class="fa fa-boxes f_s_11 white_text"></i>
                                </div>
                                <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                            </div>
                            <div class="crm_body">
                                <h4><?= $data['productos']['total'] ?></h4>
                                <p>PRODUCTOS REGISTRADOS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single_crm">
                            <div class="crm_head d-flex align-items-center justify-content-between crm_bg_5">
                                <div class="thumb">
                                <i class="fa fa-boxes f_s_11 white_text"></i>
                                </div>
                                <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                            </div>
                            <div class="crm_body">
                                <h4><?= $data['categorias']['total'] ?></h4>
                                <p>ENTRADAS DEL DIA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single_crm">
                            <div class="crm_head d-flex align-items-center justify-content-between crm_bg_6">
                                <div class="thumb">
                                    <i class="fa fa-boxes f_s_11 white_text"></i>
                                </div>
                                <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                            </div>
                            <div class="crm_body">
                                <h4><?= $data['productos']['total'] ?></h4>
                                <p>SALIDAS DEL DIA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="white_card mb_30 card_height_100">
                    <div class="white_card_header">
                        <div class="row align-items-center justify-content-between flex-wrap">
                            <div class="col-lg-4">
                                <div class="main-title">
                                    <h3 class="m-0">Productos con mas entradas y salidas</h3>
                                </div>
                            </div>
                            <div class="col-lg-4 text-end d-flex justify-content-end">
                                <select class="nice_Select2 max-width-220">
                                    <option value="1">2023</option>
                                    <option value="1"></option>
                                    <option value="1">Show by day</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="white_card_body">
                        <div id="management_bar"></div>
                    </div>
                </div>
            </div>
        </div>


        <!-- CHARTJS -->
        <!-- <div class="row mt-3">
            <div class="col-md-6">
                <div class="card text-bg-white mb-3">
                    <div class="card-header text-center">Productos con minimo stock</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Productos</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody id="productos">
                                </tbody>
                            </table>
                        </div>
                        <canvas id="stockMinimo"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-bg-white mb-3">
                    <div class="card-header text-center">Productos con mas salidas</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Productos</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody id="productosSalidas">
                                </tbody>
                            </table>
                        </div>
                        <canvas id="productoSalidas"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 488px;"></canvas>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <?php footerAdmin($data); ?>