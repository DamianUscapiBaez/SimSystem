<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="stylesheet" href="<?= medias() ?>/plantilla/css/bootstrap1.min.css"/>
    <link rel="stylesheet" href="<?= medias() ?>/plantilla/vendors/font_awesome/css/all.min.css"/>
    <link rel="stylesheet" href="<?= medias() ?>/plantilla/vendors/material_icon/material-icons.css"/>
    <link rel="stylesheet" href="<?= medias() ?>/plantilla/css/style1.css"/>
    <title><?= $data['page_title'] ?></title>
</head>

<body class="crm_body_bg">
<div class="main_content_iner d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="modal-content cs_modal">
                    <div class="modal-header justify-content-center theme_bg_1">
                        <h5 class="modal-title text_white">Bienvenido</h5>
                    </div>
                    <div class="modal-body">
                        <form id="formLogin" name="formLogin">
                            <div>
                                <input type="email" class="form-control" placeholder="Ingresar email" id="txtEmail"
                                       name="txtEmail">
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Contraseña" id="txtPassword"
                                       name="txtPassword">
                            </div>
                            <button type="submit" class="btn_1 full_width text-center">Iniciar Sesion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= medias() ?>/plantilla/js/jquery1-3.4.1.min.js"></script>
<script src="<?= medias() ?>/plantilla/js/popper1.min.js"></script>
<script src="<?= medias() ?>/plantilla/js/bootstrap1.min.js"></script>
<script src="<?= media() ?>/libs/js/sweetalert.min.js"></script>
<!-- apps -->
<script> const base_url = "<?=base_url();?>"; </script>
<script type="text/javascript" src="<?= media() ?>/js/functions/<?= $data["page_functions_js"]; ?>"></script>
</body>

</html>
