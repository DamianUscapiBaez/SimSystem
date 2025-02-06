<?php
class EntradasModel extends Mysql
{
    private $IdEntrada;
    private $IdUsuario;
    private $IdProveedor;
    private $FechaEmision;
    private $TipoEntrada;
    private $TipoDocumento;
    private $NumeroDocumento;
    private $Detalle;
    private $Total;
    private $StatusEntrada;

    public function __construct()
    {
        parent::__construct();
    }
    // public function selectProducto(string $idproducto)
    // {
    //     $sql = "SELECT * FROM producto WHERE idproducto = $idproducto";
    //     $request = $this->select($sql);
    //     return $request;
    // }
    public function insertEntrada(int $identrada, int $idusuario, int $idproveedor, string $fechaemision, string $tipoentrada, string $tipodocumento, string $numerodocumento, string $detalle, float $total, int $statusentrada)
    {
        $this->IdEntrada = $identrada;
        $this->IdUsuario = $idusuario;
        $this->IdProveedor = $idproveedor;
        $this->FechaEmision = $fechaemision;
        $this->TipoEntrada = $tipoentrada;
        $this->TipoDocumento = $tipodocumento;
        $this->NumeroDocumento = $numerodocumento;
        $this->Detalle = $detalle;
        $this->Total = $total;
        $this->StatusEntrada = $statusentrada;

        $sql = "INSERT INTO entradas (identrada, idusuario, idproveedor, fechaemision, tipoentrada, tipodocumento, numerodocumento, detalle, total, statusentrada) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arrData = array($this->IdEntrada, $this->IdUsuario, $this->IdProveedor, $this->FechaEmision, $this->TipoEntrada, $this->TipoDocumento, $this->NumeroDocumento, $this->Detalle, $this->Total, $this->StatusEntrada);
        $request = $this->insert($sql, $arrData);

        if (empty($request)) {
            $return = "ok";
        } else {
            $return = "error";
        }
        return $return;
    }

    public function get_tmp_detalle($idusuario)
    {
        $sql = "SELECT d.*, p.idproducto,p.codigo as codigo,p.nombre as producto FROM dtmp_entrada d INNER JOIN producto p ON
            d.productoid = p.idproducto WHERE d.usuarioid = $idusuario";
        $request = $this->select_all($sql);
        return $request;
    }

    public function deleteDetalle(int $id_detalle)
    {
        $sql = "DELETE FROM dtmp_entrada WHERE dtmp_entrada_id = ?";
        $dato = array($id_detalle);
        $request = $this->insert($sql, $dato);
        if (isset($request)) {
            $return = "ok";
        } else {
            $return = "error";
        }
        return $return;
    }
    public function consultarDetalle(int $idproducto, int $idusuario)
    {
        $sql = "SELECT * FROM dtmp_entrada WHERE productoid = $idproducto AND usuarioid = $idusuario";
        $request = $this->select($sql);
        return $request;
    }

    public function getTotalDetalle(int $idusuario)
    {
        $sql = "SELECT subtotal,SUM(subtotal) AS total FROM dtmp_entrada WHERE usuarioid = $idusuario";
        $request = $this->select($sql);
        return $request;
    }
    public function actualizarDetalle(int $idproducto, int $idusuario, int $total_cantidad, float $subTotal)
    {
        $sql = "UPDATE dtmp_entrada SET cantidad=?,subtotal=? WHERE productoid = ? AND usuarioid = ?";
        $arrData = array($total_cantidad, $subTotal, $idproducto, $idusuario);
        $request = $this->insert($sql, $arrData);
        if (isset($request)) {
            $return = "ok";
        } else {
            $return = "error";
        }
        return $return;
    }
    public function vaciarDetalle(int $idusuario)
    {
        $this->intIdusuario = $idusuario;
        $sql = "DELETE FROM dtmp_entrada WHERE usuarioid = ?";
        $arrData = array($this->intIdusuario);
        $request = $this->insert($sql, $arrData);
        if (isset($request)) {
            $return = "ok";
        } else {
            $return = "error";
        }
        return $return;
    }
    public function registrarEntrada(int $idusuario, int $idproveedor, float $total)
    {
        $this->intIdusuario = $idusuario;
        $sql = "INSERT INTO entradas(usuarioid,proveedorid,total,datecreated,timecreated) VALUES (?,?,?,?,?)";
        $arrData = array($this->intIdusuario, $idproveedor, $total, date('Y-m-d'), date('H:i:s'));
        $request = $this->insert($sql, $arrData);
        if (isset($request)) {
            $return = "ok";
        } else {
            $return = "error";
        }
        return $return;
    }

