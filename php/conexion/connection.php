<?php

$conn = new mysqli(
    'localhost',
    'root',
    '',
    'clase_21_08'
);

if($conn->connect_error){
    die("Error de conexion:" . $conn->connect_error);
}

