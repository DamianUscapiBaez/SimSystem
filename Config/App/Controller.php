<?php

class Controller
{
    public $views; // Declarar la propiedad views fuera del constructor para evitar avisos de deprecación
    public $model; // Declarar la propiedad model fuera del constructor para evitar avisos de deprecación

    public function __construct()
    {
        $this->views = new Views(); // Inicializar la vista
        $this->cargarModel(); // Llamar al método para cargar el modelo
    }

    public function cargarModel()
    {
        $model = get_class($this) . "Model";
        $ruta = "Models/" . $model . ".php";
        if (file_exists($ruta)) {
            require_once $ruta;
            $this->model = new $model();
        }
    }
}

?>
