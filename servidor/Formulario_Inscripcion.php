<?php

$host     = getenv('DB_HOST') ?: 'localhost';
$usuario  = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '1234';
$bd       = getenv('DB_NAME') ?: 'oratorio';
$puerto   = getenv('DB_PORT') ?: 3306;

$conexion = new mysqli($host, $usuario, $password, $bd, $puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>