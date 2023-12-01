<?php
 require "../../modelo/modelUsuario.php";
 
    $modelusuario=new modelUsuario();
    $consulta = $modelusuario->obtener_Usuario();
    if($consulta){
        echo json_encode($consulta);
    }else{
        echo '{
		    "sEcho": 1,
		    "iTotalRecords": "0",
		    "iTotalDisplayRecords": "0",
		    "aaData": []
		}';
    }




?>