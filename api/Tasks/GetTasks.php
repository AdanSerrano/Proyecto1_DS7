<?php
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// incluir archivos de objetos
include_once '../../class/Tasks.php';

$objTasks = new Tasks();
$listTasks = $objTasks->GetTasks();

// cuenta la cantidad de registros que devuelve el array
$records = count($listTasks);

if($records > 0){
    // array de tareas
    $arrTasks = array();
    $arrTasks["records"] = array();

    // recorrer el array de tareas
    foreach($listTasks as $task){
        $arrTask = array(
            "ID_TASK" => $task["ID_TASK"],
            "TASK_NAME" => $task["TASK_NAME"],
            "TASK_DESCRIPTION" => $task["TASK_DESCRIPTION"],
            "TASK_STATE" => $task["TASK_STATE"],
            "PARA_NAME" => $task["PARA_NAME"],
            "TASK_DATE" => $task["TASK_DATE"],
            "TASK_EDIT" => $task["TASK_EDIT"],
            "CAT_NAME" => $task["CAT_NAME"],
            "USER_NAME" => $task["USER_NAME"],
        );
        array_push($arrTasks["records"], $arrTask);
    }
    // respuesta 200 - OK
    http_response_code(200);

    // mostrar los datos en formato json
    echo json_encode($arrTasks);
}
else{
    // respuesta 404 - No encontrado
    http_response_code(404);

    // mensaje de que no se encontraron tareas
    echo json_encode(
        array("message" => "No se encontraron tareas.")
    );
}
