<?php

    $id=$_POST["idusuario"];
    $usuario=$_POST["usuario"];
    $rol=$_POST["rol"];
     
    session_start();
    $_SESSION["IDUSUARIO"]=$id;
    $_SESSION["USUARIO"]=$usuario;
    $_SESSION["ROL"]=$rol;

?>