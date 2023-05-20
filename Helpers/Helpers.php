<?php
//retorna url del proyecto
function base_url(){
    return BASE_URL;
}
//retorna la url de Assets
function media(){
    return BASE_URL."/Assets";
}
function headerAdmin($data=""){
    $view_header = "Views/Templates/header.php";
    require_once ($view_header);
}
function footerAdmin($data=""){
    $view_footer = "Views/Templates/footer.php";
    require_once ($view_footer);
}

//muestra informacion formateada
function dep($data){
    $format = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}
function getModal(string $nameModal,$data){
    $view_modal ="Views/Templates/Modals/{$nameModal}.php";
    require_once $view_modal;
}

function getPermisos(int $idmodulo){
    require_once 'Models/PermisosModel.php';
    $objPermisos = new PermisosModel();
    $idrol = $_SESSION['userData']['idrol'];
    $arrPermisos = $objPermisos->permisosModulo($idrol);
    $permisos = "";
    $permisosMod = "";
    if(count($arrPermisos)>0){
        $permisos = $arrPermisos;
        $permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo]: "";
    }
    $_SESSION['permisos'] = $permisos;
    $_SESSION['permisosMod'] = $permisosMod;
}
function sessionUser(int $idpersona){
    require_once "Models/HomeModel.php";
    $objLogin = new homeModel();
    $request = $objLogin->sessionLogin($idpersona);
    return $request;
}
function uploadImage(array $data, string $name){
    $url_temp = $data['tmp_name'];
    $destino = "Assets/images/uploads/".$name;
    $move = move_uploaded_file($url_temp,$destino);
    return $move;
}
function deleteFile(string $name)
{
    unlink('Assets/images/uploads/'.$name);
}
//Elimina exceso de espacion entre palabras
function strClean($strCadena){
    $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''],$strCadena);
    $string = trim($string); //elimina espacion en blanco al inicio y al final 
    $string = stripslashes($string);//elimina las \ invertidas
    $string =str_ireplace("<script>","",$string);
    $string =str_ireplace("</script>","",$string);
    $string =str_ireplace("<script src>","",$string);
    $string =str_ireplace("<script type=>","",$string);
    $string =str_ireplace("SELECT * FROM","",$string);
    $string =str_ireplace("DELETE FROM","",$string);
    $string =str_ireplace("INSERT INTO","",$string);
    $string =str_ireplace("SELECT COUNT(*) FROM","",$string);
    $string =str_ireplace("DROP TABLE","",$string);
    $string =str_ireplace("OR '1'='1","",$string);
    $string =str_ireplace('OR "1"="1"',"",$string);
    $string =str_ireplace('OR ´1´=´1´',"",$string);
    $string =str_ireplace("is NULL; --","",$string);
    $string =str_ireplace("is NULL; --","",$string);
    $string =str_ireplace("LIKE '","",$string);
    $string =str_ireplace('LIKE "',"",$string);
    $string =str_ireplace("LIKE ´","",$string);
    $string =str_ireplace("OR 'a'='a","",$string);
    $string =str_ireplace('OR "a"="a',"",$string);
    $string =str_ireplace("OR ´a´=´a","",$string);
    $string =str_ireplace("OR ´a´=´a","",$string);
    $string =str_ireplace("--","",$string);
    $string =str_ireplace("^","",$string);
    $string =str_ireplace("[","",$string);
    $string =str_ireplace("]","",$string);
    $string =str_ireplace("==","",$string);
    return $string;
}

//Genera una contraseña de 10 caracteres
function passGenerator($length=10){
    $pass = "";
    $longitudPass=$length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena=strlen($cadena);
    for ($i=1; $i <=$longitudPass ; $i++) { 
        $pos= rand(0,$longitudCadena-1);
        $pass .=substr($cadena,$pos,1);
    }
    return $pass;
}

//generar un token
function token(){
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token =$r1.'-'.$r2.'-'.$r3.'-'.$r4;
    return $token;
}


//formato para valores monetarios
// function formatMoney($cantidad){
//     $cantidad=number_format($cantidad,2,SPD,SPM);
//     return $cantidad;
// }

?>