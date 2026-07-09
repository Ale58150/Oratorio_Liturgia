<?php
require_once("conexionBD.php");

// Verificar que llegue el ID
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM usuarios_sistema WHERE id_usuario = '$id'";

    if (mysqli_query($conexion, $sql)) {

        header("Location: ../cliente/usuarios.php");
        exit();

    } else {

        echo "Error al eliminar: " . mysqli_error($conexion);

    }

} else {

    echo "ID no recibido.";

}
?>