<?php
require "../../modelo/modelUsuario.php";

$MU=new modelUsuario();
$idusuario=htmlspecialchars($_POST["idusuario"],ENT_QUOTES,'UTF-8');
$contra=htmlspecialchars($_POST["contra"],ENT_QUOTES,'UTF-8');
$passActual=htmlspecialchars($_POST["passActual"],ENT_QUOTES,'UTF-8');
$passNueva=password_hash($_POST["passNueva"],PASSWORD_DEFAULT,['cost'=>10]);
    if(password_verify($passActual,$contra)){
        $consulta=$MU->modificarPassUsuario($idusuario,$passNueva);
        echo $consulta;
    }else{
        echo 2;
    }

?>