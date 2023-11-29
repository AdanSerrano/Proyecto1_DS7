<?php
    //encabezados obligatorios
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow- Headers, Authorization, X-Requested-With");

    // incluir archivos de objetos
    include_once '../../class/Tasks.php';

    $objTasks = new tasks();

    // obtener los datos
    $data = json_decode(file_get_contents("php://input"));

    $data = file_get_contents('php://input');

    // Decodificar los datos JSON
    $jsonData = json_decode($data, true);

    //$result = $objTasks->PostTasks($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $categoria);

    $titulo = $jsonData['titulo'];
    $descripcion = $jsonData['descripcion'];
    $estado = $jsonData['estado'];
    $fechaCompromiso = $jsonData['fechaCompromiso'];
    $responsable = $jsonData['responsable'];
    $categoria = $jsonData['categoria'];

    //imprime array
    $result = $objTasks->PostTasks($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $categoria);

    echo json_encode($result);

    
echo "entree al api post";
    print_r($jsonData);
    
