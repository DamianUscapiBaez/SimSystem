<?php

class Categorias extends Controller
{
    // Constructor de la clase
    public function __construct()
    {
        parent::__construct();
        session_start();
        // Redirige al inicio de sesión si la sesión no está establecida
        if (empty($_SESSION['login'])) {
            header('location:' . base_url() . '/');
        }
        // Obtiene y establece permisos específicos
        getPermisos(5);
    }

    // Página principal para mostrar las categorías
    public function Categorias()
    {
        // Redirige al Panel si los permisos no están establecidos
        if (empty($_SESSION['permissionsMod']['statuspermissions'])) {
            header('Location:' . base_url() . '/Dashboard');
        }
        // Configuración de datos para la vista
        $data = [
            'page_tag' => "categorias",
            'page_title' => "CATEGORIAS DE PRODUCTOS",
            'page_name' => "categorias",
            'page_descripcion' => "Página categorías para productos",
            'page_functions_js' => "functions_categorias.js",
        ];
        // Carga la vista con los datos proporcionados
        $this->views->getView($this, 'categorias', $data);
    }

    // Obtiene y formatea todas las categorías para la respuesta JSON
    public function getCategorias()
    {
        $arrData = $this->model->selectCategorias();
        foreach ($arrData as &$category) {
            // Reemplaza descripciones vacías con "N.A."
            $category['descriptioncategory'] = $category['descriptioncategory'] ?? "N.A.";
            // Convierte el estado de la categoría en un botón de estado
            $category['statuscategory'] = $category['statuscategory'] == 1 ? '<span class="status_btn_success">Activo</span>' : '<span class="status_btn_error">Inactivo</span>';
            // Construye botones de acciones para cada categoría
            $btnViewCat = '<button class="action_btn mr_10 border-0" onclick="fntViewCategoria(' . $category['idcategory'] . ')" title="Ver Categoria"><i class="fa fa-eye"></i></button>';
            $btnEditCat = '<button class="action_btn mr_10 border-0" onclick="fntEditCategoria(' . $category['idcategory'] . ')" title="Editar Categoria"><i class="far fa-edit"></i></button>';
            $btnDeleCat = '<button class="action_btn mr_10 border-0" onclick="fntDelCategoria(' . $category['idcategory'] . ')" title="Eliminar Categoria"><i class="fa fa-trash"></i></button>';
            // Agrega opciones a cada categoría
            $category['options'] = '<div class="text-center">' . $btnViewCat . '' . $btnEditCat . '' . $btnDeleCat . '</div>';
        }
        // Devuelve los datos formateados como JSON
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Obtiene y formatea una categoría específica por ID para la respuesta JSON
    public function getCategoria($idcategoria)
    {
        $intIdcategoria = intval(strClean($idcategoria));

        if ($intIdcategoria > 0) {
            $arrData = $this->model->selectCategoria($intIdcategoria);

            // Devuelve la respuesta como JSON
            echo json_encode(
                empty($arrData)
                    ? ['status' => false, 'msg' => 'Datos no encontrados.']
                    : ['status' => true, 'data' => array_merge($arrData)],
                JSON_UNESCAPED_UNICODE
            );
        }

        // Finaliza la ejecución del script
        die();
    }

    // Agrega o actualiza una categoría según los datos del formulario
    public function setCategoria()
    {
        if ($_POST && !empty($_POST['nombrecategoria']) && !empty($_POST['statuscategoria'])) {
            $arrResponse = [];
            $idcategoria = intval($_POST['idcategoria']);
            $nombrecategoria = strClean($_POST['nombrecategoria']);
            $descripcioncategoria = strClean($_POST['descripcioncategoria']);
            $statuscategoria = $_POST['statuscategoria'];
            $foto = $_FILES['foto'];
            $nombre_foto = $foto['name'];
            $imgPortada = 'portada_categoria.png';

            if ($nombre_foto != '') {
                $imgPortada = 'img_' . md5(date('d-m-Y H:m:s')) . '.jpg';
            }

            $option = ($idcategoria == 0) ? 1 : 2;

            $request_categoria = ($idcategoria == 0)
                ? $this->model->insertCategoria($nombrecategoria, $descripcioncategoria, $imgPortada, $statuscategoria)
                : $this->model->updateCategoria($idcategoria, $nombrecategoria, $descripcioncategoria, $imgPortada, $statuscategoria);

            if ($request_categoria > 0) {
                $arrResponse = ['status' => true, 'msg' => ($option == 1) ? 'Datos Guardados con Éxito.' : 'Datos Actualizados con Éxito.'];

                if ($nombre_foto != '') {
                    uploadImage($foto, $imgPortada);
                }

                if ($option == 2 && $nombre_foto != '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png') {
                    deleteFile($_POST['foto_actual']);
                }
            } elseif ($request_categoria == 'exist') {
                $arrResponse = ['status' => false, 'msg' => '¡Atención! La categoría ya existe.'];
            } else {
                $arrResponse = ['status' => false, 'msg' => 'No es posible almacenar datos.'];
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Datos incorrectos'], JSON_UNESCAPED_UNICODE);
        }

        die();
    }

    // Elimina una categoría por ID
    public function delCategoria()
    {
        if ($_POST) {
            // Obtiene el ID de la categoría a eliminar
            $idcategoria = $_POST['idcategoria'];
            // Realiza la operación de eliminación y obtiene la respuesta
            $requestDelete = $this->model->deleteCategoria($idcategoria);
            // Maneja la respuesta de eliminación
            if ($requestDelete == "ok") {
                $arrResponse = ['status' => true, 'msg' => 'Se ha eliminado la categoría'];
            } elseif ($requestDelete == "exist") {
                $arrResponse = ['status' => false, 'msg' => 'No es posible eliminar la categoría asociada a productos'];
            } else {
                $arrResponse = ['status' => false, 'msg' => 'Error al eliminar la categoría'];
            }

            // Devuelve la respuesta como JSON
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }

        // Finaliza la ejecución del script
        die();
    }

    // Obtiene opciones para un menú desplegable con categorías activas
    public function getSelectCategorias()
    {
        // Obtiene todas las categorías activas y construye las opciones para el menú desplegable
        $htmlOptions = array_reduce(
            $this->model->selectCategorias(),
            function ($options, $category) {
                return $options .= ($category['statuscategory'] == 1)
                    ? '<option value="' . $category['idcategory'] . '">' . $category['namecategory'] . '</option>'
                    : '';
            },
            ''
        );

        // Devuelve las opciones como HTML
        echo $htmlOptions;
        die();
    }
}

?>