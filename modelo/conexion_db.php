<?php

    class conexion {
        private $localhost;
        private $usuario;
        private $password;
        private $baseDatos;
        private $conexion;

        function __construct()
        {
            $this->localhost="localhost";
            $this->usuario="root";
            $this->password="";
            $this->baseDatos="hospital";

        }
        
        function conectar(){

            try{
            $this->conexion=new mysqli($this->localhost,$this->usuario,$this->password,$this->baseDatos);
            $this->conexion->set_charset('utf8');
            return $this->conexion;
            }catch(Exception $e){
                echo "ERROR:" . $e->getMessage();
            }
        

        }

        function cerrar(){
            $this->conexion->close();
        }

    }



?>