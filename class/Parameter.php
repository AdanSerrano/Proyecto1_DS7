<?php
    require_once('model.php');

    class Parameter extends modeloCredencialesBD{

        public function __construct(){
            parent::__construct();
        }

        public function GetParameter($PARA_CATEGORY){
            $instruccion = "CALL SP_Parameter('". $PARA_CATEGORY ."')";
            
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

        public function PostCategorie($CAT_NAME, $CAT_COLOR){
            $instruccion = "CALL SP_CATEGORIE_NEW('". $CAT_NAME ."','". $CAT_COLOR  ."');";
            
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