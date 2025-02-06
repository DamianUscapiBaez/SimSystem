<?php
//retorna url del proyecto
function base_url(): string
{
    return BASE_URL;
}

//retorna la url de Assets
function media(): string
{
    return BASE_URL . "/Assets";
}

function medias(): string
{
    return BASE_URL;
}

// function ObtenerFecha()
// {
//     date_default_timezone_set('America/Lima');

//     $formatoFecha = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
//     $fechaActual = $formatoFecha->format(new DateTime());

//     return $fechaActual;
// }
function ObtenerFecha()
{
    // Establecer la zona horaria a Lima, Perú
    date_default_timezone_set('America/Lima');

    // Crear un objeto DateTime para la fecha deseada (por ejemplo, 2022-12-01)
    $fechaDeseada = new DateTime('2023-02-15');

    // Formatear la fecha deseada en el formato deseado (en este caso, en español)
    $formatoFecha = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
    $fechaFormateada = $formatoFecha->format($fechaDeseada);

    return $fechaFormateada;
}

function headerAdmin($data = "")
{
    $view_header = "Views/Templates/header.php";
    require_once ($view_header);
}

function footerAdmin($data = "")
{
    $view_footer = "Views/Templates/footer.php";
    require_once ($view_footer);
}

//muestra informacion formateada
function dep($data)
{
    $format = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

function getModal(string $nameModal, $data)
{
    $view_modal = "Views/Templates/Modals/{$nameModal}.php";
    require_once $view_modal;
}

function getPermisos(int $idmodule)
{
    require_once 'Models/PermisosModel.php';
    $objPermisos = new PermisosModel();
    $idrole = $_SESSION['userData']['idrole'];
    $arrPermisos = $objPermisos->permisosModulo($idrole);
    $permisos = "";
    $permisosMod = "";
    if (count($arrPermisos) > 0) {
        $permisos = $arrPermisos;
        $permisosMod = isset($arrPermisos[$idmodule]) ? $arrPermisos[$idmodule] : "";
    }
    $_SESSION['permissions'] = $permisos;
    $_SESSION['permissionsMod'] = $permisosMod;
}

function sessionUser(int $idpersona)
{
    require_once "Models/HomeModel.php";
    $objLogin = new homeModel();
    $request = $objLogin->sessionLogin($idpersona);
    return $request;
}

function uploadImage(array $data, string $name)
{
    $url_temp = $data['tmp_name'];
    $destino = "Assets/images/uploads/" . $name;
    $move = move_uploaded_file($url_temp, $destino);
    return $move;
}

function deleteFile(string $name)
{
    unlink('Assets/images/uploads/' . $name);
}

//Elimina exceso de espacion entre palabras
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //elimina espacion en blanco al inicio y al final 
    $string = stripslashes($string);//elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}

//Genera una contraseña de 10 caracteres
function passGenerator($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);
    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}

//generar un token
function token()
{
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}

// arraays 
function tipodocumento()
{
    return [
        (object) ["codigo" => "00", "documento" => "OTROS"],
        (object) ["codigo" => "01", "documento" => "LIBRETA ELECTORAL O DNI"],
        (object) ["codigo" => "06", "documento" => "REG. UNICO DE CONTRIBUYENTES O RUC"],
        (object) ["codigo" => "04", "documento" => "CARNET DE EXTRANJERIA"],
        (object) ["codigo" => "07", "documento" => "PASAPORTE"],
        (object) ["codigo" => "11", "documento" => "PART. DE NACIMIENTO"]
    ];
}