    public function seleccionarProducto(int $idproducto)
    {
        $sql = "SELECT * FROM producto WHERE idproducto = $idproducto";
        $request = $this->select($sql);
        return $request;
    }
    public function registrarMovimientos(string $producto, int $stock, int $cantidad)
    {
        $sql = "SELECT * FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "INSERT INTO movimientos(fecha,producto,iven_inicial,entradas,salidas,existencias) VALUES(?,?,?,?,?,?)";
            $arrData = array(date('Y-m-d'), $producto, $stock, $cantidad, 0, $stock);
            $request_m = $this->insert($sql, $arrData);
        } else {
            $sql = "SELECT entradas FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
            $request = $this->select($sql);
            if ($request) {
                $cantidadT = $request['entradas'] + $cantidad;
                $sql = "UPDATE movimientos SET entradas = ?,existencias = ?  WHERE producto = ?";
                $arrData = array($cantidadT, $stock, $producto);
                $request_m = $this->insert($sql, $arrData);
            }
        }
        if ($request_m >= 0) {
            $sql = "SELECT * FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
            $sql_resquest = $this->select_all($sql);
            return $sql_resquest;
        }
    }
    public function detalle_movimiento(int $id_movimiento, int $cantidad, float $precio, float $subtotal)
    {
        $sql = "INSERT INTO detalle_movimientos(movimientoid,tipo_movimiento,descripcion,cantidad,precio,total,datecreated) VALUES(?,?,?,?,?,?,?)";
        $arrData = array($id_movimiento, 1, "Compra de producto", $cantidad, $precio, $subtotal, date('Y-m-d'));
        $request = $this->insert($sql, $arrData);
        return $request;
    }

    public function set_movimiento(string $producto, int $stock, int $cantidad)
    {
        $sql = "SELECT * FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "INSERT INTO movimientos(fecha,producto,iven_inicial,entradas,salidas,existencias) VALUES(?,?,?,?,?,?)";
            $arrData = array(date('Y-m-d'), $producto, $stock, $cantidad, 0, $stock);
            $request_m = $this->insert($sql, $arrData);
        } else {
            $sql = "SELECT entradas FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
            $request = $this->select($sql);
            if ($request) {
                $cantidadT = $request['entradas'] + $cantidad;
                $sql = "UPDATE movimientos SET entradas = ?,existencias = ?  WHERE producto = ?";
                $arrData = array($cantidadT, $stock, $producto);
                $request_m = $this->insert($sql, $arrData);
            }
        }
        if ($request_m >= 0) {
            $sql = "SELECT * FROM movimientos WHERE producto = '$producto' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
            $sql_resquest = $this->select_all($sql);
            return $sql_resquest;
        }
    }
    // public function set_detalle_movimiento(int $id_movimiento, int $cantidad, float $precio, float $subtotal)
    // {
    //     $sql = "INSERT INTO detalle_movimientos(movimientoid,tipo_movimiento,descripcion,cantidad,precio,total,datecreated) VALUES(?,?,?,?,?,?,?)";
    //     $arrData = array($id_movimiento, 2, "Salida por anulacion", $cantidad, $precio, $subTotal, date('Y-m-d'));
    //     $request = $this->insert($sql, $arrData);
    //     return $request;
    // }
    public function set_detalle_movimiento(int $id_movimiento, int $cantidad, float $precio, float $subtotal)
    {
        $sql = "INSERT INTO detalle_movimientos(movimientoid,tipo_movimiento,descripcion,cantidad,precio,total,datecreated) VALUES(?,?,?,?,?,?,?)";
        $arrData = array($id_movimiento, 2, "Salida por anulacion", $cantidad, $precio, $subtotal, date('Y-m-d'));
        $request = $this->insert($sql, $arrData);
        return $request;
    }

    public function id_entrada()
    {
        $sql = "SELECT MAX(identrada) AS identrada FROM entradas";
        $resquest = $this->select($sql);
        return $resquest;
    }

    public function registrar_detalle_entrada(int $identrada, int $idproducto, int $cantidad, float $precio, float $subtotal)
    {
        $this->intIdentrada = $identrada;
        $this->intIdproducto = $idproducto;
        $this->Cantidad = $cantidad;
        $sql = "INSERT INTO detalle_entradas(entradaid,productoid,cantidad,precio,subtotal) VALUES (?,?,?,?,?)";
        $arrData = array($this->intIdentrada, $this->intIdproducto, $this->Cantidad, $precio, $subtotal);
        $request = $this->insert($sql, $arrData);
        if (isset($request)) {
            $return = "ok";
        } else {
            $return = "error";
        }
        return $return;
    }

    public function getHistorialEntrada()
    {
        // $sql = "SELECT e.idmovements, e.datemovements, e.typemovements, e.reason, e.typedocument, e.total, e.statusmovements, p.nameprovider , u.username FROM movements e
        // INNER JOIN user u ON e.createdBy = u.iduser INNER JOIN provider p ON e.providerid = p.idprovider WHERE type;";
        $sql = "SELECT 
        e.idmovements,
        e.datemovements,
        e.typemovements,
        e.reason,
        e.typedocument,
        e.documentnumber,
        e.total,
        e.statusmovements,
       c.nameclient,
        u.username
    FROM 
        movements e
    INNER JOIN 
        user u ON e.createdBy = u.iduser
    INNER JOIN 
        client c ON e.clientid = c.idclient
    WHERE 
        e.typemovements = 'salida'
    ";
        $resquest = $this->select_all($sql);
        return $resquest;
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM config";
        $data = $this->select($sql);
        return $data;
    }
    public function getProveedorEntrada(int $identrada)
    {
        $sql = "SELECT e.*,p.ruc,p.nombre as proveedor,p.correo, p.telefono,p.direccion FROM entradas e INNER JOIN proveedor p
            ON p.idproveedor = e.proveedorid
            WHERE e.identrada = $identrada";
        $resquest = $this->select($sql);
        return $resquest;
    }
    public function getEntrada(int $identrada)
    {
        $sql = "SELECT * FROM entradas WHERE identrada = $identrada";
        $resquest = $this->select($sql);
        return $resquest;
    }
    public function getProEntrada(int $identrada)
    {
        $sql = "SELECT e.*,d.*,p.idproducto,p.nombre,p.codigo,p.precio_compra FROM entradas e INNER JOIN detalle_entradas d
            ON e.identrada = d.entradaid INNER JOIN producto p ON p.idproducto = d.productoid
            WHERE e.identrada = $identrada";
        $resquest = $this->select_all($sql);
        return $resquest;
    }

    public function actualizarStock(int $idproducto, int $cantidad)
    {
        $sql = "UPDATE producto SET stock = ? WHERE idproducto = ?";
        $arrData = array($cantidad, $idproducto);
        $data = $this->insert($sql, $arrData);
        return $data;
    }

    public function getAnularEntrada(int $id_entrada)
    {
        $this->intIdentrada = $id_entrada;
        $sql = "SELECT e.*,d.* FROM entradas e INNER JOIN detalle_entradas d ON e.identrada = d.entradaid
                    WHERE e.identrada = $this->intIdentrada";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getAnular(int $id_entrada)
    {
        $this->intIdentrada = $id_entrada;
        $sql = "UPDATE entradas SET status = ? WHERE identrada = ?";
        $arrData = array(0, $this->intIdentrada);
        $request = $this->insert($sql, $arrData);
        if ($request == 0) {
            $return = "ok";
        } else {
            $return = "error";
        }
        return $return;
    }

    public function getDetalleTmp($idusuario)
    {
        $this->intIdusuario = $idusuario;
        $sql = "SELECT * FROM dtmp_entrada WHERE usuarioid = $this->intIdusuario";
        $request = $this->select_all($sql);
        return $request;
    }
}
