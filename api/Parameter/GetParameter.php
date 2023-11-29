<?php
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow- Headers, Authorization, X-Requested-With");

// obtener los datos
$data = json_decode(file_get_contents("php://input"));

// incluir archivos de objetos
include_once '../../class/Parameter.php';

$objParameter = new Parameter();
$listParameter = $objParameter->GetParameter($data->parameterValue);

// cuenta la cantidad de registros que devuelve el array
$records = count($listParameter);

// retorna la lista de parametros en formato json
if ($records > 0) 
{
    $arrParametros = array();
    $arrParametros["records"] = array();

    // recorrer el array de parametros
    foreach ($listParameter as $parameter) 
    {
        $arrParameter = array(
            "ID_PARAMETER" => $parameter["ID_PARAMETER"],
            "PARA_NAME" => $parameter["PARA_NAME"],
            "PARA_CATEGORY" => $parameter["PARA_CATEGORY"],

        );
        array_push($arrParametros["records"], $arrParameter);
    }
    // respuesta 200 - OK
    http_response_code(200);

    // mostrar los datos en formato json
    echo json_encode($arrParametros);
    
} else {
    // respuesta 404 - No encontrado
    http_response_code(404);

    // mensaje de que no se encontraron parametros
    echo json_encode(
        array("message" => "No se encontraron los parametos.")
    );
}