function tipounidad()
{
    return [
        (object) ["codigo" => "AMP", "unidad" => "AMPOLLA"],
        (object) ["codigo" => "BOL", "unidad" => "BOLSA"],
        (object) ["codigo" => "BOT", "unidad" => "BOTELLA"],
        (object) ["codigo" => "CAJ", "unidad" => "CAJA"],
        (object) ["codigo" => "CAR", "unidad" => "CARTUCHO"],
        (object) ["codigo" => "CM", "unidad" => "CENTIMETRO"],
        (object) ["codigo" => "FRA", "unidad" => "FRASCO"],
        (object) ["codigo" => "GR", "unidad" => "GRAMOS"],
        (object) ["codigo" => "M", "unidad" => "METRO"],
        (object) ["codigo" => "MG", "unidad" => "MILIGRAMOS"],
        (object) ["codigo" => "ML", "unidad" => "MILILITROS"],
        (object) ["codigo" => "PLA", "unidad" => "PLANCHA"],
        (object) ["codigo" => "ROL", "unidad" => "ROLLO"],
        (object) ["codigo" => "TAB", "unidad" => "TABLETAS"],
        (object) ["codigo" => "UNI", "unidad" => "UNIDAD"]
    ];
}

function tipoentrada()
{
    return [
        (object) ["codigo" => "01", "entrada" => "COMPRAS PROVEEDORES"],
        (object) ["codigo" => "02", "entrada" => "MUESTRAS GRATUITAS"],
        (object) ["codigo" => "03", "entrada" => "PROMOCIONES O REGALOS"],
        (object) ["codigo" => "04", "entrada" => "PREPOSICIÓN DE STOCK"],
        (object) ["codigo" => "05", "entrada" => "DEVOLUCIÓN DE CLIENTES"],
        (object) ["codigo" => "06", "entrada" => "RECIBO DE REPARACIONES"]
    ];
}


function tipodocumentoentrada()
{
    return [
        (object) ["codigo" => "FAC", "documento" => "FACTURA DE COMPRA"],
        (object) ["codigo" => "BOL", "documento" => "BOLETA DE COMPRA"],
        (object) ["codigo" => "ODC", "documento" => "ORDEN DE COMPRA"],
        (object) ["codigo" => "REM", "documento" => "REMISIÓN DE COMPRA"],
        (object) ["codigo" => "VRC", "documento" => "VOUCHER DE RECEPCIÓN DE COMPRA"],
        (object) ["codigo" => "IRI", "documento" => "INFORME DE RECEPCIÓN DE INVENTARIO DE COMPRA"],
        (object) ["codigo" => "NRE", "documento" => "NOTA DE RECEPCIÓN DE COMPRA"],
        (object) ["codigo" => "OTR", "documento" => "OTROS DOCUMENTOS DE ENTRADA"]
    ];
}

function tiposalida()
{
    return [
        (object) ["codigo" => "01", "salida" => "VENTAS"],
        (object) ["codigo" => "02", "salida" => "CONSUMO INTERNO"],
        (object) ["codigo" => "03", "salida" => "DESTRUCCIÓN DE PRODUCTOS"],
        (object) ["codigo" => "04", "salida" => "PÉRDIDA O ROBO"],
        (object) ["codigo" => "05", "salida" => "REPARACIÓN O REEMPLAZO"],
        (object) ["codigo" => "06", "salida" => "DEVOLUCIÓN A PROVEEDORES"]
    ];
}

function tipodocumentosalida()
{
    return [
        (object) ["codigo" => "FAC", "documento" => "FACTURA DE VENTA"],
        (object) ["codigo" => "BOL", "documento" => "BOLETA DE VENTA"],
        (object) ["codigo" => "REM", "documento" => "REMISIÓN DE MERCANCÍA"],
        (object) ["codigo" => "VRC", "documento" => "VOUCHER DE ENTREGA"],
        (object) ["codigo" => "GUI", "documento" => "GUÍA DE DESPACHO"],
        (object) ["codigo" => "NC", "documento" => "NOTA DE CRÉDITO"],
        (object) ["codigo" => "ND", "documento" => "NOTA DE DÉBITO"],
        (object) ["codigo" => "OTR", "documento" => "OTROS DOCUMENTOS DE SALIDA"]
    ];
}

?>