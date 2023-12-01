<?php
class modelUsuario {
        
        private $conexion;
        

        private $nombre;
        private $password;
        private $sexo;

        function __construct()
        {
                require_once 'conexion_db.php';
                $this->conexion = new conexion();
              // $this->conexion->conectar();
        }

        function confirmarUsuario($usuario,$contrasena){
                $sql="call SP_CONFIRMAR_USUARIO('$usuario')";
                $arreglo=array();
                if($consulta= $this->conexion->conectar()->query($sql)){
                        while($consulta_CU = mysqli_fetch_array($consulta)){
                                if(password_verify($contrasena,$consulta_CU["contrasena"])){
                                        $arreglo[]= $consulta_CU;
                                }
                        }
                        
                        return $arreglo;
                        $this->conexion->cerrar();
                }

        }

        function traerDatosUsuario($usuario){
                $sql="call SP_CONFIRMAR_USUARIO('$usuario')";
                $arreglo=array();
                if($consulta= $this->conexion->conectar()->query($sql)){
                        while($consulta_CU = mysqli_fetch_array($consulta)){
                                        $arreglo[]= $consulta_CU;
                                
                        }
                        
                        return $arreglo;
                        $this->conexion->cerrar();
                }

        }

        function obtener_Usuario(){
                $sql="call SP_USUARIO_LISTAR()";
                $arreglo=array();
                if($consulta=$this->conexion->conectar()->query($sql)){
                        while($consulta_UL = mysqli_fetch_assoc($consulta)){
                                $arreglo["data"][]=$consulta_UL;
                               
                        }
                       return $arreglo;
                       $this->conexion->cerrar();
                }
        }

        function listarComboRol(){
                $sql="call SP_LISTAR_COMBO_ROL()";
                $arreglo=array();
                if($consulta=$this->conexion->conectar()->query($sql)){
                        while($consulta_CR = mysqli_fetch_array($consulta)){
                                $arreglo[]=$consulta_CR;
                        
                        }
                        return $arreglo;
                        $this->conexion->cerrar();
                }
                

        }


        function registrarUsuario($usuario,$contrasena,$sexo,$rol){
                $sql="call SP_REGISTRAR_USUARIO('$usuario','$contrasena','$sexo','$rol')";
                if($consulta=$this->conexion->conectar()->query($sql)){
                        if($row= mysqli_fetch_array($consulta)){
                                return $cant= trim($row[0]);
                        }
                        $this->conexion->cerrar();
                }

        

        }


        function modificarEstadoUsuario($idusuario,$estado){
                $sql="call SP_MODIFICAR_ESTADO_USUARIO('$idusuario','$estado')";
                if($consulta=$this->conexion->conectar()->query($sql)){
                        return 1;
                       
                }else{
                        return 0;
                }

                $this->conexion->cerrar();

        }

        function editarDatosUsuario($idusuario,$sexo,$rol){
                $sql="call SP_EDITAR_USUARIO('$idusuario','$sexo','$rol')";
                if($consulta=$this->conexion->conectar()->query($sql)){
                        return 1;
                }else{
                        return 0;
                }

        $this->conexion->cerrar();

        }

        //////////funcion de modificiar contraseña del usuario////////////

        function modificarPassUsuario($idusuario,$passNueva){
                $sql="call SP_MODIFICAR_PASS_USUARIO('$idusuario','$passNueva')";
                if($consulta=$this->conexion->conectar()->query($sql)){
                        return 1;
                       
                }else{
                        return 0;
                }

                $this->conexion->cerrar();
        }

        function restablecerPass($correo,$contrasena){
                $sql="call SP_RESTABLECER_PASS('$correo','$contrasena')";
                if($consulta=$this->conexion->conectar()->query($sql)){
                        if($row= mysqli_fetch_array($consulta)){
                                return $cant= trim($row[0]);
                        }
                        $this->conexion->cerrar();
                }

        

        }

        function intentosUsuario($usuario){
                 $sql="call SP_INTENTOS_USUARIO('$usuario')";
                if($consulta=$this->conexion->conectar()->query($sql)){
                        if($row= mysqli_fetch_array($consulta)){
                                return $cant= trim($row[0]);
                        }
                        $this->conexion->cerrar();
                }
        }

}

?>