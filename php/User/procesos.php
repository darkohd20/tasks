<?php
require __DIR__ . "/model/user.php";
require __DIR__ . "/../conexion/connection.php";
header('Content-Type: application/json');

$jsonString = file_get_contents('php://input');
$data = json_decode($jsonString, true);

if ($data == null || !isset($data['accion'])) {
    echo json_encode([
        "message" => "Json no valido",
        "statusCode" => 400
    ]);
    exit;
}

$user = new User($conn);

switch ($data['accion']) {
    case 'login':
        $response = $user->login($data);
        echo json_encode($response);
        break;
    case 'register':
        $response = $user->register($data);
        echo json_encode($response);
        break;
    default:
        echo json_encode([
            "message" => "Accion no valida",
            "statusCode" => 400
        ]);
        break;
}
