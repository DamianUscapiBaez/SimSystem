<?php

class homeModel extends Mysql
{
    private $intIdUsuario;
    private $strUsuario;
    private $strPassword;
    private $strToken;

    public function __construct()
    {
        parent::__construct();
    }

    public function loginUser(string $usuario, string $password)
    {
        $this->strUsuario = $usuario;
        $this->strPassword = $password;

        $sql = "SELECT iduser, statususer FROM user WHERE emailuser = '$this->strUsuario' AND password = '$this->strPassword' and statususer != 0";
        $request = $this->select($sql);
        return $request;
    }

    public function sessionLogin(int $iduser)
    {
        $this->intIdUsuario = $iduser;
        $sql = "SELECT u.iduser, u.username, u.firstname, u.emailuser, r.idrole, r.namerole, u.statususer FROM user u INNER JOIN role r ON u.roleid = r.idrole WHERE u.iduser = $this->intIdUsuario";
        $request = $this->select($sql);
        $_SESSION['userData'] = $request;
        return $request;
    }
}

?>