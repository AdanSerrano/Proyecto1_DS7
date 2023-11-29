<?php
    require_once('model.php');

    class Categorie extends modeloCredencialesBD{

        public function __construct(){
            parent::__construct();
        }

        public function GetCategorie(){
            $instruccion = "CALL SP_CATEGORIE()";
            
            $consulta = $this->_db->query($instruccion);
            $resultado = $consulta->fetch_all(MYSQLI_ASSOC);

            if(!$resultado){
                echo "Error al consultar las categorias";
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