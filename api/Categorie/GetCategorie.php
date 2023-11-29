<?php
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// incluir archivos de objetos
include_once '../../class/Categorie.php';

$objCategorie = new Categorie();
$listCategorie = $objCategorie->GetCategorie();

// cuenta la cantidad de registros que devuelve el array
$records = count($listCategorie);

if($records > 0){
    // array de categorias
    $arrCategories = array();
    $arrCategories["records"] = array();

    // recorrer el array de categorias
    foreach($listCategorie as $categorie){
        $arrCategorie = array(
            "ID_CATEGORIE" => $categorie["ID_CATEGORIE"],
            "CAT_NAME" => $categorie["CAT_NAME"],
        );
        array_push($arrCategories["records"], $arrCategorie);
    }
    // respuesta 200 - OK
    http_response_code(200);

    // mostrar los datos en formato json
    echo json_encode($arrCategories);
}
else{
    // respuesta 404 - No encontrado
    http_response_code(404);

    // mensaje de que no se encontraron categorias
    echo json_encode(
        array("message" => "No se encontraron categorias.")
    );
}