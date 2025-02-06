<?php headerAdmin($data); getModal('modalClientes',$data); ?>
<div class="main_content_iner overly_inner">
    <div id="contentAjax"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                <div class="page_title_left d-flex align-items-center">
                    <h3 class="f_s_25 f_w_700 dark_text mr_30">Clientes</h3>
                    <ol class="breadcrumb page_bradcam mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>/?>">Inicio</a></li>
                        <li class="breadcrumb-item active">Clientes</li>
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
        <div class="col-lg-12">
            <div class="white_card card_height_100 mb_30 pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>Listado de Clientes</h4>
                            <div class="box_right d-flex lms_block">
                                <div class="serach_field_2 me-2">
                                    <div class="search_inner">
                                        <form Active="#">
                                            <div class="search_field">
                                                <input type="text" placeholder="Search content here...">
                                            </div>
                                            <button type="submit"> <i class="ti-search"></i> </button>
                                        </form>
                                    </div>
                                </div>
                                <button class="add_button btn_1" onclick="openModal();" type="button">
                                    Nuevo
                                </button>
                            </div>
                        </div>
                        <div class="QA_table mb_30">
                            <table class="table table-responsive lms_table_active" id="tableClientes">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tipo documento</th>
                                        <th scope="col">N° documento</th>
                                        <th scope="col">Nombre cliente</th>
                                        <th scope="col">Direccion</th>
                                        <th scope="col">N° telefono</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data); ?>