<?php
require_once('model.php');

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
