<?php 

    require '../../modelo/modelUsuario.php';

    $modelusuario = new modelUsuario();
    $usurio=htmlspecialchars($_POST['usuario'],ENT_QUOTES,'UTF-8');
    $contrasena=htmlspecialchars($_POST['contrasena'],ENT_QUOTES,'UTF-8');
    $consulta=$modelusuario->confirmarUsuario($usurio,$contrasena);
    $data = json_encode($consulta);

    if(count($consulta)>0){
        echo $data;
    }else{
        echo 0;
    }


?>