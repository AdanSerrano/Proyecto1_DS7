<?php
    require_once('model.php');

    class Users extends modeloCredencialesBD{

        protected $ID_USER;
        protected $USER_NAME;
        protected $USER_FIRST_NAME;
        protected $USER_LAST_NAME;

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
                return $resultado;
                $consulta->close();
                $this->_db->close();
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
                return $resultado;
                $consulta->close();
                $this->_db->close();
            }
        }
    }
?>