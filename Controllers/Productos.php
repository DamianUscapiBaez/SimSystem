<?php
class Productos extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/');
            die();
        }
        getPermisos(6);
    }

    public function Productos()
    {
        if (empty($_SESSION['permissionsMod']['statuspermissions'])) {
            header('Location:' . base_url() . '/Dashboard');
        }
        $data['page_tag'] = "Productos";
        $data['page_title'] = "PRODUCTOS";
        $data['page_name'] = "productos";
        $data['page_descripcion'] = "productos";
        $data['page_functions_js'] = "functions_productos.js";
        $this->views->getView($this, "productos", $data);
    }
    public function getProductos()
    {
        $arrData = $this->model->selectProductos();

        foreach ($arrData as &$producto) {
            // foreach (tipounidad() as $unidad) {
            //     if ($unidad->codigo == $producto['tipounidad']) {
            //         $producto['tipounidad'] = $unidad->unidad;
            //         break;
            //     }
            // }
            $producto['unitprice'] = "S/. " . $producto['unitprice'];
            $producto['imageproduct'] = '<div class="thumb_54 mr_15 mt-0"> <img class="img-fluid radius_50" src="' . base_url() . "/Assets/images/uploads/" . $producto['imageproduct'] . '"> </div>';

            if ($producto['statusproduct'] == 1) {
                $producto['statusproduct'] = '<span class="status_btn_success">Activo</span>';
            } else {
                $producto['statusproduct'] = '<span class="status_btn_error">Inactivo</span>';
            }

            $btnView = '<button class="action_btn mr_10 border-0" onClick="fntViewInfo(' . $producto['idproduct'] . ')" title="Ver Producto"><i class="fa fa-eye"></i></button>';
            $btnEdit = '<button class="action_btn mr_10 border-0" onClick="fntEditInfo(' . $producto['idproduct'] . ')" title="Editar Producto"><i class="far fa-edit"></i></button>';
            $btnDelete = '<button class="action_btn border-0" onClick="fntDelInfo(' . $producto['idproduct'] . ')" title="Eliminar Producto"><i class="fa fa-trash"></i></button>';

            $producto['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function setProducto()
    {
        if ($_POST) {
            if (empty($_POST['nombreproducto']) || empty($_POST['codigoproducto']) || empty($_POST['categoriaid']) || empty($_POST['preciounitario']) || empty($_POST['tipounidad'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {

                $idproducto = intval($_POST['idproducto']);
                $categoriaid = intval($_POST['categoriaid']);
                $nombreproducto = strClean($_POST['nombreproducto']);
                $codigoproducto = strClean($_POST['codigoproducto']);
                $tipounidad = $_POST['tipounidad'];
                $cantidadminima = intval($_POST['cantidadminima']);
                $preciounitario = floatval($_POST['preciounitario']);
                $statusproducto = intval($_POST['statusproducto']);

                $request_producto = "";

                $foto = $_FILES['foto'];
                $nombre_foto = $foto['name'];
                $type = $foto['type'];
                $url_temp = $foto['tmp_name'];
                $imgPortada = 'portada_categoria.png';
                if ($nombre_foto != '') {
                    $imgPortada = 'img_' . md5(date('d-m-Y H:m:s')) . '.jpg';
                }
                if ($idproducto == 0) {
                    $option = 1;
                    $request_producto = $this->model->insertProducto($categoriaid, $nombreproducto, $codigoproducto, $tipounidad, $preciounitario, $cantidadminima, $imgPortada, $statusproducto);
                } else {
                    if ($nombre_foto == '') {
                        if ($_POST['foto_actual'] != 'portada_categoria.png' && $_POST['foto_remove'] == 0) {
                            $imgPortada = $_POST['foto_actual'];
                        }
                    }
                    $option = 2;
                    $request_producto = $this->model->updateProducto($idproducto, $categoriaid, $nombreproducto, $codigoproducto, $tipounidad, $preciounitario, $cantidadminima, $imgPortada, $statusproducto);
                }
                if ($request_producto > 0) {
                    if ($option == 1) {
                        if ($nombre_foto != '') {uploadImage($foto, $imgPortada);}
                        $arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        if ($nombre_foto != '') {
                            uploadImage($foto, $imgPortada);
                        }
                        $arrResponse = array('status' => true, 'idproducto' => $idproducto, 'msg' => 'Datos Actualizados correctamente.');
                        if (($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png')
                            || ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.png')) {
                            deleteFile($_POST['foto_actual']);
                        }
                    }
                } else if ($request_producto == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! El codigo o el nombre del producto ya existen');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getProducto($idproducto)
    {
        $idproducto = intval($idproducto);
        if ($idproducto > 0) {
            $arrData = $this->model->selectProducto($idproducto);
            // foreach (tipounidad() as $documento) {
            //     if ($documento->codigo == $arrData['tipounidad']) {
            //         $arrData['tipounidadview'] = $documento->unidad;
            //         break;
            //     }
            // }
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrData['imageproduct'] = media() . '/images/uploads/' . $arrData['imageproduct'];
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function delProducto()
    {
        if ($_POST) {
            $intIdproducto = intval($_POST['idProducto']);
            $requestDelete = $this->model->deleteProducto($intIdproducto);
            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setImage()
    {
        if ($_POST) {
            if (empty($_POST['idproducto'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de dato.');
            } else {
                $idProducto = intval($_POST['idproducto']);
                $foto = $_FILES['foto'];
                $imgNombre = 'pro_' . md5(date('d-m-Y H:m:s')) . '.jpg';
                $request_image = $this->model->insertImage($idProducto, $imgNombre);
                if ($request_image) {
                    $uploadImage = uploadImage($foto, $imgNombre);
                    $arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error de carga.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delFile()
    {
        if ($_POST) {
            if (empty($_POST['idproducto']) || empty($_POST['file'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                //Eliminar de la DB
                $idProducto = intval($_POST['idproducto']);
                $imgNombre = strClean($_POST['file']);
                $request_image = $this->model->deleteImage($idProducto, $imgNombre);

                if ($request_image) {
                    $deleteFile = deleteFile($imgNombre);
                    $arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function buscarProductoCodigo($codigo)
    {
        $arrData = $this->model->searchProductoCodigo($codigo);
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Producto no existe o esta inactivo');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscarProducto($codigo)
    {
        $arrData = $this->model->buscarProductoCodigoNombre($codigo);
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
