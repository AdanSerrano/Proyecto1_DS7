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
                $this->_db->close();
                return true; // Éxito en la eliminación
            } else {
                echo "Error al eliminar la tarea: " . $this->_db->error; // Imprimir mensaje de error
                return false; // Error en la eliminación
            }
        }

        public function GetFilteredTasks($categoria, $responsable, $estado) {
            $query = "SELECT * FROM TASKS TA
                      INNER JOIN CATEGORIES CA ON TA.TASK_CATEGORIE_ID = CA.ID_CATEGORIE
                      INNER JOIN USERS US ON TA.TASK_USER_ID = US.ID_USER
                      INNER JOIN PARAMETERS PA ON TA.TASK_STATE = PA.ID_PARAMETER";
        
            // Agregar condiciones de filtro según los parámetros proporcionados
            $conditions = array();
            if ($categoria !== null) {
                $conditions[] = "TA.TASK_CATEGORIE_ID = '" . $categoria. "' ";
            }
            if ($responsable !== null) {
                $conditions[] = "TA.TASK_USER_ID = ' " . $responsable. "' ";
            }
            if ($estado !== null) {
                $conditions[] = "TA.TASK_STATE = ' " . $estado. "' ";
            }
        
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
        
            // Ejecutar la consulta y devolver los resultados
            $result = $this->_db->query($query);
        
            // Verificar si la consulta fue exitosa
            if ($result) {
                $listFilteredTasks = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();  // Liberar los resultados
                return $listFilteredTasks;
            } else {
                // Manejar el error
                echo "Error en la consulta: " . $this->_db->error;
                return array();  // Otra lógica según tus necesidades
            }
        }
        
          
          
        
    }
?>