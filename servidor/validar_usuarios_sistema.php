<?php
include("conexionBD.php");

$rol=$_POST['txtrol'];
$permisos=$_POST['txtpermisos'];
$estado=$_POST['txtestado'];


$consulta=" INSERT INTO usuarios_sistema (rol,permisos,estado) VALUES ('$rol','$permisos','$estado')";

$resultado=mysqli_query($conexion,$consulta);

if ($resultado) {
    echo "<script>
            alert('¡Registro exitoso!');
            window.location='../cliente/usuarios_sistema.php';
        </script>";
} else {
    echo "Error al insertar: " . mysqli_error($conexion);
}
?>