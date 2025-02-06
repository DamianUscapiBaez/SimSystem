<?php
class ProductosModel extends Mysql
{
    private $IdProducto;
    private $NombreProducto;
    private $CodigoProducto;
    private $TipoUnidad;
    private $CategoriaProducto;
    private $CantidadMinima;
    private $PrecioUnitario;
    private $PortadaProducto;
    private $StatusProducto;

    public function __construct()
    {
        parent::__construct();
    }
    public function selectProducto(int $idproducto)
    {
        $this->IdProducto = $idproducto;
        $sql = "SELECT p.*, c.namecategory as namecategory FROM product p INNER JOIN category c ON p.categoryid = c.idcategory WHERE idproduct = $this->IdProducto";
        $request = $this->select($sql);
        return $request;
    }
    public function selectProductos()
    {
        $sql = "SELECT p.*, c.namecategory as namecategory FROM product p INNER JOIN category c ON p.categoryid = c.idcategory WHERE p.statusproduct != 0";
        $request = $this->select_all($sql);
        return $request;
    }
    public function searchProductoCodigo(string $cod)
    {
        $sql = "SELECT * FROM product WHERE codeproduct = '$cod' AND statusproduct = 1";
        $request = $this->select($sql);
        return $request;
    }
    public function buscarProductoCodigoNombre(string $nombre)
    {
        $sql = "SELECT * FROM product WHERE nameproduct LIKE '%$nombre%' OR codeproduct LIKE '%$nombre%' AND statusproduct = 1 ";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertProducto(int $categoria, string $nombreproducto, string $codigoproducto, string $unidad, float $preciounitario, int $cantidadminima, string $portada, int $status)
    {
        $this->CategoriaProducto = $categoria;
        $this->NombreProducto = $nombreproducto;
        $this->CodigoProducto = $codigoproducto;
        // $this->TipoUnidad = $unidad;
        $this->PrecioUnitario = $preciounitario;
        $this->CantidadMinima = $cantidadminima;
        $this->PortadaProducto = $portada;
        $this->StatusProducto = $status;
        $return = 0;
        $sql = "SELECT * FROM product WHERE codeproduct = '$this->CodigoProducto' OR nameproduct = '$this->NombreProducto'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO product (categoryid, nameproduct, codeproduct, unitprice, minimunquantity, imageproduct, statusproduct) VALUES(?, ?, ?, ?, ?, ?, ?)";
            $arrData = array($this->CategoriaProducto, $this->NombreProducto, $this->CodigoProducto, $this->PrecioUnitario, $this->CantidadMinima, $this->PortadaProducto, $this->StatusProducto);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function select_producto()
    {
        $sql = "SELECT MAX(idproduct) AS idproduct FROM product";
        $request = $this->select($sql);
        return $request;
    }

    public function updateProducto(int $idproducto, int $categoria, string $nombreproducto, string $codigoproducto, string $unidad, float $preciounitario, int $cantidadminima, string $portada, int $status)
    {
        $this->IdProducto = $idproducto;
        $this->CategoriaProducto = $categoria;
        $this->NombreProducto = $nombreproducto;
        $this->CodigoProducto = $codigoproducto;
        // $this->TipoUnidad = $unidad;
        $this->PrecioUnitario = $preciounitario;
        $this->CantidadMinima = $cantidadminima;
        $this->PortadaProducto = $portada;
        $this->StatusProducto = $status;
        $return = 0;
        $sql = "SELECT * FROM product WHERE codeproduct = '$this->CodigoProducto' AND idproduct != $this->IdProducto";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE product SET categoryid = ?, codeproduct = ?, nameproduct = ?, preciounitario = ?, minimunquantity = ?, imageproduct = ?, statusproduct = ? WHERE idproduct = $this->IdProducto";
            $arrData = $arrData = array($this->CategoriaProducto, $this->CodigoProducto, $this->NombreProducto, $this->PrecioUnitario, $this->CantidadMinima, $this->PortadaProducto, $this->StatusProducto);
            $request = $this->update($sql, $arrData);
            $return = $request;
        } else {
            $return = "exist";
        }
        return $return;
    }
    public function deleteProducto(int $idproducto)
    {
        $this->IdProducto = $idproducto;
        $sql = "UPDATE product SET statusproduct = ? WHERE idproduct = $this->IdProducto ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        // if($request){
        //     $sql = "UPDATE producto SET status = ? WHERE idproducto = $this->intIdProducto ";
        //     $arrData = array(0);
        //     $request = $this->update($sql,$arrData);
        // }
        return $request;
    }
}
