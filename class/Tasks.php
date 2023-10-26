<?php
    require_once('model.php');

    class Tasks extends modeloCredencialesBD{

        public function __construct(){
            parent::__construct();
        }

        public function GetTasks(){
            $instruccion = "CALL SP_TASK()";
            
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

        public function GetTasksById($ID_TASK){
            $instruccion = "CALL SP_TASK_BY_ID(" . $ID_TASK . ")";
            
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

        public function PutTasks($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $categoria){
            $instruccion = "CALL SP_TASK_PUT('" . $titulo . "','" . $descripcion . "','" . $estado . "','" . $fechaCompromiso . "','" . $responsable. "','" . $categoria  . "');";
            
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

        public function DeleteTasks($ID_TASK){
            $instruccion = "CALL SP_TASK_DELETE('" . $ID_TASK  . "');";
            
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