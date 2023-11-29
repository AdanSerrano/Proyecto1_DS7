<?php
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// incluir archivos de objetos
include_once '../../class/Users.php';

$objUsers = new users();
$listUser = $objUsers->GetUsers();

// cuenta la cantidad de registros que devuelve el array
$records = count($listUser);


if ($records > 0) {
    // array de usuarios
    $arrUsers = array();
    $arrUsers["records"] = array();

    // recorrer el array de usuarios
    foreach ($listUser as $user) {
        $arrUser = array(
            "ID_USER" => $user["ID_USER"],
            "USER_NAME" => $user["USER_NAME"],
            "USER_FIRST_NAME" => $user["USER_FIRST_NAME"],
            "USER_LAST_NAME" => $user["USER_LAST_NAME"],
        );
        array_push($arrUsers["records"], $arrUser);
    }
    // respuesta 200 - OK
    http_response_code(200);

    // mostrar los datos en formato json
    echo json_encode($arrUsers);
} else {
    // respuesta 404 - No encontrado
    http_response_code(404);

    // mensaje de que no se encontraron usuarios
    echo json_encode(
        array("message" => "No se encontraron usuarios.")
    );
}
