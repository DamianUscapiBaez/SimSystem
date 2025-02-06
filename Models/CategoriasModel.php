<?php

class CategoriasModel extends Mysql
{
    public $Idcategoria;
    public $NombreCategoria;
    public $DescripcionCategoria;
    public $PortadaCategoria;
    public $StatusCategoria;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectCategorias()
    {
        //extraer Categoria
        $sql = "SELECT * FROM category WHERE statuscategory != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCategoria(int $idcategoria)
    {
        // Buscar categoría
        $this->Idcategoria = $idcategoria;
        $sql = "SELECT * FROM category WHERE idcategory = $this->Idcategoria";
        return $this->select($sql);
    }

    public function insertCategoria(string $categoria, string $descripcion, string $img, int $status)
    {
        $return = "";
        $this->NameCategory = $categoria;
        $this->DescriptionCategory = trim($descripcion) !== '' ? $descripcion : null;
        $this->ImageCategory = $img;
        $this->StatusCategory = $status;

        $sql = "SELECT * FROM category WHERE namecategory =?";
        $request = $this->select_all($sql, [$this->NameCategory]);

        if (empty($request)) {
            $query_insert = "INSERT INTO category (namecategory, descriptioncategory, imagecategory, statuscategory) VALUES (?,?,?,?)";
            $arrData = array($this->NameCategory, $this->DescriptionCategory, $this->ImageCategory, $this->StatusCategory);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateCategoria(int $idcategoria, string $categoria, string $descripcion, string $img, int $status)
    {
        $this->Idcategoria = $idcategoria;
        $this->NameCategory = $categoria;
        $this->DescriptionCategory = trim($descripcion) !== '' ? $descripcion : null;
        $this->ImageCategory = $img;
        $this->StatusCategory = $status;

        $sql = "SELECT * FROM category WHERE namecategory = ? AND idcategory != ?";
        $request = $this->select_all($sql, [$this->NameCategory, $this->Idcategoria]);

        if (empty($request)) {
            $sql = "UPDATE category SET namecategory =?, descriptioncategory =?, imagecategory =?, statuscategory =? WHERE idcategory =?";
            $arrData = array($this->NameCategory, $this->DescriptionCategory, $this->ImageCategory, $this->StatusCategory, $this->Idcategoria);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteCategoria(int $idcategoria)
    {
        $this->Idcategoria = $idcategoria;
        $sql = "UPDATE category SET statuscategory = ? WHERE idcategory = $this->Idcategoria";
        $arrData = array(0);
        return $this->update($sql, $arrData);
    }

}
