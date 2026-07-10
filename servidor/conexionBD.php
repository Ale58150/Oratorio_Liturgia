
//$conexion = new mysqli("localhost", "root", "1234", "oratorio");

//if ($conexion->connect_error) {
//die("Error de conexión: " . $conexion->connect_error);
//}
<?php
$host = getenv('containers-us-west-123.railway.app');
$puerto = getenv('6543');
$base = getenv('railway');
$usuario = getenv('root');
$password = getenv('xxxxx');

$conexion = new mysqli($host, $usuario, $password, $base, (int)$puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");
?>