<?php  require "../../modelo/modelUsuario.php";

$MU=new modelUsuario();
$usuario=htmlspecialchars($_POST["usuario"],ENT_QUOTES,'UTF-8');
$consulta= $MU->intentosUsuario($usuario);
echo $consulta;

?>