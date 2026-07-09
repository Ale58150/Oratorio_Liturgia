<?php
$servername = getenv('DB_HOST') ?: 'localhost';
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASS') ?: '1234';
$dbname     = getenv('DB_NAME') ?: 'oratorio';
$dbport     = getenv('DB_PORT') ?: 3306;

$conexion = new mysqli($servername, $username, $password, $dbname, $dbport);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>