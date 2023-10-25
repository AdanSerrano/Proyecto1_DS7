<?php
    require_once('model.php');

    class Tasks extends modeloCredencialesBD{

        public function __construct(){
            parent::__construct();
        }

        public function GetTasks(){
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

        public function PostTasks($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $categoria){
            $instruccion = "CALL SP_TASK_NEW('" . $titulo . "','" . $descripcion . "','" . $estado . "','" . $fechaCompromiso . "','" . $responsable. "','" . $categoria  . "');";
            
            $actualizar = $this->_db->query($instruccion);

            if($actualizar){
                return $actualizar;
                $resactualizarultado->close();
                $this->_db->close();
            }
            else{
                echo "Error al insertar la tarea";
            }
        }
    }
?>