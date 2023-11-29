<?php

// URL de la API
$url = 'http://localhost/Proyecto1_DS7/api/Parameter/GetParameter.php';

// Datos que enviarás en el cuerpo de la solicitud
$data = array(
    'parameterValue' => 'ESTADOS DE TAREAS'

);

// Convierte los datos a formato JSON
$json_data = json_encode($data);

// Configuración de contexto para la solicitud
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => $json_data,
    ),
);

$context = stream_context_create($options);

// Realiza la solicitud a la API y obtén la respuesta
$result = file_get_contents($url, false, $context);

// Si hay algún error, muestra el mensaje de error
if ($result === FALSE) {
    die('Error al realizar la solicitud');
}

// La variable $result contiene la respuesta de la API
echo $result;

?>