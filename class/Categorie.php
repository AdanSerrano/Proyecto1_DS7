<?php
    require_once('model.php');

    class Categorie extends modeloCredencialesBD{

        public function __construct(){
            parent::__construct();
        }

        public function GetUsers(){
            $instruccion = "CALL SP_USER()";
            
            $consulta = $this->_db->query($instruccion);
            $resultado = $consulta->fetch_all(MYSQLI_ASSOC);

            if(!$resultado){
                echo "Error al consultar las noticias";
            }
            else{
                $resultado->close();
                $this->_db->close();
                return $resultado;
            }
        }

        public function PostUsers($USER_NAME, $USER_FIRST_NAME, $USER_LAST_NAME){
            $instruccion = "CALL SP_USER_NEW('". $USER_NAME ."','". $USER_FIRST_NAME ."','". $USER_LAST_NAME ."');";
            
            $consulta = $this->_db->query($instruccion);
            $resultado = $consulta->fetch_all(MYSQLI_ASSOC);

            if(!$resultado){
                echo "Error al consultar las noticias ";
            }
            else{
                $resultado->close();
                $this->_db->close();
                return $resultado;
            }
        }
    }
?>