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
            $this->setData($results[0]);
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
            $this->setData($results[0]);
        }else{
            throw new Exception("Login e/ou senha inválidos!");
        }
    }

    public function setData($data){
        $this->setIDUsuario($data['id']);
        $this->setLoginUsuario($data['deslogin']);
        $this->setSenhaUsuario($data['dessenha']);
        $this->setDtCadastro(new DateTime($data['dt_cadastro']));
    }

    public function insert(){
        $sql = new SQL();

        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
            ":LOGIN"=>$this->getLoginUsuario(),
            ":PASSWORD"=>$this->getSenhaUsuario()
        ));

        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }

    public function update($login, $password){
        $this->setLoginUsuario($login);
        $this->setSenhaUsuario($password);

        $sql = new SQL();

        $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE id = :ID", array(
            ':LOGIN'=>$this->getLoginUsuario(),
            ':PASSWORD'=>$this->getSenhaUsuario(),
            ':ID'=>$this->getIDUsuario()
        ));
    }

    public function delete(){
        $sql = new SQL();

        $sql->query("DELETE FROM tb_usuarios WHERE id = :ID", array(
            'ID'=>$this->getIDUsuario()
        ));

        $this->setIDUsuario(0);
        $this->setLoginUsuario("");
        $this->setSenhaUsuario("");
        $this->setDtCadastro(new DateTime());
    }

    public function __construct($login = "", $password = ""){
        $this->setLoginUsuario($login);
        $this->setSenhaUsuario($password);
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