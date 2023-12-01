<?php
    require '../../modelo/modelUsuario.php';

    $modelusuario = new modelUsuario();
    $usuario=htmlspecialchars($_POST['usuario'],ENT_QUOTES,'UTF-8');
    $consulta=$modelusuario->traerDatosUsuario($usuario);
    echo json_encode($consulta);
?>