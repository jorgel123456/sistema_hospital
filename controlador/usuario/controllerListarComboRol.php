<?php
    require "../../modelo/modelUsuario.php";

    $usuario=new modelUsuario();
    $consulta= $usuario->listarComboRol();
    echo json_encode($consulta);
?>