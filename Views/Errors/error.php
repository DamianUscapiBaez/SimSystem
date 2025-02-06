<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?= media()?>/css/main.css">

  <title>Login - Vali Admin</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="mt-5 col-md-12">
                <div class="page-error tile text-center">
                    <h1><i class="fa fa-exclamation-circle"></i> Error 404: Pagina no encontrada</h1>
                    <p>La página que ha solicitado no se encuentra.</p>
                    <p><a class="btn btn-primary" href="javascript:window.history.back();">Regresar</a></p>
                </div>
            </div>
        </div>
    </div>
  <!-- Essential javascripts for application to work-->
  <script src="<?= media();?>/js/librerias/jquery.min.js"></script>
  <script src="<?= media();?>/js/librerias/bootstrap.bundle.min.js"></script>
  <script src="<?= media()?>/js/main.js"></script>
</body>

</html>