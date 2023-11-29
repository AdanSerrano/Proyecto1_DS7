<?php
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// incluir archivos de objetos
include_once '../../class/Parameter.php';

$objParameter = new Parameter();
$listParameter = $objParameter->GetParameter('ESTADOS DE TAREAS');

// cuenta la cantidad de registros que devuelve el array
$records = count($listParameter);

if($records > 0){
    // array de estados
    $arrStates = array();
    $arrStates["records"] = array();

    // recorrer el array de estados
    foreach($listParameter as $parameter){
        $arrState = array(
            "ID_PARAMETER" => $parameter["ID_PARAMETER"],
            "PARA_NAME" => $parameter["PARA_NAME"],
        );
        array_push($arrStates["records"], $arrState);
    }
    // respuesta 200 - OK
    http_response_code(200);

    // mostrar los datos en formato json
    echo json_encode($arrStates);
}
else{
    // respuesta 404 - No encontrado
    http_response_code(404);

    // mensaje de que no se encontraron estados
    echo json_encode(
        array("message" => "No se encontraron estados.")
    );
}