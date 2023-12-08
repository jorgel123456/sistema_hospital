<?php
require "../../modelo/modelUsuario.php";

$MU=new modelUsuario();
$usuario=htmlspecialchars($_POST["usuario"],ENT_QUOTES,'UTF-8');
$contrasena=password_hash($_POST["contrasena"],PASSWORD_DEFAULT,['cost'=>10]);
$sexo=htmlspecialchars($_POST["sexo"],ENT_QUOTES,'UTF-8');
$rol=htmlspecialchars($_POST["rol"],ENT_QUOTES,'UTF-8');
$correo=htmlspecialchars($_POST["correo"],ENT_QUOTES,'UTF-8');
$consulta=$MU->registrarUsuario($usuario,$contrasena,$sexo,$rol,$correo);
 echo $consulta;


?>