<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>
        <?= $data['page_title'] ?>
    </title>
    <!-- Custom CSS -->
    <link href="<?= media()?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=media()?>/css/login.css" rel="stylesheet">
    <title><?= $data['page_title'] ?></title>
</head>

<body>
    <div class="login">
        <h3 class="text-center textTitle">BIENVENIDO</h3>
        <div class="alertLogin"></div>
        <form id="formLogin" name="formLogin">
            <label class="form-label" for="email"></label>
            <div class="input-group form-group">
                <i class="fas fa-envelope input-group-text bg_success text-white d-flex justify-content-center fs-9"></i>
                <input class="form-control" type="email" id="txtEmail" name="txtEmail" placeholder="CORREO ELECTRONICO" required>
            </div>
            <div class="mt-3 input-group form-group">
                <i class="fas fa-lock input-group-text bg_success text-white d-flex justify-content-center"></i>
                <input class="form-control" type="password" id="txtPassword" name="txtPassword" placeholder="CONTRASEÑA" required>
                <span class="input-group-text bg_success text-white" onclick="handelPassword()">
                    <i id="show-eye" class="fas fa-eye fs-9 "></i>
                    <i id="hide-eye" class="fa fa-eye-slash d-none fs-9 "></i>
                </span>
            </div>
            <input class="btn bg_success w-100 mt-3 textButton" type="submit" value="Entrar">
        </form>
    </div>
    <script src="<?= media()?>/libs/js/jquery.min.js "></script>
    <script src="<?= media()?>/libs/js/popper.min.js"></script>
    <script src="<?= media()?>/libs/js/bootstrap.min.js"></script>
    <script src="<?= media();?>/libs/js/sweetalert.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?= media();?>/libs/js/fontawesome.js"></script>
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>
    <script type="text/javascript" src="<?= media()?>/js/functions/<?= $data["page_functions_js"]; ?>"></script>
    <script>
        function handelPassword(){
            var inputP = document.getElementById('txtPassword');
            var show = document.getElementById('show-eye');
            var hide = document.getElementById('hide-eye');
            if(inputP.type === 'password'){
                inputP.type = 'text';
                hide.classList.remove('d-none');
                show.style.display = "none";
                hide.style.display = "block";
            }else{
                inputP.type = 'password';
                show.style.display = "block";
                hide.style.display = "none";
            }
        }
    </script>
</body>
</html>