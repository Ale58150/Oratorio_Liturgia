
//$conexion = new mysqli("localhost", "root", "1234", "oratorio");

//if ($conexion->connect_error) {
   // die("Error de conexión: " . $conexion->connect_error);
//}

<?php

$host = getenv('MYSQLHOST');
$puerto = getenv('MYSQLPORT');
$base = getenv('MYSQLDATABASE');
$usuario = getenv('MYSQLUSER');
$password = getenv('MYSQLPASSWORD');

$conexion = new mysqli($host, $usuario, $password, $base, (int)$puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");
?>