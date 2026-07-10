<?php
//$conexion = new mysqli("localhost", "root", "1234", "oratorio");

//if ($conexion->connect_error) {
//die("Error de conexión: " . $conexion->connect_error);
//}



echo "<pre>";

echo "getenv():\n";
var_dump(getenv('MYSQLHOST'));

echo "\n_ENV:\n";
var_dump($_ENV);

echo "\n_SERVER:\n";
var_dump($_SERVER['MYSQLHOST'] ?? null);

exit;
?>