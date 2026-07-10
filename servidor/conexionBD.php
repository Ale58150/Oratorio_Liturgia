<?php
//$conexion = new mysqli("localhost", "root", "1234", "oratorio");

//if ($conexion->connect_error) {
//die("Error de conexión: " . $conexion->connect_error);
//}

echo "<pre>";
echo "MYSQLHOST: ";
var_dump(getenv('MYSQLHOST'));

echo "MYSQLPORT: ";
var_dump(getenv('MYSQLPORT'));

echo "MYSQLDATABASE: ";
var_dump(getenv('MYSQLDATABASE'));

echo "MYSQLUSER: ";
var_dump(getenv('MYSQLUSER'));

echo "MYSQLPASSWORD: ";
var_dump(getenv('MYSQLPASSWORD'));

exit;
?>