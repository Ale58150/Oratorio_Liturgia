<?php
require_once("../servidor/conexionBD.php");

$id = $_POST['id_usuario'];
$rol = $_POST['rol'];
$permisos = $_POST['permisos'];
$estado = $_POST['estado'];

$sql = "UPDATE usuarios_sistema
SET
rol='$rol',
permisos='$permisos',
estado='$estado',
fecha_actualizacion=NOW()
WHERE id_usuario='$id'";

mysqli_query($conexion, $sql);

header("Location: ../cliente/usuarios.php");
exit();
?>