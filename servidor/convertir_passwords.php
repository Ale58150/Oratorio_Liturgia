<?php
include("conexionBD.php");

echo "<h3>Iniciando conversión de contraseñas...</h3>";

$sql = "SELECT id_persona, password FROM personas";
$resultado = $conexion->query($sql);

while ($fila = $resultado->fetch_assoc()) {

    $id = $fila['id_persona'];
    $password = $fila['password'];

    // Verificar si ya está encriptado (bcrypt empieza con $2y$)
    if (strpos($password, '$2y$') !== 0) {

        // Encriptar contraseña
        $nuevoHash = password_hash($password, PASSWORD_BCRYPT);

        // Actualizar en BD
        $update = "UPDATE personas SET password='$nuevoHash' WHERE id_persona=$id";
        $conexion->query($update);

        echo "Usuario ID $id actualizado ✔<br>";
    } else {
        echo "Usuario ID $id ya está encriptado 🔒<br>";
    }
}

echo "<h3>Proceso terminado 🚀</h3>";
?>