<?php

require_once("config.php");

/*$sql = new SQL();
$usuarios = $sql->select("SELECT * FROM tb_usuarios");

echo json_encode($usuarios);*/

//Carrega um usuário
//$root = new Usuario();
//$root->loadByID(3);
//echo $root;

//Carrega uma lista de usuários
//$lista = Usuario::getList();
//echo json_encode($lista);

//Carrega uma lista de usuarios buscando pelo login
//$search = Usuario::search("jo"); 
//echo json_encode($search);

//Carrega um usuario usando o login e a senha
//$usuario = new Usuario();
//$usuario->login("Miguel","13456");
//echo $usuario;

//Criando um novo usuario
//$aluno = new Usuario("aluno","@lun0");

//$aluno->insert();

//echo $aluno;

$usuario = new Usuario();
$usuario->loadById(8);

$usuario->update("professor", "!@#$%");
echo $usuario;

?>