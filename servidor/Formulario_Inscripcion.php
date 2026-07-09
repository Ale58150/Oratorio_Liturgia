<?php

$host = "localhost";
$usuario = "root";
$password = "1234";
$bd = "oratorio";

$conexion = new mysqli($host, $usuario, $password, $bd);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>