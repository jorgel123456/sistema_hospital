<?php
require "../../modelo/modelUsuario.php";

$MU=new modelUsuario();
$idusuario=htmlspecialchars($_POST["idusuario"],ENT_QUOTES,'UTF-8');
$sexo=htmlspecialchars($_POST["sexo"],ENT_QUOTES,'UTF-8');
$rol=htmlspecialchars($_POST["rol"],ENT_QUOTES,'UTF-8');
$consulta=$MU->editarDatosUsuario($idusuario,$sexo,$rol);
echo $consulta;


?>