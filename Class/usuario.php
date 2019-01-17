<?php

class Usuario{
    private $id;
    private $deslogin;
    private $dessenha;
    private $dt_cadastro;

    //Getters e Setters
    public function getIDUsuario(){
        return $this->id;
    }

    public function setIDUsuario($value){
        $this->id = $value;
    }

    public function getLoginUsuario(){
        return $this->deslogin;
    }

    public function setLoginUsuario($value){
        $this->deslogin = $value;
    }

    public function getSenhaUsuario(){
        return $this->dessenha;
    }

    public function setSenhaUsuario($value){
        $this->dessenha = $value;
    }

    public function getDtCadastro(){
        return $this->dt_cadastro;
    }

    public function setDtCadastro($value){
        $this->dt_cadastro = $value;
    }

    public function loadByID($id){
        $sql = new SQL();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE id = :ID", array(
            ":ID"=>$id
        ));

        if(count($results) > 0){
            $row = $results[0];

            $this->setIDUsuario($row['id']);
            $this->setLoginUsuario($row['deslogin']);
            $this->setSenhaUsuario($row['dessenha']);
            $this->setDtCadastro(new DateTime($row['dt_cadastro']));
        }
    }

    public static function getList(){
        $sql = new SQL();

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
    }

    public static function search($login){
        $sql = new SQL();

        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ':SEARCH'=> '%'.$login.'%'
        ));
    }

    public function login($login, $password){
        $sql = new SQL();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));

        if(count($results) > 0){
            $row = $results[0];

            $this->setIDUsuario($row['id']);
            $this->setLoginUsuario($row['deslogin']);
            $this->setSenhaUsuario($row['dessenha']);
            $this->setDtCadastro(new DateTime($row['dt_cadastro']));
        }else{
            throw new Exception("Login e/ou senha inválidos!");
        }
    }

    public function __toString(){
        return json_encode(array(
            "id"=>$this->getIDUsuario(),
            "deslogin"=>$this->getLoginUsuario(),
            "dessenha"=>$this->getSenhaUsuario(),
            "dt_cadastro"=>$this->getDtCadastro()->format("d/m/y H:i:s")
        ));
    }

}
?>