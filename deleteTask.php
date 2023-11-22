<?php
// deleteTask.php

require_once("class/Tasks.php");

if (isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];

    // Realiza la lógica de eliminación aquí (puedes utilizar tu función DeleteTasks del script Tasks.php)
    $objTasks = new Tasks();
    $result = $objTasks->DeleteTasks($taskId);

    if ($result) {
        echo "Tarea eliminada exitosamente";
    } else {
        echo "Error al eliminar la tarea";
    }
} else {
    echo "No se proporcionó un ID de tarea válido";
}
?>
