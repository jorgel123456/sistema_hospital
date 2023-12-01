<?php  require "../../modelo/modelUsuario.php";

$MU=new modelUsuario();
$idusuario=htmlspecialchars($_POST["idusuario"],ENT_QUOTES,'UTF-8');
$estado=htmlspecialchars($_POST["estado"],ENT_QUOTES,'UTF-8');
$consulta= $MU->modificarEstadoUsuario($idusuario,$estado);
echo $consulta;

?>