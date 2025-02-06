<?php
require_once 'Config/Config.php';
require_once 'Helpers/Helpers.php';

$ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/login";
$array = explode("/", $ruta);
$controller = $array[0];
$metodo = $array[0];
$parametro = "";
if (!empty($array[1])) {
    if (!empty($array[1] != "")) {
        $metodo = $array[1];
    }
}
if (!empty($array[2])) {
    if (!empty($array[2] != "")) {
        for ($i = 2; $i < count($array); $i++) {
            $parametro .= $array[$i] . ",";
        }
        $parametro = trim($parametro, ",");
    }
}
require_once 'Config/App/autoload.php';
$dirControllers = "Controllers/" . $controller . ".php";
if (file_exists($dirControllers)) {
    require_once $dirControllers;
    $controller = new $controller();
    if (method_exists($controller, $metodo)) {
        $controller->$metodo($parametro);
    } else {
        require_once ("Controllers/Error.php");
    }
} else {
    require_once ("Controllers/Error.php");
}
?>