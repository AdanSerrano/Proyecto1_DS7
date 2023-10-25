<?php
require_once('model.php');
class Todolist extends modeloCredencialesBD
{
    public function agregarTarea($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $tipoTareaID)
    {
        $titulo = $this->_db->real_escape_string($titulo);
        $descripcion = $this->_db->real_escape_string($descripcion);
        $estado = $this->_db->real_escape_string($estado);
        $fechaCompromiso = $this->_db->real_escape_string($fechaCompromiso);
        $responsable = $this->_db->real_escape_string($responsable);
        $tipoTareaID = intval($tipoTareaID);

        $query = "INSERT INTO Tareas (Titulo, Descripcion, Estado, FechaCompromiso, EtiquetaEditado, Responsable, TipoTareaID) VALUES ('$titulo', '$descripcion', '$estado', '$fechaCompromiso', 0, '$responsable', $tipoTareaID)";
        $result = $this->_db->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerTareas()
    {
        $instruccion = "call sp_mostrar_tareas()";
        $consulta = $this->_db->query($instruccion);
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);

        if ($resultado) {
            return $resultado;
            $consulta->close();
            $this->_db->close();
        }
    }
}

$todolist = new Todolist();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $fechaCompromiso = $_POST['fechaCompromiso'];
    $responsable = $_POST['responsable'];
    $tipoTareaID = $_POST['tipoTareaID'];

    if ($todolist->agregarTarea($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $tipoTareaID)) {
        echo "Tarea agregada correctamente";
    } else {
        echo "Error al agregar la tarea";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tareas = $todolist->obtenerTareas();
    echo json_encode($tareas);
}
